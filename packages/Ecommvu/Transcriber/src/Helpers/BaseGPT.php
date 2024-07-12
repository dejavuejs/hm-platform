<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

abstract class BaseGPT {
    public $assistantId;
    public $thread;
    public $message;
    public $runAssistant;
    public $reply;
    public $transcriptPath;

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

    public function addMessages()
    {
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/" . $this->thread['id'] . "/messages");

        $transcriptData = Storage::get($this->transcriptPath);
        $data = [
            "role" => "user",
            "content" => $transcriptData
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

        while (true) {
            if ($runAssistant['status'] !== 'completed') {
                $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $this->thread['id'] . "/runs/" . $this->runAssistant['id']);

                curl_setopt($curl, CURLOPT_HTTPGET, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $runAssistant = curl_exec($curl);
                $runAssistant = json_decode($runAssistant, true);
                curl_close($curl);

                if ($runAssistant['status'] == 'completed') {
                    $this->runAssistant = $runAssistant;
                    return;
                }
            }  else if ($runAssistant['status'] == 'expired' || $runAssistant['status'] == 'failed' || $runAssistant['cancelled'] || $runAssistant['status'] == 'requires_action') {
                throw new Exception('Run failed or expired or cancelled, please try again');
            } else {
                sleep(5);
            }
        }
    }

    public function getReply()
    {
        // create thread
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $this->thread['id'] . "/messages");

        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $messages = curl_exec($curl);
        $messages = json_decode($messages, true);
        curl_close($curl);

        $this->reply = $messages;
    }
}