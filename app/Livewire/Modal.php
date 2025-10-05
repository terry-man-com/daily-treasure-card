<?php

namespace App\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;
    public $currentChildId = null; // child_id を保持

    protected $listeners = [
        'openModal' => 'open'
    ];

    public function open($childId = null) // child_id を受け取る
    {
        \Log::info('Modal open called', ['childId' => $childId]);
        $this->currentChildId = $childId;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function goToCreate()
    {
        \Log::info('goToCreate called', ['currentChildId' => $this->currentChildId]);
        return redirect()->route('tasks.create', ['child_id' => $this->currentChildId]);
    }
    
    public function goToEdit()
    {
        \Log::info('goToEdit called', ['currentChildId' => $this->currentChildId]);
        return redirect()->route('tasks.edit', ['child_id' => $this->currentChildId]);
    }

    public function render()
    {
        return view('livewire.modal');
    }
}
