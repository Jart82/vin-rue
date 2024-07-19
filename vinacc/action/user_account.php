<?php 
require "../../action/conn.php";
?>
<?php 
require "../admin_core.php";
?>
<?php 
$id = $conn -> real_escape_string( gpost('id') );
$profit = $conn -> real_escape_string( gpost('profit') );
$real_account = $conn -> real_escape_string( gpost('real_account') );
$signal_fee = $conn -> real_escape_string( gpost('signal_fee') );
$account_status = $conn -> real_escape_string( gpost('account_status') );
$account_type = $conn -> real_escape_string( gpost('account_type') );
if (user_set_by_id("profit = $profit, real_account = $real_account, signal_fee = $signal_fee, account_status = '$account_status', account_type = '$account_type' ",$id,$conn)) {
    header("Location:../success");
}
?>