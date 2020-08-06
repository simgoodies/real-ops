<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stancl\Tenancy\Features\UserImpersonation;

class LoginUserController extends Controller
{
    public function __invoke(Request $request, $token)
    {
        return UserImpersonation::makeResponse($token);
    }
}
