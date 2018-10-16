


<div class="container-fluid">
<div>
<h1>{{ $presenter->getReport()->getReportName()  }}</h1>
</div>
<div>
{{ $presenter->getReport()->getReportDescription() }}
</div>


<div class="container-fluid">
    <div class="row h-100">
        <div class="col-xs-2">
            <form method="GET">
                <div>
                    <h3>Node Types</h3>
                    <ul id="node_types">
                    </ul>
                </div>
                <div>
                    <h3>Link Types</h3>
                    <ul id="link_types">
                    </ul>
                </div>
                <div>
                    <input type="submit" value="Refresh">
                </div>
            </form>
        </div>
        <div class="col-lg">
            <div class="view_contents">
                <div class="force_visual">
                </div>
            </div>
         </div>
    </div>
</div>

</div>



<script type="text/javascript" src="/vendor/CareSet/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/js/moment.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/js/daterangepicker.js"></script>
<script type="text/javascript" src="/vendor/CareSet/js/d3.v4.min.js"></script>

<script>
		var json_url = "{{ $presenter->getGraphUri() }}";

		var color = d3.scaleOrdinal(d3.schemeCategory10);
		var size_min = null;
		var size_max = null;
		var link_min = null;
		var link_max = null;
		var is_dragging = false;


var dasharrayLookup = [
							'',
							'5,5',
							'20,10,1,10',
							'20,5,1,5,1,5,1,5',
							'10,10',
							'30,10',
							'30,10,30'
							];

var edgeColorLookup = ['#1b9e77','#d95f02','#7570b3','#e7298a','#66a61e','#e6ab02']

