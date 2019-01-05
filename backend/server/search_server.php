<?php
include("../connection.php");

$managed='';
$status='';
$type='';
$os='';
$owner='';
if(isset($_POST['managed'])){
    $managed=$_POST['managed'];
}
if(isset($_POST['status'])){
    $status=$_POST['status'];
}
if(isset($_POST['type'])){
    $type=$_POST['type'];
}
if(isset($_POST['os'])){
    $os=$_POST['os'];
}
if(isset($_POST['owner'])){
    $owner=$_POST['owner'];
}
if(isset($_POST['datacenter'])){
    $datacenter=$_POST['datacenter'];
}

$query = "";

if(!empty($managed)){
    $query.="SELECT * FROM server WHERE managed = '$managed' ;";
}

if(!empty($status)){
    $query.="SELECT * FROM server WHERE status = '$status' ;";
}

if(!empty($type)){
    $query.="SELECT * FROM server WHERE type = '$type' ;";
}

if(!empty($os)){
    $query.="SELECT * FROM server WHERE os = '$os' ;";
}

if(!empty($owner)){
    $query.="SELECT * FROM server,team WHERE server.owner_idx= team.team_idx and team.name = '$owner' ;";
}

if(!empty($datacenter)){
    $query.="select cmdb.server.name as 'server_name', cmdb.server.description as 'server_description',cmdb.application.name as 'application_name',
    cmdb.application.description as 'application_description', cmdb.application.sla as 'application_sla',
    server_owner.name as 'server_owner', app_owner.name as 'application_owner' from cmdb.server
    join discovery.vmware_vms on (cmdb.server.name = discovery.vmware_vms.server_name)
    join application_rel_server on (server.server_idx = application_rel_server.server_idx)
    join application on (application.application_idx = application_rel_server.application_idx)
    join cmdb.team server_owner on (server_owner.team_idx = cmdb.server.owner_idx)
    join cmdb.team app_owner on (app_owner.team_idx = cmdb.application.team_idx)
    where discovery.vmware_vms.datacenter='$datacenter'";
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