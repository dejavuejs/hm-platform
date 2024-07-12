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

        $this->fileURL = 'https://audio2transcriber.s3.ap-south-1.amazonaws.com/mix_16m58s%20%28audio-joiner.com%29.mp3?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEFEaCmFwLXNvdXRoLTEiRjBEAiAifborJuf1lIUEAgZP9MC9elhwEfmFv99MKjYj%2FDpl2wIgI8BBIbvW4QqCuRpVyycni36V86wYgtM3OtZW4kB%2B7EAq5AIIGhABGgw2Mzg1MDAyOTQwMzIiDHpOlkmBBH98NWLDfSrBAirngWrEFALb%2FlxrFViYyg2ofAhVLVJYTXGkc1b3iJSnIdhYmqiWWeHGIaN%2Fjj3ImaY%2F5%2FmN%2FQFVMCfERendk7z6iiLs9%2FfxnK5%2FOih%2FKyh1FeaXKH5IgYqNz9lobnb44G%2B5oTXIL5MpMo5S76PMrGD9ZFktUczvn8KYBvqiM4E2e0uPQxnuQMbl8SBWNQpFoMuW6hCgMfm%2Fw4zAufYgOCuDohuoUMCRFJry2wF%2Bj865mLCGVZ8LAeW9C0BZbECSW77qrA4Wcs41qDg9giE38SRLAJf8mNoVChcBP2k%2Fiac1dVIMqu5VxFykeGqectOmG%2FM4xOGg5g0Ldo9Jtl3%2FVgYSFwuSpLpcG4UmwKRYDZZx45Om2ieggwOoQcdL%2Bzs2Wy0eQaEhfmnxYnPTGx6SA2xMdmYjow3Fcw9jAv%2BSBTlvzjDfsLC0Bjq0AiHzEfoA%2FsHWRkhuA8dnm1hELiW5bFPOGV8yGamhPVo6sYbAUDig37A0iCftW%2Bbs0kksqwjNGbSEV%2BkJqlVbdWRa2QKLis%2FG3NqPA9VlmL2tJXfP9nzxkgNv56n1r1NXe0GU%2FJ9pNlHlIgAt0JeAEbjvq9%2BzLs4L8aAyfi3PrCIJfIzN2gWTgyMbRBh5Jr71Hqt6I5nIiWdnIo05H5Y2EIvPSRKJ8KMjWIuOeDv15IEwsR6pe5i1ZJRwbSWadeu%2FOOxlfsgRKOagFZdS6rUwGy1YG5eWfPjFzGCC4JrZHFX9dAabnb02pNN0aDSRkOqEZw142CM8oK21%2FHjHB%2F477aQ7JIKIfEbugqsy%2F9cOPRSYU3ucN0zHQ2hfhwFbUXD0coPE6nCKXmftH7gy1QrzWGZqTYnZ&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20240708T164917Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAZJKMVJWIDJBS4M7X%2F20240708%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Signature=d37d80b0c73747ea86a7035aadb057c1438661f2339588d26c9e862034e0f1bd';

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