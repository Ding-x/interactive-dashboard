$(document).ready(function () {


    function run() {
        getAllReport();
        refresh();
    }
    run();

    //Refresh each single report's count
    function refresh() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/custom/report_all.php",
            success: function (result) {
              
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }

    //Get all report list
    function getAllReport() {
        $.ajax({
            type: "post",
            async: false,
            data: {type:2},
            url: "backend/custom/report_fetch.php",
            success: function (result) {
                if (result) {
                    $("#issue_display_list").html(result);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }

    //Get single report info
    function getSingleReport(id) {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/custom/report_single.php",
            data: {id:id},
            success: function (result) {
                if (result) {
                    $("#myTable").html(result);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }

    //Click to show the report table
    $(document).on('click', '.issue-bar' ,function(){
        var id=$(this).attr("id");
        var title= $(this).find('.issue-name').text().split(". ")[1].split(" :")[0];
        $('#table-frame').fadeIn();
        $('#table_title').html(title);
        getSingleReport(id);
    })
    
    //Close report table
    $("#table_close").click(function () {
        $('#search_table').val("");
        $('#table-frame').fadeOut();
    });

    //Open 'manage reports' interface
    $("#issue_manage_open").click(function(){
        $('#issue_display').fadeOut(100, function () {
            $('#issue_edit').fadeIn();
        });
        $.ajax({
            type: "post",
            async: false,
            url: "backend/custom/report_fetch.php",
            data: {type:1},
            success: function (result) {
                if (result) {
                    $("#issue_edit_list").html(result);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    })

    //Close 'manage reports' interface
    $("#issue_manage_close").click(function(){
        location.reload();
    })

    //Get report's category
    function getCategory(){
        $.ajax({
            type: "post",
            async: false,
            url: "backend/custom/report_category.php",
            success: function (result) {
                if (result) {
                    $("#issue_cate_select").html(result);
                    $("#cate_edit").html(result);
                    $("#issue_cate_select").selectpicker('refresh');
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }
    getCategory();

    //Fill the category and priority into the interfaces
    var priority='';
    var category='';

    function select(priority,category){
        $.ajax({
            type: "post",
            async: false,
            data:{priority:priority,category:category},
            url: "backend/custom/report_fetch.php",
            success: function (result) {
                if (result) {
                    $("#issue_display_list").html(result);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }

    $("#issue_cate_select").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
        var selectedD = $(this).val();
        category=selectedD;
        select(priority,category);
        
      });

      $("#issue_prio_select").on("changed.bs.select", function(e, clickedIndex, newValue, oldValue) {
        var selectedD = $(this).val();
        priority=selectedD;
        select(priority,category);
        
      });

      

})