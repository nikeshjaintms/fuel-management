@include('layouts.head')
@yield('style')
@include('layouts.sidebar')
@include('layouts.header')
@yield('content-page')
@include('layouts.footer')
{{-- @include('layouts.alertmsg') --}}
@include('layouts.flash')
@include('layouts.footer-script')
@yield('footer-script')

