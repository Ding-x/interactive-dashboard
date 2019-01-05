<?php

$conn= mysqli_connect("localhost", "root", "","query") or die("Failed");

if(isset($_POST['id'])){
    $id=$_POST['id'];
    $type=-1;
    if(isset($_POST['type'])){
        $type=$_POST['type'];
    }

    class ReportData{
        public $sql;
        public $name;
        public $priority;
        public $category;
        public $dashboard;

    }

    $data = array();

    $query="SELECT queries.SQLS,queries.NAME,queries.COUNT,queries.PRIORITY,queries.DASHBOARD,category.CATEGORY 
    FROM queries,category 
    WHERE queries.CATEGORY_ID =category.ID AND queries.ID = $id;";
    $get_query=mysqli_query($conn,$query);
    $query_report="";
    while($row = mysqli_fetch_array($get_query)) {
        $reportData = new ReportData();
        $reportData->sql = $row['SQLS'];
        $query_report.=$row['SQLS'];
        $reportData->name = $row['NAME'];
        $reportData->priority = $row['PRIORITY'];
        $reportData->category = $row['CATEGORY'];
        $reportData->dashboard = $row['DASHBOARD'];

    }

    //When type equals to 1, it means return the single report data to the edit form to be updated.
    if($type==1){
        echo json_encode($reportData);
    }
    //When type not equals to 1, it means return the single report detail info to the table.
    else{
        $conn_cmdb=mysqli_connect("cowsvplsys01", "systems_r", "systems_r","cmdb") or die("Failed");    
        $result=mysqli_query($conn_cmdb,$query_report);
        if(!$result){
            die("FAILED");
        }
    
        $field_data = array();
        echo"<thead> <tr>";
    
        while ($fieldinfo=mysqli_fetch_field($result))
        {
            echo "<th>".$fieldinfo->name."</th>";
            array_push($field_data,$fieldinfo->name);
        }
        echo"</tr></thead><tbody >";
    
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            for($x = 0; $x < count($field_data); $x++) {
                echo "<td>".$row[$field_data[$x]]."</td>";
            }
            echo "</tr>";
        }
        echo"</tbody >";
    }
    
}

mysqli_close($conn);

?>