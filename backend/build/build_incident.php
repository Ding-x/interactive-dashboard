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
    
    $query="SELECT server.name AS server_name, server_build.incident AS incident_name, user.username,server_build.date_begin,server_build.date_complete,server_build.notes
    FROM server, server_build, user
    WHERE server_build.server_idx = server.server_idx
    AND user.user_idx = server_build.staff_assign_idx
    AND server_build.incident ='$incident'";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $anIncident = new Incident();
        $anIncident->servername = $row['server_name'];
        $anIncident->incident = $row['incident_name'];
        $anIncident->username = $row['username'];
        $anIncident->startDate = $row['date_begin'];
        $anIncident->endDate = $row['date_complete'];
        $anIncident->notes = $row['notes'];
        $data[] = $anIncident;
    }
}
else{
    class Incident{
        public $name;
    }
    
    
    $query="SELECT incident
    FROM  server_build 
    GROUP BY incident";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $anIncident = new Incident();
        $anIncident->name = $row['incident'];
        $data[] = $anIncident;
    }
}

 

mysqli_close($conn);
    
echo json_encode($data);




?>