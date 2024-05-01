<?php

/*
 * This file is part of towoju5/laravel-referral package.
 *
 * © towoju5 <towojuads@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Towoju5\Referral\Http\Middleware;

use Closure;
use Cookie;

class CheckReferral
{
    public function handle($request, Closure $next)
    {
        if ($request->has('ref')) {
            // Get the value of the referrerId
            $referrerId = $request->query('ref');

            // Set referral information in cookies with a lifespan of 6 months
            cookie()->queue('referral', $referrerId, 60 * 24 * 30 * 6); // 60 minutes * 24 hours * 30 days * 6 months
        }

        return $next($request);
    }
}
