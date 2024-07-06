<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

abstract class BaseGPT {
    private $assistantId;
    private $thread;
    private $message;
    private $runAssistant;
    private $reply;

    public function getHeaders()
    {
        return [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];
    }

    public function createThread()
    {
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads");

        curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $thread = curl_exec($curl);
        $thread = json_decode($thread, true);
        curl_close($curl);

        $this->thread = $thread;
    }

    public function addMessages($transcriptPath = null)
    {
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/" . $this->thread['id'] . "/messages");

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

        $this->message = $message;
    }

    public function runAssistant()
    {
        // create thread
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $this->thread['id'] . "/runs");

        $data = [
            "assistant_id" => $this->assistantId
        ];

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $runAssistant = curl_exec($curl);
        $runAssistant = json_decode($runAssistant, true);
        curl_close($curl);

        $this->runAssistant = $runAssistant;
    }

    public function getReply()
    {
        // create thread
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $this->threadId . "/messages");

        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $messages = curl_exec($curl);
        $messages = json_decode($messages, true);
        curl_close($curl);

        $this->reply = $messages;
    }
}