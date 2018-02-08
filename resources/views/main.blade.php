<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials._head')
</head>

<body>
@include('partials._nav')

<div class="container">
    @include('partials._messages')
    @yield('content')
</div>
<br>
<div class="container">
    @include('partials._footer')
</div>

@include('partials._javascript')

@yield('scripts')
</body>
</html>