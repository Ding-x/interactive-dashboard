<?php

 $query="SELECT ID,NAME,COUNT FROM queries WHERE DASHBOARD='YES';";
 $conn=  mysqli_connect("localhost", "root", "","query") or die("Failed");
 $result = mysqli_query($conn,$query); 
 $rowcount=mysqli_num_rows($result);
 
for($x=0;$x< $rowcount;$x++){
    $delay_time=1;
    if($x%3==0){
        if($x<($rowcount-$rowcount%3)){
            $y=3;
        }
        else{
            $y=$rowcount%3;
        }
        
        echo "<div id='{$x}' class='row'>";

        while($y>0 ){
            $row = mysqli_fetch_array($result);
            echo "<div id='{$row['ID']}' class='col-md-4 animated zoomIn delay-{$delay_time}s'>
                     <div class='panel-group' >
                        <div class='panel panel-default'>
                            <div class='panel-heading' style='height:80px' data-toggle='collapse' href='#collapse{$row['ID']}'>
                                <div class='row'>
                                    <div class='col-md-2'>
                                        <i class='pe-7s-bell' style='color:#C13834;font-size:40px;margin-top:5px;font-weight:400'></i>
                                    </div>
                                    <div class='col-md-10'>
                                        <h4 class='panel-title' style='font-weight:400' id='col_title_{$row['ID']}'>{$row['NAME']}</h4>
                                    </div>
                                </div>

                            </div>
                            <div id='collapse{$row['ID']}' class='panel-collapse collapse'>
                                 <div class='panel-body'><h2 style='color:#C13834' class='animated zoomIn text-center'> {$row['COUNT']}</h2></div>
                                 <div id='{$row['ID']}' class='panel-footer' style='height:50px'><a><h6>See detail</h6></a></div>
                            </div>
                        </div>
                    </div>
                 </div>";
            $y--;
            $delay_time++;
        }
        echo "</div>";
    }
}
mysqli_close($conn);


?>