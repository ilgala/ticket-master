<?php

namespace App\Livewire\Utils;

use Livewire\Component;
use Livewire\WithFileUploads;

class Dropzone extends Component
{
    use WithFileUploads;

    public array $files = [];

    public function render()
    {
        return view('livewire.utils.dropzone');
    }

    public function updatedFiles()
    {
        // TODO: logica di upload
    }

    public function removeFile($index)
    {
        // TODO: logica di eliminazione file

        unset($this->files[$index]);
        $this->files = array_values($this->files);
    }
}
