<?php

namespace App\Exports;


use App\Model\Vadmin\Core\Cat\AccIndex;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class CatExport implements FromView, Responsable
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fileName = 'danhmuc.xlsx';
	
    public function view(): View
    {
        return view('vadmin.core.cat.accindex.export', [
            'export' => AccIndex::all()
        ]);
    }
}
