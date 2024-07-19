<?php 
require "../action/conn.php";
require "admin_core.php";
?>
<?php 
$r = get_waddress($conn);
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
                                        <h3 class="text-center font-weight-light my-4">Edit Contact Info</h3>
                                        <code>Update Contact</code>
                                        </div>
                                    <div class="card-body">
                                        <form action="action/adr2" method="post">
                                            
                                            <div class="form-floating mb-3">
                                                <textarea name="script" class="form-control" id="inputPassword" type="text" step="any"><?=$r['script']; ?></textarea>
                                                <label for="inputPassword">Live Chat</label>
                                            </div>
                                            
                                            <div class="form-floating mb-3">
                                                <input name="phone" class="form-control" id="inputPassword" type="text" step="any" value="<?=$r['phone']; ?>"/>
                                                <label for="inputPassword">Phone</label>
                                            </div>
                                            
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
