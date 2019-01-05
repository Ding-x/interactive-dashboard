<?php

$conn =  mysqli_connect("localhost", "root", "","query") or die("Failed");


 $name='';
 $sql='';
 $id='';
 $priority='';
 $category='';
 $dashboard='';

 if(isset($_POST['name'])){
    $name=$_POST['name'];
}
if(isset($_POST['sql'])){
    $sql=$_POST['sql'];
}
if(isset($_POST['id'])){
    $id=$_POST['id'];
}
if(isset($_POST['priority'])){
    $priority=$_POST['priority'];
}
if(isset($_POST['category'])){
    $category=$_POST['category'];
}
if(isset($_POST['dashboard'])){
    $dashboard=$_POST['dashboard'];
}

//When id = -1, it means it will create a new report
if( $id==-1){
    $query="SELECT ID FROM category where CATEGORY= '$category';";
    $get_query= mysqli_query($conn, $query);
    $category_id=0;
    while($row = mysqli_fetch_array($get_query)) {
        $category_id=$row['ID'];
    }
    $query="INSERT INTO query.queries (NAME, SQLS, PRIORITY, CATEGORY_ID, DASHBOARD) VALUES ('$name', '$sql','$priority',$category_id,'$dashboard');";
    mysqli_query($conn, $query);

}
//When id != -1, it means it will update a existed report

else{
    $query="SELECT ID FROM category where CATEGORY= '$category';";
    $get_query= mysqli_query($conn, $query);
    $category_id=0;
    while($row = mysqli_fetch_array($get_query)) {
        $category_id=$row['ID'];
    }
    $query="UPDATE query.queries SET NAME = '$name', SQLS= '$sql', PRIORITY= '$priority', CATEGORY_ID= '$category_id', DASHBOARD= '$dashboard' WHERE ID =  $id;";
    mysqli_query($conn, $query);
}
mysqli_close($conn);


?>