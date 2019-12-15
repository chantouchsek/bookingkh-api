<?php

namespace App\Concerns;

use Illuminate\Http\Request;

trait RequestsThrottlingCompatibility
{
    /**
     * Resolve request signature.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function resolveRequestSignature($request)
    {
        if ($user = $request->user()) {
            return sha1($user->getAuthIdentifier());
        }
        if ($route = $request->route()) {
            return sha1($request->getHttpHost().'|'.$request->ip());
        }

        return sha1($request->server('SERVER_NAME').'|'.$request->ip());
    }
}
