<?php

namespace App\Widgets;

use App\Model\Vadmin\Core\Slide\AcsIndex;
use Arrilot\Widgets\AbstractWidget;

class SliderIndex extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $objmAcsIndex = new AcsIndex();
        $objItems = $objmAcsIndex->getItemsPl();
        return view('widgets.slider', [
            'config' => $this->config,
            'objItems' => $objItems
        ]);
    }
}
