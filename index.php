
<?php
session_start(); 

 
if((substr($_SERVER['SERVER_SOFTWARE'],0,9) == 'Microsoft') && (!isset($_SERVER['PHP_AUTH_USER']))
&& (!isset($_SERVER['PHP_AUTH_PW'])) && (substr($_SERVER['HTTP_AUTHORIZATION'],0,6)=='Basic')){
    list($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])
        = explode(':',base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'],6)));
}
 
if(($_SERVER['PHP_AUTH_USER'] != 'system_d') || ($_SERVER['PHP_AUTH_PW'] != 'system_d')){
    header('WWW-Authenticate:Basic realm="Realm-Name"');
 
    if(substr($_SERVER['SERVER_SOFTWARE'],0,9) == 'Microsoft'){
        header('Status:401 Unauthorized');
    }else{
        header('HTTP/1.0 401 Unauthorized');
    }
    echo "<p></p><p></p><h1 class='text-center'>Access Limited!</h1><p class='text-center'>You are not authorized to access this site. Refresh to login.</p>";
}else{
    $_SESSION['username']=$_SERVER['PHP_AUTH_USER'];
    header("location: dashboard.php "); 
}
