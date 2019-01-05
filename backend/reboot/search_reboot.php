<?php
include("../connection.php");

$enabled='';
$schedule='';
$weeks='';
$time='';

if(isset($_POST['enabled'])){
    $enabled=$_POST['enabled'];
}
if(isset($_POST['schedule'])){
    $schedule=$_POST['schedule'];
}
if(isset($_POST['weeks'])){
    $weeks=$_POST['weeks'];
}
if(isset($_POST['time'])){
    $time=$_POST['time'];
}
$query = "";

if(!empty($enabled)){
    if($enabled=="EMPTY"){
        $query.="SELECT * FROM reboot WHERE enabled = '' ;";
    }
    else{
        $query.="SELECT * FROM reboot WHERE enabled = '$enabled' ;";
    }
}

if(!empty($schedule)){
    $query.="SELECT * FROM reboot WHERE schedule = '$schedule' ;";
}

if(!empty($weeks)){
    if($weeks=="EMPTY"){
        $query.="SELECT * FROM reboot WHERE weeks = '' ;";
    }
    else{
        $query.="SELECT * FROM reboot WHERE weeks = '$weeks' ;";
    }
}

if(!empty($time)){
    $query.="SELECT * FROM reboot WHERE time = '$time' ;";
}

if(!empty($owner)){
    $query.="SELECT * FROM server,team WHERE server.owner_idx= team.team_idx and team.name = '$owner' ;";
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