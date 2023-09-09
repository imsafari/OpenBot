<?php

namespace App\BotServices\Enums;

enum PrivateState: string
{
    case Start = 'start';
    case MainMenu = 'main';
    case GetMobile = 'get_mobile';
    case GetName = 'get_name';

}
