<div>
    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="relative bg-white rounded-xl px-8 py-10 shadow-lg w-[340px] flex flex-col items-center justify-center">
                <!-- 閉じるボタン（モーダル本体の右上に絶対配置） -->
                <button wire:click="close"
                    class="absolute top-1 right-4 text-2xl text-gray-400 hover:text-gray-600 focus:outline-none">
                    &times;
                </button>
                <div class="flex flex-col items-center justify-center gap-8 w-full mt-6">
                        <button wire:click="goToChildIndex" class="black w-full py-3 mb-4 bg-custom-pink text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/40 transition">こども情報</button>
                        <button wire:click="goToChildCreate" class="black w-full py-3 mb-4 bg-custom-brown text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-custom-brown/40 transition">こども登録</button>
                        <button wire:click="goToChildEdit" class="black w-full py-3 mb-4 bg-green-400 text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-green-400/40 transition">こども編集</button>
                </div>
            </div>
        </div>
    @endif
</div>