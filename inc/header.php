 <!--  App Topstrip -->
 <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
     <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
         <a class="d-flex justify-content-center" href="#">
             <img src="assets/images/logos/logo-wrappixel.svg" alt="" width="150">
         </a>


     </div>

     <div class="d-lg-flex align-items-center gap-2">
         <h3 class="text-white mb-2 mb-lg-0 fs-5 text-center">Fresh. Fast. Fabulous</h3>
         <div class="d-flex align-items-center justify-content-center gap-2">

             <div class="dropdown d-flex">
                 <a class="btn btn-primary d-flex align-items-center gap-1 " href="javascript:void(0)" id="drop4"
                     data-bs-toggle="dropdown" aria-expanded="false">
                     <i class="ti ti-shopping-cart fs-5"></i>
                     Buy Now
                     <i class="ti ti-chevron-down fs-5"></i>
                 </a>
             </div>
         </div>
     </div>

 </div>

 <header class="app-header">
     <nav class="navbar navbar-expand-lg navbar-light">
         <ul class="navbar-nav">
             <li class="nav-item d-block d-xl-none">
                 <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                     <i class="ti ti-menu-2"></i>
                 </a>
             </li>
             <li class="nav-item dropdown">
                 <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                     <i class="ti ti-bell"></i>
                     <div class="notification bg-primary rounded-circle"></div>
                 </a>
                 <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                     <div class="message-body">
                         <a href="javascript:void(0)" class="dropdown-item">
                             Item 1
                         </a>
                         <a href="javascript:void(0)" class="dropdown-item">
                             Item 2
                         </a>
                     </div>
                 </div>
             </li>
         </ul>
         <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
             <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">

                 <li class="nav-item dropdown">
                     <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                         aria-expanded="false">
                         <img src="template
                                    /assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                     </a>
                     <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                         <div class="message-body">
                             <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                 <i class="ti ti-user fs-6"></i>
                                 <p class="mb-0 fs-3">My Profile</p>
                             </a>
                             <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                 <i class="ti ti-mail fs-6"></i>
                                 <p class="mb-0 fs-3">My Account</p>
                             </a>
                             <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                 <i class="ti ti-list-check fs-6"></i>
                                 <p class="mb-0 fs-3">My Task</p>
                             </a>
                             <a href="template/authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                         </div>
                     </div>
                 </li>
             </ul>
         </div>
     </nav>
 </header>