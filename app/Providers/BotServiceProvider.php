<?php

namespace App\Providers;

use App\BotServices\BotContext;
use App\BotServices\ConversationLayer\ConversationHandlerInterface;
use App\BotServices\ConversationLayer\Steps\StepContext;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;

class BotServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Telegram::class, function () {
            return new Telegram(config("app.bot_token"), config("app.bot_username"));
        });

        $this->app->singleton(Update::class, function () {
            return new Update(\request()->json()->all());
        });

        /* Structure begins here */

        $this->app->singleton(BotContext::class, function (Application $app) {
            return new BotContext(
                $app->make(Telegram::class),
                $app->make(Update::class)
            );
        });

        $this->app->singleton(UpdateHandlerInterface::class, function (Application $app) {
            return $app->make(BotContext::class)->updateHandler();
        });

        $this->app->singleton(ConversationHandlerInterface::class, function (Application $app) {
            return $app->make(BotContext::class)->conversationHandler();
        });

        $this->app->singleton(StepContext::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

}
