$(document).ready(function () {

    //Resize the charts when window size changed
    setTimeout(function () {
        window.onresize = function () {
            backup_baremetal_charts.resize();
            backup_frequency_charts.resize();
            backup_retention_charts.resize();


        }
    }, 200);
 
    // =================================================================================
    // Get Backup Baremetal info 
    var count = [],
    baremetal = [];

    function getBackupBaremetal() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/backup/backup_baremetal.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        count.push(result[i].count);
                        baremetal.push(result[i].baremetal);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return count, baremetal;
    }

    getBackupBaremetal();
    var backup_baremetal_charts = echarts.init(document.getElementById("container_backup_baremetal"));

    var option_backup_baremetal = {
        color: ['#749f83',  '#ca8622'],
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Backup Baremetal',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = baremetal.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: baremetal[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Backup Baremetal',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['50%', '40%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = count.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: baremetal[i],
                            value: count[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    backup_baremetal_charts.setOption(option_backup_baremetal);
    backup_baremetal_charts.on('click', function (params) {
        var baremetal = params.name;
        $.ajax({
            url: "backend/backup/search_backup.php",
            data: { baremetal: baremetal},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup baremetal:'+baremetal);
                    $("#myTable").html(result);
                }
            }
        })
    });

    // =================================================================================
    // Get Bakcup Frequency info 
    var name = [],
        frequency = [];

    function getBackupFrequency() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/backup/backup_frequency.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        name.push(result[i].name);
                        frequency.push(result[i].frequency);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return name, frequency;
    }

    getBackupFrequency();
    var backup_frequency_charts = echarts.init(document.getElementById("container_backup_frequency"));

    var option_backup_frequency = {
        color: ['#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3'],
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Bakcup Frequency',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = name.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: name[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Bakcup Frequency',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['50%', '40%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = frequency.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: name[i],
                            value: frequency[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };

    backup_frequency_charts.setOption(option_backup_frequency);
    backup_frequency_charts.on('click', function (params) {
        var frequency =params.name;
        if(frequency==0){
            frequency="EMPTY"
        }
        $.ajax({
            url: "backend/backup/search_backup.php",
            data: { frequency: frequency},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup frequency: '+frequency);
                    $("#myTable").html(result);
                }
            }
        })
    });
    // =================================================================================
    // Get Backup Retention info 
    var name = [],
    retention = [];

    function getBackupRetention() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/backup/backup_retention.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    for (var i = 0; i < result.length; i++) {
                        name.push(result[i].name);
                        retention.push(result[i].retention);
                    }
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        return name, retention;
    }

    getBackupRetention();
    var backup_retention_charts = echarts.init(document.getElementById("container_backup_retention"));

    var option_backup_retention = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        title: {
            text: 'Bakcup Retention',
            x: 'center'
        },
        legend: {
            orient: 'horizontal',
            x: 'center',
            y: 'bottom',
            data: (function () {
                var res = [];
                var len = name.length;
                for (var i = 0, size = len; i < size; i++) {
                    res.push({
                        name: name[i],
                    });
                }
                return res;
            })()

        },
        series: [
            {
                name: 'Bakcup Retention',
                type: 'pie',
                radius: ['35%', '60%'],
                center: ['50%', '40%'],
                label: {
                    formatter: "{b}: {c}"
                },
                data: (function () {
                    var res = [];
                    var len = retention.length;
                    for (var i = 0, size = len; i < size; i++) {
                        res.push({
                            name: name[i],
                            value: retention[i]
                        });
                    }
                    return res;
                })()
            }
        ]
    };


    backup_retention_charts.setOption(option_backup_retention);
    backup_retention_charts.on('click', function (params) {
        var retention = params.name;
        if(retention==0){
            retention="EMPTY"
        }
        $.ajax({
            url: "backend/backup/search_backup.php",
            data: { retention: retention},
            type: 'POST',
            success: function (result) {
                if (result) {
                    $('#table-frame').fadeIn();
                    $('#table_title').html('Backup retention: '+retention);
                    $("#myTable").html(result);
                }
            }
        })
    });
 // =================================================================================
    // Get backup policy info 


    function getBackupPolicy(){
        $.ajax({
            type: "post",
            async: false,
            url: "backend/backup/backup_lookup.php",
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
    getBackupPolicy();

    $(".selectpicker").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
        var selectedD = $(this).find('option').eq(clickedIndex).text();
        $.ajax({
            type: "post",
            async: false,
            data:{servername:selectedD},
            url: "backend/backup/backup_lookup.php",
            success: function (result1) {
                if (result1) {
                    var result=JSON.parse(result1);                    
                    var str = "";
                    str +="<thead><tr><th>Server</th><th>Backup</th><th>Baremetal</th><th>Frenquency</th><th>Retention</th></tr></thead><tbody>"
                    for (var i = 0; i < result.length; i++) {
                        str += "<tr><td>" + result[i].servername+ "</td><td>" + result[i].backupname + "</td><td>" + result[i].baremetal +"</td><td>" + result[i].frequency +"</td><td>" + result[i].retention +"</td></tr>";
                    }
                    str +="</tbody>"
                    $("#backupTable").html(str);
                 
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
        
      });
    
  

});