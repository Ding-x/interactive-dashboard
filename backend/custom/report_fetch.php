<?php

$type=0;
$category='';
$priority='';

if(isset($_POST['category'])){
    $category=$_POST['category'];
}

if(isset($_POST['priority'])){
    $priority=$_POST['priority'];
}

if(isset($_POST['type'])){
    $type=$_POST['type'];
}

//Return each single report's data to the report list or to the edit report list
if($type!=0){
    $query="SELECT queries.ID,queries.NAME,queries.COUNT,queries.PRIORITY,category.CATEGORY FROM queries,category WHERE queries.CATEGORY_ID =category.ID;";
    $conn=  mysqli_connect("localhost", "root", "","query") or die("Failed");
    $result = mysqli_query($conn,$query); 
    $count=1;
    $delay_time=1;
    while($row = mysqli_fetch_array($result)) 
    { 
        if($type==1){
            echo "<div id='bar{$row['ID']}' class='issue-edit-bar'><span>Report {$count}: </span><span>{$row['NAME']} </span></div>";
        }
        else{
            echo "<div id='{$row['ID']}' class='issue-bar animated bounceInUp delay-{$delay_time}s'><span class='issue-name'>{$count}. {$row['NAME']}</span><span class='issue-priority'>{$row['PRIORITY']} </span><span class='issue-category'>{$row['CATEGORY']} </span><span class='issue-count'>{$row['COUNT']} </span></div>";
        }
        $count++;
        if($count%2!=0){
            $delay_time++;

        }
    } 
}

//Return report list based on the input category and priority data to implement the multi-filter function
if(!empty($category) || !empty($priority)){
    $query="SELECT queries.ID,queries.NAME,queries.COUNT,queries.PRIORITY,category.CATEGORY 
    FROM queries,category 
    WHERE queries.CATEGORY_ID =category.ID";

    if(!empty($category)){
        $query.=" AND (category.CATEGORY = '$category[0]'";
        if(count($category)>1)
            for($x = 1; $x < count($category); $x++)
                $query.=" OR category.CATEGORY = '$category[$x]'";
        $query.=")";
    }

    if(!empty($priority)){
        $query.=" AND (queries.PRIORITY = '$priority[0]'";
        if(count($priority)>1)
            for($x = 1; $x < count($priority); $x++)
                $query.=" OR queries.PRIORITY = '$priority[$x]'";
        $query.=")";
    }

    $conn=  mysqli_connect("localhost", "root", "","query") or die("Failed");
    $result = mysqli_query($conn,$query); 
    $count=1;

    while($row = mysqli_fetch_array($result)){
        echo "<div id='{$row['ID']}' class='issue-bar '><span class='issue-name '>{$count}. {$row['NAME']} :</span><span class='issue-priority'>{$row['PRIORITY']} </span><span class='issue-category'>{$row['CATEGORY']} </span><span class='issue-count'>{$row['COUNT']} </span></div>";
        $count++;
    }
}

else if($type!=2 && $type!=1 ) {
    $query="SELECT queries.ID,queries.NAME,queries.COUNT,queries.PRIORITY,category.CATEGORY 
    FROM queries,category 
    WHERE queries.CATEGORY_ID =category.ID";

    $conn=  mysqli_connect("localhost", "root", "","query") or die("Failed");
    $result = mysqli_query($conn,$query); 
    $count=1;

    while($row = mysqli_fetch_array($result)){
        echo "<div id='{$row['ID']}' class='issue-bar'><span class='issue-name'>{$count}. {$row['NAME']} :</span><span class='issue-priority'>{$row['PRIORITY']} </span><span class='issue-category'>{$row['CATEGORY']} </span><span class='issue-count'>{$row['COUNT']} </span></div>";
        $count++;
    }
}



mysqli_close($conn);
?>

<script>
    var issue_id=-1;

    //Get the report id
    $(".issue-edit-bar").click(function(){
        $(".issue-edit-bar").css("background-color", "#f8f8f8");
        var a_bar=$(this).attr("id");
        $('#'+a_bar).css("background-color", "#ddd");
        var length = a_bar.length;
        issue_id=a_bar.substring(3,length);
    })

    //Open editing exsisted report interface
    $("#issue_manage_edit").off("click").on("click",function(){
        if(issue_id===-1){
            alert("Please select an issue to edit.");
        }
        else{
            $('#issue_edit_delete').removeAttr("disabled");//Enable the delete button
            $.ajax({
                type: "post",
                async: false,
                url: "backend/custom/report_single.php",
                data: {id:issue_id,type:1},
                success: function (result) {
                    if (result) {
                        var obj = jQuery.parseJSON( result );
                        $("#issue_name").val(obj.name);
                        $("#issue_sql").val(obj.sql);
                        $('#prio_edit').val(obj.priority);
                        $('#cate_edit').val(obj.category);
                        $('#dashboard_edit').val(obj.dashboard);

                    }
                },
                error: function (errmsg) {
                    alert("Ajax wrong!" + errmsg);
                }
            });
            $('#issue_edit').fadeOut(100, function () {
                $('#issue_detail').fadeIn();
            });
        }
    })
    //Open the adding new report interface
    $("#issue_manage_add").off("click").on("click",function(){
        issue_id=-1;
        $('#issue_edit').fadeOut(100, function () {
            $('#issue_detail').fadeIn();
        });
        $('#issue_edit_delete').attr('disabled',"true");
        $("#issue_name").val("");
        $("#issue_sql").val("");
        $("#issue_sql").attr("placeholder","Important Notice:\n1.When more than one column names you selected are the same, you MUST assign them with unique name respectively without any blank space. \n2. MUST use double quotes instead of single quotes in the SQL.");
    })
    

    $("#issue_edit_cancel").off("click").on("click",function(){
        issue_id=-1;
        $('#issue_detail').fadeOut(100, function () {
            $('#issue_edit').fadeIn();
        });
    })

    //Submit a report updation.
    $("#issue_edit_submit").off("click").on("click",function(){
        var name= $("#issue_name").val();
        var sql= $("#issue_sql").val();
        var priority= $("#prio_edit").val();
        var category= $("#cate_edit").val();
        var dashboard= $("#dashboard_edit").val();
        if(sql.trim().split(" ",1)[0].toLowerCase().localeCompare("select")!=0) {
            alert("You can only SELECT data from the database. Please modify your SQL.");
        }else{
            if (confirm("Are you sure to add the new issue?")) {
                $.ajax({
                    type: "post",
                    async: false,
                    url: "backend/custom/update_query.php",
                    data: {name:name,sql:sql,id:issue_id,priority:priority,category:category,dashboard:dashboard},
                    success: function (result) {
                        issue_id=-1;
                        $('#issue_detail').fadeOut(100, function () {
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
                    },
                    error: function (errmsg) {
                        alert("Ajax wrong!" + errmsg);
                    }
                });
            } else {
            }
        }
    })


    //Delete an exsited report
    $("#issue_edit_delete").off("click").on("click",function(){
        if (confirm("Are you sure to delete the issue?")) {
            $.ajax({
                type: "post",
                async: false,
                url: "backend/custom/delete_query.php",
                data: {id:issue_id},
                success: function () {
                    issue_id=-1;
                    $('#issue_detail').fadeOut(100, function () {
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
                },
                error: function (errmsg) {
                    alert("Ajax wrong!" + errmsg);
                }
            });
        } else {
        }

    })
</script>