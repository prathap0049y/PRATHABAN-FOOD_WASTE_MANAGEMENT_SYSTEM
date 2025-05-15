<?php
session_name("delivery_session");   //to start the session
session_start();
session_unset();
session_destroy();
// ob_start();
header("location:deliverylogin.php");
// ob_end_flush(); 

exit();

?>