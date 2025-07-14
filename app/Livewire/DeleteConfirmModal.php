<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class DeleteConfirmModal extends Component
{
    public $show = false;

    protected $listeners = ['openDeleteModal' => 'open'];

    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.delete-confirm-modal');
    }
}