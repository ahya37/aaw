<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MemberExportDistrict implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $district;
    
    public function __construct(int $district)
    {
        $this->district = $district;
    }

    public function collection()
    {
        return DB::table('users as a')
                ->join('villages as b','a.village_id','b.id')
                ->join('districts as c','b.district_id','c.id')
                ->join('regencies as d','c.regency_id','d.id')
                ->select('a.name','b.name as village','c.name as district','d.name as regency','a.phone_number','a.whatsapp')
                ->where('b.district_id', $this->district)
                ->orderBy('b.name','asc')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Desa',
            'Kecamatan',
            'Kabupaten / Kota',
            'Telpon',
            'Whatsapp'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }
}
