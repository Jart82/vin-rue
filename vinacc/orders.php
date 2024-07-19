<?php 
require "../action/conn.php";
require "admin_core.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <a class="nav-link" href="./new_room">
                                <div class="sb-nav-link-icon"><i class="fas fa-hotel"></i></div>
                                New Room
                            </a>
                            <a class="nav-link" href="./orders">
                                <div class="sb-nav-link-icon"><i class="fas fa-hotel"></i></div>
                                Orders
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Orders</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#"><?=ht_get_rows_all_num($conn,'orders'); ?></a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Users
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatablesSimple" class="table">
                                    <thead>
                                        <tr>
                                            <th>Appartment</th>
                                            <th>Orderd By</th>
                                            <th>Price</th>
                                            <th>Guests</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Appartment</th>
                                            <th>Orderd By</th>
                                            <th>Price</th>
                                            <th>Guests</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach(ht_get_all_rows($conn,'orders') as $order) { ?>
                                        <tr>
                                            <td>
                                                <?=$order['title']; ?> 
                                            </td>
                                            <td>
                                                <?=$order['name']; ?> <br/>
                                                <?=$order['email']; ?> <br/>
                                                <?=$order['phone']; ?> <br/>
                                                <hr/>
                                                <p>Requested on: <?= date('d F Y', strtotime($order['date_created'])); ?></p>
                                            </td>
                                            <td>
                                                NGN <?=number_format($order['price'],2); ?> 
                                            </td>
                                            <td><?=$order['guests']; ?></td>
                                            <td>
                                                <p>Order Status:</p>
                                                <i class="fa fa-info"></i> <span class="badge bg-<?= gst($order['status']); ?>"><?= $order['status']; ?></span>
                                                <br/><br/>
                                                <?php if ($order['status'] == 'Pending') { ?>
                                                <a class=" btn btn-success mb-2" href="action/order?id=<?=$order['id'];?>&ac=apr" >Approve</a> 
                                                <a class=" btn btn-danger mb-2" href="action/order?id=<?=$order['id']; ?>&ac=can">Cancel</a> 
                                                <?php } else if (!$order['status'] == 'Complete') { ?>
                                                <a class=" btn btn-info mb-2" href="action/order?id=<?=$order['id'];?>&ac=com" >Complete</a> 
                                                <?php } ?>
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
            function del(id) {
                if (confirm('Are you sure to delete this apartment')) {
                    window.location.replace("action/tdel?id=" + id);
                }
                return;
            }
        </script>
    </body>
</html>
