<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'NIM',
            'Nama',
            'Jurusan',
            'Tanggal Wisuda',
        ];
    }

    public function map($row): array
    {
        return [
            $row['nim'],
            $row['nama'],
            $row['kd_jur'] == 12 ? 'Teknik Informatika' : 'Sistem Informasi',
            $row['tgl_wisuda'],
        ];
    }
}
