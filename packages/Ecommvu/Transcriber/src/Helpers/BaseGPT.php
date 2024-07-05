<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\TranscriptionJobRepository;
use Illuminate\Support\Facades\Storage;

abstract class BaseGPT {
    public function getHeaders()
    {
        return [
            "Authorization: Bearer " . config('services.chat_gpt.key'),
            "content-type: application/json",
            "OpenAI-Beta: assistants=v2"
        ];
    }
}