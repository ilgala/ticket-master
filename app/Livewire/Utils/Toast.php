<?php

namespace App\Livewire\Utils;

use Livewire\Component;

class Toast extends Component
{
    public $type = '';

    public $message = '';

    public $show = false;

    protected $listeners = ['showToast'];

    public function showToast($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
        $this->show = true;
    }

    public function hide()
    {
        $this->type = '';
        $this->message = '';
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.utils.toast');
    }
}
