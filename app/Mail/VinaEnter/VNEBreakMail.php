<?php

namespace App\Mail\VinaEnter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Model\VinaEnter\User;
use Illuminate\Support\Facades\Auth;

class VNEBreakMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $arItem;

    public function __construct($arItem)
    {
        $this->arItem = $arItem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $arInfoMail  = $this->arItem;
        $fullname = $arInfoMail ['fullname'];

        $this->subject("VINAENTER[NGHIPHEP][$fullname]");
        return $this->view('email.vinaenter.vnebreak', compact('arInfoMail'));
    }
}
