$(document).ready(function () {

    //Resize the charts when window size changed
    setTimeout(function () {
        window.onresize = function () {
            build_date_charts.resize();
            build_period_charts.resize();
            build_user_charts.resize();
        }
    }, 200);

    // Get server daily build info 
    var data=[],queryData;

    function getServerBuildDate() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/build/build_daily.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) 
                    queryData=result;
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
        return queryData;
    }

    getServerBuildDate();

    function buildData(queryData) {
        return {
            name: queryData.name,
            value: [
                queryData.value.time,
                queryData.value.count,
            ]
        }
    }

    for (var i = 0; i < 150; i++) {
        data.push(buildData(queryData[i]));
    }

    var build_date_charts = echarts.init(document.getElementById("container_build_daily_complete"));

    var option_build_date = {
        title: {
            text: 'Daily Servers Build',
            x:'center'
        },
        tooltip: {
            trigger: 'axis',
            formatter: function (params) {
                params = params[0];
                var date = params.name;
                return date + ' : ' + params.value[1];
            },
            axisPointer: {
                animation: false
            }
        },
        xAxis: {
            type: 'time',
            splitLine: {
                show: false
            },
            boundaryGap: [0, '100%'],
  
        },
        yAxis: {
            type: 'value',
            boundaryGap: [0, '60%'],
            splitLine: {
                show: false
            }
        },
        series: [{
            name: '模拟数据',
            type: 'line',
            showSymbol: false,
            hoverAnimation: false,
            data: data
        }]
    };
    

    build_date_charts.setOption(option_build_date);
    i=150;
    setInterval(function () {
        if(i<queryData.length-1){
            data.shift();
            data.push(buildData(queryData[i++]));
            data.push(buildData(queryData[i++]));
            build_date_charts.setOption({
                series: [{
                    data: data
                }]
            });
        }
       
    }, 400);

    // =================================================================================
    // Get build in last week, month and year info 
    var names = [],
        counts = [];

    function getBuildPeriod() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/build/build_week_month_year.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        names.push(result[i].names);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return names, counts;
    }

    getBuildPeriod();
    var build_period_charts = echarts.init(document.getElementById("container_build_wmy"));

    var option_build_period = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Build Completion',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = names.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: names[i],
                    });
                }
                return res;
            })()

        },

        series: [
            {
                name: 'Build Completion',
                type: 'pie',
                radius: '60%',
                center: ['50%', '50%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = counts.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: names[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    build_period_charts.setOption(option_build_period);
    build_period_charts.on('click', function (params) {
        var period = params.name;
        $.ajax({
            url: "backend/build/search_build.php",
            data: { period: period},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Buildt in ' + period);
                    $("#myTable").html(result);
                }
            }
        })
    });

 // =================================================================================
    // Get Build User  info 
    var names = [],
        counts = [];

    function getBuildUser() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/build/build_user.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        names.push(result[i].names);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return names, counts;
    }

    getBuildUser();

    var build_user_charts = echarts.init(document.getElementById("container_build_user"));
    var option_build_user = {
        title: {
            text: 'Built by',
            x: 'center'
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        legend: {
            data: ['Amout'],
            x: 'left'
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        color:['#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
        xAxis: {
            type: 'category',
            data: names,
            axisLabel: {
                            rotate: 70,
                            interval: 0,
                            fontSize: 12
                        },
        },

        yAxis: {
            type: 'value',
            boundaryGap: [0, 0.01]
        },
        series: [{
                "name": "Amout",
                "type": "bar",
                "data": counts,
            }
        ]
    };

    build_user_charts.setOption(option_build_user);
    build_user_charts.on('click', function (params) {
        var user = params.name;
        $.ajax({
            url: "backend/build/search_build.php",
            data: { user: user},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Buildt by ' + user);
                    $("#myTable").html(result);
                }
            }
        })
    });
     // =================================================================================
    // Get Build Incident info 


    function getIncident(){
        $.ajax({
            type: "post",
            async: false,
            url: "backend/build/build_incident.php",
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
        var selectedD = $(this).find('option').eq(clickedIndex).text();
        $.ajax({
            type: "post",
            async: false,
            data:{incident:selectedD},
            url: "backend/build/build_incident.php",
            success: function (result1) {
                if (result1) {
                    var result=JSON.parse(result1);                    
                    var str = "";
                    str +="<thead><tr><th>Server</th><th>Incident</th><th>User</th><th>Start Date</th><th>Completion Date</th><th>Notes</th></tr></thead><tbody>"
                    for (var i = 0; i < result.length; i++) {
                        str += "<tr><td>" + result[i].servername + "</td><td>" + result[i].incident +"</td><td>" + result[i].username +"</td><td>" + result[i].startDate +"</td><td>" + result[i].endDate + "</td><td>" + result[i].notes +"</td></tr>";
                    }
                    str +="</tbody>"
                    $("#incidentTable").html(str);
                 
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
      });

});