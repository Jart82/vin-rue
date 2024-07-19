<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
require "../template.php";
?>
<?php 
$template = $conn -> real_escape_string( gpost('template') );
$obj = json_decode($get_json[$template]);
$acct = $conn -> real_escape_string( gpost('acct') );
if ($acct == 1) {
    $user = get_user_2($conn,$conn -> real_escape_string( gpost('user_id') ));
    $obj->data[] = (object) ["name" => "user_id", "type" => "hidden_string", "value" => $user['user_id']];
}
if (table_action($conn,$obj)) {
    header("Location:../success");
}
?>