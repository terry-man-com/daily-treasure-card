<div>
    @if($isOpen)
        <div class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
             wire:click.self="closeModal">

            {{-- ガチャマシン演出 --}}
            @if($currentStep === 'machine' || $currentStep === 'excitement')
                <div class="gacha-machine-container relative">
                    <img src="{{ asset('images/items/gacha_effect/gachagacha_1.png') }}"
                         alt="ガチャマシン"
                         class="gacha-machine w-80 h-96 object-contain">

                    {{-- カプセル出現エリア --}}
                    <div class="gacha-capsule absolute bottom-20 left-1/2 transform -translate-x-1/2 w-16 h-16 rounded-full border-4 border-white shadow-lg hidden"></div>
                </div>
            @endif

            {{-- カプセル演出 --}}
            @if($currentStep === 'capsule')
                <div class="capsule-container">
                    <div class="gacha-capsule w-24 h-24 rounded-full border-4 border-white shadow-lg mx-auto"></div>
                </div>
            @endif

            {{-- 結果表示 --}}
            @if($currentStep === 'result' && $selectedItem)
                <div class="gacha-result bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
                    <h2 class="text-3xl font-bold mb-6 text-custom-gray">おめでとう！</h2>

                    {{-- 景品画像 --}}
                    <div class="relative mb-6">
                        <img src="{{ $selectedItem->item_image_path }}"
                             alt="{{ $selectedItem->item_name }}"
                             class="result-item-image w-40 h-40 mx-auto rounded-lg shadow-lg">
                    </div>

                    {{-- 景品情報 --}}
                    <h3 class="text-2xl font-bold mb-3 text-custom-gray">{{ $selectedItem->item_name }}</h3>
                    <p class="text-lg mb-3 font-semibold">{{ $this->getRarityDisplayName($rarity) }}</p>
                    <p class="text-sm text-gray-600 mb-6">{{ $message }}</p>

                    {{-- ボタン群 --}}
                    <div class="flex gap-4 justify-center">
                        <button wire:click="closeModal"
                                class="bg-custom-pink text-white px-6 py-3 rounded-full hover:bg-custom-pink/80 font-bold">
                            戻る
                        </button>
                        <button wire:click="goToTreasureBox"
                                class="bg-custom-blue text-white px-6 py-3 rounded-full hover:bg-custom-blue/80 font-bold">
                            たからばこを見る
                        </button>
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
