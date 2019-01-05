<?php


$lastWeek=date("Y-m-d",mktime(0,0,0,date("m") ,date("d")-7,date("Y")));
$lastMonth=date("Y-m-d",mktime(0,0,0,date("m")-1 ,date("d"),date("Y")));
$lastYear=date("Y-m-d",mktime(0,0,0,date("m") ,date("d"),date("Y")-1));


include("../connection.php");

class DateComplete{
    public $names;
    public $counts;
}

$data = array();

$query="SELECT count(date_complete) as counts FROM server_retire where date_complete>='$lastWeek';";
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $dateComplete = new DateComplete();
    $dateComplete->counts= $row['counts'];
    $dateComplete->names= 'Last Week';
    $data[] = $dateComplete;
}

$query="SELECT count(date_complete) as counts FROM server_retire where date_complete>='$lastMonth';";
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $dateComplete = new DateComplete();
    $dateComplete->counts= $row['counts'];
    $dateComplete->names= 'Last Month';
    $data[] = $dateComplete;
}

$query="SELECT count(date_complete) as counts FROM server_retire where date_complete>='$lastYear';";
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $dateComplete = new DateComplete();
    $dateComplete->counts= $row['counts'];
    $dateComplete->names= 'Last Year';
    $data[] = $dateComplete;
}


mysqli_close($conn);

echo json_encode($data);



?>