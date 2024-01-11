<?php

namespace App\Helpers;

class CallbackKeyboard
{

    public function __construct(
        public Keyboard $k
    )
    {
    }

    public function MainMenu(): string
    {
        return $this->k::InlineKeyboardMarkup(
            [
                [$this->k->btn()->MainMenu()],
                [$this->k->btn()->Accept()],
            ]
        );
    }
}
