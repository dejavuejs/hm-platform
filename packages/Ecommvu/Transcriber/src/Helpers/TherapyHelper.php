<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

class TherapyHelper {
    public function listAssistants()
    {
        try {
            // HTTP request headers
            $headers = [
                "Authorization: Bearer " . config('services.chat_gpt.key'),
                "content-type: application/json",
                "OpenAI-Beta: assistants=v2"
            ];

            // submit for transcription via HTTP request
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/assistants?order=desc&limit=20");

            curl_setopt($curl, CURLOPT_HTTPGET, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);

            $ids = [];
            foreach ($response['data'] as $assistant) {
                array_push($ids, $assistant['id']);
            }

            return $ids;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAssistant()
    {
        $ids = $this->listAssistants();

        $id = $ids[0];

        echo $id;

        // process notes
        try {
            // HTTP request headers
            $headers = [
                "Authorization: Bearer " . config('services.chat_gpt.key'),
                "content-type: application/json",
                "OpenAI-Beta: assistants=v2"
            ];

            // submit for transcription via HTTP request
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/assistants/". $id);

            curl_setopt($curl, CURLOPT_HTTPGET, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);

            echo json_encode($response);

            // return $ids;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function prepareFeedbackThread()
    {
        $ids = $this->listAssistants();
        $id = $ids[0];
        $thread = null;
        $headers = [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];

        // create thread
        try {
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads");

            curl_setopt($curl, CURLOPT_POST, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $thread = curl_exec($curl);
            $thread = json_decode($thread, true);
            curl_close($curl);

            echo json_encode($thread);
        } catch (Exception $e) {
            throw $e;
        }

        // add messages
        try {
            // post https://api.openai.com/v1/threads/{thread_id}/messages
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/" . $thread['id'] . "/messages");

            $data = [
                "role" => "user",
                "content" => "Help me, i'm unable to sleep during night"
            ];

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            echo $response;
            curl_close($curl);
            echo $response;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function prepareRunForAssistant()
    {
        $threadId = "thread_2ITJS59SfmFvrzJBdob7pkYu";
        $ids = $this->listAssistants();
        $assistantId = $ids[0];
        $headers = [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];

        // create thread
        try {
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $threadId . "/runs");

            $data = [
                "assistant_id" => $assistantId
            ];

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $thread = curl_exec($curl);
            curl_close($curl);

            echo $thread;
            // $thread = json_decode($thread, true);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getMessagesByAssistant()
    {
        $threadId = "thread_2ITJS59SfmFvrzJBdob7pkYu";
        $headers = [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];

        // create thread
        try {
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $threadId . "/messages");

            curl_setopt($curl, CURLOPT_HTTPGET, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $thread = curl_exec($curl);
            curl_close($curl);

            echo $thread;
            // $thread = json_decode($thread, true);

        } catch (Exception $e) {
            throw $e;
        }
    }
}