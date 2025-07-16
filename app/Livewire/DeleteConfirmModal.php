<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class DeleteConfirmModal extends Component
{
    public $show = false;
    public $checkedTasks = [];
    public $errorMessage = '';

    protected $listeners = ['openDeleteModal' => 'open'];

    public function open($params = [])
    {
        $this->show = true;
        $this->checkedTasks = $params['checkedTasks'] ?? [];
        $this->errorMessage = '';
    }

    public function close()
    {
        $this->show = false;
        $this->checkedTasks = [];
        $this->errorMessage = '';
    }

    public function clickedDeleteButton()
    {
        // チェックボックスが全てのからの場合
        // エラーメッセージを表示する
        if(empty($this->checkedTasks)) {
            $this->errorMessage = 'チェックボックスを選択してください';
            return;
        }
        // IDが一致したタスクを消去する
        Task::whereIn('id', $this->checkedTasks)->delete();
        $this->close();
        session()->flash('success', '選択したタスクを削除しました');
    }

    public function render()
    {
        return view('livewire.delete-confirm-modal');
    }
}