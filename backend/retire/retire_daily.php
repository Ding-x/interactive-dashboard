<?php

include("../connection.php");

 class DateComplete{
    public $name;
    public $value;
}

class Value{
    public $time;
    public $count;
}

    $query="SELECT date_complete as dates, count(date_complete) as counts FROM server_retire where date_complete>'2014-07-01'  group by date_complete;";
    $data = array();
    $resultset= mysqli_query($conn, $query);

    while($row = mysqli_fetch_array($resultset)) {
        $dateComplete = new DateComplete();
        $dateComplete->name = $row['dates'];
        $value=new Value();
        $value->time=$row['dates'];
        $value->count=$row['counts'];
        $dateComplete->value = $value;
        $data[] = $dateComplete;
    }

    mysqli_close($conn);
    
    echo json_encode($data);




?>