<?php

namespace App\Http\Middleware;

use App\Models\Collaborator;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureReferral
{
    public const COOKIE = 'referral_code';
    public const SESSION = 'referral_code';
    public const DAYS = 60;

    public function handle(Request $request, Closure $next): Response
    {
        $ref = trim((string) $request->query('ref', ''));

        if ($ref !== '') {
            $collaborator = Collaborator::where('code', $ref)
                ->where('status', 'active')
                ->first();

            if ($collaborator) {
                session([self::SESSION => $collaborator->code]);

                return $next($request)->withCookie(cookie(
                    self::COOKIE,
                    $collaborator->code,
                    self::DAYS * 24 * 60,
                    '/',
                    null,
                    $request->isSecure(),
                    true,
                    false,
                    'lax'
                ));
            }
        }

        return $next($request);
    }
}
