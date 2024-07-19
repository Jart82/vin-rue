<?php 
require "../conn.php";
$json =rooms_single_get_json($conn);
retmsg($json);
?>