<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SphereLeadMail;

class SphereLeadController extends Controller
{
    public function make(Request $request)
    {
        $data = $request->validate([
            'calculator' => 'required|array',
            'contact' => 'required|array',
            'bestOffer' => 'required|array',
        ]);

        $fields = [
            'TITLE' => 'Заявка с сайта',
            'NAME' => $data['contact']['name'] ?? '',
            'PHONE' => [
                [
                    'VALUE' => $data['contact']['phone'] ?? '',
                    'VALUE_TYPE' => 'WORK',
                ]
            ],
            'COMMENTS' => $this->makeComment($data),
        ];

        $webhook = env('SPHERE_BITRIX24_WEBHOOK');
        $response = Http::post("{$webhook}/crm.lead.add.json", [
            'fields' => $fields,
            'params' => ['REGISTER_SONET_EVENT' => 'Y'],
        ]);

        // Формируем данные для письма
        $mailData = [
            'title' => $fields['TITLE'],
            'phone' => $fields['PHONE'][0]['VALUE'],
            'name' => $fields['NAME'],
            'body' => $this->makeMailBody($data),
        ];

        Mail::to('test@test.com')->send(new SphereLeadMail($mailData));

        return response()->json([
            'bitrix24_response' => $response->json(),
        ]);
    }

    private function makeComment(array $data): string
    {
        $comment = "";
        if (isset($data['bestOffer'])) {
            $comment .= "Лучшее предложение:\n";
            foreach ($data['bestOffer'] as $key => $value) {
                $comment .= ucfirst($key) . ': ' . $value . "\n";
            }
        }
        if (isset($data['calculator'])) {
            $comment .= "\nКалькулятор:\n";
            foreach ($data['calculator'] as $key => $value) {
                $comment .= ucfirst($key) . ': ' . (is_bool($value) ? ($value ? 'Да' : 'Нет') : ($value ?? '')) . "\n";
            }
        }
        return $comment;
    }

    private function makeMailBody(array $data): array
    {
        $body = [];
        if (isset($data['bestOffer'])) {
            foreach ($data['bestOffer'] as $key => $value) {
                $body[] = [
                    'title' => 'BestOffer: ' . ucfirst($key),
                    'value' => is_bool($value) ? ($value ? 'Да' : 'Нет') : ($value ?? ''),
                ];
            }
        }
        if (isset($data['calculator'])) {
            foreach ($data['calculator'] as $key => $value) {
                $body[] = [
                    'title' => 'Calculator: ' . ucfirst($key),
                    'value' => is_bool($value) ? ($value ? 'Да' : 'Нет') : ($value ?? ''),
                ];
            }
        }
        return $body;
    }
}
