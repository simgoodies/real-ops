@extends('main')

@section('title', 'Contact')

@section('main-content')
    @include('partials._nav')

    <div class="typeform-widget" data-url="https://rolgonzalez.typeform.com/to/CjREly" data-transparency="50"
         data-hide-headers=true data-hide-footer=true style="width: 100%; height: 500px;"></div>
    <script> (function () {
            var qs, js, q, s, d = document, gi = d.getElementById, ce = d.createElement, gt = d.getElementsByTagName,
                id = "typef_orm", b = "https://embed.typeform.com/";
            if (!gi.call(d, id)) {
                js = ce.call(d, "script");
                js.id = id;
                js.src = b + "embed.js";
                q = gt.call(d, "script")[0];
                q.parentNode.insertBefore(js, q)
            }
        })() </script>
    <div style="font-family: Sans-Serif;font-size: 12px;color: #999;opacity: 0.5; padding-top: 5px;"> powered by <a
                href="https://admin.typeform.com/signup?utm_campaign=CjREly&utm_source=typeform.com-13389669-Basic&utm_medium=typeform&utm_content=typeform-embedded-poweredbytypeform&utm_term=EN"
                style="color: #999" target="_blank">Typeform</a></div>

    @include('partials._footer')

@endsection
