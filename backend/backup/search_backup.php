<?php
include("../connection.php");

$baremetal='';
$frequency='';
$retention='';
if(isset($_POST['baremetal'])){
    $baremetal=$_POST['baremetal'];
}
if(isset($_POST['frequency'])){
    $frequency=$_POST['frequency'];
}
if(isset($_POST['retention'])){
    $retention=$_POST['retention'];
}
$query = "";

if(!empty($baremetal)){
    $query.="SELECT * FROM backup WHERE baremetal = '$baremetal' ;";
}

if(!empty($frequency)){
    if($frequency=='EMPTY'){
        $frequency=0;
    }
    $query.="SELECT * FROM backup WHERE frequency = '$frequency' ;";
}

if(!empty($retention)){
    if($retention=='EMPTY'){
        $retention=0;
    }
    $query.="SELECT * FROM backup WHERE retention = $retention ;";
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