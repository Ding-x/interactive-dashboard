<?php

include("../connection.php");


$server='';
if(isset($_POST['server'])){
    $server=$_POST['server'];
}

if(!empty($server)){
    $query="select *
    from server
    where name = '$server'";

    $resultset= mysqli_query($conn, $query);
    
    while($row = mysqli_fetch_array($resultset)) {
        echo "<div class='col-md-3'>
        <h4>Server</h4>
        <hr>
        <ul>
            <li>Name: {$row['name']}</li>
            <li>Type: {$row['type']}</li>
            <li>OS: {$row['os']}</li>
            <li>Description: {$row['description']}</li>
            <li>Status: {$row['status']}</li>
        </ul>
    </div>";
    };


    $query="select server.owner_idx, server.name, team.name, team.team_idx
    from server
    inner join team on (team.team_idx = server.owner_idx)
    where server.name = '$server'";

    $resultset= mysqli_query($conn, $query);
    $row_cnt = mysqli_num_rows($resultset);

    if($row_cnt>0){
        while($row = mysqli_fetch_array($resultset)) {
            echo "<div class='col-md-3'>
            <h4>Owner</h4>
            <hr>
            <ul>
                <li>Group: {$row['name']}</li>";
    
            if($row['name'] == "CSS_SYS")
                echo "<li>Contact: CSS-BTS-MH-Systems@winnipeg.ca</li>";
            elseif ($row['name'] == "CSS_MW")
                echo "<li>Contact: CSS-BTS-MH-Middleware@winnipeg.ca</li>";
            elseif ($row['name'] == "WWD")
                echo "<li>Contact: WDD</li>";
            else
                echo "<li>Contact: Unknown</li>";
            echo "</ul></div>";
        }
    } 
    else{
        echo "<div class='col-md-3'>
        <h4>Owner</h4>
        <hr>
        <p>N/A<p>
    </div>";
    };


    $query="select *
    from server
    inner join ip on (ip.server_idx = server.server_idx)
    where name = '$server'";

    $resultset= mysqli_query($conn, $query);
    $row_cnt = mysqli_num_rows($resultset);
    if($row_cnt>0){
        while($row = mysqli_fetch_array($resultset)) {
            echo "<div class='col-md-3'>
            <h4>IP</h4>
            <hr>
            <ul>
                <li>IP: {$row['address']}</li>
                <li>Subnet: {$row['mask']}</li>
                <li>Gateway: {$row['gateway']}</li>
                <li>Vlan: {$row['vlan']}</li>
            </ul>
        </div>";
        }
    }
    else{
        echo "<div class='col-md-3'>
        <h4>IP</h4>
        <hr>
        <p>N/A<p>
    </div>";
    };


    $query="select *
    from reboot
    where name = '$server'";

    $resultset= mysqli_query($conn, $query);

    $row_cnt = mysqli_num_rows($resultset);
    if($row_cnt>0){
        while($row = mysqli_fetch_array($resultset)) {
            echo "<div class='col-md-3'>
            <h4>Reboot</h4>
            <hr>
            <ul>
                <li>Time: {$row['time']}</li>
                <li>Day(s): {$row['days']}</li>
                <li>Week(s): {$row['weeks']}</li>
                <li>Schedule: {$row['schedule']}</li>
                <li>Enabled: {$row['enabled']}</li>
            </ul>
        </div>";
        }
    }
    else{
        echo "<div class='col-md-3'>
        <h4>Rebbot</h4>
        <hr>
        <p>N/A<p>
    </div>";
    }


}
else{

    $query="SELECT name
    FROM  server 
    GROUP BY name";

    $resultset= mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($resultset)) {
        echo '<option>'.$row['name'].'</option>';
    }
}

 

mysqli_close($conn);
    




?>