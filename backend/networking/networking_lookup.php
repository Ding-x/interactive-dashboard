<?php

include("../connection.php");
$vlan='';
if(isset($_POST['vlan'])){
    $vlan=$_POST['vlan'];
}

if(!empty($vlan)){
    class IP{
        public $servername;
        public $vlan;
        public $address;
        public $value;
        public $host;
        public $modifier;
        public $modifydate;
        public $incident;
        public $builder;
    }
    
    
    $query="select server.name as 'servername', ip.vlan, ip.address, ip.value, ip.host,
    user_ip.username as 'ip_modifier', userlog.update_date as 'ip_modify_date',
    server_build.incident as 'build_incident', user_build.username as 'builder'
    from ip
    join userlog on (userlog.key_value = ip.address)
    join user user_ip on (user_ip.user_idx = userlog.update_user_idx)
    left outer join server on (server.server_idx = ip.server_idx)
    left outer join server_build on (server_build.server_idx = server.server_idx)
    left outer join user user_build on (user_build.user_idx = server_build.staff_assign_idx)
    where ip.vlan=$vlan";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $ip = new IP();
        $ip->servername = $row['servername'];
        $ip->vlan = $row['vlan'];
        $ip->address = $row['address'];
        $ip->value = $row['value'];
        $ip->host = $row['host'];
        $ip->modifier = $row['ip_modifier'];
        $ip->modifydate = $row['ip_modify_date'];
        $ip->incident = $row['build_incident'];
        $ip->builder = $row['builder'];
        $data[] = $ip;
    }
}
else{
    class Vlan{
        public $name;
    }
    
    
    $query="SELECT vlan
    FROM  ip 
    GROUP BY vlan";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $vlan = new Vlan();
        $vlan->name = $row['vlan'];
        $data[] = $vlan;
    }
}

 

mysqli_close($conn);
    
echo json_encode($data);




?>