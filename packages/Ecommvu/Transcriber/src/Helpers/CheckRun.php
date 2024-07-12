<?php

namespace Ecommvu\Transcriber\Helpers;

class CheckRun
{
    public function getHeaders()
    {
        return [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];
    }

    public function getRun()
    {
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/thread_eT5RV3rQO36Ha2zE8skVkLCo/runs/run_SDbFVLxLuhCekvlLq0d91bzg");

        $data = [
            "assistant_id" => config('services.chat_gpt.assistant_gpt_id')
        ];

        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $runAssistant = curl_exec($curl);
        $runAssistant = json_decode($runAssistant, true);
        curl_close($curl);

        echo $runAssistant['status'];
    }

    public function pollRun()
    {
        // create thread
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads");

        curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $thread = curl_exec($curl);
        $thread = json_decode($thread, true);
        curl_close($curl);
        echo $thread['id'] . "\n";

        // add messages
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/" . $thread['id'] . "/messages");

        // $transcriptData = Storage::get($this->transcriptPath);
        $data = [
            "role" => "user",
            "content" => 'Unable to sleep at night, please help!'
        ];

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $message = curl_exec($curl);
        $message = json_decode($message, true);
        curl_close($curl);
        echo $message['id'] . "\n";

        // create run
        $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $thread['id'] . "/runs");

        $data = [
            "assistant_id" => config('services.chat_gpt.assistant_gpt_id')
        ];

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $runAssistant = curl_exec($curl);
        $runAssistant = json_decode($runAssistant, true);
        curl_close($curl);

        echo $runAssistant['id'] . "\n";

        echo $runAssistant['status'] . "\n";

        while(true) {
            echo "checking status";
            if ($runAssistant['status'] !== 'completed') {
                echo "Checking status";
                $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $thread['id'] . "/runs/" . $runAssistant['id']);

                $data = [
                    "assistant_id" => config('services.chat_gpt.assistant_gpt_id')
                ];

                curl_setopt($curl, CURLOPT_HTTPGET, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $runAssistant = curl_exec($curl);
                $runAssistant = json_decode($runAssistant, true);
                curl_close($curl);

                if ($runAssistant['status'] == 'completed') {
                    $curl = curl_init(config('services.chat_gpt.endpoint') . "/v1/threads/". $thread['id'] . "/messages");

                    curl_setopt($curl, CURLOPT_HTTPGET, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                    $messages = curl_exec($curl);
                    $messages = json_decode($messages, true);
                    curl_close($curl);

                    foreach ($messages['data'] as $index => $message) {
                        if ($message['role'] == 'assistant') {
                            echo json_encode($message['content'][0]['text']['value']);

                            return;
                        }
                    }

                    return;
                }
            } else if ($runAssistant['status'] == 'expired' || $runAssistant['status'] == 'failed' || $runAssistant['cancelled'] || $runAssistant['status'] == 'requires_action') {
                throw new Exception('Run failed or expired, please try again');
            } else {
                sleep(5);
            }
        }
    }
}