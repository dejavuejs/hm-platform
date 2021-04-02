<?php

namespace Orca\Admin\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;


/**
 * DataGridImport class
 *
 * @author     <>
 *
*/

class DataGridImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     * @return void
    */
    public function collection(Collection $rows)
    {
    }
}