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

class CheckReferral
{
    public function handle($request, Closure $next)
    {
        if ($request->hasCookie('referral')) {
            return $next($request);
        }

        if (($ref = $request->query('ref')) && app(config('referral.user_model', 'App\Models\User'))->referralExists($ref)) {
            return redirect($request->fullUrl())->withCookie(cookie()->forever('referral', $ref));
        }

        return $next($request);
    }
}
