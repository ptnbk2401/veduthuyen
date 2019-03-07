<?php

namespace App\Imports;

use App\Model\Vadmin\Core\Sim\AcsIndex;
use App\Model\Vadmin\Core\NhaMang\AcmIndex;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SimImport implements ToCollection,WithHeadingRow
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
            $active = ($row['trang_thai']=='Còn Hàng') ? 1 : 0;
            $name = $row['nha_mang'];
            $mang_id = AcmIndex::getIDByName($name);
            // dd($active);
            AcsIndex::create([
                'pnumber' => $row['so'],
                'nha_mang' => $mang_id->mang_id,
                'active' => $active,
            ]);
        }
        
    }
    public function headingRow(): int
    {
        return 1;
    }

}
