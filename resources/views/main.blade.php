<!DOCTYPE html>
<html lang="en">

{{-- HEAD --}}
<head>
    @include('partials._head')
</head>

<!-- BODY -->
<body class="font-sans bg-gray-50">

<!-- YIELD FOR MAIN-CONTENT -->
@yield('main-content')

<script src="{{ asset('js/app.js') }}"></script>
@livewireScripts
<script>
    // Get the current year for the copyright
    $('#year').text(new Date().getFullYear());
</script>

<!-- YIELD FOR CUSTOM SCRIPTS  -->
@yield('scripts')

</body>
</html>
