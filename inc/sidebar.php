<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="template/index.html" class="text-nowrap logo-img">
                <img src="assets/images/logos/logo.svg" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">

                <li class="nav-small-cap">
                    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                    <span class="hide-menu">Home</span>
                </li>
                <?php if ($_SESSION['ID_LEVEL'] == '1'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="?page=user" aria-expanded="false">
                            <i class="ti ti-atom"></i>
                            <span class="hide-menu">User</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="?page=customer" aria-expanded="false">
                            <i class="ti ti-atom"></i>
                            <span class="hide-menu">Customer</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link justify-content-between"
                            href="?page=service" aria-expanded="false">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex">
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                                <span class="hide-menu">Service</span>
                            </div>

                        </a>
                    </li>
                <?php endif ?>

                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                <?php if ($_SESSION['ID_LEVEL'] == '3'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link justify-content-between"
                            href="?page=report" aria-expanded="false">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex">
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">Report</span>
                            </div>

                        </a>
                    </li>
                <?php endif ?>

                <?php if ($_SESSION['ID_LEVEL'] == '1'): ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link justify-content-between" href="?page=transaction" aria-expanded="false">
                            <div class="d-flex align-items-center gap-3">
                                <span class="d-flex">
                                    <i class="ti ti-layout-grid"></i>
                                </span>
                                <span class="hide-menu">Transaction</span>
                            </div>
                        </a>
                    </li>
                <?php endif ?>
    </div>
</aside>