var dasharrayCount = dasharrayLookup.length - 1;
var edgeColorCount = edgeColorLookup.length - 1;

	$(function() {



var container = $(".view_contents");

function adjust_height()
{
    container.css({
            'padding-top': '0px',
            'min-height': "calc(100% - 100px)",
            'height': "calc(100% - 100px)",
            'width': "100%",
    });

}


var passthrough_params = {!! $presenter->getReport()->getRequestFormInput( true ) !!};
var merge_get_params = {
    'token': '{{ $presenter->getToken() }}',
};
var merge = $.extend({}, passthrough_params, merge_get_params);
var param = decodeURIComponent( $.param(merge) );

function scaleBetween(unscaledNum, minAllowed, maxAllowed, min, max) {
      return (maxAllowed - minAllowed) * (unscaledNum - min) / (max - min) + minAllowed;
}

$.get(json_url, param, function(graph, json_textStatus, json_jqXHR ) {

    if(typeof graph != 'object')
    {
        graph = JSON.parse(graph);
    }

    $.each(graph.node_types,function(i,item)
    {
        var checkbox = $("<input type='checkbox' name='node_types[]'/>").attr('value',item.id);
        if(item.hasOwnProperty('visible') && item.visible)
        {
            checkbox.prop('checked',true);
        }
        $("#node_types").append(
            $("<div></div>").html(checkbox).append($("<span></span>").text(item.name).addClass('node_type_name'))
        );
    });
    $.each(graph.link_types,function(i,item)
    {
        var checkbox = $("<input type='checkbox' name='link_types[]'/>").attr('value',item.id);
        if(item.hasOwnProperty('visible') && item.visible)
        {
            checkbox.prop('checked',true);
        }
        $("#link_types").append(
            $("<div></div>").html(checkbox).append($("<span></span>").text(item.name).addClass('link_type_name'))
        );
    });


    size_min = null;
    size_max = null;
    $.each(graph.nodes,function(i,item)
    {
        if(item.size*1 < size_min || size_min == null) size_min = item.size*1;
        if(item.size*1 > size_max || size_max == null) size_max = item.size*1;
    });

    $.each(graph.nodes,function(i,item)
    {
        if(size_min == size_max)
            item.size = 5;
        else
            item.size = scaleBetween(item.size, 5, 30, size_min, size_max);

        item.scale = scaleBetween(item.size,65,100,5,30);
    });

    link_min = null;
    link_max = null;
    $.each(graph.links, function(i,item)
    {
        if(item.weight*1 < link_min || link_min == null) link_min = item.weight*1;
        if(item.weight*1 > link_max || link_max == null) link_max = item.weight*1;
    });
    $.each(graph.links, function(i,item)
    {
        if(link_min == link_max)
            item.width = 1;
        else
            item.width = scaleBetween(item.weight,1,30, link_min, link_max);

        item.scale = scaleBetween(item.width,40,100,1,30);
    });


    //buffer the color so it will stay the same color depending on the index
    $.each(graph.node_types, function(i,item)
    {
        color(i);
    });
    initialize_d3(graph);


}).fail(function(data) {
    alert("WHOOPS! Something went wrong");
    console.log(data);
});;



function initialize_d3(json)
{

is_dragging = false;

d3.selection.prototype.moveToFront = function() {
  return this.each(function(){
    this.parentNode.appendChild(this);
  });
};
var width = container.width(),
    height = container.height(),
    offset_left = container[0].getBoundingClientRect().left,
    offset_top = container[0].getBoundingClientRect().top;



var zoom = d3.zoom()
    .scaleExtent([-1, 8])
    .on("zoom", zoomed);

function zoomed() {
    g.attr("transform", d3.event.transform);
}

var svg = d3.select(".force_visual").append("svg")
    .attr("width", '100%')
    .attr("height", '100%')
    .call(zoom);
var g = svg.append('g');

var tooltip = d3.select(".force_visual").append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);


var zoom_buttons = d3.select('.view_contents').append("div")
.attr('class','gui-buttons');

zoom_buttons.append('button').attr('class','button-zoom-out').text(' - ').on('click',function(d)
    {
        zoom.scaleBy(svg, .9);
    });
zoom_buttons.append('button').attr('class','button-zoom-in').text(' + ').on('click',function(d)
    {
         zoom.scaleBy(svg, 1.1);
    });

var simulation = d3.forceSimulation()
    .force("link", d3.forceLink().id(function(d) { return d.id }))
    .force("charge", d3.forceManyBody()
                        .strength(function(d)
                        {
                            return -300;
                        })
                          .distanceMax([600])
        )
    .force("center", d3.forceCenter(width / 2, height / 2))

    .force("y", d3.forceY(0))
    .force("x", d3.forceX(0))
    ;

  simulation
    .nodes(json.nodes);

  simulation
    .force("link")
    .links(json.links);


  var link = g.selectAll(".link")
      .data(json.links)
      .enter().append("line")
      .attr("class", "link")
      .attr("stroke-width",function(d)
          {
              return d.width;
          })
        .style("opacity", function(d) {
           return (d.scale)/100;
       })
        .attr('stroke', function(d){
            return(edgeColorLookup[d.link_type % edgeColorCount] );
            })
           .attr('stroke-dasharray', function(d){
            return(dasharrayLookup[d.link_type % dasharrayCount]);
            });

      ;

  var node = g.selectAll(".node")
      .data(json.nodes)
      .enter().append("g")
      .call(d3.drag()
                    .on("start", dragstarted)
                    .on("drag", dragged)
                    .on("end", dragended)
       )
       .style("opacity", function(d) {
           return (d.scale)/100;
       })
       .on("mouseover", function(d) {

            d3.select(this).moveToFront();
            d3.select(this).style("cursor", "pointer");

            tooltip.transition()
            .duration(200)
            .style("opacity", 1);

     if(!is_dragging)
     {
         tooltip.html(
                    "Type: <strong>"+json.node_types[d.type].name+
                    "<br/>Value: <strong>"+d.value + "</strong>"+
                    "<br/>Weight: <strong>"+d.sum_weight + "</strong>"+
                    "<br/>Size: "+d.size)
                  .style("left", (d3.event.pageX - offset_left) + "px")
                  .style("top", (d3.event.pageY - offset_top + 28) + "px");


  n = getNeighbors(d);
    d3.selectAll('.node').each(function(inner_d) {

        if(!(n.includes(inner_d.id)))
        {
            d3.select(this.parentNode).classed('transparent',true);
        }
  });

     d3.selectAll('.link').each(function(inner_d) {
        if(d.id != inner_d.source.id && d.id != inner_d.target.id)
        {
            d3.select(this).classed('transparent',true);
        }
  });
 }


 })


.on("mouseout", function(d) {

         if(!is_dragging)
         {
           tooltip.transition()
             .duration(500)
             .style("opacity", 0);

              d3.selectAll('g').classed('transparent',false);
            d3.selectAll('.link').classed('transparent',false);

         }


           })
     .on("dblclick",function(d)
     {
         d3.event.stopPropagation();
         d.fx=null;
         d.fy=null;
     })
         ;


node.append("circle")
    .attr("class","node")
    .attr("r", function(d) { return d.size; })
    .attr("fill", function(d) { return color(d.type); });


node.append('text')
    .attr('class','node-label')
    .text(function(d) {
        if(d.degree>2 || d.size >=10 )
            return json.node_types[d.type].name+": "+d.value
        else
            return '';
    });

  simulation.on("tick", function() {
    link.attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });

    node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

  });


function dragstarted(d) {
    is_dragging = true;
    if (!d3.event.active) simulation.alphaTarget(0.3).restart();
    d.fx = d.x;
    d.fy = d.y;

            tooltip.transition()
             .duration(0)
             .style("opacity", 0);

}

function dragged(d) {
    d.fx = d3.event.x;
    d.fy = d3.event.y;

    tooltip.transition()
     .duration(0)
     .style("opacity", 0);
}

function dragended(d) {
    is_dragging = false;
    if (!d3.event.active) simulation.alphaTarget(0);
}

function getNeighbors(node) {
  return json.links.reduce((neighbors, l) => {
    if (l.target.id === node.id) {
      neighbors.push(l.source.id)
    } else if (l.source.id === node.id) {
      neighbors.push(l.target.id)
    }
    return neighbors
  }, [node.id])
}

// Move nodes toward cluster focus.
function gravity(alpha) {
  return function(d) {
    d.y += (d.cy - d.y) * alpha;
    d.x += (d.cx - d.x) * alpha;
  };
}

}

adjust_height();


});

</script>
