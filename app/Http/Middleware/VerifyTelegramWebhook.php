<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Longman\TelegramBot\Entities\Update;
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

        if (app()->isProduction()) {
            $this->activeUpdateIdCache();
        }

        return $next($request);
    }

    public function activeUpdateIdCache(): void
    {
        $update = app(Update::class);
        if (Cache::has("update_id_{$update->getUpdateId()}")) {
            throw new HttpException(200, "duplicate update id");
        }

        Cache::set("update_id_{$update->getUpdateId()}", true, 60 * 60 * 24);

    }
}
