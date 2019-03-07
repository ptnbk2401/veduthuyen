<?php

namespace App\Widgets;

use App\Model\Vadmin\Core\PCat\AcpcIndex;
use App\Model\Vadmin\Core\Cat\AccIndex;
use Arrilot\Widgets\AbstractWidget;

class MenuTop extends AbstractWidget
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
        $objmAccIndex = new AcpcIndex();
        $objmCat = new AccIndex();
        $objcat= $objmAccIndex->getItemsActive();
        $objparentcat= $objmAccIndex->getParentActive();
        $objBlogCat= $objmCat->getItemsActive();
        return view('widgets.menutop', [
            'config' => $this->config,
            'objcat' => $objcat,
            'objBlogCat' => $objBlogCat,
            'objparentcat' => $objparentcat
        ]);
    }
}
