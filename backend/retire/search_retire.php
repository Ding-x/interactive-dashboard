<?php
include("../connection.php");

$period='';
$user='';
if(isset($_POST['period'])){
    $period=$_POST['period'];
}
if(isset($_POST['user'])){
    $user=$_POST['user'];
}

$query = "";

$lastWeek=date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-7,date("Y")));
$lastMonth=date("Y-m-d",mktime(0,0,0,date("m")-1 ,date("d"),date("Y")));
$lastYear=date("Y-m-d",mktime(0,0,0,date("m") ,date("d"),date("Y")-1));

if(!empty($period)){
    if($period=='Last Week'){
        $query.="SELECT * FROM server_retire where date_complete>='$lastWeek';";
    }
    if($period=='Last Month'){
        $query.="SELECT * FROM server_retire where date_complete>='$lastMonth';";
    }
    if($period=='Last Year'){
        $query.="SELECT * FROM server_retire where date_complete>='$lastYear';";
    }
}

if(!empty($user)){
    $query.="SELECT * FROM server_retire,user WHERE server_retire.staff_assign_idx= user.user_idx and user.username = '$user' ;";
    echo $query;
}



$result=mysqli_query($conn,$query);
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

?>