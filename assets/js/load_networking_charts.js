$(document).ready(function () {

 //Resize the charts when window size changed
    setTimeout(function () {
        window.onresize = function () {

            networking_owner_charts.resize();
            networking_zone_charts.resize();
            networking_ip_charts.resize();

        }
    }, 200);

   
    // =================================================================================
    // Get networking zone info 
    var names=[], names1 = [], counts1 = [],names2 = [], counts2 = [] ;

    function getNetworkingZone() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/networking/networking_zone.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < 4; i++) {
                        names1.push(result[i].names);
                        counts1.push(result[i].counts);
                    }
                    for (var i = 4; i < result.length; i++) {
                        names2.push(result[i].names);
                        counts2.push(result[i].counts);
                    }
                    names=names1.concat(names2)

                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return names, names1, counts1, names2, counts2;
    }

    getNetworkingZone();

    var networking_zone_charts = echarts.init(document.getElementById("container_networking_zone"));

    var option_networking_zone = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Networking Zone',
            x: 'center'
        },
        legend: {
            orient: 'vertical',
            x: 'left',
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
                name: 'Networking Zone',
                type: 'pie',
                selectedMode: 'single',
                radius: ['0%', '50%'],
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
                            name: names1[i],
                            value: counts1[i]
                        });
                    }
                    return res;
                })()
            },
            {
                name: 'Networking Zone',
                type:'pie',
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
                            name: names2[i],
                            value: counts2[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    networking_zone_charts.setOption(option_networking_zone);
    networking_zone_charts.on('click', function (params) {
        var zone = params.name;
        $.ajax({
            url: "backend/networking/search_networking.php",
            data: { zone: zone},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Networking zone: '+zone);
                    $("#myTable").html(result);
                }
            }
        })
    });
 // =================================================================================
    // Get networking IP info 
    var names = [],
        counts = [];

    function getNetworkingIP() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/networking/networking_ip.php",
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

    getNetworkingIP();

    var networking_ip_charts = echarts.init(document.getElementById("container_networking_ip"));
    var option_networking_ip = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'IPs usage',
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
                name: 'IPs usage',
                type: 'pie',
                radius: ['35%', '60%'],
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

    networking_ip_charts.setOption(option_networking_ip);
    networking_ip_charts.on('click', function (params) {
        var ip = params.name;
        $.ajax({
            url: "backend/networking/search_networking.php",
            data: { ip: ip},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Networking IP: '+ip);
                    $("#myTable").html(result);
                }
            }
        })
    });

 // =================================================================================
    // Get networking owner info 
    var names = [],
        counts = [];

    function getNetworkingOwner() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/networking/networking_owners.php",
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

    getNetworkingOwner();

    var networking_owner_charts = echarts.init(document.getElementById("container_networking_owner"));
    var option_networking_owner = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Networking Owner',
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
                name: 'Networking Owner',
                type: 'pie',
                radius: ['35%', '60%'],
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

    networking_owner_charts.setOption(option_networking_owner);
    networking_owner_charts.on('click', function (params) {
        var owner = params.name;
        $.ajax({
            url: "backend/networking/search_networking.php",
            data: { owner: owner},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Networking owner: '+owner);
                    $("#myTable").html(result);
                }
            }
        })
    });
// =================================================================================
    // Get ip address on a particular vlan


    function getIPOnVLAN(){
        $.ajax({
            type: "post",
            async: false,
            url: "backend/networking/networking_lookup.php",
            success: function (result1) {
                if (result1) {
                    var result=JSON.parse(result1);
                    var str='';
                    for (var i = 0; i < result.length; i++) {
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
    getIPOnVLAN();

    $(".selectpicker").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
        var selectedD = $(this).find('option').eq(clickedIndex).text();
        $.ajax({
            type: "post",
            async: false,
            data:{vlan:selectedD},
            url: "backend/networking/networking_lookup.php",
            success: function (result1) {
                if (result1) {
                    var result=JSON.parse(result1);                    
                    var str = "";
                    str +="<thead><tr><th>Server</th><th>Vlan</th><th>Address</th><th>Value</th><th>Host</th><th>IP Modifier</th><th>Modify Date</th><th>Incident</th><th>Builder</th></tr></thead><tbody>"
                    for (var i = 0; i < result.length; i++) {
                        str += "<tr><td>" + result[i].servername+ "</td><td>" + result[i].vlan + "</td><td>" + result[i].address +"</td><td>" + result[i].value +"</td><td>" + result[i].host +"</td><td>" + result[i].modifier +"</td><td>" + result[i].modifydate +"</td><td>" + result[i].incident +"</td><td>" + result[i].builder +"</td></tr>";
                    }
                    str +="</tbody>"
                    $("#ipTable").html(str);
                    $("#ipTitle").html("IP address on VLAN "+selectedD);
                 
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
      });
   
});