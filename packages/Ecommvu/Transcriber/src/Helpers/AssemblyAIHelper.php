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
        $FILE_URL = "https://audio2transcriber.s3.ap-south-1.amazonaws.com/mix_16m58s%20%28audio-joiner.com%29.mp3?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEEcaCmFwLXNvdXRoLTEiRzBFAiA5T2wL6rj79zwaoxMOWP6wsAQpX5NX0EVEkcycW%2FVFmAIhAIMy6h6fSY7IeMCSAX9QITGzE5mCCIsLnhCSKpEryG3SKu0CCOD%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FwEQARoMNjM4NTAwMjk0MDMyIgy6RV0r87Vjo6QHyN0qwQKetIXrLoBI%2BGSFKTWHf8iUwvWfR1XnWY0iujMdU96Cg9GdLDWY8h0EaLWVsbd%2FFg9VotEX6p4NIRVm73pBEmmRlt8dRlGxowZaJOLU%2FQr9LZLC9lFcbj0kMJsrAQ9SegFGe91pLTT1CYHs7brnX0Hcy%2FPWD4ssUT5xlvvHIjPQZ%2BNT9x065O4ot%2F0YEEq%2BLVe3tBCtX1H09OoMYxeBpeYZNyaipyUPga49XP7HJKBic1JNy3dIlKO3s%2FEH7F5aeTusoc%2FA2Gq3WeIw%2Bf9r3VZ%2BRzNuCjcdlwNIecEYS3xyoYAj2ezbH3v%2BpII53SQQAIHWYdqtAk0VTHPNeKijWh7e7u0DmoBXE7%2F3pHHZLkVjIzfZkqMnhKqm9MjcDNZ1BvMK9sKpIVuMx8iSh3impMInsK6BSP1%2F7F52NQnqzquOVjAwqNW9swY6swJ3WfrSdQaE64hPvh6R%2FS9OJCth3u0tojSjBB7HSWMAqzQvwwmo%2Bu3cBOU%2Fg6b9Q1ZxPr7XeN5PTDalm%2FRJ80s0z%2B8UMLbjZydo044DGfatQVKRYUMEZeAYgZaDl7o37P4CeWUykwQsK%2F7DtT7KK0KgQLzhz41twF6kFf9PweJLERA0DZ9527Ij%2FrXHKZycY%2F%2BnVZHl%2BU6DuRHWyJcgoeqM63xZgHGeQoad%2BlYjiGQRHRMCZFeNUUA0urIkK93ubHXzf1mhAr6OoYZ%2Br4ggFfOFHmC2pSqFiKnbYimozc6TLEl2nRiDKAtypGxoCuyvzPHj9pSyYDmOYqp34GbQ9obu8gHcaZAEBUJ950cPPBv%2F9kkM6siipMliB3ESV7PgID5WByV3gRXiDDHfW9PS9M9nS0Fm&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20240616T224448Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43199&X-Amz-Credential=ASIAZJKMVJWIEBJ2Z7FF%2F20240616%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Signature=dbe50d446d6cb58c3559f85b37ae15dd3f5ab0a0102cc9bf04258fe2ac45d916";

        // You can also transcribe a local file by passing in a file path
        // $FILE_URL = './path/to/file.mp3';

        // AssemblyAI transcript endpoint (where we submit the file)
        $transcript_endpoint = "https://api.assemblyai.com/v2/transcript";

        // Request parameters
        $data = [
            'audio_url' => $FILE_URL,
            'speech_model' => 'best',
            'speaker_labels' => true,
            // 'speakers_expected' => 2,
            'language_code' => 'hi',
            // "redact_pii" => true,
            // "redact_pii_sub" => "hash",
            // "redact_pii_policies" => [
            //     "phone_number",
            //     "medical_condition",
            //     "banking_information",
            //     "credit_card_number",
            //     "date_of_birth",
            //     "credit_card_cvv",
            //     "credit_card_expiration"
            // ]
        ];

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
                $this->transcriber->create(
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