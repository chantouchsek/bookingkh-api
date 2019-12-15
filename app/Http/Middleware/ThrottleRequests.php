<?php

namespace App\Http\Middleware;

use App\Concerns\RequestsThrottlingCompatibility;
use Illuminate\Routing\Middleware\ThrottleRequests as BaseThrottleRequests;

class ThrottleRequests extends BaseThrottleRequests
{
    use RequestsThrottlingCompatibility;
}
