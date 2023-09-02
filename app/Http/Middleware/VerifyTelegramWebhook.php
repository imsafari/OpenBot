<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VerifyTelegramWebhook
{

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->isJson()) {
            throw new HttpException(500, "invalid json format");
        }

        //todo: update id must not be duplicate from cache update ids pool
        //todo: this will checks only on production environment
//        if (Cache::has("update_id_{$update->getUpdateId()}")) {
//            throw new HttpException(200, "duplicate update id");
//        }

        return $next($request);
    }
}
