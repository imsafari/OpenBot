<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\User;

class BaseHandler
{
    public function getUser(): ?User
    {
        return null;
    }

    public function getChat(): ?Chat
    {
        return null;
    }
}
