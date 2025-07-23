<?php

namespace App\Livewire;

use Livewire\Component;

class DeleteConfirmModal extends Component
{
    public $show = false;
    public $errorMessage = '';

    protected $listeners = [
        'openDeleteModal' => 'open'
    ];

    public function open($param = [])
    {
        $this->show = true;
        $this->errorMessage = '';
    }

    public function close()
    {
        $this->show = false;
        $this->errorMessage = '';
    }

    public function render()
    {
        return view('livewire.delete-confirm-modal');
    }
}