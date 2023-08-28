@extends(config('platform.workspace', 'platform::workspace.compact'))

@section('aside')
    <!-- Menu -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" style="background-color: #F6F4EB !important;">
        <div class="app-brand demo">
            <a href="#" class="app-brand-link">
                <span class="app-brand-text demo menu-text fw-bolder ms-2"> {{ config('app.name') }}</span>
            </a>
            <a @click="nav = !nav" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">

            {!! Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_MAIN) !!}

        </ul>
    </aside>
    <!-- / Menu -->

@endsection

@section('workspace')
    <div class="order-last order-md-0 command-bar-wrapper" >
        <div class="@hasSection('navbar') @else d-none d-md-block @endif layout d-md-flex align-items-center">
            <header class="d-none d-md-block col-xs-12 col-md p-0 me-3">
                <h1 class="m-0 fw-light h3 text-black">@yield('title')</h1>
                <small class="text-muted" title="@yield('description')">@yield('description')</small>
            </header>
            <nav class="col-xs-12 col-md-auto ms-md-auto p-0">
                <ul class="nav command-bar justify-content-sm-end justify-content-start d-flex align-items-center">
                    @yield('navbar')
                </ul>
            </nav>
        </div>
    </div>

    @include('platform::partials.alert')
    @yield('content')
@endsection
