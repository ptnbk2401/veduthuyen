<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;


class PCatExport implements FromView,Responsable,ShouldAutoSize,WithTitle
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    private $fileName ;
	private $data;

    public function __construct($data){
        $this->data = $data;
        $this->fileName= 'Danhmucsanpham-'.time().'.xlsx';
    }

    public function view(): View
    {
        return view('vadmin.core.pcat.acpcindex.export', [
            'data' => $this->data
        ]);
    }
    public function title(): string
    {
        return 'Danh mục sản phẩm ';
    }
}
