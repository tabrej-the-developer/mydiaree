"use strict";

var app_demo = {
    page_like: {
        load: function(){
            
            var url = window.location.href;
            
            $.get("assets/php/get_likes.php?page="+url,function(data){
                $("#page-like").html("<span class=\"icon-heart\"></span> "+data+" likes");
            });
            
            $("#page-like").on("click",function(){
                $.get("assets/php/like.php?page="+url,function(data){
                    $("#page-like").html("<span class=\"icon-heart\"></span> "+data+" likes");
                });
                
                $.get("assets/php/get_likes.php?total=all",function(data){
                    $("#modal-thanks-heading").html(data+" Pages liked");
                });
                
                $("#modal-thanks").modal("show");
                
                $(this).unbind("click");
                return false;
            });            
        }
    },
    solutions: {
        bank: {
            change_password: function(){
                
                $("#show_password").change(function(){
                    
                    if($(this).is(":checked")) {                        
                        $("#old_password, #rep_password, #new_password").attr("type","text");                        
                    }else{                        
                        $("#old_password, #rep_password, #new_password").attr("type","password");                        
                    }
                    
                });
                
            },
            change_pin: function(){
                $('#modal-change-pin').on('shown.bs.modal', function(){
                    $("input.mask_pin").mask('99-99');
                    $("input.mask_pin").focus();
                });                
            }
        }
    },    
    googlemap: function(){
        
        if($("#google_world_map").length > 0){
            var gWorldCords = new google.maps.LatLng(0,0); 
            var gWorldOptions = {zoom: 1,center: gWorldCords, mapTypeId: google.maps.MapTypeId.ROADMAP}    
            var gWorld = new google.maps.Map(document.getElementById("google_world_map"), gWorldOptions);
        }
        
        if($("#google_map_markers").length > 0){
            var gPTMCords = new google.maps.LatLng(50.43, 30.60);
            var gPTMOptions = {zoom: 8,center: gPTMCords, mapTypeId: google.maps.MapTypeId.ROADMAP}    
            var gPTM = new google.maps.Map(document.getElementById("google_map_markers"), gPTMOptions);

            var cords = new google.maps.LatLng(50.37, 30.65);
            var marker = new google.maps.Marker({position: cords, map: gPTM, title: "Marker 1"});    
            
            var cords = new google.maps.LatLng(50.5, 30.55);
            var marker = new google.maps.Marker({position: cords, map: gPTM, title: "Marker 2"});
            
            var cords = new google.maps.LatLng(50.8, 30.55);
            var marker = new google.maps.Marker({position: cords, map: gPTM, title: "Marker 3"});
        }
        if($("#google_map_style").length > 0){
            var mapStyle = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}];
            
            var gMapStyleCords = new google.maps.LatLng(50.43, 30.60);
            var gMapStyleOptions = {styles: mapStyle,zoom: 8,center: gMapStyleCords, mapTypeId: google.maps.MapTypeId.ROADMAP};    
            var gMapStyle = new google.maps.Map(document.getElementById("google_map_style"), gMapStyleOptions);
        }
    },
    jvectormap: function(){
        
        if($("#jvm-world-map").length > 0){
            $("#jvm-world-map").vectorMap({
                map: "world_mill_en",
                backgroundColor: "#F5F5F5",
                regionsSelectable: true,
                regionStyle: {
                    selected: {fill: "#4FB5DD"},
                    initial: {fill: "#2D3349"}
                }
            });
        }
        
        if($("#jvm-us_map").length > 0){
            $("#jvm-us_map").vectorMap({
                map: "us_aea_en", 
                backgroundColor: "#F5F5F5",
                regionsSelectable: true,
                regionStyle: {
                    selected: {fill: "#4FB5DD"},
                    initial: {fill: "#2D3349"}
                }
            });
        }        
        
        if($("#jvm-world-map-markers").length > 0){
            $('#jvm-world-map-markers').vectorMap({
                map: 'world_mill_en',                
                backgroundColor: "#F5F5F5",
                normalizeFunction: 'polynomial',
                regionStyle: {
                    selected: {fill: "#4FB5DD"},
                    initial: {fill: "#2D3349"}
                },
                markerStyle: {
                    initial: {
                        fill: '#4FB5DD',
                        stroke: '#2D3349'
                    }
                },                
                markers: [
                    {latLng: [41.90, 12.45], name: 'Vatican City'},
                    {latLng: [43.73, 7.41], name: 'Monaco'},
                    {latLng: [-0.52, 166.93], name: 'Nauru'},
                    {latLng: [-8.51, 179.21], name: 'Tuvalu'},
                    {latLng: [43.93, 12.46], name: 'San Marino'},
                    {latLng: [47.14, 9.52], name: 'Liechtenstein'},
                    {latLng: [7.11, 171.06], name: 'Marshall Islands'},
                    {latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
                    {latLng: [3.2, 73.22], name: 'Maldives'},
                    {latLng: [35.88, 14.5], name: 'Malta'},
                    {latLng: [12.05, -61.75], name: 'Grenada'},
                    {latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
                    {latLng: [13.16, -59.55], name: 'Barbados'},
                    {latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
                    {latLng: [-4.61, 55.45], name: 'Seychelles'},
                    {latLng: [7.35, 134.46], name: 'Palau'},
                    {latLng: [42.5, 1.51], name: 'Andorra'},
                    {latLng: [14.01, -60.98], name: 'Saint Lucia'},
                    {latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
                    {latLng: [1.3, 103.8], name: 'Singapore'},
                    {latLng: [1.46, 173.03], name: 'Kiribati'},
                    {latLng: [-21.13, -175.2], name: 'Tonga'},
                    {latLng: [15.3, -61.38], name: 'Dominica'},
                    {latLng: [-20.2, 57.5], name: 'Mauritius'},
                    {latLng: [26.02, 50.55], name: 'Bahrain'},
                    {latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
                ]
            });
        }
        
        if($("#jvm-us-map-labels").length > 0){
            
            $("#jvm-us-map-labels").vectorMap({            
                map: 'us_aea_en',     
                backgroundColor: "#F5F5F5",
                regionStyle: {
                    selected: {fill: "#4FB5DD"},
                    initial: {fill: "#2D3349"}
                },
                regionLabelStyle: {
                    initial: {fill: "#FFF"},
                    hover: {fill: "#4FB5DD"}
                }
                ,
                labels: {
                    regions: {
                        render: function (code) {
                            var doNotShow = ['US-RI', 'US-DC', 'US-DE', 'US-MD'];

                            if (doNotShow.indexOf(code) === -1) {
                                return code.split('-')[1];
                            }
                        },
                        offsets: function (code) {
                            return {
                                'CA': [-10, 10],
                                'ID': [0, 40],
                                'OK': [25, 0],
                                'LA': [-20, 0],
                                'FL': [45, 0],
                                'KY': [10, 5],
                                'VA': [15, 5],
                                'MI': [30, 30],
                                'AK': [50, -25],
                                'HI': [25, 50]
                            }[code.split('-')[1]];
                        }
                    }
                }              
            });
            
            
        }
        
    },
    charts: {
        morris: function(){
        
            if($("#morris-line-example").length > 0){
                var sales=[];
        $.ajax({
            url: 'index.php?route=common/newdashboard/getdata&token='+getURLVar('token')+'&filter_from='+$('#filter_from').val()+'&filter_to='+$('#filter_to').val(),
            dataType: 'json',
            async:true,
		    success: function(json) {
                    sales=json;   
                    }
                });
     var months=['jan','feb','mar','apr','may','jun',];
                Morris.Line({
                    element: 'morris-line-example',
                    data: sales,
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Sales', 'Purchase'],
                    XLabelFormat:function(x){return months[x.getMonth()];},
                    resize: true,
                    lineColors: ['#2D3349', '#76AB3C']
                });


                Morris.Area({
                    element: 'morris-area-example',
                    data: [
                        {y: '2006', a: 100, b: 90},
                        {y: '2007', a: 75, b: 65},
                        {y: '2008', a: 50, b: 40},
                        {y: '2009', a: 75, b: 65},
                        {y: '2010', a: 50, b: 40},
                        {y: '2011', a: 75, b: 65},
                        {y: '2012', a: 100, b: 90}
                    ],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Series A', 'Series B'],
                    resize: true,
                    lineColors: ['#4FB5DD', '#F69F00']
                });


                Morris.Bar({
                    element: 'morris-bar-example',
                    data: [
                        {y: '2006', a: 100, b: 90},
                        {y: '2007', a: 75, b: 65},
                        {y: '2008', a: 50, b: 40},
                        {y: '2009', a: 75, b: 65},
                        {y: '2010', a: 50, b: 40},
                        {y: '2011', a: 75, b: 65},
                        {y: '2012', a: 100, b: 90}
                    ],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Series A', 'Series B'],
                    barColors: ['#2D3349', '#F04E51']
                });


                Morris.Donut({
                    element: 'morris-donut-example',
                    data: [
                        {label: "Download Sales", value: 12},
                        {label: "In-Store Sales", value: 30},
                        {label: "Mail-Order Sales", value: 20}
                    ],
                    colors: ['#2D3349', '#4FB5DD', '#F04E51']
                });
            }   
        },
        morris_bar: function(){
        var data1='';
            if($("#morris-bar-example").length > 0){
                var id=$('#token').val();
                
                $.ajax({
                type: 'get',
                url: 'index.php?route=common/newdashboard/bar&token='+id,
                dataType: 'json',
                success: function(json) {
		             // data1=JSON.stringify(json);
                        bar(json);
                },
                    error: function(xhr, ajaxOptions, thrownError) {
                       alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
              });
                            

                
            }   
        },
        rickshaw: function(){
            
            if($("#charts-lineplot").length > 0){
                // line chart
                var sin = [], cos = [], sin2 = [];

                for (var i = 0; i < 10; i += 0.3) {
                    sin.push({x: i, y: Math.sin(i)})
                    sin2.push({x: i, y: Math.sin(i - 1.57)});
                    cos.push({x: i, y: Math.cos(i)});
                }

                var rlp = new Rickshaw.Graph({
                    element: document.getElementById("charts-lineplot"),
                    renderer: 'lineplot',
                    min: -1.2,
                    max: 1.2,
                    padding: {top: 0.1},
                    series: [{data: sin, color: '#2D3349', name: "sin"},
                        {data: sin2, color: '#76AB3C', name: "sin2"},
                        {data: cos, color: '#4FB5DD', name: "cos"}]
                });

                var hover = new Rickshaw.Graph.HoverDetail({graph: rlp});

                rlp.render();

                var rlp_resize = function () {
                    rlp.configure({
                        width: $("#charts-lineplot").width(),
                        height: $("#charts-lineplot").height()
                    });
                    rlp.render();
                }

                window.addEventListener('resize', rlp_resize);
                rlp_resize();
                // eof lineplot


                // Line chart
                var seriesData = [[], [], []];
                var random = new Rickshaw.Fixtures.RandomData(50);

                for (var i = 0; i < 50; i++) {
                    random.addData(seriesData);
                }

                var rlc = new Rickshaw.Graph({
                    element: document.getElementById("charts-lines"),
                    renderer: 'line',
                    min: 50,
                    series: [{color: "#76AB3C", data: seriesData[0], name: 'New York'},
                        {color: "#4FB5DD", data: seriesData[1], name: 'London'},
                        {color: "#F04E51", data: seriesData[2], name: 'Tokyo'}]
                });

                rlc.render();

                var hoverDetail = new Rickshaw.Graph.HoverDetail({graph: rlc});
                var axes = new Rickshaw.Graph.Axis.Time({graph: rlc});
                axes.render();

                var rlc_resize = function () {
                    rlc.configure({
                        width: $("#charts-lines").width(),
                        height: $("#charts-lines").height()
                    });
                    rlc.render();
                }

                window.addEventListener('resize', rlc_resize);
                rlc_resize();
                // eof line chart

                // Bar chart 
                var rbc = new Rickshaw.Graph({
                    unstack: true,
                    element: document.querySelector("#charts-column"),
                    min: 30,
                    renderer: 'bar',
                    series: [{
                            color: '#2D3349',
                            data: [{x: 0, y: 50}, {x: 1, y: 52}, {x: 2, y: 36}, {x: 3, y: 42}, {x: 4, y: 36}, {x: 5, y: 50}]
                        }, {
                            color: '#4FB5DD',
                            data: [{x: 0, y: 48}, {x: 1, y: 40}, {x: 2, y: 45}, {x: 3, y: 32}, {x: 4, y: 33}, {x: 5, y: 45}]
                        }, {
                            color: '#F04E51',
                            data: [{x: 0, y: 43}, {x: 1, y: 35}, {x: 2, y: 46}, {x: 3, y: 49}, {x: 4, y: 34}, {x: 5, y: 42}]
                        }]
                });

                rbc.render();

                var rbc_resize = function () {
                    rbc.configure({
                        width: $("#charts-column").width(),
                        height: $("#charts-column").height()
                    });
                    rbc.render();
                }

                var hoverDetail = new Rickshaw.Graph.HoverDetail({graph: rbc});

                window.addEventListener('resize', rbc_resize);
                rbc_resize();
                // eof bar chart 

                // Area Chart 
                var seriesData = [[], [], []];
                var random = new Rickshaw.Fixtures.RandomData(100);

                for (var i = 0; i < 100; i++) {
                    random.addData(seriesData);
                }

                var graph = new Rickshaw.Graph({
                    element: document.getElementById("charts-legend"),
                    renderer: 'area',
                    width: $("#charts-legend").width(),
                    series: [{color: "#2D3349", data: seriesData[0], name: 'Total'},
                        {color: "#4FB5DD", data: seriesData[1], name: 'New'},
                        {color: "#F04E51", data: seriesData[2], name: 'Returned'}]
                });

                graph.render();

                var legend = new Rickshaw.Graph.Legend({graph: graph, element: document.getElementById('legend')});
                var shelving = new Rickshaw.Graph.Behavior.Series.Toggle({graph: graph, legend: legend});
                var order = new Rickshaw.Graph.Behavior.Series.Order({graph: graph, legend: legend});
                var highlight = new Rickshaw.Graph.Behavior.Series.Highlight({graph: graph, legend: legend});

                var resize = function () {
                    graph.configure({
                        width: $("#charts-legend").width(),
                        height: $("#charts-legend").height()
                    });
                    graph.render();
                }

                window.addEventListener('resize', resize);
                resize();
                // eof Area Chart 
            }
        },
        chartjs: function(){
            if($("#chartjs_line").length === 0) return false;
            
            window.chartColors = {
                    red: 'rgb(239, 64, 67)',
                    orange: 'rgb(246, 159, 0)',
                    yellow: 'rgb(242, 255, 37)',
                    green: 'rgb(118, 171, 60)',
                    blue: 'rgb(79, 181, 221)',
                    purple: 'rgb(153, 102, 255)',
                    grey: 'rgb(231,233,237)'
            };

            window.randomScalingFactor = function() {
                    return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
            }
            
            var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var config = {
                type: 'line',
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                        label: "My First dataset",
                        backgroundColor: window.chartColors.red,
                        borderColor: window.chartColors.red,
                        data: [
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor()
                        ],
                        fill: false,
                    }, {
                        label: "My Second dataset",
                        fill: false,
                        backgroundColor: window.chartColors.blue,
                        borderColor: window.chartColors.blue,
                        data: [
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor(), 
                            randomScalingFactor()
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display:true,
                        text:'Chart.js Line Chart'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            }
                        }]
                    }
                }
            };

            
            var color = Chart.helpers.color;
            var barChartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: 'Dataset 1',
                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.red,
                    borderWidth: 1,
                    data: [
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor()
                    ]
                }, {
                    label: 'Dataset 2',
                    backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.blue,
                    borderWidth: 1,
                    data: [
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor(), 
                        randomScalingFactor()
                    ]
                }]

            };

            
            var randomScalingFactorCustom = function() {
                return Math.round(Math.random() * 100);
            };
            
            var radar_config = {
                type: 'radar',
                data: {
                    labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                    datasets: [{
                        label: "My First dataset",
                        backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
                        borderColor: window.chartColors.red,
                        pointBackgroundColor: window.chartColors.red,
                        data: [
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom()
                        ]
                    }, {
                        label: "My Second dataset",
                        backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                        borderColor: window.chartColors.blue,
                        pointBackgroundColor: window.chartColors.blue,
                        data: [
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom(), 
                            randomScalingFactorCustom()
                        ]
                    },]
                },
                options: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Radar Chart'
                    },
                    scale: {
                      ticks: {
                        beginAtZero: true
                      }
                    }
                }
            };
            
            var config_area = {
                data: {
                    datasets: [{
                        data: [
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                        ],
                        backgroundColor: [
                            color(chartColors.red).alpha(0.5).rgbString(),
                            color(chartColors.orange).alpha(0.5).rgbString(),
                            color(chartColors.yellow).alpha(0.5).rgbString(),
                            color(chartColors.green).alpha(0.5).rgbString(),
                            color(chartColors.blue).alpha(0.5).rgbString(),
                        ],
                        label: 'My dataset' // for legend
                    }],
                    labels: [
                        "Red",
                        "Orange",
                        "Yellow",
                        "Green",
                        "Blue"
                    ]
                },
                options: {
                    responsive: true,
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Polar Area Chart'
                    },
                    scale: {
                      ticks: {
                        beginAtZero: true
                      },
                      reverse: false
                    },
                    animation: {
                        animateRotate: false,
                        animateScale: true
                    }
                }
            };
            
            var config_pie = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom()
                        ],
                        backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.green,
                            window.chartColors.blue
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [
                        "Red",
                        "Orange",
                        "Yellow",
                        "Green",
                        "Blue"
                    ]
                },
                options: {
                    responsive: true
                }
            };
            
            var config_doughnut = {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom(),
                            randomScalingFactorCustom()
                        ],
                        backgroundColor: [
                            window.chartColors.red,
                            window.chartColors.orange,
                            window.chartColors.yellow,
                            window.chartColors.green,
                            window.chartColors.blue
                        ],
                        label: 'Dataset 1'
                    }],
                    labels: [
                        "Red",
                        "Orange",
                        "Yellow",
                        "Green",
                        "Blue"
                    ]
                },
                options: {
                    responsive: true
                }
            };
            

            window.onload = function() {
                var ctx_line = document.getElementById("chartjs_line").getContext("2d");
                window.myLine = new Chart(ctx_line, config);
                
                var ctx_bar = document.getElementById("chartjs_bar").getContext("2d");
                window.myBar = new Chart(ctx_bar, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Bar Chart'
                        }
                    }
                });
                
                window.myRadar = new Chart(document.getElementById("chartjs_radar"), radar_config);                
                
                var ctx_area = document.getElementById("chartjs_area");
                window.myPolarArea = Chart.PolarArea(ctx_area, config_area);
                
                var ctx_pie = document.getElementById("chartjs_pie").getContext("2d");
                window.myPie = new Chart(ctx_pie, config_pie);
                
                var ctx_doughnut = document.getElementById("chartjs_doughnut").getContext("2d");
                window.myDoughnut = new Chart(ctx_doughnut, config_doughnut);
            };
            
        }
    },
    settings: function(){
        
        var box = $("<div></div>").addClass("app-settings")
            .append($("<div></div>").addClass("app-settings-button").html("<span class=\"icon-magic-wand\"></span>"));
            
        var themesHeaderContainer = $("<div></div>").addClass("app-settings-themes-header").append("<span>Header themes</span>");
        var themesNavigationContainer = $("<div></div>").addClass("app-settings-themes-navigation").append("<span>Navigation themes</span>");
        var themesFooterContainer = $("<div></div>").addClass("app-settings-themes-footer").append("<span>Footer themes</span>");        
        
        
        var themes = new Array();
            themes.header = themes.navigation = themes.footer = new Array();
            themes.header = ["app-header-design-default","app-header-design-dark","app-header-design-lightblue","app-header-design-orange","app-header-design-blue"];
            themes.navigation = ["app-navigation-style-default","app-navigation-style-light","app-navigation-style-lightblue","app-navigation-style-purple","app-navigation-style-blue"];
            themes.footer = ["app-footer-default","app-footer-dark","app-footer-light","app-footer-purple","app-footer-blue"];
                        
        for(var i=0; i < themes.header.length; i++){
            var active = i === 0 ? " active" : "";
            themesHeaderContainer.append($("<div></div>").addClass(themes.header[i] + active));
        }
        for(var i=0; i < themes.navigation.length; i++){
            var active = i === 0 ? " active" : "";        
            themesNavigationContainer.append($("<div></div>").addClass(themes.navigation[i] + active));
        }
        for(var i=0; i < themes.footer.length; i++){
            var active = i === 0 ? " active" : "";
            themesFooterContainer.append($("<div></div>").addClass(themes.footer[i] + active));
        }
                
        box.append(themesHeaderContainer);
        box.append(themesNavigationContainer);
        box.append(themesFooterContainer);
        
        box.append($("<p><span>Notice</span><br>It's easy to customize our template. Use /dev/css/<strong>variables.less</strong> file to make Boooya more unique.</p>"));
        
        
        $("body").append(box);
        
        $("body").on("click",".app-settings-themes-header > div",function(){
            for(var i=0; i < themes.header.length; i++){
                $(".app-header").removeClass(themes.header[i]);
            }
            $(".app-header").addClass($(this).attr("class"));
            
            $(".app-settings-themes-header > div").removeClass("active");
            $(this).addClass("active");            
        });
        
        $("body").on("click",".app-settings-themes-navigation > div",function(){            
            for(var i=0; i < themes.navigation.length; i++){
                $(".app-navigation").removeClass(themes.navigation[i]);
            }
            $(".app-navigation").addClass($(this).attr("class"));
            
            $(".app-settings-themes-navigation > div").removeClass("active");
            $(this).addClass("active");            
        });
        
        $("body").on("click",".app-settings-themes-footer > div",function(){            
            for(var i=0; i < themes.footer.length; i++){
                $(".app-footer").removeClass(themes.footer[i]);
            }
            $(".app-footer").addClass($(this).attr("class"));
            
            $(".app-settings-themes-footer > div").removeClass("active");
            $(this).addClass("active");
        });                              
        
        $("body").on("click",".app-settings-button",function(){
            $(".app-settings").toggleClass("open");
        });
    }
};
function bar(id){
    Morris.Bar({
                    element: 'morris-bar-example',
                    data: id,
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Purchse', 'Sale'],
                    barColors: ['#2D3349', '#F04E51']
                });


var items = $("#morris-bar-example").find( "svg" ).find("rect");
var u=0;
var x=0;
$.each(items,function(index,v){
    
    var value1 = 0;
   if (u) {
    value1 = id[x].b;
    u=0;
    x++;
   }else{
     value1 = id[x].a;
    u++;
   }
    
    var value = value1;
    var newY = parseFloat( $(this).attr('y') - 20 );
    var halfWidth = parseFloat( $(this).attr('width') / 2 );
    var newX = parseFloat( $(this).attr('x') ) +  halfWidth;
    var output = '<text style="text-anchor: middle; font: 12px sans-serif;" x="'+newX+'" y="'+newY+'" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,6.875)"><tspan dy="3.75">'+value+'</tspan></text>';
    $("#morris-bar-example").find( "svg" ).append(parseSVG(output));
});
}
$(function(){
    app_demo.googlemap();
    app_demo.jvectormap();
    app_demo.solutions.bank.change_password();
    app_demo.solutions.bank.change_pin();
    app_demo.charts.morris();
    app_demo.charts.morris_bar();
    app_demo.charts.rickshaw();
    app_demo.charts.chartjs();
    
   // app_demo.settings();
    
    setTimeout(function(){
        //app_demo.page_like.load();
    },1000);
});