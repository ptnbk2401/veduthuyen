<?php

namespace App\Imports;

use App\Model\Vadmin\Core\Sim\AcsIndex;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    // */


    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        {
            foreach ($row as $key => $value) {
                AcsIndex::create([
                    'pnumber' => $value,
                    'nha_mang' => $key,
                ]);
            }
            
        }
        
        
    }
    public function headingRow(): int
    {
        return 1;
    }

}
