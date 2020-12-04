<?php

namespace warehouse\Imports;

use warehouse\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToModel, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        return new Customer([
            'name' => $row[0],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}