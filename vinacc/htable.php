<?php 
require "../action/conn.php";
require "admin_core.php";
require "template.php";
?>
<?php 
$user = get_user_2($conn,$_GET['user_id']);
$user_id = $_GET['user_id'];
$template = $conn -> real_escape_string( gget('template') );
$json = $get_json[$template];
$obj = json_decode($json);
$table = $obj->table;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            table tr th {white-space:nowrap;}
            .datatable-dropdown {
                margin-bottom:20px!important;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="./">Admin Dashboard</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="./">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Admin
                            </a>
                            <a class="nav-link" href="waddress">
                                <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                Wallet Address
                            </a>
                            <a class="nav-link" href="contact">
                                <div class="sb-nav-link-icon"><i class="fas fa-phone"></i></div>
                                Live Chat and Phone Number
                            </a>
                            <a class="nav-link" href="password">
                                <div class="sb-nav-link-icon"><i class="fas fa-lock"></i></div>
                                Change Password
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?=$user['fullname']; ?> </h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?=$obj->details; ?></li>
                        </ol>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#"><?=num_of_trx($conn,$user['user_id'],$table); ?></a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <a href="table?mode=new&user_id=<?=$user['user_id']; ?>&acct=1&template=<?=$template;?>" class="btn btn-info btn-lg">Create History</a>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                <?=$obj->details; ?>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <?php foreach($obj->data as $o) { ?>
                                            <th><?=$o->label; ?></th>
                                            <?php } ?>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <?php foreach($obj->data as $o) { ?>
                                            <th><?=$o->label; ?></th>
                                            <?php } ?>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach(get_trx_2($conn,$table,$user_id,'id') as $trx) { ?>
                                        <tr>
                                            <?php foreach($trx as $key => $val)  {
                                            if ($key !='user_id' and $key != 'id') {echo "<td>$val</td>"; } }
                                            ?>
                                            <td><a href="table?mode=edit&template=<?=$template;?>_edit&id=<?=$trx['id']; ?>" class="btn btn-info">Edit</a>
                                            <button onclick="del(<?=$trx['id']; ?>, '<?=$table; ?>')" class="btn btn-danger mt-md-0 mt-2">Delete</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script>
            function del(id, table) {
                if (confirm('Are you sure to delete this account')) {
                    window.location.replace("action/tdel?id=" + id +"&table=" + table);
                }
                return;
            }
        </script>
    </body>
</html>
