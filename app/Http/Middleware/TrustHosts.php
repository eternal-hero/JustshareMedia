<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Get the host patterns that should be trusted.
     *
     * @return array
     */
    public function hosts()
    {
        return [
            'justsharedev.westlinkclient.com',
            'dev.localhost',
            'dev.localhost.com',
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
