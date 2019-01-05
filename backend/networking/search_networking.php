<?php
include("../connection.php");

$zone='';
$ip='';
$owner='';
if(isset($_POST['zone'])){
    $zone=$_POST['zone'];
}
if(isset($_POST['ip'])){
    $ip=$_POST['ip'];
}
if(isset($_POST['owner'])){
    $owner=$_POST['owner'];
}

$query = "";

if(!empty($zone)){
    $query.="SELECT * FROM subnet,zone WHERE subnet.zone_idx=zone.zone_idx AND  zone.name = '$zone' ;";
}

if(!empty($ip)){
    if($ip=="Free"){
        $query.="SELECT * FROM ip WHERE ip.server_idx = 0 ;";
    }
    else{
        $query.="SELECT * FROM ip WHERE ip.server_idx != 0 ;";
    }}


if(!empty($owner)){
    $query.="SELECT * FROM subnet,team WHERE subnet.owner_idx=team.team_idx AND  team.name = '$owner' ;";
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