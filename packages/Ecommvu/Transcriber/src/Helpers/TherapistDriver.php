<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\PatientConsultationRepository;
use Ecommvu\Transcriber\Helpers\AssemblyAI;
use Ecommvu\Transcriber\Helpers\BaseGPT;
use Illuminate\Support\Facades\Storage;

class TherapistDriver extends BaseGPT {
    protected $assemblyAI;
    protected $patientConsultationRepository;
    protected $patientConsultation;

    public function __construct(
        AssemblyAI $assemblyAI,
        PatientConsultationRepository $patientConsultationRepository
    )
    {
        $this->assemblyAI = $assemblyAI;
        $this->patientConsultationRepository = $patientConsultationRepository;
    }

    public function generateFeedbackNotes()
    {
        $this->assistantId = config('services.chat_gpt.feedback_gpt_id');
        $this->createThread();

        echo $this->thread['id'];

        $this->patientConsultation->update(
            [
                'feedback_notes_thread_id' => $this->thread['id']
            ]
        );
        $this->addMessages();
        $this->runAssistant();
        $this->getReply();

        $filePath = "transcriptions/" . $this->patientConsultation->id . "-feedback.log";

        foreach ($this->reply['data'] as $index => $message) {
            if ($message['role'] == 'assistant') {
                Storage::append($filePath, json_encode($message['content'][0]['text']['value']));
            }
        }

        $this->patientConsultation->update(
            [
                'feedback_notes_path' => $filePath
            ]
        );
    }

    public function generateAssistantNotes()
    {
        $this->assistantId = config('services.chat_gpt.assistant_gpt_id');

        $this->createThread();

        echo $this->thread['id'];

        $this->patientConsultation->update(
            [
                'assistant_notes_thread_id' => $this->thread['id']
            ]
        );
        $this->addMessages();
        $this->runAssistant();
        $this->getReply();

        $filePath = "transcriptions/" . $this->patientConsultation->id . "-assistant.log";

        foreach ($this->reply['data'] as $index => $message) {
            if ($message['role'] == 'assistant') {
                Storage::append($filePath, json_encode($message['content'][0]['text']['value']));
            }
        }

        $this->patientConsultation->update(
            [
                'assistant_notes_path' => $filePath
            ]
        );
    }

    public function generatePrescriptionNotes()
    {
        $this->assistantId = config('services.chat_gpt.prescription_gpt_id');

        $this->createThread();

        echo $this->thread['id'];

        $this->patientConsultation->update(
            [
                'prescription_notes_thread_id' => $this->thread['id']
            ]
        );
        $this->addMessages();
        $this->runAssistant();
        $this->getReply();

        $filePath = "transcriptions/" . $this->patientConsultation->id . "-prescription.log";

        foreach ($this->reply['data'] as $index => $message) {
            if ($message['role'] == 'assistant') {
                Storage::append($filePath, json_encode($message['content'][0]['text']['value']));
            }
        }

        $this->patientConsultation->update(
            [
                'prescription_notes_path' => $filePath
            ]
        );
    }

    public function main()
    {
        try {
            $fileURL = "https://audio2transcriber.s3.ap-south-1.amazonaws.com/mix_16m58s%20%28audio-joiner.com%29.mp3?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEDAaCmFwLXNvdXRoLTEiRjBEAiAvKYQVfAeHZsQc2bOPmSL5u3WUb6u5XBfHEajdS9styQIgQAfZVZQ8ZfKcoKjkHmtvHWYxBdqmRihns4qdA5cfEZYq7QII6f%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FARABGgw2Mzg1MDAyOTQwMzIiDJWchQc%2FGamF97xM%2FyrBAuB8%2FQrRLDELVk7iF7oqDdla2gtFJSuNo0gwiIWgFVYz9EKZSpMQQ26ZWWrun0xywOJEQB9mNc5Qu1URQSayxNoafkMbF49QYz%2Fu5K1LxXH8Ip9y0nj317%2FbBG3iATXXi1H1QZV%2FOpzkFuzEyyiRWmcuWIY5zIlnSbt8nUMaLKI9P3CrP3qhyrxe957x15V3XeAFDIQZgl7B%2BSajwxt05zhBjCTWYa8d87sQ3JoXs1L%2BgbLA1QjuKrnLZvWULZMIN3GMe5YyG3C0j3pbhjih7CiNfnRIzXsn6ja%2FXvWu%2BbnmxcpS6zEXCqkSoWEdIiU68lC7k8sHg1M5ScJyzXqpXTAOWzFyyE72qIbtqzpq5MqGcQPvMGVWeEkCw38FxNrqxbpd9n5KEar2qCeJ08lCxVH3EO%2FlpCnx7DObF0RIZF6RVjCmiKm0Bjq0AhzkzcB1jfKRBjzfe9DhBTVMt8%2FLLvyBkb42YkngNBrSv%2FVje4IdZmopA7dAtzXMANIcAcLWB91%2BlCuwdYzpVtNaci1LaWeD8Q0W%2FutrC5N5Ro65q5b5EqiFWmZUGWrHd2b4pxvq5Aogg72hLMZDbai0ExLoaJAskcDPxiaClUHwK%2BwREwWD0nWt3TjU6djakhIEQUsREWJrYY%2Bj%2BDxkjk4lQDlaM%2BynqxmFHprCd%2F4rZVCZVeM1TluW6C53F%2BQk%2FNUh221Cs%2BoIbwG%2FJXaaz4BO%2BLnSTAYjdIEPovUGfdARJeet%2FANWnMbf1jFKf0Gaf%2FLThI%2F6140Tnr621jrRrQv%2FN778HsthGfKK%2FiFIw4%2BFhF6tmjFMkoEBH3aVTTloiwrcrNeMZJkPtVop4IbCHUi%2Fhq7y&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20240707T073120Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAZJKMVJWIKYXWL4GM%2F20240707%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Signature=2225bae98d08cd711aae2b65351ac94d145d5b260712752750a7b501b97b55b4";

            $transcriptionJob = $this->assemblyAI->transcribe($fileURL);

            $this->patientConsultation = $this->patientConsultationRepository->create(
                [
                    "transcript_path" => $transcriptionJob->file_path,
                    "transcription_status" => true,
                    "status_label" => "processing"
                ]
            );

            $this->transcriptPath = $transcriptionJob->file_path;

            $this->generateFeedbackNotes();
            $this->generateAssistantNotes();
            $this->generatePrescriptionNotes();

            $this->patientConsultation->update(
                [
                    'status_label' => 'completed',
                    'status' => true
                ]
            );

            echo "Job complete";
        } catch (Exception $e) {
            $this->patientConsultation->update(
                [
                    'status_label' => 'error',
                    'status' => false
                ]
            );

            throw new Exception('Error! - Job failure');
        }
    }
}