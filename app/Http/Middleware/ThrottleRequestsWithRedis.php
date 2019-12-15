<?php

namespace App\Http\Middleware;

use App\Concerns\RequestsThrottlingCompatibility;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis as BaseThrottleRequestsWithRedis;

class ThrottleRequestsWithRedis extends BaseThrottleRequestsWithRedis
{
    use RequestsThrottlingCompatibility;
}
