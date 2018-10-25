<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <span class="navbar-brand">
            {{ $presenter->getReport()->getReportName() }}
            <small>{{ $presenter->getReport()->getReportDescription() }}</small>
        </span>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#graph-actions"
                aria-controls="graph-actions" aria-expanded="false" aria-label="Toggle graph actions">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="graph-actions">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a @click="refresh" href="#" class="nav-link"><i id="refresh-icon" class="fa fa-sync-alt"></i>
                        Refresh&nbsp;</a>
                </li>
                <li class="nav-item">
                    <a @click="zoomIn" href="#" class="nav-link">
                        &nbsp;<i id="refresh-icon" class="fa fa-plus"></i>&nbsp;</a>
                </li>
                <li class="nav-item">
                    <a @click="zoomOut" href="#" class="nav-link">
                        &nbsp;<i id="refresh-icon" class="fa fa-minus"></i>&nbsp;</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="cache-meta-button" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        &nbsp;<i id="cache-icon" v-bind:class="cacheIndicatorClass"></i>&nbsp;
                    </a>
                    <div class="dropdown-menu" aria-labelledby="cache-meta-button">
                        <a class="dropdown-item info-only" href="#" tabindex="1" aria-labelledby="cache-meta-button">
                            Last Generated: <span class="clear-cache-item" id="cache-last-generated-time">@{{ cache_last_generated_time }}</span>
                        </a>
                        <a class="dropdown-item info-only" href="#" tabindex="2" aria-labelledby="cache-meta-button">
                            Expires: <span id="cache-expire-time">@{{ cache_expire_time }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" @click="clearCache" href="#" tabindex="3" aria-labelledby="cache-meta-button">
                            Clear Cache
                        </a>
                    </div>
                </li>
            </ul>
        </div>

    </nav>

    <div class="container-fluid no-padding-left">

        <div class="row no-gutters h-100">
            <div class="col-sm-3 border-right no-padding-left">
                <ul class="list-group-flush no-padding-left">
                    <li class="list-group-item list-group-item-light"><h2>Nodes</h2></li>
                    <li v-for="node_type in node_types" class="list-group-item">
                        <input name="node_types" type="checkbox" v-model="selectedNodes" :id="node_type.field"
                               :value="node_type.id"/>
                        <label :for="node_type.field">@{{ node_type.name }}</label>
                    </li>
                    <li class="list-group-item list-group-item-light"><h2>Links</h2></li>
                    <li v-for="link_type in link_types" class="list-group-item">
                        <input name="link_types" type="checkbox" v-model="selectedLinks" :id="link_type.field"
                               :value="link_type.id"/>
                        <label :for="link_type.field">@{{ link_type.name }}</label>
                    </li>
                </ul>
            </div>
            <div class="col-lg" id="graph-container" ref="graphContainer">
                <div id="loader" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/vendor/CareSet/js/d3.v4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/js/popper.min.js"></script>
<script type="text/javascript" src="/vendor/CareSet/bootstrap/js/bootstrap.min.js"></script>

<script>

    var color = d3.scaleOrdinal(d3.schemeCategory10);

    var graph = new Vue({
        el: '#app',
        data: {
            json_url: "<?php echo e( $presenter->getGraphUri() ); ?>",
            canvas_width: null,
            canvas_height: null,
            canvas_offset_top: null,
            canvas_offset_left: null,
            is_dragging: false,
            dashArrayLookup: [
                '',
                '5,5',
                '20,10,1,10',
                '20,5,1,5,1,5,1,5',
                '10,10',
                '30,10',
                '30,10,30'
            ],
            edgeColorLookup: ['#1b9e77', '#d95f02', '#7570b3', '#e7298a', '#66a61e', '#e6ab02'],
            dashArrayCount: null,
            edgeColorCount: null,
            cacheIndicatorClass: "fa fa-database text-none",
            cache_state: null,
            cache_enabled: false,
            cache_generated_this_request: false,
            cache_last_generated_time: null,
            cache_expire_time: null,
            clear_cache: false,
            node_types: [],
            selectedNodes: [],
            nodes: [],
            link_types: [],
            selectedLinks: [],
            links: [],
            zoom: null,
            svg: null,
            tooltip: null,
            canvas: null,
            simulation: null,
            node_hist: []
        },
        watch: {
            selectedNodes: function (val) {
                // clear the nodes array
                this.nodes = [];

                // fetch new data
                this.fetchAndUpdate();
            },
            selectedLinks: function (val) {
                // clear the links array
                this.links = [];

                // fetch new data
                this.fetchAndUpdate();
            }
        },
        methods: {
            refresh: function () {
                this.fetchAndUpdate();
            },
            zoomIn: function () {
                this.zoom.scaleBy(this.svg, 1.1);
            },
            zoomOut: function () {
                this.zoom.scaleBy(this.svg, .9);
            },
            clearCache: function () {
                this.clear_cache = true;
                this.fetchAndUpdate();
            },
            scaleBetween: function (unscaledNum, minAllowed, maxAllowed, min, max) {
                return (maxAllowed - minAllowed) * (unscaledNum - min) / (max - min) + minAllowed;
            },
            tick: function () {

                var vm = this;

                vm.canvas.selectAll(".node-group")
                    .attr("transform", function (d) {
                        return "translate(" + d.x + "," + d.y + ")";
                    })
                    .style("opacity", function (d) {
                        return (d.scale) / 100;
                    });


                vm.canvas.selectAll(".link")
                    .attr("x1", function (d) {
                        return d.source.x;
                    })
                    .attr("y1", function (d) {
                        return d.source.y;
                    })
                    .attr("x2", function (d) {
                        return d.target.x;
                    })
                    .attr("y2", function (d) {
                        return d.target.y;
                    });

            },
            update: function () {

                var vm = this;
                this.is_dragging = false;

                // Set up the simulation
                vm.simulation = d3.forceSimulation()
                    .force("link", d3.forceLink().id(function (d) {
                        return d.id
                    }))
                    .force("charge", d3.forceManyBody()
                        .strength(function (d) {
                            return -300;
                        })
                        .distanceMax([600])
                    )
                    .force("center", d3.forceCenter(vm.canvas_width / 2, vm.canvas_height / 2))
                    .force("y", d3.forceY(0))
                    .force("x", d3.forceX(0))
                    .on("tick", vm.tick)
                ;

                vm.simulation
                    .nodes(vm.nodes);

                vm.simulation
                    .force("link")
                    .links(vm.links);

                // Update the links
                var links = vm.canvas.selectAll(".link")
                    .data(
                        vm.links,
                        function (d) {
                            return d.source.id + "-" + d.target.id;
                        });

                var link_update = links.enter()
                    .append("line")
                    .attr("class", "link")
                    .attr("stroke-width", function (d) {
                        return d.width;
                    })
                    .style("opacity", function (d) {
                        return (d.scale) / 100;
                    })
                    .attr('stroke', function (d) {
                        return (vm.edgeColorLookup[d.link_type % vm.edgeColorCount] );
                    })
                    .attr('stroke-dasharray', function (d) {
                        return (vm.dashArrayLookup[d.link_type % vm.dashArrayCount]);
                    });

                links.exit()
                    .remove();


                // Select existing node groups, and associate with
                // new data
                var nodes = vm.canvas.selectAll(".node-group")
                    .data(
                        vm.nodes,
                        function (d) {
                            return d.id;
                    });

                // When we add new nodes, add a "g" tag (svg group)
                // and associate our event callbacks for mouseover, dragging and so on
                var node_update = nodes.enter()
                    .append("g")
                    .attr("class","node-group")
                    .call(d3.drag()
                        .on("start", vm.dragstarted)
                        .on("drag", vm.dragged)
                        .on("end", vm.dragended))
                    .on("mouseover", function (d) {

                        d3.select(this).moveToFront();
                        d3.select(this).style("cursor", "pointer");

                        vm.tooltip.transition()
                            .duration(200)
                            .style("opacity", 1);

                        if (!vm.is_dragging) {
                            vm.tooltip.html(
                                "Type: <strong>" + vm.node_types[d.type].name +
                                "<br/>Value: <strong>" + d.value + "</strong>" +
                                "<br/>Weight: <strong>" + d.sum_weight + "</strong>" +
                                "<br/>Size: " + d.size)
                                .style("left", (d3.event.pageX - vm.canvas_offset_left) + "px")
                                .style("top", (d3.event.pageY - vm.canvas_offset_top + 28) + "px");


                            var n = vm.getNeighbors(d);
                            d3.selectAll('.node').each(function (inner_d) {

                                if (!(n.includes(inner_d.id))) {
                                    d3.select(this.parentNode).classed('transparent', true);
                                }
                            });

                            d3.selectAll('.link').each(function (inner_d) {
                                if (d.id != inner_d.source.id && d.id != inner_d.target.id) {
                                    d3.select(this).classed('transparent', true);
                                }
                            });
                        }
                    })
                    .on("mouseout", function (d) {

                        if (!vm.is_dragging) {
                            vm.tooltip.transition()
                                .duration(500)
                                .style("opacity", 0);

                            d3.selectAll('g').classed('transparent', false);
                            d3.selectAll('.link').classed('transparent', false);
                        }
                    })
                    .on("dblclick", function (d) {
                        d3.event.stopPropagation();
                        d.fx = null;
                        d.fy = null;
                    })
                ;

                // Add the svg circle to our node group
                var circle = node_update.append('circle')
                    .attr("class", "node")
                    .attr("r", function (d) {
                        return d.size;
                    })
                    .attr("fill", function (d) {
                        return color(d.type);
                    });

                // Add the text label to our node group
                var labels = node_update.append('text')
                    .attr('class', 'node-label')
                    .text(function (d) {
                        if (d.degree > 2 || d.size >= 10)
                            return vm.node_types[d.type].name + ": " + d.value
                        else
                            return '';
                    });

                // When nodes exit our data collection, remove them from the graph
                nodes.exit()
                    .remove();

                // Sort the elements on the canvas so that node groups are on top,
                // no matter what element was drawn last
                vm.canvas.selectAll(".node-group, .link").sort(function(d1, d2) {
                    if ( d1.class === d2.class) {
                        return -1;
                    } else if ( d1.class === "circle") {
                        return 1;
                    } else {
                        return -1;
                    }
                });
            },
            zoomed: function () {

                var vm = this;

                vm.canvas.attr("transform", d3.event.transform);
            },
            dragstarted: function (d) {

                var vm = this;

                vm.is_dragging = true;
                if (!d3.event.active) vm.simulation.alphaTarget(0.3).restart();
                d.fx = d.x;
                d.fy = d.y;

                vm.tooltip.transition()
                    .duration(0)
                    .style("opacity", 0);

            },
            dragged: function (d) {

                var vm = this;

                d.fx = d3.event.x;
                d.fy = d3.event.y;

                vm.tooltip.transition()
                    .duration(0)
                    .style("opacity", 0);
            },
            dragended: function (d) {

                var vm = this;

                vm.is_dragging = false;
                if (!d3.event.active) vm.simulation.alphaTarget(0);
            },
            getNeighbors: function (node) {
                var vm = this;
                return vm.links.reduce((neighbors, l) => {
                    if (l.target.id === node.id) {
                        neighbors.push(l.source.id)
                    } else if (l.source.id === node.id) {
                        neighbors.push(l.target.id)
                    }
                    return neighbors
                }, [node.id])
            },
            fetchAndUpdate: function () {
                var passthrough_params = {{ $presenter->getReport()->getRequestFormInput( true ) }};
                var merge_get_params = {
                    'token': '{{ e( $presenter->getToken() ) }}',
                    'node_types': this.selectedNodes,
                    'link_types': this.selectedLinks,
                    'clear_cache': this.clear_cache
                };
                var merge = Object.assign({}, passthrough_params, merge_get_params);
                // var param = decodeURIComponent( $.param(merge) );

                var vm = this;

                vm.dashArrayCount = vm.dashArrayLookup.length - 1;
                vm.edgeColorCount = vm.edgeColorLookup.length - 1;

                $('#loader').modal();

                axios.get(this.json_url, {
                    params: merge //'<?php echo $presenter->getReport()->getRequestFormInput( true ); ?>'
                })
                    .then(function (response) {

                        if (typeof response != 'object') {
                            response = JSON.parse(response);
                        }

                        // Initialize new cache state when the API call returns
                        vm.cache_expire_time = response.data.cache_meta_expire_time;
                        vm.cache_last_generated_time = response.data.cache_meta_last_generated;
                        vm.cache_generated_this_request = response.data.cache_meta_generated_this_request;
                        vm.cache_enabled = response.data.cache_meta_cache_enabled;
                        vm.clear_cache = false;

                        //this.node_types = response.data.node_types;
                        // graph.node_types contains node filter options (checkboxes), graph.link_types contain link filter options
                        vm.node_types = response.data.node_types;
                        vm.link_types = response.data.link_types;

                        // Scale the nodes and add them to our model
                        var size_min = null;
                        var size_max = null;
                        for (var i = 0; i < response.data.nodes.length; ++i) {
                            var item = response.data.nodes[i];
                            if (item.size * 1 < size_min || size_min == null) size_min = item.size * 1;
                            if (item.size * 1 > size_max || size_max == null) size_max = item.size * 1;
                        }

                        vm.nodes = [];
                        vm.node_hist = [];
                        for (var i = 0; i < response.data.nodes.length; ++i) {
                            var item = response.data.nodes[i];
                            if (size_min == size_max)
                                item.size = 5;
                            else
                                item.size = vm.scaleBetween(item.size, 5, 30, size_min, size_max);

                            item.scale = vm.scaleBetween(item.size, 65, 100, 5, 30);
                            item.class = 'circle';
                            vm.nodes.push(item);
                            vm.node_hist[item.id] = true;
                        }

                        //buffer the color so it will stay the same color depending on the index
                        for (var i = 0; i < vm.node_types.length; ++i) {
                            var item = vm.node_types[i];
                            color(item.id);
                        }

                        var link_min = null;
                        var link_max = null;
                        for (var i = 0; i < response.data.links.length; ++i) {
                            var item = response.data.links[i];
                            if (item.weight * 1 < link_min || link_min == null) link_min = item.weight * 1;
                            if (item.weight * 1 > link_max || link_max == null) link_max = item.weight * 1;
                        }

                        vm.links = [];
                        for (var i = 0; i < response.data.links.length; ++i) {
                            var item = response.data.links[i];
                            if (link_min == link_max)
                                item.width = 1;
                            else
                                item.width = vm.scaleBetween(item.weight, 1, 30, link_min, link_max);

                            item.scale = vm.scaleBetween(item.width, 40, 100, 1, 30);
                            item.class = 'link';

                            // Link Validation:
                            // Only push the link if we have the source and the target node
                            if ( vm.node_hist[item.source] == true && vm.node_hist[item.target] == true ) {
                                vm.links.push(item);
                            }
                        }


                        vm.update()
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = true
                    })
                    .finally(() => $('#loader').modal('hide'));
            },
        },
        mounted() {
            var vm = this;
            vm.canvas_width = vm.$refs.graphContainer.clientWidth;
            vm.canvas_height = vm.$refs.graphContainer.clientHeight;
            vm.canvas_offset_left = vm.$refs.graphContainer.getBoundingClientRect().left;
            vm.canvas_offset_top = vm.$refs.graphContainer.getBoundingClientRect().top;

            d3.selection.prototype.moveToFront = function () {
                return this.each(function () {
                    this.parentNode.appendChild(this);
                });
            };

            vm.zoom = d3.zoom()
                .scaleExtent([-1, 8])
                .on("zoom", vm.zoomed);

            vm.svg = d3.select("#graph-container").append("svg")
                .attr("width", vm.canvas_width)
                .attr("height", vm.canvas_height - vm.canvas_offset_top)
                .call(vm.zoom);

            vm.canvas = vm.svg.append('g')
                .attr("class", "canvas");

            vm.tooltip = d3.select("#graph-container").append("div")
                .attr("class", "tooltip")
                .style("opacity", 0);

            // Start our timer to update cache indicator when it expires
            setInterval( function() {

                var baseClass = "fa fa-database ";
                var indicatorClass = "";
                var cacheExpires = Date.parse( vm.cache_expire_time );
                var now = Date.now();

                if ( vm.cache_enabled ) {

                    if ( ( now - cacheExpires ) > 0 ) {

                        // Cache is expired
                        indicatorClass = "text-warning";

                    } else if ( vm.cache_generated_this_request ) {

                        // Cache was just generated
                        indicatorClass = "text-primary";

                    } else {

                        // Cache is active (working with cached data)
                        indicatorClass = "text-danger";
                    }

                    // Check to see if cache is about to expire (<1 minute)
                    // If so, we flash the warning
                    if ( ( cacheExpires - now ) > 0 &&
                        ( cacheExpires - now ) < 10000 ) {
                        if ( vm.cache_state != "text-warning" ) {
                            indicatorClass = "text-warning";
                        }
                    }

                } else {
                    indicatorClass = "text-none";
                }

                vm.cache_state = indicatorClass;
                vm.cacheIndicatorClass =  baseClass+indicatorClass;


            }, 1000 );

            vm.fetchAndUpdate();
        }
    });

</script>