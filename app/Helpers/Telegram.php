<?php

namespace App\Helpers;

use App\Models\Application;
use Illuminate\Support\Facades\Http;

class Telegram
{
    /**
     * @param Application $application
     * @return string
     */
    public static function parse_application_to_string(Application $application): string
    {
        $telegram_string = '';

        $telegram_string .= '*Заявка с сайта FutureMarkt:' . $application->web_site->name . "*\n\n";
        $telegram_string .= isset($application->name) ? '_Имя:_ ' . $application->name . "\n" : '';
        $telegram_string .= '_Телефон:_ ' . $application->phone . "\n";

        if (isset($application->body)) {

            foreach (json_decode($application->body) as $key => $value) {

                $telegram_string .= '_' . $key . ':_ ' . $value . "\n";

            }
        }

        return $telegram_string;
    }

    /**
     * @return string[]
     */
    public static function get_chats_ids()
    {
        return explode(', ', env('CHATS'));
    }

    /**
     * @param Application $application
     * @return array
     */
    public static function send(Application $application): array
    {

        $text = self::parse_application_to_string($application);
        $responses = [];

        foreach (self::get_chats_ids() as $chat_id => $value) {

            $response = Http::post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_API_KEY') . '/sendMessage', [
                'chat_id' => $value,
                'text' => $text,
                'parse_mode' => 'markdown'
            ]);

            $responses[] = $response->object();


        }


        return $responses;

    }

}