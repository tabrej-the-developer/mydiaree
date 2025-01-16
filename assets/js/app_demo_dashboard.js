"use strict";

var app_demo_dashboard = {    
    rickshaw: function(){

        if($("#dashboard-chart-line").length > 0){
            
            var sales=[];
            var max=0;
              $.ajax({
            url: 'index.php?route=common/newdashboard/getdataActivitydata&token='+getURLVar('token')+'&filter_from='+$('#filter_from').val()+'&filter_to='+$('#filter_to').val(),
            dataType: 'json',
            async:false,
		    success: function(json) {
                   
                   
                   sales=json['sales'];
                   max=json['max'];
                   
                 
                    }
                });
          
            var data1 = sales;
            
            var data2 = [
                
            ];

            var rlp = new Rickshaw.Graph({
                element: document.getElementById("dashboard-chart-line"),
                renderer: 'lineplot',
                min: 1,
                max: max,
                padding: {top: 10},
                series: [{data: data1, color: '#2D3349', name: "Activity click"},{data: data2, color: '#76AB3C', name: "Activity"}]
            });

            var xTicks = new Rickshaw.Graph.Axis.X({
                graph: rlp,                
                orientation: "bottom",
                element: document.querySelector("#xaxis")
            });
            var yTicks = new Rickshaw.Graph.Axis.Y({
                graph: rlp,                
                orientation: "left",
                element: document.querySelector("#yaxis")
            });

            new Rickshaw.Graph.HoverDetail({
                graph: rlp,
                formatter: function(series, x, y) {                    
                    var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
                    var content = swatch + series.name + ": " + parseInt(y) + '<br>';
                    return content;
                }
            });

            rlp.render();
            
            var rlp_resize = function () {
                rlp.configure({
                    width: $("#dashboard-chart-line").width(),
                    height: $("#dashboard-chart-line").height()
                });
                rlp.render();
            }
                                    
            window.addEventListener('resize', rlp_resize);
            rlp_resize();
            // eof lineplot
        }
        
        
        
        
        
        
        
        if($("#dashboard-chart-line11").length > 0){
           
            var sales=[];
            var max=0;
              $.ajax({
            url: 'index.php?route=common/newdashboard/getcommodityActivitydata&token='+getURLVar('token'),
            dataType: 'json',
            async:false,
		    success: function(json) {
                   
                   
                   sales=json['sales'];
                   max=json['max'];
                   
                 
                    }
                });
          
            var data1 = sales;
            
            var data2 = [
                
            ];

            var rlp = new Rickshaw.Graph({
                element: document.getElementById("dashboard-chart-line11"),
                renderer: 'lineplot',
                min: 1,
                max: max,
                padding: {top: 10},
                series: [{data: data1, color: '#2D3349', name: "Activity click"},{data: data2, color: '#76AB3C', name: "Activity"}]
            });

            var xTicks = new Rickshaw.Graph.Axis.X({
                graph: rlp,                
                orientation: "bottom",
                element: document.querySelector("#xaxis")
            });
            var yTicks = new Rickshaw.Graph.Axis.Y({
                graph: rlp,                
                orientation: "left",
                element: document.querySelector("#yaxis")
            });

            new Rickshaw.Graph.HoverDetail({
                graph: rlp,
                formatter: function(series, x, y) {                    
                    var swatch = '<span class="detail_swatch" style="background-color: ' + series.color + '"></span>';
                    var content = swatch + series.name + ": " + parseInt(y) + '<br>';
                    return content;
                }
            });

            rlp.render();
            
            var rlp_resize = function () {
                rlp.configure({
                    width: $("#dashboard-chart-line11").width(),
                    height: $("#dashboard-chart-line11").height()
                });
                rlp.render();
            }
                                    
            window.addEventListener('resize', rlp_resize);
            rlp_resize();
            // eof lineplot
        }
        
        
        
        
        
        
    },
    map: function(){        
        if($("#dashboard-map").length > 0){
            
            var data = [];
                data.names = ["Shopnumone","Best Shoptwo","Third Awesome","Alltranding","Shop Name"];                
                data.sales = ["135","121","107","83","77"];            
            
            $("#dashboard-map").vectorMap({
                map: "us_aea_en", 
                backgroundColor: "#FFF",
                regionsSelectable: false,
                regionStyle: {
                    selected: {fill: "#2D3349"},
                    initial: {fill: "#DBE0E4"}
                },
                markers: [
                    [61.18, -149.53],
                    [21.18, -157.49],
                    [40.66, -73.56],
                    [41.52, -87.37],
                    [35.22, -80.84]                    
                ],
                markerStyle: {
                    initial: {
                        fill: '#2D3349',
                        stroke: '#2D3349'
                    }
                },                
                onMarkerTipShow: function(event, label, index){
                  label.html(
                    '<b>'+data.names[index]+'</b><br/>'+
                    '<b>Sales: </b>'+data.sales[index]+'</br>'                    
                  );
                }
            });
        }
    }
};

$(function(){

    app_demo_dashboard.rickshaw();
    app_demo_dashboard.map();
});