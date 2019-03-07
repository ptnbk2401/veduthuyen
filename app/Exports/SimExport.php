<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;


class SimExport implements FromView,Responsable,ShouldAutoSize,WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fileName ;
    private $data;
	private $nhamang="";

    public function __construct($data,$nhamang=false){
        $this->data = $data;
        $this->nhamang = $nhamang;
        $this->fileName= 'Sim-'.time().'.xlsx';
    }

    public function view(): View
    {
        return view('vadmin.core.sim.acsindex.export', [
            'data' => $this->data
        ]);
    }
    public function title(): string
    {
        return 'Danh sách Sim '.$this->nhamang;
    }
}
