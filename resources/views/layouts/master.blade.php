@include('layouts.master_header')

<div class="page-wrapper">
    @include('layouts.top_bar')
    @include('layouts.side_bar')
    <div class="content-wrapper">
        @yield('pages')
        @include('layouts.footer')
    </div>
</div>
@include('layouts.right_side_bar')
@include('layouts.preloader')
@include('layouts.master_footer')
