<?php

include("../connection.php");


$incident='';
if(isset($_POST['incident'])){
    $incident=$_POST['incident'];
}

if(!empty($incident)){
    class Incident{
        public $servername;
        public $incident;
        public $username;
        public $startDate;
        public $endDate;
        public $notes;
    }
    
    
    $query="SELECT server.name AS server_name, server_retire.incident AS incident_name, user.username,server_retire.date_begin,server_retire.date_complete,server_retire.notes
    FROM server, server_retire, user
    WHERE server_retire.server_idx = server.server_idx
    AND user.user_idx = server_retire.staff_assign_idx
    AND server_retire.incident ='$incident'";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $aIncident = new Incident();
        $aIncident->servername = $row['server_name'];
        $aIncident->incident = $row['incident_name'];
        $aIncident->username = $row['username'];
        $aIncident->startDate = $row['date_begin'];
        $aIncident->endDate = $row['date_complete'];
        $aIncident->notes = $row['notes'];
        $data[] = $aIncident;
    }
}
else{
    class Incident{
        public $name;
    }
    
    
    $query="SELECT incident
    FROM  server_retire 
    GROUP BY incident";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $aIncident = new Incident();
        $aIncident->name = $row['incident'];
        $data[] = $aIncident;
    }
}

 

mysqli_close($conn);
    
echo json_encode($data);




?>