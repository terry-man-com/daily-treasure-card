<div>
    <a href="#" wire:click="open" class="w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60">約束の登録・編集</a>
    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="relative bg-white rounded-xl px-8 py-10 shadow-lg w-[340px] flex flex-col items-center justify-center">
                <!-- 閉じるボタン（モーダル本体の右上に絶対配置） -->
                <button wire:click="close"
                    class="absolute top-1 right-4 text-2xl text-gray-400 hover:text-gray-600 focus:outline-none">
                    &times;
                </button>
                <div class="flex flex-col items-center justify-center gap-8 w-full mt-6">
                        <button wire:click="goToCreate" class="black w-full py-3 mb-4 bg-custom-pink text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/40 transition">新規登録</button>
                        <button wire:click="goToEdit" class="black w-full py-3 mb-4 bg-green-400 text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-green-400/40 transition">編集・削除</button>
                </div>
            </div>
        </div>
    @endif
</div>


