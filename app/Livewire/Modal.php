<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;

    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function goToCreate()
    {
        return redirect()->route('tasks.create');
    }
    public function goToEdit()
    {
        return redirect()->route('tasks.edit'); // 必要に応じてルート名を修正
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
