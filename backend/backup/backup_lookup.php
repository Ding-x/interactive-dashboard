<?php

include("../connection.php");
$servername='';
if(isset($_POST['servername'])){
    $servername=$_POST['servername'];
}

if(!empty($servername)){
    class Backup{
        public $servername;
        public $backupname;
        public $baremetal;
        public $frequency;
        public $retention;
    }
    
    
    $query="SELECT backup.name as backup_name, backup.baremetal, backup.frequency,backup.retention,server.name as server_name
    FROM backup , server, backup_rel_server
    WHERE backup.backup_idx = backup_rel_server.backup_idx
    AND backup_rel_server.server_idx = server.server_idx
    AND server.name ='$servername'";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $backup = new Backup();
        $backup->servername = $row['server_name'];
        $backup->backupname = $row['backup_name'];
        $backup->baremetal = $row['baremetal'];
        $backup->frequency = $row['frequency'];
        $backup->retention = $row['retention'];
        $data[] = $backup;
    }
}
else{
    class Backup{
        public $name;
    }
    
    
    $query="SELECT name
    FROM  server 
    GROUP BY name";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $backup = new Backup();
        $backup->name = $row['name'];
        $data[] = $backup;
    }
}

 

mysqli_close($conn);
    
echo json_encode($data);




?>