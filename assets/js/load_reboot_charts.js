$(document).ready(function () {
    
    //Resize the charts when window size changed
    setTimeout(function () {
        window.onresize = function () {
            reboot_enabled_charts.resize();
            reboot_schedule_charts.resize();
            reboot_weeks_charts.resize();
            reboot_time_charts.resize();
        }
    }, 200);
 
    // =================================================================================
    // Get reboot enabled info 
    var enabled = [],
        counts = [];

    function getRebootEnabled() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/reboot/reboot_enabled.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        enabled.push(result[i].enabled);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return enabled, counts;
    }

    getRebootEnabled();
    var reboot_enabled_charts = echarts.init(document.getElementById("container_reboot_enabled"));

    var option_reboot_enabled = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Reboot Enabled',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = enabled.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: enabled[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Reboot Enabled',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['50%', '50%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = counts.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: enabled[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    reboot_enabled_charts.setOption(option_reboot_enabled);

    reboot_enabled_charts.on('click', function (params) {
        var enabled = params.name;
        if(enabled==''){
            enabled="EMPTY"
        }
        $.ajax({
            url: "backend/reboot/search_reboot.php",
            data: { enabled: enabled},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup enabled: '+enabled);
                    $("#myTable").html(result);
                }
            }
        })
    });
    // =================================================================================
    //Get reboot schedule info 
    var schedule = [],
        counts = [];

    function getRebootSchedule() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/reboot/reboot_schedule.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        schedule.push(result[i].schedule);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return schedule, counts;
    }

    getRebootSchedule();
    var reboot_schedule_charts = echarts.init(document.getElementById("container_reboot_schedule"));

    var option_reboot_schedule = {
        color:[ '#d48265', '#91c7ae','#749f83'],
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Reboot Schedule',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = schedule.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: schedule[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Reboot Schedule',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['50%', '50%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = counts.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: schedule[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    reboot_schedule_charts.setOption(option_reboot_schedule);
    reboot_schedule_charts.on('click', function (params) {
        var schedule = params.name;
        $.ajax({
            url: "backend/reboot/search_reboot.php",
            data: { schedule: schedule},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup schedule: '+schedule);
                    $("#myTable").html(result);
                }
            }
        })
    });
    // =================================================================================
    // Get reboot plan info 
    var weeks = [],weeks1 = [], counts1 = [],weeks2 = [], counts2 = [];

    function getRebootWeeks() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/reboot/reboot_weeks.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < 4; i++) {
                        weeks1.push(result[i].weeks);
                        counts1.push(result[i].counts);
                    }
                    for (var i = 4; i < result.length; i++) {
                        weeks2.push(result[i].weeks);
                        counts2.push(result[i].counts);
                    }
                    weeks=weeks1.concat(weeks2)

                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return weeks,weeks1, counts1,weeks2,counts2;
    }

    getRebootWeeks();
    var reboot_weeks_charts = echarts.init(document.getElementById("container_reboot_weeks"));

    var option_reboot_weeks = {
        color:['#c23531','#aaa', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'],
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Reboot by Weeks',
            x: 'center'
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data: (function () {
                var res = [];
                var len = weeks.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: weeks[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Reboot by Weeks',
                type: 'pie',
                selectedMode: 'single',
                radius: [0, '50%'],
                center: ['50%', '55%'],
                label: {
                    normal: {
                        position: 'inner'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data: (function () {
                    var res = [];
                    var len = counts1.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: weeks1[i],
                            value: counts1[i]
                        });
                    }
                    return res;
                })()
            },
            {
                name: 'Reboot by Weeks',
                type: 'pie',
                radius: ['55%', '75%'],
                center: ['50%', '55%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = counts2.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: weeks2[i],
                            value: counts2[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };


    reboot_weeks_charts.setOption(option_reboot_weeks);
    reboot_weeks_charts.on('click', function (params) {
        var weeks = params.name;
        if(weeks==''){
            weeks="EMPTY"
        }
        $.ajax({
            url: "backend/reboot/search_reboot.php",
            data: { weeks: weeks},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup weeks: '+weeks);
                    $("#myTable").html(result);
                }
            }
        })
    });
    // =================================================================================
    // Get reboot time info 
    var time = [],
        counts = [];

    function getRebbotTime() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/reboot/reboot_time.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        time.push(result[i].time);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return time, counts;
    }

    getRebbotTime();

    var reboot_time_charts = echarts.init(document.getElementById("container_reboot_time"));
    var option_reboot_time = {
        tooltip: {
            trigger: 'axis',
            formatter: function (params) {
                params = params[0];
                var date = params.name;
                return date + ' : ' + params.value;
            },
            axisPointer: {
                animation: false
            }
        },
        title: {
            text: 'Reboot Time',
            x: 'center'
        },
        
        xAxis: {
            type: 'category',
            data:time
        },
        yAxis: {
            type: 'value'
        },
        series: [{
            data: counts,
            type: 'line',
            smooth: true
        }]
    };

    reboot_time_charts.setOption(option_reboot_time);
    reboot_time_charts.on('click', function (params) {
        var time = params.name;
        if(weeks==''){
            weeks="EMPTY"
        }
        $.ajax({
            url: "backend/reboot/search_reboot.php",
            data: { time: time},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup time: '+time);
                    $("#myTable").html(result);
                }
            }
        })
    });

});