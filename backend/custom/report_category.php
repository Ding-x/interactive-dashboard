<?php

$query="select  DISTINCT CATEGORY from query.category";
$conn=mysqli_connect("localhost", "root", "","query") or die("Failed");
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    echo "<option>".$row['CATEGORY']."</option>";
}

mysqli_close($conn);
?>
