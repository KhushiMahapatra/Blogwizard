
<!DOCTYPE html>



<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- theme meta -->
  <meta name="theme-name" content="mono" />
  

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
  <link href="{{ asset('assets/auth/plugins/material/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/auth/plugins/simplebar/simplebar.css') }}" rel="stylesheet" />

  <!-- PLUGINS CSS STYLE -->
  <link href="{{ asset('assets/auth/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  @yield('styles')



  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">



  <link href="{{ asset('assets/auth/') }}plugins/toaster/toastr.min.css" rel="stylesheet" />


  <!-- MONO CSS -->
  <link id="main-css-href" rel="stylesheet" href="{{ asset('assets/auth/css/style.css') }}" />




  <!-- FAVICON -->
  <link href="{{ asset('assets/auth/images/favicon.png') }}" rel="shortcut icon" />

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="{{ asset('assets/auth/plugins/nprogress/nprogress.js') }}"></script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

</head>


  <body class="navbar-fixed sidebar-fixed" id="body">



    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="wrapper">


        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
            <div id="sidebar" class="sidebar sidebar-with-footer">
                <!-- Application Brand -->
                <div class="app-brand">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/auth/images/logo.png') }}" alt="Mono">
                        <span class="brand-name">Auth Dashboard</span>
                    </a>
                </div>
                <!-- begin sidebar scrollbar -->
                <div class="sidebar-left" data-simplebar style="height: 100%;">
                    <!-- sidebar menu -->
                    <ul class="nav sidebar-inner" id="sidebar-menu">
                        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('dashboard') }}">
                                <i class="mdi mdi-briefcase-account-outline"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="section-title">Apps</li>

                        <li class="{{ request()->routeIs('auth.categories') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('auth.categories') }}">
                                <i class="fas fa-tasks"></i>
                                <span class="nav-text">Categories</span>
                            </a>
                        </li>



                        <li class="{{ request()->routeIs('auth.tags') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('auth.tags') }}">
                                <i class="fas fa-tags"></i>
                                <span class="nav-text">Tags</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('comments.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('comments.index') }}">
                                <i class="fas fa-comments"></i>
                                <span class="nav-text">Comments</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('posts.index') ? 'active' : '' }}">
                            <a class="sidenav-item-link" href="{{ route('posts.index') }}">
                                <i class="fas fa-edit"></i>
                                <span class="nav-text">Posts</span>
                            </a>
                        </li>




                            <li class="has-sub">
                                <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#pages"
                                aria-expanded="false" aria-controls="pages">
                                    <i class="far fa-sticky-note"></i>
                                    <span class="nav-text">Pages</span> <b class="caret"></b>
                                </a>
                                <ul class="collapse" id="pages" data-parent="#sidebar-menu">
                                    <li class="{{ request()->routeIs('admin.pages.index') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('admin.pages.index') }}">
                                            <span class="nav-text ml-8 mb-3 mt-2" style="color:white">Pages</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('admin.index') }}">
                                            <span class="nav-text ml-8 mb-3 mt-2" style="color:white"> Fix Pages</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('admin.pages.pagescomments') ? 'active' : '' }}">
                                        <a class="sidenav-item-link" href="{{ route('admin.pages.pagescomments') }}">
                                            <span class="nav-text ml-8 mb-3 mt-2" style="color:white"> Pages comments</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>





                    </ul>
                </div>
            </div>
        </aside>

        <div class="page-wrapper">
        <header class="main-header" id="header">
            <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
              <!-- Sidebar toggle button -->
              <button id="sidebar-toggler" class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
              </button>

              <span class="page-title">dashboard</span>

              <div class="navbar-right ">



                <ul class="nav navbar-nav">
                  <!-- Offcanvas -->


                  <!-- User Account -->
                  <!-- User Account -->
                            <li class="dropdown user-menu">
                                <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                                    <img src="{{ asset('assets/site/images/user-image.jpg') }}" class="user-image rounded-circle" alt="User  Image" />
                                    <span class="d-none d-lg-inline-block">{{ auth()->check() ? auth()->user()->name : 'Guest' }}</span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-link-item" href="{{ route('auth.profile.index') }}">
                                            <i class="mdi mdi-account-outline"></i>
                                            <span class="nav-text" style="margin-left: 75px" >My Profile</span>
                                        </a>
                                    </li>
                                    <li class="dropdown-footer">
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            <a class="dropdown-link-item" href="{{ route('logout') }}">
                                                <i class="mdi mdi-logout"></i>
                                                <span class="nav-text" style="margin-left: 75px" >Logout</span>
                                            </a></form>
                                    </li>
                                </ul>
                            </li>



                    </ul>
                  </li>
                </ul>
              </div>
            </nav>


          </header>


          <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
     {{--  content will be here--}}

     @yield('content')





    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="copyright bg-white">
          <p>
            &copy; <span id="copy-year"></span> Copyright Mono Dashboard Bootstrap Template by <a class="text-primary" href="http://www.iamabdus.com/" target="_blank" >Abdus</a>.
          </p>
        </div>
        <script>
            var d = new Date();
            var year = d.getFullYear();
            document.getElementById("copy-year").innerHTML = year;
        </script>
      </footer>
    </div>

                    <script src="{{ asset('assets/auth/plugins/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('assets/auth/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                    <script src="{{ asset('assets/auth/plugins/simplebar/simplebar.min.js') }}"></script>
                    <script src="https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>
                    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
                    <script src="{{ asset('assets/auth/plugins/toaster/toastr.min.js') }}"></script>
                    <script src="{{ asset('assets/auth/js/mono.js') }}"></script>
                    <script src="{{ asset('assets/auth/js/custom.js') }}"></script>

    <script src="{{ asset('assets\tinymce\js\tinymce\tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#myeditorinstance',
            plugins: 'code table lists',
            menubar: false,
            toolbar: 'undo redo |  bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist '

        });
    </script>
                    <!--  -->
    @yield('scripts')

  </body>
</html>
