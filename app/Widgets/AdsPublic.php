<?php

namespace App\Widgets;

use App\Model\Vadmin\Core\Advertisement\AcaIndex;
use Arrilot\Widgets\AbstractWidget;

class AdsPublic extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'vitri'=>'index',
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $objmAcaIndex = new AcaIndex;
        // $objItems = $objmAcapIndex->getItemPl();
        return view('widgets.adspublic', [
            'config' => $this->config,
            'objmAcaIndex' => $objmAcaIndex
        ]);
    }
}
