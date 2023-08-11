<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{

    protected $headingRow = 1;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    protected $columns;
    public function __construct(array $columns)
    {
        $this->columns = $columns;
        // dd($this->columns);
    }

    public function model(array $row)
    {
        // dd($row[str_replace(' ','_',strtolower($this->columns['full_name']))]);
        return new User([
            'full_name' => $row[str_replace(' ','_',strtolower($this->columns['full_name']))],
            'phone_number' => $row[str_replace(' ','_',strtolower($this->columns['phone_number']))],
            'email' => $row[str_replace(' ','_',strtolower($this->columns['email']))],
        ]);
    }
}
