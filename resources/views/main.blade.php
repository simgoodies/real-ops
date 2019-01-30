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

<script>
    // Get the current year for the copyright
    $('#year').text(new Date().getFullYear());
</script>
<!-- YIELD FOR CUSTOM SCRIPTS  -->
@yield('scripts')

</body>
</html>