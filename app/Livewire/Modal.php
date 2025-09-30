<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;
    public $currentTabIndex = 0; // タブのインデックスを保持

    protected $listeners = [
        'openModal' => 'open'
    ];

    public function open($tabIndex = 0) // タブインデックスを受け取る
    {
        $this->currentTabIndex = $tabIndex;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function goToCreate()
    {
        return redirect()->route('tasks.create', ['tab' => $this->currentTabIndex]);
    }
    
    public function goToEdit()
    {
        return redirect()->route('tasks.edit', ['tab' => $this->currentTabIndex]);
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
