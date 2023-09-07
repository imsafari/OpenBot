<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\User;

abstract class BaseHandler
{
    abstract public function getUser(): ?User;


    abstract public function getChat(): ?Chat;
}
