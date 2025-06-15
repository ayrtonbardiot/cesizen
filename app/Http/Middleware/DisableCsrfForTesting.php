<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

class DisableCsrfForTesting extends VerifyCsrfToken
{
    protected function tokensMatch($request)
    {
        return app()->environment('testing') ? true : parent::tokensMatch($request);
    }
}


