$(document).ready(function () {

    //Resize the charts when window size changed
    setTimeout(function () {
        window.onresize = function () {
            app_sla_charts.resize();
        }
    }, 200);

    // Get application sla info 
    var sla=[],count=[];

    function getAppSla() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/application/app_sla.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result)
                    for (var i = 0; i < result.length; i++) {
                        sla.push(result[i].sla);
                        count.push(result[i].count);
                    } 
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
        return sla,count;
    }

    getAppSla();


    var app_sla_charts = echarts.init(document.getElementById("container_app_sla"));

    var option_app_sla = {
        title: {
            text: 'sla',
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            data: ['amout']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        yAxis: {
            type: 'value',
            boundaryGap: [0, 0.01]
        },
        xAxis: {
            type: 'category',
            data: sla
        },
        series: [
            {
                name: 'amout',
                type: 'bar',
                data: count
            },
           
        ]
    };
    

    app_sla_charts.setOption(option_app_sla);
    app_sla_charts.on('click', function (params) {
        var sla = params.name;
        $.ajax({
            url: "backend/application/search_app.php",
            data: { sla: sla},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup sla: '+sla);
                    $("#myTable").html(result);
                }
            }
        })
    });
    
     // =================================================================================
    // Get application detail info 

    function getIncident(){
        $.ajax({
            type: "post",
            async: false,
            url: "backend/application/app_lookup.php",
            data:{category:1},
            success: function (result1) {
                if (result1) {
                    var result=JSON.parse(result1);
                    var str='';
                    for (var i = 0; i < result.length; i++) {
                        if(result[i].name.length>3)
                            str+='<option>'+result[i].name+'</option>';
                    }
    
                    $(".selectpicker").html(str);
                    $(".selectpicker").selectpicker('refresh');
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }
    getIncident();

    $(".selectpicker").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
        var selectedD = $(this).val();
        $.ajax({
            type: "post",
            async: false,
            data:{appname:selectedD},
            url: "backend/application/app_lookup.php",
            success: function (result1) {
                if (result1) {
                    var result=JSON.parse(result1); 
                    var str = "";
                    if(result!=null){
                        str +="<thead><tr><th>App</th><th>Server</th><th>Sla</th><th>Description</th><th>Team</th></tr></thead><tbody>"
                        for (var i = 0; i < result.length; i++) {
                            str += "<tr><td>" + result[i].appname + "</td><td>" + result[i].servername +"</td><td>" + result[i].sla +"</td><td>" + result[i].des +"</td><td>" + result[i].username +"</td></tr>";
                        }
                        str +="</tbody>"
                    }
                    $("#incidentTable").html(str);

                 
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
      });


});