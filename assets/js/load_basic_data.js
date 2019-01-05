$(document).ready(function () {

    //Refresh the page every 5 mins
    setTimeout(function(){
        window.location.reload();
    },300000)


    // Get basic info to show on dashboard's header panel
    function getBasicInfo() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/basic_info.php",
            data: {},
            dataType: "json",
            success: function (result) {
                if (result) {
                    $("#server_count").html(result.server_count);
                    $("#app_count").html(result.app_count);
                    $("#ip_count").html(result.ip_count);
                    $("#team_count").html(result.team_count);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }
    getBasicInfo();

    // Get each single alert
    function getAlert() {
        $.ajax({
            type: "post",
            async: false,
            url: "backend/alert.php",
            success: function (result) {
                if (result) {
                    $(".dashbord-alert").html(result);
                }
            },
            error: function (errmsg) {
                alert("Ajax wrong!" + errmsg);
            }
        });
    }
    getAlert();

    // Get each single alert
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

    // Click to see each single report's detail info
    $(document).on('click', '.panel-footer' ,function(){
        var id=$(this).attr("id");
        var title= $('#col_title_'+id).text();
        $('#table-frame').fadeIn();
        $('#table_title').html(title);
        getSingleReport(id);
    })

    //Search function in the report table
    $("#search_table").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });

    //Close the report table
    $("#table_close").click(function () {
        $('#search_table').val("");
        $('#table-frame').fadeOut();
    });

    //Export report table to excel
    $("#export_btn").click(function(){
        $("#myTable").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: "NewExcelTable"
        });
    });


    //Print report table
    function printData()
    {
        var divToPrint=document.getElementById("myTable");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }

    $('#print_btn').on('click',function(){
        printData();
    })

})