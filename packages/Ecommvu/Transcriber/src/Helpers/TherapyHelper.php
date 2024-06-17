<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

class TherapyHelper {
    public function listAssistants()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // HTTP request headers
        $headers = [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];

        // submit for transcription via HTTP request
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/assistants?order=desc&limit=20");

        // $data = [
        //     "instructions" => "You are a personal math tutor. When asked a question, write and run Python code to answer the question.",
        //     "name" => "Math Tutor",
        //     "tools" => [
        //         ["type" => "code_interpreter"]
        //     ],
        //     "model" => "gpt-4-turbo"
        // ];

        curl_setopt($curl, CURLOPT_HTTPGET, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        echo json_encode($response);

        curl_close($curl);
    }
}