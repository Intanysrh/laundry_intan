<?php
ob_start();
include "config/koneksi.php";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flexy Free Bootstrap Admin Template by WrapPixel</title>
    <link rel="shortcut icon" type="image/png" href="template/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="template/assets/css/styles.min.css" />
</head>

<body>
    <?php include 'inc/header.php' ?>

    <?php include 'inc/sidebar.php' ?>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!--  App Topstrip -->

        <!-- Sidebar Start -->
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <!--  Header End -->
            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <section class="section">
                        <?php isset($_GET['page']) ? str_replace("-", " ", ucfirst($_GET['page'])) : 'Home' ?>
                        <div class="card-body">
                            <?php
                            if (isset($_GET['page'])) {
                                if (file_exists("content/" . $_GET['page'] . ".php")) {
                                    include("content/" . $_GET['page'] . ".php");
                                } else {
                                    include "content/notfound.php";
                                }
                            }
                            ?>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
    <script src="template/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="template/assets/js/sidebarmenu.js"></script>
    <script src="template/assets/js/app.min.js"></script>
    <script src="template/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="template/assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="template/assets/js/dashboard.js"></script>
    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>