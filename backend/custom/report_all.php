<?php

$query="select * from query.queries";
$conn=mysqli_connect("localhost", "root", "","query") or die("Failed");
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $single_query= $row['SQLS'];
    $id= $row['ID'];
    $conn_cmdb= mysqli_connect("cowsvplsys01", "systems_r", "systems_r","cmdb") or die("Failed");
    $result= mysqli_query($conn_cmdb, $single_query);
    $count= mysqli_num_rows($result);
    $update_count_query="UPDATE query.queries SET COUNT = $count WHERE ID =  $id;"; 
    mysqli_query($conn, $update_count_query);
}

mysqli_close($conn);

?>
