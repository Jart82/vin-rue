<?php 
require "../conn.php";
$json =rooms_get_json($conn);
retmsg($json);
?>