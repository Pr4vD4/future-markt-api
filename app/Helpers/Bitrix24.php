<?php

namespace App\Helpers;

use App\Models\Application;
use Illuminate\Support\Facades\Http;

class Bitrix24
{

    /**
     * @param Application $application
     * @return object|null
     */
    public static function send(Application $application): ?object
    {

        $params = self::parse_application_to_params($application);

        return Http::post(env('LEAD_ADD_ENDPOINT'), $params)->object();
    }

    /**
     * @param Application $application
     * @return array|array[]
     */
    public static function parse_application_to_params(Application $application): array
    {
        $params = [
            'fields' => [
                'TITLE' => 'Заявка с сайта FutureMarkt:' . $application->web_site->name,
                'NAME' => $application->name ?? '',
                'PHONE' => [
                    'VALUE' => $application->phone,
                    'VALUE_TYPE' => 'MOBILE'
                ],
            ]
        ];

        $data = '';

        if (isset($application->body)) {

            foreach (json_decode($application->body) as $key => $value) {

                $data .= $key . ': ' . $value . "\n";

            }

            $params['fields']['COMMENTS'] = $data;

        }

        return $params;
    }

}