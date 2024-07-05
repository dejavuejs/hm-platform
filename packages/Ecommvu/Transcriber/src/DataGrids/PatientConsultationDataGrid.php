<?php

namespace Ecommvu\Transcriber\DataGrids;

use Illuminate\Support\Facades\DB;
use Orca\Ui\DataGrid\DataGrid;

class PatientConsultationDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('patient_consultations')->addSelect('id', 'transcript_path', 'transcript_completed', 'prescription_notes_path', 'assistant_notes_path', 'feedback_notes_path', 'status_label', 'status');

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
            'index'      => 'transcript_completed',
            'label'      => trans('Transcribed'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'prescription_notes_path',
            'label'      => trans('Prescription Notes'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'assistant_notes_path',
            'label'      => trans('Assistant Notes'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
            // 'wrapper'    => function ($value) {
            //     if ($value->status == 1) {
            //         return trans('admin::app.datagrid.active');
            //     } else {
            //         return trans('admin::app.datagrid.inactive');
            //     }
            // },
        ]);

        $this->addColumn([
            'index'      => 'feedback_notes_path',
            'label'      => trans('Feedback'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'status_label',
            'label'      => trans('Status'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
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