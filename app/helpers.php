<?php

if (!function_exists('tenant_path_route')) {
    function tenant_path_route($route, $parameters = [], $absolute = true)
    {
        return route($route, ['tenant' => tenant('code')] + $parameters, $absolute);
    }
}
