<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MemberExportProvince implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $province;

    use Exportable;
    
    public function __construct(int $province)
    {
        $this->province = $province;
    }
    
    public function collection()
    {
        return DB::table('users as a')
                ->join('villages as b','a.village_id','b.id')
                ->join('districts as c','b.district_id','c.id')
                ->join('regencies as d','c.regency_id','d.id')
                ->join('users as e','a.id','=','e.user_id')
                ->select('a.name','d.name as regency','c.name as district','b.name as village','a.rt','a.rw','a.phone_number','a.whatsapp','e.code as reveral_code')
                ->where('d.province_id', $this->province)
                ->whereNotIn('a.level',[1])
                ->orderBy('d.name','asc')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Kabupaten / Kota',
            'Kecamatan',
            'Desa',
            'RT',
            'RW',
            'Telpon',
            'Whatsapp',
            'Reveral'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

}
