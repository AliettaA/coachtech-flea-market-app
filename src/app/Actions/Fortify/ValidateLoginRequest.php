<?php

namespace App\Actions\Fortify;

use App\Http\Requests\LoginRequest;

class ValidateLoginRequest
{
    public function handle($request, $next)
    {
        $request->validate(
            (new LoginRequest())->rules(),
            (new LoginRequest())->messages()
        );

        return $next($request);
    }
}
