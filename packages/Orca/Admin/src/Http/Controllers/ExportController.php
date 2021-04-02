<?php

namespace Orca\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Admin\Http\Controllers\Controller;
use Orca\Admin\Exports\DataGridExport;
use Excel;

/**
 * Export controlller
 *
 * @author     <>
 *
 */
class ExportController extends Controller
{
    protected $exportableGrids = [
        'OrderDataGrid', 'OrderInvoicesDataGrid', 'OrderShipmentsDataGrid', 'AudienceDataGrid', 'TaxRateDataGrid', 'ProductDataGrid', 'CMSPageDataGrid'
    ];

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * function for export datagrid
     *
     * @return \Illuminate\Http\Response
    */
    public function export()
    {
        $criteria = request()->all();

        $format = $criteria['format'];

        $gridName = explode('\\', $criteria['gridName']);
        $path = '\Orca\Admin\DataGrids'.'\\'.last($gridName);

        $proceed = false;

        foreach ($this->exportableGrids as $exportableGrid) {
            if (last($gridName) == $exportableGrid) {
                $proceed = true;
            }
        }

        if (! $proceed) {
            return redirect()->back();
        }

        $gridInstance = new $path;
        $records = $gridInstance->export();

        if (count($records) == 0) {
            session()->flash('warning', trans('admin::app.export.no-records'));

            return redirect()->back();
        }

        if ($format == 'csv') {
            return Excel::download(new DataGridExport($records), last($gridName).'.csv');
        }

        if ($format == 'xls') {
            return Excel::download(new DataGridExport($records), last($gridName).'.xlsx');
        }

        session()->flash('warning', trans('admin::app.export.illegal-format'));

        return redirect()->back();
    }
}