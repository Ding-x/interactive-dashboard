<?php
$conn = mysqli_connect("cowsvplsys01", "systems_r", "systems_r","discovery") or die("Failed");
$query = "select datacenter,count(datacenter) as counts from vmware_vms group by datacenter";

$data = array();
$resultset= mysqli_query($conn, $query);
class DataCenter{
    public $center;
    public $counts;
}

while($row = mysqli_fetch_array($resultset)) {
    $dataCenter = new DataCenter();
    $dataCenter->center = $row['datacenter'];
    $dataCenter->counts = $row['counts'];
    $data[] = $dataCenter;
}

mysqli_close($conn);

echo json_encode($data);
?>