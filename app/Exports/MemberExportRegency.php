<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class MemberExportRegency implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $regency;
    
    public function __construct(int $regency)
    {
        $this->regency = $regency;
    }
    public function collection()
    {
        return DB::table('users as a')
                ->join('villages as b','a.village_id','b.id')
                ->join('districts as c','b.district_id','c.id')
                ->join('regencies as d','c.regency_id','d.id')
                ->select('a.name','c.name as district','d.name as regency','b.name as village','a.phone_number','a.whatsapp')
                ->where('c.regency_id', $this->regency)
                ->whereNotIn('a.level',[1])
                ->orderBy('c.name','asc')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Kecamatan',
            'Kabupaten / Kota',
            'Desa',
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
