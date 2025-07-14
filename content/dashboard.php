<?php
$user = isset($_SESSION['NAME']) ? $_SESSION['NAME'] : '';

$queryService = mysqli_query($config, 'SELECT COUNT(id) AS total_services FROM type_of_service');
$totalServices = mysqli_fetch_assoc($queryService)['total_services'];

$queryCustomer = mysqli_query($config, 'SELECT COUNT(id) AS total_customer FROM customer');
$totalCustomer = mysqli_fetch_assoc($queryCustomer)['total_customer'];

$queryTransaction = mysqli_query($config, 'SELECT COUNT(id) AS total_transaction FROM trans_order WHERE deleted_at IS NULL');
$totalTransaction = mysqli_fetch_assoc($queryTransaction)['total_transaction'];

$queryIncome = mysqli_query($config, 'SELECT SUM(total) AS income FROM trans_order');
$totalIncome = mysqli_fetch_assoc($queryIncome)['income'];
?>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Greeting Card (baris pertama) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Heloo <?= $user ?>! 🎉</h5>
                            <p class="mb-4">Optimalkan layananmu—waktunya hasilkan lebih banyak order hari ini!</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="template/assets/img/illustrations/man-with-laptop-light.png"
                                height="140"
                                alt="Greeting Image"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards (baris kedua) -->
    <div class="row d-flex align-items-stretch">
        <!-- Services -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-1000">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="template/assets/img/icons/unicons/chart-success.png" alt="chart" class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="?page=service">View More</a>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Services</span>
                    <h3 class="card-title mb-2"><?= $totalServices ?></h3>
                </div>
            </div>
        </div>

        <!-- Customer -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="template/assets/img/icons/unicons/wallet-info.png" alt="customer" class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="customer">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Customer</span>
                    <h3 class="card-title text-nowrap mb-2"><?= $totalCustomer ?></h3>
                </div>
            </div>
        </div>

        <!-- Income -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="template/assets/img/icons/unicons/paypal.png" alt="income" class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="transaction-history">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                    <span class="d-block mb-1">Income</span>
                    <h3 class="card-title text-nowrap mb-2">Rp <?= number_format($totalIncome / 1000, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>

        <!-- Transactions -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <img src="template/assets/img/icons/unicons/cc-primary.png" alt="transactions" class="rounded" />
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">View More</a>
                                <a class="dropdown-item" href="#">Delete</a>
                            </div>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">On Going Transaction</span>
                    <h3 class="card-title mb-2"><?= $totalTransaction ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>