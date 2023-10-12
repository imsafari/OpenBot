<?php

namespace App\Helpers;

/**
 * Class Keyboard
 *
 * by This Class u Can Make Keyboard and inlineKeyboard buttons and markup
 *
 * @package Telegram
 */
class Keyboard
{

	public static function replyKeyboardMarkup($keyboard, $resize_keyboard = false, $one_time_keyboard = false, $selective = false)
	{
		// Compact and Decode as Json and Return to Use in Response`s methods
		return json_encode(compact('keyboard', 'resize_keyboard', 'one_time_keyboard', 'selective'));
	}

	public static function KeyboardButton($text, $request_contact = false, $request_location = false)
	{
		return compact('text', 'request_contact', 'request_location');
	}

	public static function replyKeyboardRemove($selective = false)
	{
		// Requests clients to remove the custom keyboard
		// user will not be able to summon this keyboard;
		// if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in ReplyKeyboardMarkup)
		$remove_keyboard = true;
		return json_encode(compact('remove_keyboard', 'selective'));
	}


	public static function forceReply($selective = false)
	{
		// Shows reply interface to the user, as if they manually selected the bot‘s message and tapped ’Reply'
		$force_reply = true;
		return json_encode(compact('force_reply', 'selective'));
	}


	public static function InlineKeyboardMarkup($inline_keyboard): string
    {
		return json_encode(compact('inline_keyboard'));
	}

	public static function InlineKeyboardButton($text, $url = '', $callback_data = '', $switch_inline_query = '',
	                                            $switch_inline_query_current_chat = '', $callback_game = '', $pay = false)
	{
		return array_filter(compact('text', 'url', 'callback_data', 'switch_inline_query',
		                            'switch_inline_query_current_chat', 'callback_game', 'pay'));
	}
}
