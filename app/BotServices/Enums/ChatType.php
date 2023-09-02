<?php

namespace App\BotServices\Enums;

enum ChatType: string
{
    case Channel = "channel";
    case Private = "private";
    case Group = "group";
    case Supergroup = "supergroup";

    case Sender = "sender"; //for inline query and only in secret chat
}
