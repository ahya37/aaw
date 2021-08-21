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

class MemberExportProvince implements FromCollection, WithHeadings, WithEvents, WithDrawings
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
                ->select('a.name','d.name as regency','c.name as district','b.name as village','a.phone_number','a.whatsapp')
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

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('assets/images/logos.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B2');

        return $drawing;
    }

}
