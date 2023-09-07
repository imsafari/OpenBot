<?php

namespace App\BotServices\UpdateHandlers;

use App\BotServices\Chat;
use App\BotServices\User;

interface UpdateHandlerInterface
{
    public function doAction(): void;

    //based this method response, conversation will handle by bot context conversation handler
    public function chatType(): string;

    public function getChat(): ?Chat;

    public function getUser(): ?User;
}
