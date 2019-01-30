<!DOCTYPE html>
<html lang="en">

{{-- HEAD --}}
<head>
    @include('partials._head')
</head>

<!-- BODY -->
<body>

<!-- YIELD FOR MAIN-CONTENT -->
@yield('main-content')

    <!-- INCLUDE REQUIRED JAVASCRIPT -->
    @include('partials._javascript')

<!-- YIELD FOR CUSTOM SCRIPTS  -->
@yield('scripts')

</body>
</html>