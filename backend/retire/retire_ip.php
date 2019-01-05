<?php

include("../connection.php");


$query="select cmdb.server.name, cmdb.server.status, cmdb.server_retire.date_begin, cmdb.user.username,
cmdb.ip.address, cmdb.ip.vlan, cmdb.ip.value, discovery.ip.alive,
discovery.ip.os, discovery.ip.vmware, discovery.ip.dns_int_ad, discovery.ip.dns_ext_ad, discovery.ip.dns_ext_dmz 
from cmdb.server
join cmdb.ip on (cmdb.ip.server_idx = cmdb.server.server_idx)
left outer join cmdb.server_retire on (cmdb.server.server_idx = cmdb.server_retire.server_idx)
left outer join cmdb.user on (cmdb.user.user_idx = cmdb.server_retire.staff_assign_idx)
join discovery.ip on (cmdb.ip.address = discovery.ip.address)
where cmdb.server.status = 'retire';";

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

mysqli_close($conn);






?>