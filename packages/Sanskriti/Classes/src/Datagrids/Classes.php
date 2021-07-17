<?php

namespace Sanskriti\Classes\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class Classes extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('classes')->addSelect('id', 'code', 'name');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => 'Id',
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'code',
            'label'      => 'Code',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => 'Name',
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction(
            [
                'type' => 'Edit',
                'method' => 'GET', // use GET request only for redirect purposes
                'route' => 'admin.catalog.families.edit',
                'icon' => 'icon pencil-lg-icon'
            ]
        );

        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST', // use GET request only for redirect purposes and POST for rest
            'route' => 'admin.catalog.families.delete',
            // 'confirm_text' => trans('ui::app.datagrid.massaction.delete', ['resource' => 'product']),
            'icon' => 'icon trash-icon'
        ]);
    }
}