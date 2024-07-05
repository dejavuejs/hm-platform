<?php

namespace Ecommvu\Transcriber\Models;

use Ecommvu\Transcriber\Contracts\PatientConsultation as ContractsPatientConsultation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class PatientConsultation extends Model implements ContractsPatientConsultation
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transcript_path',
        'transcription_status',
        'prescription_notes_path',
        'assistant_notes_path',
        'feedback_notes_path',
        'prescription_notes_thread_id',
        'assistant_notes_thread_id',
        'feedback_notes_thread_id',
        'prescription_notes_link',
        'assistant_notes_link',
        'feedback_notes_link',
        'patient_name',
        'case_id',
        'case_description',
        'clinic_name',
        'status_label',
        'status'
    ];
}