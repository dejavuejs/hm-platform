<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\PatientConsultationRepository;
use Ecommvu\Transcriber\Helpers\AssemblyAI;
use Ecommvu\Transcriber\Helpers\BaseGPT;
use Illuminate\Support\Facades\Storage;

class TherapistHelper  extends BaseGPT {
    protected $assemblyAI;
    protected $patientConsultationRepository;
    protected $patientConsultation;
    protected $transcriptPath;

    public function __construct(
        AssemblyAI $assemblyAI,
        Repository $patientConsultationRepository
    )
    {
        $this->assemblyAI = $assemblyAI;
        $this->patientConsultationRepository = $patientConsultationRepository;
    }

    public function generateFeedbackNotes()
    {
        $this->assistantId = config('services.chat_gpt.feedback_gpt_id');
        $this->createThread();
        $this->patientConsultation->update(
            [
                'feedback_notes_thread_id' => $this->thread['id']
            ]
        );
        $this->addMessages();
        $this->runAssistant();
        $this->getReply();

        // $filePath = "transcriptions/" . $result->id . ".log";
        // foreach ($utterances as $utterance) {
        //     $speaker = $utterance['speaker'];
        //     $text = $utterance['text'];
        //     $utter = $speaker . ": " . $text . "\n";
        //     Storage::append($filePath, $utter);
        // }
    }

    // public function generateAssistantNotes()
    // {
    //     $this->assistantId = config('services.chat_gpt.feedback_gpt_id');
    // }

    // public function generatePrescriptionNotes()
    // {
    //     $this->assistantId = config('services.chat_gpt.feedback_gpt_id');
    // }

    public function main()
    {
        try {
            $fileURL = "https://audio2transcriber.s3.ap-south-1.amazonaws.com/mix_16m58s%20%28audio-joiner.com%29.mp3?response-content-disposition=inline&X-Amz-Security-Token=IQoJb3JpZ2luX2VjEBcaCXVzLWVhc3QtMSJHMEUCIB7P6IRkV5dsNa5JUPp2MB1y6ebMJMOd4jNmLFak0m2NAiEAh7Ke5qAbifWshAZp1rYCtTyijyOYOXo9ykvw5N4qvpkq7QIIz%2F%2F%2F%2F%2F%2F%2F%2F%2F%2F%2FARABGgw2Mzg1MDAyOTQwMzIiDO3kEl%2FHlmhtMwFa%2FCrBAjjbGil26%2BawgYLyHVCqGEY73fqV8zs0HNBUhRfPeLSi8bzaZg2kxToPxJEhmLSjT3SdRDVPk3E5ZOCTS%2BV5ofTgyygG3240JlXdIUY2vj4dChy7%2FLKOUALQClaGUsZDNiMfmCE6vqxIzAIbFJ0MIPB5mxrrczgVW56N5pnA1uIm%2FW1wp2%2FuoZG0Um7hqs64yEtvFhoyIl3lMsqR6qg%2BGM9ZdDz5zYPcutaxEE0oj7ftntUwSZUOcX2ZCyVpbFaGRn63L0ORGQg7saFapsUBOnGgL%2BbpMMlIC7P0y0bHEFhGve34Xp6lYIzYtbSOhRBu5fQedY3c78zFLs2BUf%2B5avr%2B4NDpkXppOUScLdC5YT3RYcKhLZz5ruxUgxcH1e8OapSD2nVTszOi%2FMU%2BSZnDdYxDCs0T2RC%2Btz1MlXvJdeGlMjCTvaO0BjqzAtDyaHB07YAwEK6H%2Fiba4Etdmw4iyKw%2FRMCkoXFZAv2X9FefT3nlTEiMY1WiuVjk%2FFySkECoGtr5t3x1asfL4mwqY1s%2BVoYtdEvVD8i%2BToMx4OqKLW%2BHOnE6DjVnYphXK%2Fdj%2Fx1sxLt9mSUx0S2RdtspwtSVW%2BdnT0TAfcod9E0PawsUJ8iYaPVHev0TfPXitkIIEAZ5Lus1neaaW5Hdhpiu9DNnZ5a6S2VT4I%2FHheWuKjRK5wS%2B2f8gXzF9%2FkCdkerLBJmKC5gKMFyYFVXot3x%2BUv0Luz2odhM0okXyt0vK0ZWMeRU0HhdL3H2R7PCCL5%2BHCBmIYYwhvdYa%2F%2FSKcvFD9AryWTdjLuNcNEHmRAho45pzPJ1OP1t4019Oeq61zunF9dR3o0fhwhzfw2d1RM8Iqq4%3D&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Date=20240706T060555Z&X-Amz-SignedHeaders=host&X-Amz-Expires=43200&X-Amz-Credential=ASIAZJKMVJWIGA3X55HF%2F20240706%2Fap-south-1%2Fs3%2Faws4_request&X-Amz-Signature=769eb1f688660d4864cb7e8cf42c4c0ef773c8a4700f182c8398b46a4037551a";
            $transcriptionJob = $this->assemblyAI->transcribe($fileURL);

            $this->patientConsultation = $this->patientConsultationRepository->create(
                [
                    "transcript_path" => $transcriptionJob->file_path,
                    "transcription_status" => true
                ]
            );

            $this->transcriptPath = $transcriptionJob->file_path;

            $this->generateFeedbackNotes();

            return $this->reply;
        } catch (Exception $e) {
            throw new Exception('Error! - Job failure');
        }
    }
}