<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

class AssistantGPT extends BaseGPT {
    private $assistantId;

    public function __construct()
    {
        $this->assistantId = config('services.assistant_gpt_id');
    }

    public function prepareFeedbackThread()
    {
        $thread = null;
        $message = null;

        // create thread
        try {
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads");

            curl_setopt($curl, CURLOPT_POST, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $thread = curl_exec($curl);
            $thread = json_decode($thread, true);
            curl_close($curl);
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
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $message = curl_exec($curl);
            $message = json_decode($message, true);
            curl_close($curl);
        } catch (Exception $e) {
            throw $e;
        }

        return [
            "thread" => $thread,
            "message" => $message
        ];
    }

    public function prepareRunForAssistant()
    {
        $result = $this->prepareFeedbackThread();
        $threadId = $result['thread']['id'];

        // create thread
        try {
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $threadId . "/runs");

            $data = [
                "assistant_id" => $this->assistantId
            ];

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $thread = curl_exec($curl);
            curl_close($curl);

            $thread = json_decode($thread, true);

            return $thread;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getMessagesByAssistant()
    {
        $thread = $this->prepareRunForAssistant();

        // create thread
        try {
            $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $threadId . "/messages");

            curl_setopt($curl, CURLOPT_HTTPGET, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $messages = curl_exec($curl);
            curl_close($curl);
            $messages = json_decode($messages, true);

            return $messages;
        } catch (Exception $e) {
            throw $e;
        }
    }
}