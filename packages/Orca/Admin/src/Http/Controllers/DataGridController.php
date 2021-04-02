<?php

namespace Orca\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Admin\Http\Controllers\Controller;
use Orca\Admin\DataGrids\TestDataGrid;

/**
 * TestDataGrid controller
 *
 * @author    Nikhil orca <orca@orca.com> @ysmorca
 * @author    Prashant Singh <>
 *
 */
class DataGridController extends Controller
{
    protected $_config;
    protected $testgrid;

    public function __construct(TestDataGrid $testgrid)
    {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->testgrid = $testgrid;
    }

    public function massDelete() {
        dd(request()->all());
    }

    public function massUpdate() {
        dd(request()->all());
    }

    public function testGrid() {
        return $this->testgrid->render();
    }
}
