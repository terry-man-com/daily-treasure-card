<?php

namespace App\Livewire;

use Livewire\Component;

class RewardModal extends Component
{
    public $showModal = false;
    public $item = null;
    public $earnedAt = null;

    protected $listeners = ['show-reward-modal' => 'openModal'];

public function openModal($item, $earnedAt)
{
    $this->item = $item;
    $this->earnedAt = $earnedAt;
    $this->showModal = true;
}

    public function closeModal()
    {
        $this->showModal = false;
        $this->item = null;
        $this->earnedAt = null;
    }

    public function getRarityDisplayName($rarity)
    {
        $rarityNames = [
            'perfect' => '★★★ パーフェクト！',
            'partial' => '★★ がんばった！',
            'fail' => '★ またあした！',
        ];
        return $rarityNames[$rarity] ?? $rarity;
    }

    public function render()
    {
        return view('livewire.reward-modal');
    }
}
