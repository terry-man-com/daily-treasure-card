<div>
    @if($showModal)
        <!-- モーダルオーバーレイ -->
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" wire:click="closeModal">
            <!-- モーダルコンテンツ -->
            <div class="bg-white rounded-lg p-6 max-w-md mx-4 shadow-xl md:max-w-2xl md:w-[50vw] md:h-[40vh] lg:w-[40vw] lg:h-[35vh] xl:h-[50vh] md:overflow-y-auto" wire:click.stop>
                <div class="flex justify-end items-center mb-4">
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">✕</button>
                </div>
                    <div class="text-center">
                        <img src="{{ $item['item_image_path'] }}" alt="{{ $item['item_name'] }}"
                             class="w-32 h-32 md:w-64 md:h-64 2xl:w-96 2xl:h-96 mx-auto mb-4 rounded-lg shadow-lg">
                    </div>
                <div class="flex justify-center mt-10">
                    <button wire:click="closeModal" 
                            class="bg-custom-pink text-white px-6 py-2 rounded-full hover:bg-custom-pink/80">
                        閉じる
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
