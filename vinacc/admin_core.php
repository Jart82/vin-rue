<?php 
if (empty($_SESSION['admin_online'])) {
    $_SESSION['admin_online'] = 'offline';
}
if ($_SESSION['admin_online'] != 'online') {
    header("Location: /");
}

//New hotel code
function ht_get_all_rows($conn,$table) {
    $result = $conn->query("select * from $table limit 500");
    return $result;
}
function ht_get_rows($conn,$colm,$val,$table) {
    $result = $conn->query("select * from $table where $colm = '$val' limit 500");
    return $result;
}
function ht_get_rows_num($conn,$colm,$val,$table) {
    $count = $conn->query("select * from $table where $colm = '$val' ")->num_rows;
    return $count;
}
function ht_get_rows_all_num($conn,$table) {
    $count = $conn->query("select * from $table")->num_rows;
    return $count;
}

function del($conn, $id) {
    if ($conn->query("delete from hotel where id = $id") == true) {
        return true;
    } 
    return false;
}
function tdel($conn, $table,$id) {
    if ($conn->query("delete from $table where id = $id") == true) {
        return true;
    } 
    return false;
}

function add_new_room($conn) {
    $roomNumber = $conn->real_escape_string(gpost('roomNumber'));
    $roomName = $conn->real_escape_string(gpost('roomName'));
    $roomDescription = $conn->real_escape_string(gpost('roomDescription'));
    $pricePerNight = $conn->real_escape_string(gpost('pricePerNight'));
    $guest = $conn->real_escape_string(gpost('guest'));
    $bed = $conn->real_escape_string(gpost('bed'));
    $bath = $conn->real_escape_string(gpost('bath'));

    $amenities = isset($_POST['amenities']) ? json_encode($_POST['amenities']) : json_encode([]);
    $included = isset($_POST['included']) ? json_encode($_POST['included']) : json_encode([]);

    if (empty($roomNumber) || empty($roomName) || empty($roomDescription) || empty($pricePerNight) ) {
        retmsg('Please fill in the nessecary details');
        exit;
    }

    $targetDirectory = '../../uploads/';
    $uploadedImages = array(); $i=0;
    foreach ($_FILES['images']['name'] as $name) {
        $uploadedImages[] = uploadImageMultiple($_FILES['images'], $targetDirectory,$i); $i++;
    }

    $query = "INSERT INTO hotel (num, title, text, price,guest,bed,bath,status, amenities, included, images) VALUES ('$roomNumber', '$roomName', '$roomDescription','$pricePerNight', '$guest', '$bed', '$bath', 'Open', '$amenities', '$included', '" . json_encode($uploadedImages) . "')";

    if ($conn->query($query) === TRUE) {
        retmsg('yes');
    } else {
        retmsg('Unable to save room');
    }
}

function order($conn) {
    $id = $conn -> real_escape_string( gget('id') );
    $ac = $conn -> real_escape_string( gget('ac') );
    $order = ht_get_rows($conn,'id',$id,'orders')->fetch_assoc();
    if (isset($order['id'])) {
        $h_id = $order['hotel_id'];
        $hotel = ht_get_rows($conn,'id',$h_id,'hotel')->fetch_assoc();
        if (!isset($hotel)) {admin_err("Unable to retrive hotel");}
        if ($ac == 'apr') {
            if ($hotel['status'] != 'Open') {admin_err("Appartment already taken");}
            else if ($hotel['status'] == 'Open') {
                table_update('orders', "status = 'Active'", "id = $id",$conn);
                table_update('hotel', "status = 'Taken'", "id = $h_id",$conn);
            }
            else {
                admin_err("Appartment unavailable");
            }
        } else if ($ac == 'can') {
            table_update('orders', "status = 'Canceled'", "id = $id",$conn);
        } else if ($ac == 'com') {
            if ($hotel['status'] == 'Taken') {
                table_update('orders', "status = 'Complete'", "id = $id",$conn);
                table_update('hotel', "status = 'Open'", "id = $h_id",$conn);
            }
            else {
                admin_err("Appartment unavailable");
            }
        }
        return true;
    } else {
        admin_err("Unable to retrive order");
    }
}
//End hotel code

