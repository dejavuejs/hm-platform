<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

class AssemblyAI {
    protected $transcriber;
    protected $fileURL;

    public function __construct(TranscriptionJobRepository $transcriber)
    {
        $this->transcriber = $transcriber;
    }

    public function transcribe($fileURL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // replace with your API key
        $YOUR_API_KEY = config('services.assembly_ai.key');

        // URL of the file to transcribe
        // $FILE_URL = "https://github.com/AssemblyAI-Examples/audio-examples/raw/main/20230607_me_canadian_wildfires.mp3";


        // You can also transcribe a local file by passing in a file path
        // $FILE_URL = './path/to/file.mp3';

        $this->fileURL = $fileURL;

        // AssemblyAI transcript endpoint (where we submit the file)
        $endpoint = "https://api.assemblyai.com/v2/transcript";

        // Request parameters
        $data = [
            'audio_url' => $this->fileURL,
            'speech_model' => 'best',
            'speaker_labels' => true,
            // 'speakers_expected' => 2,
            'language_code' => 'hi',
            "redact_pii" => true,
            "redact_pii_sub" => "hash",
            "redact_pii_policies" => [
                "phone_number",
                "medical_condition",
                "banking_information",
                "credit_card_number",
                "date_of_birth",
                "credit_card_cvv",
                "credit_card_expiration"
            ]
        ];

        // HTTP request headers
        $headers = array(
            "authorization: 8d249894f8954b6784fc2ad416015706",
            "content-type: application/json"
        );

        // submit for transcription via HTTP request
        $curl = curl_init($endpoint);

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        $response = json_decode($response, true);

        curl_close($curl);

        # polling for transcription completion
        $transcript_id = $response['id'];
        $polling_endpoint = "https://api.assemblyai.com/v2/transcript/" . $transcript_id;

        while (true) {
            $pollingResponse = curl_init($polling_endpoint);

            curl_setopt($pollingResponse, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($pollingResponse, CURLOPT_RETURNTRANSFER, true);

            $transcriptionResult = json_decode(curl_exec($pollingResponse), true);

            if (isset($transcriptionResult['status']) && $transcriptionResult['status'] === "completed") {
                $result = $this->transcriber->create(
                    [
                        "source_path" => $this->fileURL,
                        "status_label" => "completed",
                        "status" => true,
                        "transcription_result" => json_encode($transcriptionResult),
                    ]
                );

                $utterances = $transcriptionResult['utterances'];
                $filePath = "transcriptions/" . $result->id . ".log";
                foreach ($utterances as $utterance) {
                    $speaker = $utterance['speaker'];
                    $text = $utterance['text'];
                    $utter = $speaker . ": " . $text . "\n";
                    Storage::append($filePath, $utter);
                }

                $result->update(
                    [
                        "file_path" => $filePath
                    ]
                );

                return $result;

                break;
            } else if (isset($transcriptionResult['status']) && $transcriptionResult['status'] === "error") {
                throw new \Exception("Transcription failed: " . $transcriptionResult['error']);
            } else {
                sleep(3);
            }
        }
    }
}