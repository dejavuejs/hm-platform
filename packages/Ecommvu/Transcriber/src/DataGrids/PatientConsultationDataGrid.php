<?php

namespace Ecommvu\Transcriber\DataGrids;

use Illuminate\Support\Facades\DB;
use Orca\Ui\DataGrid\DataGrid;
use Illuminate\Support\Facades\Storage;

class PatientConsultationDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('patient_consultations')->addSelect('id', 'transcript_path', 'transcription_status', 'prescription_notes_path', 'assistant_notes_path', 'feedback_notes_path', 'status_label', 'status');

        // $this->addFilter('status', 'marketing_campaigns.status');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('admin::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'transcription_status',
            'label'      => trans('Transcribed'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => true,
            'wrapper' => function($value) {
                if ($value->transcription_status)
                    return '<span class="badge badge-md badge-success">Done</span>';
                else if (!$value->transcription_status)
                    return '<span class="badge badge-md badge-warning">Pending</span>';
            }
        ]);

        $this->addColumn([
            'index'      => 'prescription_notes_path',
            'label'      => trans('Prescription Notes'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure' => true,
            // 'wrapper' => function($value) {
            //     return Storage::url($value->prescription_notes_path);
            // }
            'wrapper' => function($value) {
                return '<a href=' . Storage::url($value->prescription_notes_path) . '>Download</a>';
            }
        ]);

        $this->addColumn([
            'index'      => 'assistant_notes_path',
            'label'      => trans('Assistant Notes'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure' => true,
            'wrapper' => function($value) {
                return '<a href=' . Storage::url($value->assistant_notes_path) . '>Download</a>';
            }
            // 'wrapper' => function ($value) {
            //     return '<a href="' .  Storage::url($value->assistant_notes_path) . '">Download</a>';
            // },
        ]);

        $this->addColumn([
            'index'      => 'feedback_notes_path',
            'label'      => trans('Feedback'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
            'closure' => true,
            // 'wrapper' => function($value) {
            //     return Storage::url($value->feedback_notes_path);
            // }
            'wrapper' => function($value) {
                return '<a href=' . Storage::url($value->feedback_notes_path) . '>Download</a>';
            }
        ]);

        $this->addColumn([
            'index'      => 'status_label',
            'label'      => trans('Status'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            'closure' => true,
            'wrapper' => function ($value) {
                if ($value->status_label == 'processing')
                    return '<span class="badge badge-md badge-success">Processing</span>';
                else if ($value->status_label == 'completed')
                    return '<span class="badge badge-md badge-success">Completed</span>';
                else if ($value->status_label == "pending")
                    return '<span class="badge badge-md badge-warning">Pending</span>';
            },
        ]);
    }

    public function prepareActions()
    {
        // $this->addAction([
        //     'title'  => trans('admin::app.datagrid.edit'),
        //     'method' => 'GET',
        //     'route'  => 'admin.campaigns.edit',
        //     'icon'   => 'icon pencil-lg-icon',
        // ]);

        // $this->addAction([
        //     'title'        => trans('admin::app.datagrid.delete'),
        //     'method'       => 'POST',
        //     'route'        => 'admin.campaigns.delete',
        //     'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'Campaign']),
        //     'icon'         => 'icon trash-icon',
        // ]);
    }
}