<?php

namespace App\Exports;

use App\Models\prospect;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProspectExport implements FromCollection,WithHeadings
{
    protected $data;

    function __construct($data) {
            $this->data = $data;
    }
    public function headings():array{
        return [
            'Nama',
            'Hp',
            'Email',
            'Pesan',
            'Jenis Kelamin',
            'Range Usia',
            'Tempat Tinggal',
            'Pekerjaan',
            'Sumber Data',
            'Platform',
            'Level Input',
            'Input By',
            'Input Date',
            'Kode Sales',
            'Nama Sales',
            'Kode Agent',
            'Nama Agent',
            'Kode Project',
            'Harga Jual',
            'CatatanSales',
            'Status',
            'Hot'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }
}