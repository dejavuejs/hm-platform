<?php

namespace Orca\Admin\DataGrids;

use Orca\Ui\DataGrid\DataGrid;
use DB;

/**
 * AudienceDataGrid class
 *
 * @author Prashant Singh <>
 *
 */
class AudienceDataGrid extends DataGrid
{
    protected $index = 'audience_id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    protected $itemsPerPage = 10;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('audiences')
                ->leftJoin('audience_groups', 'audiences.audience_group_id', '=', 'audience_groups.id')
                ->addSelect('audiences.id as audience_id', 'audiences.email', 'audience_groups.name', 'status')
                ->addSelect(DB::raw('CONCAT(audiences.first_name, " ", audiences.last_name) as full_name'));

        $this->addFilter('audience_id', 'audiences.id');
        $this->addFilter('full_name', DB::raw('CONCAT(audiences.first_name, " ", audiences.last_name)'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'audience_id',
            'label' => trans('admin::app.datagrid.id'),
            'type' => 'number',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'full_name',
            'label' => trans('admin::app.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'email',
            'label' => trans('admin::app.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('admin::app.datagrid.group'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.datagrid.status'),
            'type' => 'boolean',
            'searchable' => false,
            'sortable' => true,
            'filterable' => true,
            'wrapper' => function ($row) {
                if ($row->status == 1) {
                    return 'Activated';
                } else {
                    return 'Blocked';
                }
            }
        ]);
    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Edit',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.audience.edit',
            'icon' => 'icon pencil-lg-icon',
            'title' => trans('admin::app.audiences.audiences.edit-help-title')
        ]);

        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'admin.audience.delete',
            'icon' => 'icon trash-icon',
            'title' => trans('admin::app.audiences.audiences.delete-help-title')
        ]);

        $this->addAction([
            'type' => 'Add Note',
            'method' => 'GET',
            'route' => 'admin.audience.note.create',
            'icon' => 'icon note-icon',
            'title' => trans('admin::app.audiences.note.help-title')
        ]);
    }

    /**
     * Audience Mass Action To Delete And Change Their
     */
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type' => 'delete',
            'label' => 'Delete',
            'action' => route('admin.audience.mass-delete'),
            'method' => 'PUT',
        ]);

        $this->addMassAction([
            'type' => 'update',
            'label' => 'Update Status',
            'action' => route('admin.audience.mass-update'),
            'method' => 'PUT',
            'options' => [
                'Active' => 1,
                'Inactive' => 0
            ]
        ]);

        $this->enableMassAction = true;
    }
}