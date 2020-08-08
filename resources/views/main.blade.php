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

<!-- YIELD FOR CUSTOM SCRIPTS  -->
@stack('scripts')

</body>
</html>
