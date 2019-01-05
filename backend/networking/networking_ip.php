<?php

include("../connection.php");

 class IP{
    public $names;
    public $counts;
}

$data = array();


$query="SELECT COUNT( ip_idx ) as counts
FROM  ip 
WHERE server_idx !=0";
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $ip = new IP();
    $ip->names = 'Used';
    $ip->counts = $row['counts'];
    $data[] = $ip;
}

$query="SELECT COUNT( ip_idx ) as counts
FROM  ip 
WHERE server_idx =0";
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $ip = new IP();
    $ip->names = 'Free';
    $ip->counts = $row['counts'];
    $data[] = $ip;
}

mysqli_close($conn);

echo json_encode($data);




?>