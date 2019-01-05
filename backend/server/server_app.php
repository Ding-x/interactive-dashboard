<?php
include("../connection.php");

$query = "SELECT application.name as apps,COUNT(application.name) as count
FROM server,application_rel_server,application
WHERE application_rel_server.server_idx=server.server_idx AND application_rel_server.application_idx=application.application_idx
GROUP BY apps";

$data = array();
$resultset= mysqli_query($conn, $query);
class ServerApp{
    public $apps;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $serverApp = new ServerApp();
    $serverApp->apps = $row['apps'];
    $serverApp->counts = $row['count'];
    $data[] = $serverApp;
}

mysqli_close($conn);

echo json_encode($data);
?>