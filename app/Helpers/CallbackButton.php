<?php

namespace App\Helpers;

use function Laravel\Prompts\select;

class CallbackButton
{

    public function __construct(
        public Keyboard $k
    )
    {
    }

    const KeyMainMenu = "main_menu";
    const KeyBack = "back";
    const KeySkip = "skip";
    const KeyAccept = "accept";


    public function MainMenu(): array
    {
        return $this->k::InlineKeyboardButton(
            text: __("bot/private.btn.main_menu"),
            callback_data: self::KeyMainMenu
        );
    }

    public function Back(): array
    {
        return $this->k::InlineKeyboardButton(
            text: __("bot/private.btn.back"),
            callback_data: self::KeyBack
        );
    }

    public function Skip(): array
    {
        return $this->k::InlineKeyboardButton(
            text: __("bot/private.btn.skip"),
            callback_data: self::KeySkip
        );
    }

    public function Accept(): array
    {
        return $this->k::InlineKeyboardButton(
            text: __("bot/private.btn.accept"),
            callback_data: self::KeyAccept
        );
    }

}
