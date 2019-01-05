<?php

include("../connection.php");

 class UserComplete{
    public $names;
    public $counts;
}



$query="SELECT user.username, COUNT( server_retire.staff_assign_idx ) AS counts FROM server_retire, user WHERE user.user_idx = server_retire.staff_assign_idx GROUP BY server_retire.staff_assign_idx;";
$data = array();
$resultset= mysqli_query($conn, $query);

while($row = mysqli_fetch_array($resultset)) {
    $userComplete = new UserComplete();
    $userComplete->names = $row['username'];
    $userComplete->counts = $row['counts'];
    $data[] = $userComplete;
}

mysqli_close($conn);

echo json_encode($data);




?>