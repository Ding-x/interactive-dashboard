$(document).ready(function () {

    //Resize the charts when window size changed
    setTimeout(function () {
        window.onresize = function () {
            server_managed_charts.resize();
            server_status_charts.resize();
            server_type_charts.resize();
            server_os_charts.resize();
            server_owner_charts.resize();
            server_datacenter_charts.resize();
        }
    }, 200);

    // =================================================================================
    // Get server Managed statistic info 
    var bool = [],
        counts = [];

    function getServerManaged() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_managed.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        bool.push(result[i].bool);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return bool, counts;
    }

    getServerManaged();
    var server_managed_charts = echarts.init(document.getElementById("container_server_managed"));

    var option_managed = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Server Managed',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = bool.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: bool[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Server Managed',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['50%', '50%'],
                label: {
                    formatter: "{b}: {c}",
                },
                data: (function () {
                    var res = [];
                    var len = counts.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: bool[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    server_managed_charts.setOption(option_managed);
    server_managed_charts.on('click', function (params) {
        var managed = params.name;
        $.ajax({
            url: "backend/server/search_server.php",
            data: { managed: managed },
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Server manage: ' + managed);
                    $("#myTable").html(result);
                }
            },
        })
    });

    // =================================================================================
    // Get server Status statistic info 
    var status = [],
        counts = [];

    function getServerStatus() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_status.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        status.push(result[i].status);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return status, counts;
    }

    getServerStatus();
    var server_status_charts = echarts.init(document.getElementById("container_server_status"));

    var option_status = {
        color: ['#61a0a8', '#d48265', '#91c7ae', '#749f83'],
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Server Status',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = status.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: status[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Server Status',
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
                            name: status[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    server_status_charts.setOption(option_status);
    server_status_charts.on('click', function (params) {
        var status = params.name;
        $.ajax({
            url: "backend/server/search_server.php",
            data: {status: status},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Server status: ' + status);
                    $("#myTable").html(result);
                }
            }
        })
    });
    // =================================================================================
    // Get server Type statistic info 
    var typeNames = [],
        counts = [];

    function getServerType() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_type.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        typeNames.push(result[i].typeName);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return typeNames, counts;
    }

    getServerType();
    var server_type_charts = echarts.init(document.getElementById("container_server_type"));

    var option_type = {
        color: ['#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3'],
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Server Type',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = typeNames.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: typeNames[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Server Type',
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
                            name: typeNames[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };


    server_type_charts.setOption(option_type);
    server_type_charts.on('click', function (params) {
        var type = params.name;
        $.ajax({
            url: "backend/server/search_server.php",
            data: {type: type},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Server type: ' + type);
                    $("#myTable").html(result);
                }
            }
        })
    });
    // =================================================================================
    // Get server OS statistic info 
    var osNames = [],
        counts = [];

    function getServerOS() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_os.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        osNames.push(result[i].osName);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return osNames, counts;
    }

    getServerOS();

    var server_os_charts = echarts.init(document.getElementById("container_server_os"));
    var option_os = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Server OS',
            x: 'center'
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data: (function () {
                var res = [];
                var len = osNames.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: osNames[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Server OS',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['60%', '60%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = counts.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: osNames[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    server_os_charts.setOption(option_os);
    server_os_charts.on('click', function (params) {
        var os = params.name;
        $.ajax({
            url: "backend/server/search_server.php",
            data: {os: os},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Server os: ' + os);
                    $("#myTable").html(result);
                }
            }
        })
    });


    // =================================================================================
    // Get server datacenter statistic info 
    var datacenter = [],
        counts = [];

    function getServerDataCenter() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_datacenter.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        datacenter.push(result[i].center);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return datacenter, counts;
    }
    getServerDataCenter();

    var server_datacenter_charts = echarts.init(document.getElementById("container_server_datacenter"));
    var option_datacenter = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Server Datacenter',
            x: 'center'
        },
        legend: {
            orient: 'vertical',
            x: 'right',
            data: (function () {
                var res = [];
                var len = datacenter.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: datacenter[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Server Datacenter',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['40%', '60%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = counts.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: datacenter[i],
                            value: counts[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    server_datacenter_charts.setOption(option_datacenter);
    server_datacenter_charts.on('click', function (params) {
        var datacenter = params.name;
        $.ajax({
            url: "backend/server/search_server.php",
            data: {datacenter: datacenter},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Server datacenter: ' + datacenter);
                    $("#myTable").html(result);
                }
            }
        })
    });


    // =================================================================================
    // Get server Owner statistic info 
    var ownerNames = [],
        counts = [];

    function getServerOwner() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_owner.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        ownerNames.push(result[i].owner);
                        counts.push(result[i].counts);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return ownerNames, counts;
    }

    getServerOwner();

    var server_owner_charts = echarts.init(document.getElementById("container_server_owner"));
    var option_owner = {
        title: {
            text: 'Server Owner',
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
        xAxis: {
            type: 'category',
            data: ownerNames,
            axisLabel: {
                rotate: 70,
                interval: 0,
                fontSize: 10
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

    server_owner_charts.setOption(option_owner);
    server_owner_charts.on('click', function (params) {
        var owner = params.name;
        $.ajax({
            url: "backend/server/search_server.php",
            data: { owner: owner},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Server owner: ' + owner);
                    $("#myTable").html(result);
                }
            }
        })
    });


    // =================================================================================
    // Get server info 


    function getServerInfo(){
        $.ajax({
            type: "post",
            async: false,
            url: "backend/server/server_info.php",
            success: function (result) {
                if (result) {
                    $(".selectpicker").html(result);
                    $(".selectpicker").selectpicker('refresh');
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }
    getServerInfo();

    $(".selectpicker").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
        var selectedD = $(this).find('option').eq(clickedIndex).text();
        $.ajax({
            type: "post",
            async: false,
            data:{server:selectedD},
            url: "backend/server/server_info.php",
            success: function (result) {
                if (result) {
                    $("#server_detail").html(result);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
      });
});