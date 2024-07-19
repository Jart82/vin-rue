<?php 
require "../action/conn.php";
require "admin_core.php";
require "template.php";
?>
<?php 
$mode = $conn -> real_escape_string( gget('mode') );
$table = $conn -> real_escape_string( gget('mode') );
$id = $conn -> real_escape_string( gget('id') );
$template = $conn -> real_escape_string( gget('template') );
$json = $get_json[$template];
$obj = json_decode($json);

$acct = $conn -> real_escape_string( gget('acct') );
if ($acct == 1) {
    $user = get_user_2($conn,$_GET['user_id']);
    $obj->data[] = (object) ["name" => "user_id", "type" => "hidden_string", "value" => $user['user_id']];
}
//echo json_encode($obj); die;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Account - Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4"><?=$obj->heading; ?></h3>
                                        <code><?=$obj->details; ?></code>
                                        </div>
                                    <div class="card-body">
                                        <form action="action/table" method="post">
                                            <?php if ($obj->mode == 'new') { ?>
                                            <?php foreach($obj->data as $o) { ?>
                                            <?php if ($o->type == 'number') { ?>
                                                <div class="form-floating mb-4">
                                                    <input name="<?=$o->name; ?>" class="form-control" id="inputPassword" type="number" step="any" placeholder="<?=$o->placeholder; ?>" />
                                                    <label for="inputPassword"><?=$o->label; ?></label>
                                                </div>
                                            <?php } else if ($o->type == 'text') { ?>
                                                <div class="form-floating mb-4">
                                                    <input name="<?=$o->name; ?>" class="form-control" id="inputPassword" type="text" placeholder="<?=$o->placeholder; ?>" />
                                                    <label for="inputPassword"><?=$o->label; ?></label>
                                                </div>
                                            <?php } else if ($o->type == 'select') { ?>
                                                <div class="form-floating mb-4">
                                                    <select name="<?=$o->name; ?>" class="form-control" id="inputPassword">
                                                        <?php foreach($o->option as $o2) { ?>
                                                        <option><?=$o2; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="inputPassword"><?=$o->placeholder; ?></label>
                                                </div>
                                            <?php } else if ($o->type == 'set_datetime') { ?>
                                                <input type="hidden" name="<?=$o->type; ?>" value = "<?=$o->name; ?>" >
                                            <?php } else if ($o->type == 'hidden_string') { ?>
                                                <input type="hidden" name="<?=$o->name; ?>" value = "<?=$o->value; ?>" >
                                            <?php }  else if ($o->type == 'hidden_number') { ?>
                                                <input type="hidden" name="<?=$o->name; ?>" value = <?=$o->value; ?> >
                                            <?php } else if ($o->type == 'datetime') { ?>
                                            <div class="form-floating mb-4">
                                                <input type="datetime-local" class="form-control" name="<?=$o->name; ?>" >
                                                <label for="inputPassword"><?=$o->placeholder; ?></label>
                                            </div>
                                            <?php } ?>
                                            
                                            <?php } ?>
                                            
                                            
                                            <?php }  else if ($obj->mode =='edit') { ?>
                                            
                                            
                                            <?php foreach($obj->data as $o) { ?>
                                            <?php if ($o->type == 'number') { ?>
                                                <div class="form-floating mb-4">
                                                    <input name="<?=$o->name; ?>" class="form-control" id="inputPassword" type="number" step="any" placeholder="<?=$o->placeholder; ?>" value = <?=get_val($o->name,$obj->table, $id,$conn) ?> />
                                                    <label for="inputPassword"><?=$o->label; ?></label>
                                                </div>
                                            <?php } else if ($o->type == 'text') { ?>
                                                <div class="form-floating mb-4">
                                                    <input name="<?=$o->name; ?>" class="form-control" id="inputPassword" type="text" placeholder="<?=$o->placeholder; ?>" 
                                                    value = '<?=get_val($o->name,$obj->table, $id,$conn) ?>'
                                                    />
                                                    <label for="inputPassword"><?=$o->label; ?></label>
                                                </div>
                                            <?php } else if ($o->type == 'select') { ?>
                                                <div class="form-floating mb-4">
                                                    <select name="<?=$o->name; ?>" class="form-control" id="inputPassword">
                                                        <?php foreach($o->option as $o2) { ?>
                                                        <option <?php if ($o2 == get_val($o->name,$obj->table, $id,$conn)) {echo 'selected'; } ?>><?=$o2; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <label for="inputPassword"><?=$o->placeholder; ?></label>
                                                </div>
                                            <?php } else if ($o->type == 'set_datetime') { ?>
                                                <input type="hidden" name="<?=$o->type; ?>" value = "<?=$o->name; ?>" >
                                            <?php } else if ($o->type == 'hidden_string') { ?>
                                                <input type="hidden" name="<?=$o->name; ?>" value = "<?=$o->value; ?>" >
                                            <?php }  else if ($o->type == 'hidden_number') { ?>
                                                <input type="hidden" name="<?=$o->name; ?>" value = <?=$o->value; ?> >
                                            <?php } else if ($o->type == 'datetime') { ?>
                                                <div class="form-floating mb-4">
                                                    <input type="datetime-local" name="<?=$o->name; ?>" class="form-control" value = '<?=get_val($o->name,$obj->table, $id,$conn); ?>' >
                                                    <label for="inputPassword"><?=$o->placeholder; ?></label>
                                                </div>
                                            <?php } ?>
                                            <input type="hidden" name="id" value = <?=$id; ?> >
                                            
                                            <?php } ?>
                                            
                                            <?php } ?>
                                            
                                            
                                            
                                            <input type="hidden" name="template" value = '<?=$template; ?>' >
                                            <?php  if ($acct == 1) { ?> 
                                                <input type="hidden" name="acct" value = 1 >
                                                <input type="hidden" name="user_id" value = "<?=$user['user_id']; ?>" >
                                            <?php } else { ?>
                                                <input type="hidden" name="acct" value = 0 >
                                            <?php } ?>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" >Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
