<?php

namespace App\Livewire;

use Livewire\Component;

class ChildManageModal extends Component
{
    public $show = false;

    protected $listeners = [
        'openChildModal' => 'open'
    ];


    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function goToChildIndex()
    {
        $this->close();
        return redirect()->route('children.index');
    }

    public function goToChildCreate()
    {
        $this->close();
        return redirect()->route('children.create');
    }

    public function goToChildEdit()
    {
        $this->close();
        return redirect()->route('children.edit');
    }

    public function render()
    {
        return view('livewire.child-manage-modal');
    }
}
