<?php

include("../connection.php");

$appname='';
$category=-1;

if(isset($_POST['appname'])){
    $appname=$_POST['appname'];
}

if(isset($_POST['category'])){
    $category=$_POST['category'];
}

if(!empty($appname) && count($appname)>0){
    class App{
        public $servername;
        public $appname;
        public $username;
        public $sla;
        public $des;
    }
    
    
    $query="SELECT application.name AS app_name, application.sla, application.description, server.name AS server_name, team.name AS team_name
    FROM application, server, application_rel_server, team
    WHERE application.application_idx = application_rel_server.application_idx
    AND application_rel_server.server_idx = server.server_idx
    AND application.team_idx = team.team_idx
    AND (application.name = ";

    for ($x = 0; $x < count($appname)-1; $x++) {
       $query.="'".$appname[$x]."' OR application.name =";
    }

    $query.="'".$appname[ count($appname)-1]."' ) ";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $app = new App();
        $app->servername = $row['server_name'];
        $app->appname = $row['app_name'];
        $app->username = $row['team_name'];
        $app->sla = $row['sla'];
        $app->des = $row['description'];
        $data[] = $app;
    }
}


if($category==1){
    class App{
        public $name;
    }
    
    
    $query="SELECT DISTINCT name
    FROM  application ";

    $data = array();
    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        $app = new App();
        $app->name = $row['name'];
        $data[] = $app;
    }
}

 

mysqli_close($conn);
    
echo json_encode($data);




?>