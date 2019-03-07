<?php

namespace App\Exports;


use App\Model\Vadmin\Core\User\User;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, Responsable,WithHeadings,ShouldAutoSize,WithEvents
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fileName = 'nhanvien.xlsx';

    public function collection()
    {
        return User::all();
    }
    public function headings(): array
    {
        return [
            '#ID',
            'Username',
            'First_name',
            'Last_name',
            'Email',
            'Phone',
            '',
            'Address',
            'Avatar',
            '',
            'Created at',
            'Updated at',
        ];
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:L1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $styleArray = [
				    'borders' => [
				        'outline' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				            'color' => ['argb' => '#5B2D2D'],
				        ],
				    ],
				];
				$event->sheet->getStyle('A1:L3')->applyFromArray($styleArray);
            },
        ];
    }
}
