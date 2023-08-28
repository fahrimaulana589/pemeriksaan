<!DOCTYPE html>
<html x-data="{nav:false}" :class="{'layout-menu-expanded':nav}" lang="{{  app()->getLocale() }}" data-controller="html-load" dir="{{ \Orchid\Support\Locale::currentDir() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>
        @yield('title', config('app.name'))
        @hasSection('title')
            - {{ config('app.name') }}
        @endif
    </title>
    <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
    <meta name="auth" content="{{  Auth::check() }}" id="auth">

    @if(\Orchid\Support\Locale::currentDir(app()->getLocale()) == "rtl")
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid.rtl.css','vendor/orchid') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid.css','vendor/orchid') }}">
    @endif

    @stack('head')

    <meta name="dashboard-prefix" content="{{  Dashboard::prefix() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{url('')}}/assets/vendor/fonts/boxicons.css"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{url('')}}/assets/vendor/css/core.css" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{url('')}}/assets/vendor/css/theme-default.css"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{url('')}}/assets/css/demo.css"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{url('')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"/>

    <link rel="stylesheet" href="{{url('')}}/assets/vendor/libs/apex-charts/apex-charts.css"/>

    <!-- Page CSS -->

    <!-- Helpers -->
{{--    <script src="{{url('')}}/assets/vendor/js/helpers.js"></script>--}}

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{url('')}}/assets/js/config.js"></script>

    @if(!config('platform.turbo.cache', false))
        <meta name="turbo-cache-control" content="no-cache">
    @endif

    <script src="{{ mix('/js/manifest.js','vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js','vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/orchid.js','vendor/orchid') }}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{  $stylesheet }}">
    @endforeach

    @stack('stylesheets')

    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{  $scripts }}" defer type="text/javascript"></script>
    @endforeach

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar" style="background-color: #F6F4EB !important;">
    <div class="layout-container">
        @yield('aside')

        <!-- Layout container -->
        <div class="layout-page">
            @if(Auth::check())
                <!-- Navbar -->
                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar"
                >
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" @click="nav = !nav">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <ul  class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- User -->
                            <li x-data="{show:false}" class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a @click="show = !show" :class="{'show':show}"  class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);">
                                    <div class="avatar avatar-online">
                                        @if($image = Auth::user()->presenter()->image())
                                            <img src="{{url('')}}/assets/img/avatars/1.png"
                                                 class="w-px-40 h-auto rounded-circle" type="image/*"/>
                                        @else
                                            <img src="{{url('')}}/assets/img/avatars/1.png" alt
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        @endif
                                    </div>
                                </a>
                                <ul :class="{'show':show}" class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route(config('platform.profile', 'platform.profile')) }}">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        @if($image = Auth::user()->presenter()->image())
                                                            <img src="{{url('')}}/assets/img/avatars/1.png"
                                                                 alt="{{ Auth::user()->presenter()->title()}}"
                                                                 class="w-px-40 h-auto rounded-circle" type="image/*"/>
                                                        @else
                                                            <img src="{{url('')}}/assets/img/avatars/1.png" alt
                                                                 class="w-px-40 h-auto rounded-circle"/>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                <span
                                                    class="fw-semibold d-block">{{Auth::user()->presenter()->title()}}</span>
                                                    <small
                                                        class="text-muted">{{Auth::user()->presenter()->subTitle()}}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item ps-3" href="{{ route(config('platform.profile', 'platform.profile')) }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <button data-controller="button" data-turbo="true" class="dropdown-item ps-3" type="submit" form="post-form" formaction="{{url('')}}/admin/logout">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>
                <!-- / Navbar -->
            @endif

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">

                    @if(Breadcrumbs::has())
                        <h4 class="fw-bold py-3 mb-4">
                            <x-tabuna-breadcrumbs
                                class="breadcrumb-item"
                                active="active"
                            />
                        </h4>
                    @endif

                    @yield('body')
                </div>
                <!-- / Content -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
@include('platform::partials.toast')
</body>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{url('')}}/assets/vendor/libs/jquery/jquery.js"></script>
<script src="{{url('')}}/assets/vendor/libs/popper/popper.js"></script>
<script src="{{url('')}}/assets/vendor/js/bootstrap.js"></script>
<script src="{{url('')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="{{url('')}}/assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{url('')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{url('')}}/assets/js/main.js"></script>

<!-- Page JS -->
<script src="{{url('')}}/assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>


@stack('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.3/dist/cdn.min.js"></script>

</body>
</html>