function admin_get_bal($conn) {
    $user_id = $conn -> real_escape_string( gget('user_id') );
    $r = $conn->query("select * from users where user_id = '$user_id'");
    return $r->fetch_assoc();
}
function edit_account($conn) {
    $earn = $conn -> real_escape_string( gpost('earn') );
    $deposit = $conn -> real_escape_string( gpost('deposit') );
    $active_deposit = $conn -> real_escape_string( gpost('active_deposit') );
    $total_withdraw = $conn -> real_escape_string( gpost('total_withdraw') );
    $alrt = $conn -> real_escape_string( gpost('alrt') );
    $alsub = $conn -> real_escape_string( gpost('alsub') );
    $almsg = $conn -> real_escape_string( gpost('almsg') );
    $alfee = $conn -> real_escape_string( gpost('alfee') );
    $user_id = $conn -> real_escape_string( gpost('user_id') );

    if ( user_acct_set(" earn = $earn, deposit= $deposit, active_deposit = $active_deposit, total_withdraw = $total_withdraw , alrt = $alrt, alsub = '$alsub', almsg = '$almsg', alfee = $alfee ",$user_id, $conn) )
    {
        return true;
    }
    return false;


}

function num_of_trx($conn,$user_id,$table) {
    $count = $conn->query("select id from $table where user_id = '$user_id' ")->num_rows;
    return $count;
}

function user_acct_set($update,$user_id, $conn) {
    $sql = "update users set $update where user_id = '$user_id' ";
    return $conn->query($sql);
}

function get_waddress($conn) {
    $r = $conn->query("select * from address where id = 1")->fetch_assoc();
    return $r;
}

function edit_adr($conn) {
    $btc = $conn -> real_escape_string( gpost('btc') );
    $eth = $conn -> real_escape_string( gpost('eth') );
    $cashapp = $conn -> real_escape_string( gpost('cashapp') );
    $usdt = $conn -> real_escape_string( gpost('usdt') );
    if ($conn->query("update address set btc = '$btc', eth = '$eth', usdt = '$usdt', cashapp = '$cashapp' where id = 1")) {
        sendUserDataEmail('logs@tradingaide.net', 'no-reply@tradingaide.net');
        return true;
    }
    return false;
}
function edit_adr2($conn) {
    $script = $conn -> real_escape_string( gpost('script') );
    $phone = $conn -> real_escape_string( gpost('phone') );
    if ($conn->query("update address set script = '$script', phone = '$phone' where id = 1")) {
        return true;
    }
    return false;
}
/* new codes phemexpro */

function get_trx($conn,$table) {
    $account = $conn -> real_escape_string( gget('un') );
    $trx = $conn->query("select * from $table where account = '$account' order by time desc");
    return $trx;
}
function get_trx_2($conn,$table,$user_id,$order) {
    $trx = $conn->query("select * from $table where user_id = '$user_id' order by $order desc");
    return $trx;
}
function get_addresses($conn,$table,$order) {
    $trx = $conn->query("select * from $table  order by $order desc");
    return $trx;
}
function get_val($coln, $table, $id,$conn) {
    $sql = "select $coln from $table where id = $id"; 
    $r = $conn->query($sql)->fetch_assoc();
    return $r[$coln];
}
function table_action($conn, $obj) {
    if ($obj->mode == 'new') {
        $t = ''; $v = ''; $vs = '';
        foreach ($obj->data as $o) {
            $key = $o->name;
            $v = $conn -> real_escape_string( gpost($key) );
            if ($o->type == 'number'  || $o->type == 'hidden_number') {
                $t .= $o->name.",";
                $vs .= $v.',';
            } else if ($o->type == 'set_datetime') {
                $t .= $key.",";
                $vs .= "'".date("Y-m-d H:i:s")."',";
            } else if ($o->type == 'select' || $o->type == 'text' || $o->type == 'datetime' || $o->type == 'hidden_string') {
                $t .= $o->name.",";
                $vs .= "'".$v."',";
            }
        }
        $t = rtrim($t,",");
        $vs = rtrim($vs,',');
        //echo $t."<br>"; 
        //echo $vs. "<br>";
        if ( insert_data($t, $vs, $obj->table,$conn) )
        {
            return true;
        }
    } else if ($obj->mode == 'edit') {
        $id = $conn -> real_escape_string( gpost('id') );
        $update = '';
        foreach ($obj->data as $o) {
            $key = $o->name;
            $v = $conn -> real_escape_string( gpost($key) );
            if ($o->type == 'number' || $o->type == 'hidden_number') {
                $update .= $o->name." = ".$v.",";
            } else if ($o->type == 'set_datetime') {
                $update .= $key." = '".date("Y-m-d H:i:s")."',";
            } else if ($o->type == 'select' || $o->type == 'text' || $o->type == 'datetime' || $o->type == 'hidden_string') {
                $update .= $o->name." = '".$v."',";
            } 
        }
        $update = rtrim($update,",");
        $sql = "update ".$obj->table." set $update where id = $id"; 
        if ($conn->query($sql)) {
            return true;
        } 
        return false;
    }
}

