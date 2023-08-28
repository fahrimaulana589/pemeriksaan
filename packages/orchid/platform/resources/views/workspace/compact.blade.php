@extends('platform::app')

@section('body')

    <div class="container-xl p-0">
        <div class="workspace workspace-limit mb-4 mb-md-0 d-flex flex-column h-100">
            @yield('workspace')
        </div>
    </div>

@endsection
