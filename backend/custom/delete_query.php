<?php

$conn =  mysqli_connect("localhost", "root", "","query") or die("Failed");

$id=-1;
if(isset($_POST['id'])){
    $id=$_POST['id'];
}
$query="delete from query.queries WHERE ID =  $id;";
mysqli_query($conn, $query);

mysqli_close($conn);


?>