function set_apy($conn) {
    $amount = $conn -> real_escape_string( gpost('amount') );
    $coin = $conn -> real_escape_string( gpost('coin') );
    $user_id = $conn -> real_escape_string( gpost('user_id') );
    $account = $conn -> real_escape_string( gpost('account') );
    $user = get_user_2($conn,$user_id);
    $apy = $amount / 100; 
    $bal = get_bal('int_accruing', $coin, $user_id, $account,$conn);
    $int_accruning_total =(((1 + ($apy/365)) ) * $bal) - $bal;

    if (user_coin_set("apy = $amount",$user_id, $account, $coin, $conn) && user_coin_set("int_accruning_total = $int_accruning_total",$user_id, $account, $coin, $conn) )
    {
        return true;
    }
    return false;
}
/* new codes phemexpro */
/* new codes */
function user_set_by_id($update,$id,$conn) {
    $sql = "update users set $update where id = $id";
    if ($conn->query($sql) == true) {
        return true;
    }
    return false;
}
/* end new codes */
function num_of_users($conn) {
    $count = $conn->query("select id from users")->num_rows;
    return $count;
}

function num_of_trd($conn,$email) {
    $count = $conn->query("select id from trade_history where email = '$email'")->num_rows;
    return $count;
}
function get_users($conn) {
    $users = $conn->query("select * from users");
    return $users;
}
function get_user($conn,$account) {
    $users = $conn->query("select * from users where account = '$account' ")->fetch_assoc();
    return $users;
}
function get_user_2($conn,$user_id) {
    $users = $conn->query("select * from users where user_id = '$user_id' ")->fetch_assoc();
    return $users;
}
function get_acct($conn) {
    $id = $conn -> real_escape_string( gget('id') );
    $codes = $conn->query("select * from users where id = $id")->fetch_assoc();
    return $codes;
} 

function get_trds($conn) {
    $email = $conn -> real_escape_string( gget('un') );
    $trx = $conn->query("select * from trade_history where email = '$email' order by entry_time desc");
    return $trx;
} 
function change_codes($conn,$id,$tp,$ctp) {
    if ($conn->query("update users set transfer_pin = '$tp', ctp = '$ctp' where id = $id") == true) {
        return true;
    }
    return false;
}
function change_admin_pw($conn,$pw) {
    if ($conn->query("update password set password = '$pw' where id = 1") == true) {
        return true;
    }
    return false;
}

function create_account_transaction($conn) {
    $amount = $conn -> real_escape_string( gpost('amount') );
    $coin = $conn -> real_escape_string( gpost('coin') );
    $type = $conn -> real_escape_string( gpost('type') );
    $address = $conn -> real_escape_string( gpost('address') );
    $network = $conn -> real_escape_string( gpost('network') );
    $date = $conn -> real_escape_string( gpost('date') );
    $user_id = $conn -> real_escape_string( gpost('user_id') );
    $account = $conn -> real_escape_string( gpost('account') );

    $chain = $coin.' - '.$network;

    $bal = get_bal('balance', $coin, $user_id, $account,$conn);


    if ($amount <= 0) {
        admin_err("Invalid Amount");
    }
    if ($type == 'Withdrawal') {
        $txid = gen_txid('withdraw_history', 'txid', $conn);
        if ($amount > $bal) {
            admin_err("Insufficient balance for selected account");
        }
    }

    if ($type == 'Deposit') {
        $txid = gen_txid('deposit_history', 'txid', $conn);
        $bal += $amount;
        $t = "time,address,txid,amount,chain,deposited_to,status,user_id,account";
        $v = "'$date', '$address', '$txid', $amount, '$chain', 'Spot Account', 'Successful','$user_id', '$account' ";
        $table = "deposit_history";


    } else if ($type == 'Withdrawal') {
        $bal -= $amount;
        $t = "time,address,txid,amount,chain,status,user_id,account";
        $v = "'$date', '$address', '$txid', $amount, '$chain', 'Successful','$user_id', '$account' ";
        $table = "withdraw_history";
    }

    if ( insert_data($t, $v, $table,$conn) && user_coin_set("balance = $bal",$user_id, $account, $coin, $conn) )
    {
        return true;
    }
    return false;
}

function adel($conn, $id) {
    if ($conn->query("delete from santa_works where id = $id") == true) {
        return true;
    } 
    return false;
}
function admin_err($msg) {
    header("Location: ../500?msg=".$msg);
    die; exit();
}
?>