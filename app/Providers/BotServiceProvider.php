<?php

namespace App\Providers;

use App\BotServices\Chat;
use App\BotServices\ConversationLayer\ConversationManager;
use App\BotServices\BotHandler;
use App\BotServices\ConversationLayer\ConversationSteps\StepContext;
use App\BotServices\UpdateHandlers\CallbackQueryHandler;
use App\BotServices\UpdateHandlers\ChannelPostHandler;
use App\BotServices\UpdateHandlers\ChatMemberHandler;
use App\BotServices\UpdateHandlers\ChosenInlineResultHandler;
use App\BotServices\UpdateHandlers\EditedChannelPostHandler;
use App\BotServices\UpdateHandlers\EditedMessageHandler;
use App\BotServices\UpdateHandlers\InlineQueryHandler;
use App\BotServices\UpdateHandlers\MessageHandler;
use App\BotServices\UpdateHandlers\MyChatMemberHandler;
use App\BotServices\UpdateHandlers\PollAnswerHandler;
use App\BotServices\UpdateHandlers\PollHandler;
use App\BotServices\UpdateHandlers\PreCheckoutQueryHandler;
use App\BotServices\UpdateHandlers\ShippingQueryHandler;
use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Entities\Update;
use Longman\TelegramBot\Telegram;

class BotServiceProvider extends ServiceProvider implements DeferrableProvider
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

        $this->app->singleton(BotHandler::class, function (Application $app) {
            return new BotHandler;
        });

        $this->app->singleton(UpdateHandlerInterface::class, function (Application $app) {
            return $app->call([$app->make(BotHandler::class), "UpdateHandler"]);
        });

        $this->app->singleton(StepContext::class, function (Application $app) {
            return new StepContext();
        });

    }

    public function bindUpdateHandlers(): void
    {
        $this->app->singleton(MessageHandler::class, function (Application $app) {
            return new MessageHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(CallbackQueryHandler::class, function (Application $app) {
            return new CallbackQueryHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(EditedMessageHandler::class, function (Application $app) {
            return new EditedMessageHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(ChannelPostHandler::class, function (Application $app) {
            return new ChannelPostHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(EditedChannelPostHandler::class, function (Application $app) {
            return new EditedChannelPostHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(InlineQueryHandler::class, function (Application $app) {
            return new InlineQueryHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(ChosenInlineResultHandler::class, function (Application $app) {
            return new ChosenInlineResultHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(ShippingQueryHandler::class, function (Application $app) {
            return new ShippingQueryHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(PreCheckoutQueryHandler::class, function (Application $app) {
            return new PreCheckoutQueryHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(PollHandler::class, function (Application $app) {
            return new PollHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(PollAnswerHandler::class, function (Application $app) {
            return new PollAnswerHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(MyChatMemberHandler::class, function (Application $app) {
            return new MyChatMemberHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });

        $this->app->singleton(ChatMemberHandler::class, function (Application $app) {
            return new ChatMemberHandler(
                $app->make(ConversationManager::class),
                $app->make(UpdateHandlerInterface::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [
            UpdateHandlerInterface::class,
        ];
    }

}
