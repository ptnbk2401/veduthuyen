<?php

namespace App\Exports;


use App\Exports\SimExport;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use App\Model\Vadmin\Core\Sim\AcsIndex;
use App\Model\Vadmin\Core\NhaMang\AcmIndex;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class MulSheetsExport implements WithMultipleSheets,Responsable
{
    use Exportable;

    protected $nha_mang;
    private $fileName ;
    public function __construct()
    {
        $this->fileName= 'Sim-'.time().'.xlsx';

    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $arMang = AcmIndex::getArItems();
        $objmAcsIndex = new AcsIndex();
        // dd($arMang);
        foreach ($arMang as $key => $mang) {
            // dd($mang);
            $arData = $objmAcsIndex->getItemsByMang($mang->mang_id);
            $sheets[] = new SimExport($arData,$mang->name);
        }
        
        return $sheets;
    }
}
