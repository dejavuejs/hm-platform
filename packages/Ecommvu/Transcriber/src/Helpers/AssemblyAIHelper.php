<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

class AssemblyAIHelper {
    protected $transcriber;

    public function __construct(TranscriptionJobRepository $transcriber)
    {
        $this->transcriber = $transcriber;
    }

    public function transcribe()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // replace with your API key
        $YOUR_API_KEY = "8d249894f8954b6784fc2ad416015706";

        // URL of the file to transcribe
        // $FILE_URL = "https://github.com/AssemblyAI-Examples/audio-examples/raw/main/20230607_me_canadian_wildfires.mp3";
        $FILE_URL = "https://mvp-audio-files.s3.ap-south-1.amazonaws.com/mix_16m58s%20%28audio-joiner.com%29.mp3?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjECYaCXVzLWVhc3QtMSJIMEYCIQDWGeMWma61u5HGMKVohqyeS3hOVjlq3Tb4rVIZrXsfFgIhAI3Uw4VPYsWwep5xXUMxNEIY3lFZ0rmllGEiKqBa%2B274Ku0CCL7%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjM4NTAwMjk0MDMyIgx2W1eCpeCDMDcyV1wqwQINOEL21sz23XmqZVyp2BnW5oIvUPVaPdrSEC9CHnDkee9SF%2BIWLyuguhIUVCAZhhafsfzsXfvjpwOpuQ7KDNPXeRob8AC%2BA9uIlFC%2BNfoZ4cwgB3czMtUpXAE3pUBetIiC1vrWL8UFgBp%2B6by%2BmwfM%2FQu3C940N7strJpfK1EaHzCjaVNUzxIHi1k%2BHcbqrXr36ncoIEuGO1tTPvsRA7bE301lTnkshQeZk31oSTFcJihmoe1DohlXbkEeQKfCwXLjHtHqVf0JCO7c32WCMnbqx9F4t%2FwsYD4oCjIgWgTLdjiKfuUSfbgLZaFirk161lumHEbTUY5SU2ZNi15DtXfq7y1jvSiAeb1fxgApzhvHEtGxncZ6J6qnVtSMGUX6RDOjXnSqf6bk%2FvDHig3Id6ARG%2Fn2BjVuGLeqn0N7KMo%2BEC0w16m2swY6sgIea%2BSqyI08dus5odM4hljvgLJvyDAS5Yeal88ruhbHZIe4s6JPv1uhf%2FXQHaBcqZ987p1D5404BkwXclpJkcR92x3Se8Uxl4%2BqZz6q5PFLfnPBqib7Q3jEnY1LRIc4L56wFTStr%2FVOWF%2FResRufN%2FhDBVS7zNePn5zu5%2FmtjbBU%2FqNxwQcTcPJcxb9ieDG6RQzEWT2BRQ4zoJdtsaNHTdKhPsYJnqntw7JLpl%2FNKpBShO63Z0OlFGzAdpUGMH2mCvNIkLeWUP0fsWOUBZQRt4Cfy1UR0z96vtT27PJm%2FEbJpUk99zIJNKqVKzqZOPyVEdhIQRjJBuWP1G8is6Yoiq8OFbITXn0QpXAYjcu%2BuJpBDSjGBCD2WM7JMMb2FducseDxIsb2nliizy1eo9affNs6TU%3D&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20240615T171703Z&X-Amz-SignedHeaders=host&X-Amz-Expires=21600&X-Amz-Credential=ASIAZJKMVJWIFBCZJEPG%2F20240615%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Signature=2dd05603b0f887f13f791a9190132620a7f4e79246f46abffe38080328744998";

        // You can also transcribe a local file by passing in a file path
        // $FILE_URL = './path/to/file.mp3';

        // AssemblyAI transcript endpoint (where we submit the file)
        $transcript_endpoint = "https://api.assemblyai.com/v2/transcript";

        // Request parameters
        $data = array(
            "audio_url" => $FILE_URL,
            "speech_model" => "best",
            "redact_pii" => true,
            "speaker_labels" => "true",
            "speakers_expected" => 2,
            "language_code" => "hi",
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
        );

        // HTTP request headers
        $headers = array(
            "authorization: 8d249894f8954b6784fc2ad416015706",
            "content-type: application/json"
        );

        // submit for transcription via HTTP request
        $curl = curl_init($transcript_endpoint);

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
            $polling_response = curl_init($polling_endpoint);

            curl_setopt($polling_response, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($polling_response, CURLOPT_RETURNTRANSFER, true);

            $transcription_result = json_decode(curl_exec($polling_response), true);

            if (isset($transcription_result['status']) && $transcription_result['status'] === "completed") {
                $transcribed = $this->transcriber->create(
                    [
                        "source_path" => $FILE_URL,
                        "status_label" => "completed",
                        "status" => true,
                        "transcription_result" => json_encode($transcription_result),
                        "transcription_text" => $transcription_result['text']
                    ]
                );

                Storage::append('transcribes/1.log', $transcription_result['text']);

                echo "Operation complete";

                break;
            } else if (isset($transcription_result['status']) && $transcription_result['status'] === "error") {
                throw new \Exception("Transcription failed: " . $transcription_result['error']);
            } else {
                sleep(3);
            }
        }
    }
}