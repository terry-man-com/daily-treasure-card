<?php

namespace App\Livewire;

use Livewire\Component;

class GachaModal extends Component
{
    // モーダル状態管理
    public $isOpen = false;
    public $currentStep = 'closed'; // closed, machine, capsule, result

    // 結果データ（Controllerから受信）
    public $selectedItem = null;
    public $rarity = null;
    public $isNewRecord = false;
    public $message = '';

    protected $listeners = [
        'openGachaModal' => 'startGacha',
        'closeGachaModal' => 'closeModal'
    ];

    public function startGacha($childId, $trueCount, $totalTasks)
    {
        logger('🎯 GachaModal: startGacha called', ['childId' => $childId, 'trueCount' => $trueCount, 'totalTasks' => $totalTasks]);
        
        $this->isOpen = true;
        $this->currentStep = 'machine';

        // gacha.jsにアニメーション開始を通知
        logger('🔗 GachaModal: Dispatching triggerGachaAnimation');
        $this->dispatch('triggerGachaAnimation', 
            childId: $childId,
            trueCount: $trueCount,
            totalTasks: $totalTasks
        );
    }


    public function goToTreasureBox()
    {
        return redirect()->route('rewards.index');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->currentStep = 'closed';
        $this->reset(['selectedItem', 'rarity', 'isNewRecord', 'message']);
    }

    public function getRarityDisplayName($rarityName)
    {
        $rarityNames = [
            'perfect' => '★★★ パーフェクト！',
            'partial' => '★★ がんばった！',
            'fail' => '★ またあした！'
        ];
        return $rarityNames[$rarityName] ?? $rarityName;
    }
    
    public function render()
    {
        return view('livewire.gacha-modal');
    }
}
