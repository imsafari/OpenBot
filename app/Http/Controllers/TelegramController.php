<?php

namespace App\Http\Controllers;

use App\BotServices\UpdateHandlers\UpdateHandlerInterface;
use App\BotServices\User;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function username_webhook(Request $request, UpdateHandlerInterface $handler)
    {
        $handler->doAction();
    }
}