<!DOCTYPE html>
<html lang="en">
  
<head>
    <!--  Title -->
    <title>Mordenize | @yield('title')</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('template/dist/images/logos/favicon.png') }}" />
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('template/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="{{ asset('template/dist/css/style.min.css') }}" />
    {{-- Toastify --}}
	  <link rel="stylesheet" type="text/css" href="{{ asset('template/toastify/toastify.min.css') }}">
	  <script type="text/javascript" src="{{ asset('template/toastify/toastify.min.js') }}"></script>
    {{-- Sweetalert --}}
	  <link rel="stylesheet" type="text/css" href="{{ asset('template/sweetalert/sweetalert2.min.css') }}">
	  <script type="text/javascript" src="{{ asset('template/sweetalert/sweetalert2.all.min.js') }}"></script>
    <!-- Datatable -->
    <link rel="stylesheet" href="{{ asset('template/dist/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
  </head>
  <body>
    <!-- Preloader -->
    <style>
      /* CSS untuk animasi lingkaran putar */
      @keyframes lds-ring {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      /* CSS untuk mengatur dimensi dan tata letak loader */
      .preloader {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
      }

      .lds-ring {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
      }

      .lds-ring div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 51px;
        height: 51px;
        margin: 6px;
        border: 6px solid #0b6280; /* Warna biru muda (#00BFFF) */
        border-radius: 50%;
        animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        border-color: #00BFFF transparent transparent transparent; /* Warna biru muda (#00BFFF) */
      }

      .lds-ring div:nth-child(1) {
        animation-delay: -0.45s;
      }

      .lds-ring div:nth-child(2) {
        animation-delay: -0.3s;
      }

      .lds-ring div:nth-child(3) {
        animation-delay: -0.15s;
      }

    </style>
    <div class="preloader">
      <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
    <!-- Preloader -->
    <div class="preloader">
      <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme"  data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <!-- Sidebar Start -->
      <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div>
          <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
              <img src="{{ asset('template/dist/images/logos/dark-logo.svg') }}" class="dark-logo" width="180" alt="" />
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
              <i class="ti ti-x fs-8"></i>
            </div>
          </div>
          <!-- Sidebar navigation-->
          <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
              <!-- ============================= -->
              <!-- Menu -->
              <!-- ============================= -->
              <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <span class="hide-menu">Daftar Menu</span>
              </li>
              <!-- =================== -->
              <!-- Dashboard -->
              <!-- =================== -->
              <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                  <span>
                    <i class="ti ti-chart-pie"></i>
                  </span>
                  <span class="hide-menu">Dashboard</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('kasir') }}" aria-expanded="false">
                  <span>
                    <i class="ti ti-shopping-cart"></i>
                  </span>
                  <span class="hide-menu">Layanan&nbsp;Kasir</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('kelola_stok_harga') }}" aria-expanded="false">
                  <span>
                    <i class="ti ti-table"></i>
                  </span>
                  <span class="hide-menu">Stok&nbsp;&&nbsp;Harga</span>
                </a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('data_pembelian') }}" aria-expanded="false">
                    <span>
                        <i class="ti ti-history"></i>
                      </span>
                      <span class="hide-menu">Data&nbsp;Pembelian</span>
                  </a>
              </li>
              <!-- ============================= -->
              
            </ul>
          </nav> 
          <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
      </aside>
      <!--  Sidebar End -->
      <!--  Main wrapper -->
      <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header"> 
          <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                  <i class="ti ti-menu-2"></i>
                </a>
              </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-lg-flex">
            
            </ul>
            <div class="d-block d-lg-none">
              <img src="{{ asset('template/dist/images/logos/dark-logo.svg') }}" class="dark-logo" width="180" alt="" />
            </div>
            <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="p-2">
                <i class="ti ti-dots fs-7"></i>
              </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
                        Data Profile&emsp;<i class="ti ti-chevron-right fs-7"></i>&emsp;Detail&emsp;<i class="ti ti-chevron-right fs-7"></i>
                    </a>
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                  <li class="nav-item dropdown">
                    <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <div class="user-profile-img">
                          <img src="{{ asset('template/dist/images/profile/user-1.jpg') }}" class="rounded-circle" width="35" height="35" alt="" />
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                      <div class="profile-dropdown position-relative" data-simplebar>
                        <div class="py-3 px-7 pb-0">
                          <h5 class="mb-0 fs-5 fw-semibold">Data Profile</h5>
                        </div>
                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                          <img src="{{ asset('template/dist/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80" alt="" />
                          <div class="ms-3">
                            <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                            <span class="mb-1 d-block text-dark">Owner</span>
                            <p class="mb-0 d-flex text-dark align-items-center gap-2">
                              <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                            </p>
                          </div>
                        </div>
                        <div class="message-body" style="padding-right:20px; padding-left:20px;">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="btn btn-outline-primary" style="width: 100%;">Keluar Aplikasi</a>
                            </form>
                          <br>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </header>
        <!--  Header End -->

        {{-- Main content --}}
        <script src="{{ asset('template/dist/libs/jquery/dist/jquery.min.js') }}"></script>
        @yield('content')
        {{-- Main content --}}

      </div>
    </div>

    <!--  Import Js Files -->
    
    <script src="{{ asset('template/dist/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('template/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--  core files -->
    <script src="{{ asset('template/dist/js/app.min.js') }}"></script>
    <script src="{{ asset('template/dist/js/app.init.js') }}"></script>
    <script src="{{ asset('template/dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('template/dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('template/dist/js/custom.js') }}"></script>
    <!--  current page js files -->
    <script src="{{ asset('template/dist/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template/dist/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <script>
        // SCRIPT CUSTOM
        function toastSuccess(message) {
          Toastify({
              text: message,
              style: {
                  background: "#3434eb",
              },
              duration: 3000,
              close: false,
          }).showToast();
        }
        function toastError(message) {
          Toastify({
              text: message,
              style: {
                  background: "#ce0006",
              },
              duration: 4000,
              close: false,
          }).showToast();
        }
        function errorHandlerToast(value) {
          Object.values(value).forEach(function(errors) {
              errors.forEach(function(error) {
                toastError(error);
              });
          });
        }
        function customConfirm(title, message) {
            return new Promise((resolve) => {
                Swal.fire({
                    title: title,
                    text: message,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, lanjutkan",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    resolve(result.isConfirmed);
                });
            });
        }
    </script>
  </body>

</html>