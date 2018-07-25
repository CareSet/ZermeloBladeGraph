<?php

namespace CareSet\ZermeloBladeGraph;

use CareSet\Zermelo\Interfaces\CacheInterface;
use CareSet\Zermelo\Interfaces\GeneratorInterface;
use CareSet\Zermelo\Models\AbstractGenerator;
use CareSet\Zermelo\Models\ZermeloReport;
use CareSet\Zermelo\Exceptions\InvalidDatabaseTableException;
use CareSet\Zermelo\Exceptions\InvalidHeaderFormatException;
use CareSet\Zermelo\Exceptions\InvalidHeaderTagException;
use CareSet\Zermelo\Exceptions\UnexpectedHeaderException;
use CareSet\Zermelo\Exceptions\UnexpectedMapRowException;
use \DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class GraphGenerator extends AbstractGenerator// implements GeneratorInterface
{
    private $_cache_key = null;
    private $_node_types = null;
    private $_link_types = null;
    protected  $cacheInterface = null;

    public function __construct( CacheInterface $cacheInterface )
    {
        $this->cacheInterface = $cacheInterface;
    }

    public function init( array $params = null )
    {
        $database = $params['database'];
        $table = $params['table'];
        parent::init($params);

        // Graph-specific initialization
        $this->_cache_key = md5("{$database}.{$table}");

        //default only the first 2 node_types and only 1 link type
        $this->_node_types = [0,1];
        $this->_link_types = [0];
    }

    public function graphTable(array $NodeColumns, array $LinkColumns)
    {

        $cache_key = $this->_cache_key;
        
        $node_table = config("zermelo.CACHE_DB") . ".GraphNode_{$cache_key}";
        $link_table = config("zermelo.CACHE_DB") . ".GraphLinks_{$cache_key}";
   
        $node_limit_finder =config("zermelo.CACHE_DB") . ".NFinalGraphNode_{$cache_key}"; 
        $limit_node_table = config("zermelo.CACHE_DB") . ".FinalGraphNode_{$cache_key}";
        $limit_link_table = config("zermelo.CACHE_DB") . ".FinalGraphLinks_{$cache_key}";

        $fields = $this->getTableColumnDefinition();
        $node_index = 0;
        $node_types = [];
        $link_index = 0;
        $link_types = [];
        $visible_node_types = [];
        $visible_link_types = [];

        foreach ($fields as $field) {
            $column = $field['Name'];
            $title = ucwords(str_replace('_', ' ', $column), "\t\r\n\f\v ");
            if (self::isColumnInKeyArray($column, $NodeColumns)) {
                $subjects_found[] = $column;
                $node_types[$node_index] = [
                    'id'=>$node_index,
                    'field'=>$column,
                    'name'=>$title,
                    'visible'=> ( (!is_array($this->_node_types) || empty($this->_node_types) ) || (is_array($this->_node_types) && in_array($node_index, $this->_node_types)) )
                ];
                $visible_node_types[$node_index] = $node_types[$node_index]['visible'];
                ++$node_index;
            }
            if (self::isColumnInKeyArray($column, $LinkColumns)) {
                $weights_found[] = $column;
                $link_types[$link_index] = [
                    'id'=>$link_index,
                    'field'=>$column,
                    'name'=>$title,
                    'visible'=> ( (!is_array($this->_link_types) || empty($this->_link_types) ) || (is_array($this->_link_types) && in_array($link_index, $this->_link_types)) )
                ];
                $visible_link_types[$link_index] = $link_types[$link_index]['visible'];
                ++$link_index;
            }
        }

        if(!is_array($this->_node_types) || empty($this->_node_types))
        {
            for($i=2,$len=count($node_types);$i<$len;++$i)
            {
                $node_types[$i]['visible'] = false;
                $visible_node_types[$i] = false;
            }
        }


        $this->buildGraphTable($node_table,$link_table,$NodeColumns,$LinkColumns,$visible_node_types,$visible_link_types);


        /* LIMITER */
        /*
        DB::statement("
            CREATE TEMPORARY TABLE {$node_limit_finder} AS 
            SELECT id,type,value,size,sum_weight,degree,rank FROM (
                SELECT
                C.*,
                CASE
                WHEN @last_type = C.type
                    THEN @counter := @counter + 1
                ELSE @counter := 1
                END                    AS rank,
                (@last_type := C.type) AS last_type
            
                FROM {$node_table} AS C, (SELECT
                                                                        @last_type := -1,
                                                                        @counter := 0) AS cntr
                ORDER BY type ASC, sum_weight DESC
            ) as sorter where rank <= 5;
        ");
        DB::statement("ALTER TABLE {$node_limit_finder} ADD PRIMARY KEY(id);");

        DB::statement("
                CREATE TEMPORARY TABLE {$limit_link_table} AS
                SELECT source,target,link_type,weight,rank FROM (
                    SELECT
                      C.*,
                      CASE WHEN @last_source = C.source AND @last_link_type = C.link_type
                        THEN @counter := @counter + 1
                      ELSE @counter := 1
                      END                              AS rank,
                      (@last_source := C.source)       AS last_source,
                      (@last_link_type := C.link_type) AS last_link
                    FROM {$link_table} AS C
                    INNER JOIN {$node_limit_finder} AS B ON (B.id = C.source || B.id = C.target)
                    , (SELECT
                                                                              @last_source := -1,
                                                                              @last_link_type := -1,
                                                                              @counter := 0) AS cntr
                    ORDER BY source ASC, link_type ASC, weight DESC
                  ) as sorter where rank <= 2;
        ");

        DB::statement("
                CREATE TEMPORARY TABLE {$limit_node_table} AS
               SELECT DISTINCT
                    A.id as old_id,
                    A.type,
                    A.value,
                    A.size,
                    A.sum_weight,
                    A.degree
               FROM
               {$limit_link_table} as B
               INNER JOIN {$node_table} as A ON (A.id = B.target OR A.id = B.source)
        ");

        DB::statement("ALTER TABLE {$limit_node_table} ADD id integer not null primary key AUTO_INCREMENT FIRST");
        DB::statement("ALTER TABLE {$limit_node_table} DROP PRIMARY KEY, ADD index(id), add index(old_id)");
        DB::statement("UPDATE {$limit_node_table} SET id = id-1;");


        DB::statement("
                UPDATE {$limit_link_table} AS C
                SET C.source = (SELECT id FROM {$limit_node_table} as A WHERE A.old_id = C.source),
                    C.target = (SELECT id FROM {$limit_node_table} as B WHERE B.old_id = C.target)
        ");
        */

        return [
            'node_types' => array_values($node_types),
            'link_types' => array_values($link_types),
            'nodes' => DB::table($node_table)->select("id", "type", "value", "size", "sum_weight","degree")->get(),
            'links' => DB::table($link_table)->select("source", "target", "link_type", "weight")->whereNotNull("source")->whereNotNull("target")->get(),
        ];

    }

    public function onlyNodeTypes($types = null)
    {
        $this->_node_types = $types;
    }

    public function onlyLinkTypes($types = null)
    {
        $this->_link_types = $types;
    }

    private function buildGraphTable(string $node_table,string $link_table,array $NodeColumns,array $LinkColumns, array $visible_node_types, array $visible_link_types)
    {
        $cache_key = $this->_cache_key;

        $destinationTable = "GraphCache_{$cache_key}";
        $cache_table = "{$this->_database}.{$destinationTable}";

        $this->cacheTo($this->_database, $destinationTable);

        $weight_table = config("zermelo.CACHE_DB") . ".GraphWeight_{$cache_key}";

        /*
            Determine the subjects and the weights column
        */
        $subjects_found = [];
        $weights_found = [];

        $node_types = [];
        $link_types = [];

        $fields = $this->getTableColumnDefinition();
        foreach ($fields as $field) {
            $column = $field['Name'];
            if (self::isColumnInKeyArray($column, $NodeColumns)) {
                $subjects_found[] = $column;
            }
            if (self::isColumnInKeyArray($column, $LinkColumns)) {
                $weights_found[] = $column;
            }
        }


        /*
            Create the cache table
        */
        DB::statement("DROP TABLE IF EXISTS {$node_table}");
        DB::statement("DROP TABLE IF EXISTS {$link_table}");
        DB::statement("DROP TABLE IF EXISTS {$weight_table}");

        Schema::create( $node_table, function ( Blueprint $table ) {
            $table->bigIncrements('id');
            $table->integer('type')->nullable(false);
            $table->string('value')->nullable(false);
            $table->decimal('size', 5, 2);
            $table->integer('sum_weight');
            $table->integer('degree')->default(0);
            //$table->temporary();
            //$table->unique(['type', 'value']);
        });

        Schema::create( $link_table, function ( Blueprint $table ) {
            $table->bigInteger('source')->nullable(true);
            $table->bigInteger('target')->nullable(true);
            $table->integer('link_type')->nullable(false);
            $table->integer('weight')->nullable(false)->default(0);
            //$table->temporary();
          //  $table->unique(['source', 'target', 'link_type']);
           // $table->index(['source','target']);
            $table->index('target');
        });

        /* populating the nodes table */
        foreach ($subjects_found as $index => $subject) {

            /* each subject will be its own node type for now */
            $node_types[$index] = [
                'id' => $index,
                'field' => $subject
            ];
            /*
                If we need to build the table, Insert into the node table, all the nodes possible
            */
            if( $visible_node_types[$index] )
                DB::statement("INSERT INTO {$node_table}(type,value,size,sum_weight) SELECT distinct ?,`{$subject}`,0,0 from {$cache_table}", [$index]);
        }

        DB::statement("UPDATE {$node_table} A SET A.id = A.id-1;");

        foreach ($weights_found as $index => $weight) {
            $link_types[$index] = [
                'id' => $index,
                'field' => $weight,
            ];

            /*
                Actually has links
            */
            if (count($node_types) > 1) {
                foreach ($node_types as $AIndex => $ASubject) {
                    foreach ($node_types as $BIndex => $BSubject) {

                        if ($BIndex <= $AIndex) {
                            continue;
                        }

                        if( $visible_link_types[$index] )
                            DB::statement("INSERT INTO {$link_table}(source,target,link_type,weight)
                                            SELECT
                                            A.id as source,
                                            B.id as target,
                                            ? as link_type,
                                            sum(COALESCE(`{$weight}`,0)) as weight
                                            FROM {$cache_table} as MASTER
                                            LEFT JOIN {$node_table} AS A on (MASTER.`{$ASubject['field']}` = A.value and A.type = ?)
                                            LEFT JOIN {$node_table} AS B on (MASTER.`{$BSubject['field']}` = B.value and B.type = ?)
                                            group by A.id, B.id
                                            HAVING sum(COALESCE(`{$weight}`,0)) > 0
                                            ;
                                            ", [$index, $AIndex, $BIndex]
                                        );
                    }
                }

            } else {

                /*
                    Does not have any link, but we need to insert a null link to determine the size of the nodes
                */
                $AIndex = 0;
                $ASubject = $node_types[0];
                DB::statement("INSERT INTO {$link_table}(source,target,link_type,weight)
                                SELECT
                                A.id as source,
                                null as target,
                                ? as link_type,
                                sum(COALESCE(`{$weight}`,0)) as weight
                                FROM {$cache_table} as MASTER
                                INNER JOIN {$node_table} AS A on (MASTER.`{$ASubject['field']}` = A.value and A.type = ?)
                                group by A.id
                                HAVING sum(COALESCE(`{$weight}`,0)) > 0
                                ;
                                ", [$index, $AIndex]
                );
            }

        }

        /*
            Calculate the sum_weight per each node.
            This is cross-SQL friendly
        */
        DB::statement("CREATE TABLE {$weight_table} AS
            SELECT A.id,sum(COALESCE(B.weight,0) + COALESCE(C.weight,0)) as sum_weight FROM {$node_table} AS A
            LEFT JOIN  {$link_table} AS B ON B.source = A.id
            LEFT JOIN  {$link_table} AS C ON C.target = A.id
            GROUP BY A.id;
        ");
        DB::statement("ALTER TABLE {$weight_table} add primary key(id);");
        DB::statement("UPDATE {$node_table} AS A 
                            SET 
                                A.sum_weight = (SELECT sum_weight from {$weight_table} AS B WHERE B.id = A.id),
                                A.degree = (SELECT count(distinct C.source, C.target) from {$link_table} as C WHERE (C.source = A.id OR C.target = A.id) AND (C.source IS NOT NULL and C.target IS NOT NULL))
        
        ;");

        /* scale the size by the min/max of that type */
        $results = DB::select("select type, min(sum_weight) as min, max(sum_weight) as max, (max(sum_weight) - min(sum_weight)) as localize_max from {$node_table} group by type order by type");
        foreach ($results as $index => $result) {
            $type = $result->type;
            $min = $result->min;
            $max = $result->max;
            $local_max = $result->localize_max;
            DB::statement("UPDATE {$node_table} SET size = COALESCE(((sum_weight - ?) / ?) * 100,0) WHERE type = ?", [$min, $local_max, $type]);
        }

//        DB::statement("DROP TABLE IF EXISTS {$node_table}");
//        DB::statement("DROP TABLE IF EXISTS {$link_table}");
//        DB::statement("DROP TABLE IF EXISTS {$weight_table}");


    }

    /**
     * GraphModelJson
     * Retrieve the nodes and links array to be used with graph
     *
     * @param ZermeloReport $Report
     * @return array
     */
    public function toJson( ZermeloReport $Report ): array
    {
        $report_name = trim($Report->getClassName());
        $Code = $Report->getCode();
        $Parameters = $Report->getParameters();

        $cache_key = md5($Report->getClassName() . "-" . $Code . "-" . $Report->GetBoltId() . "-" . implode("-", $Parameters));

        // We've got our cache key, see if this report is in cache
     /*   if ( $this->cacheInterface->exists( $key ) ) {

        } else {
            $this->cacheInterface->set( $key, $Report, 0 );
        }
*/
        $cache_table_stub = "Report_{$cache_key}";
        $cache_table = config("zermelo.CACHE_DB") . ".{$cache_table_stub}";

        DB::statement(DB::raw("CREATE DATABASE IF NOT EXISTS " . config("zermelo.CACHE_DB") . ";"));
        DB::statement(DB::raw("SET SESSION group_concat_max_len = 1000000;"));

        /*
            Check to see if the main report table exists and if it needs to be ran
        */
        $exists = count(DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema=? and table_name = ?", [config("zermelo.CACHE_DB"), $cache_table_stub])) > 0;
        $cacheable = config("zermelo.CACHABLE");
        $this->cacheInterface->init( $Report );

        $force_update = false;
        if (!$exists || !$cacheable)
        {
            $force_update = true;
            $this->cacheInterface->CacheReport($Report);
        } else if ($exists && $this->cacheInterface->CheckUpdateCacheForReport($Report))
        {
            $force_update = true;
            $this->cacheInterface->CacheReport($Report);
        }

        $this->init( [ 'database' => config("zermelo.CACHE_DB"), 'table' => $cache_table_stub ] );

        /*
        If there is a filter, lets apply it to each column
         */
        $filter = $Report->getInput('filter');
        if ($filter && is_array($filter)) {
            $associated_filter = [];
            foreach($filter as $f=>$item)
            {
                $field = key($item);
                $value = $item[$field];
                $associated_filter[$field] = $value;
            }

            $this->addFilter($associated_filter);
        }

        $orderBy = $Report->getInput('order') ?? [];
        $associated_orderby = [];
        foreach ($orderBy as $order) {
            $orderKey = key($order);
            $direction = $order[$orderKey];
            $associated_orderby[$orderKey] = $direction;
        }
        $this->orderBy($associated_orderby);



        if ($Report->getInput('node_types') && is_array($Report->getInput('node_types'))) {
            $this->onlyNodeTypes($Report->getInput('node_types'));
        }
        if ($Report->getInput('link_types') && is_array($Report->getInput('link_types'))) {
            $this->onlyLinkTypes($Report->getInput('link_types'));
        }

        return $this->graphTable($Report->SUBJECTS,$Report->WEIGHTS);

    }

}