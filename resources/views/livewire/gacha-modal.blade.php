<div>
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
             wire:click.self="closeModal">

            {{-- ガチャマシン演出 --}}
            @if($currentStep === 'machine' || $currentStep === 'excitement')
                <div class="gacha-machine-container relative">
                    <img src="{{ asset('images/items/gacha_effect/gachagacha_1.png') }}"
                         alt="ガチャマシン"
                         class="gacha-machine w-80 h-96 object-contain"
                         style="transform: scale(0,0); opacity: 0;">

                    {{-- カプセル出現エリア --}}
                    <div class="gacha-capsule w-80 h-96 hidden" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                </div>
            @endif

        </div>
    @endif
</div>
