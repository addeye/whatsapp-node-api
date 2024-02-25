<?php

namespace App\Imports;

use App\Models\Participant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ParticipantImport implements ToModel, WithStartRow
{
    protected $group_id;

    public function __construct($group_id)
    {
        $this->group_id = $group_id;
    }

    public function startRow(): int
    {
        return 2; // Mulai membaca dari baris kedua (baris setelah baris judul/heading)
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(empty($row[0])) {
            return null;
        }

        return Participant::updateOrCreate(
        [
            "group_id" => $this->group_id,
            "phone" => $row[2],
        ],
        [
            "name" => $row[1]
        ]);
    }
}
