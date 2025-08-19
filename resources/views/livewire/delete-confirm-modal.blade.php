<div>
    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="relative bg-white rounded-xl px-8 py-10 shadow-lg w-[340px] flex flex-col items-center justify-center">
                <p class="text-xl text-center">選択した約束を削除しますか？</p>
                <div class="flex items-center justify-center gap-8 w-full mt-10">
                    <button type="button" onclick="window.confirmDelete()" class="w-full py-2 bg-custom-pink text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/40 transition">OK</button>
                    <button wire:click="close" class="w-full py-2 bg-green-400 text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-green-400/40 transition">戻る</button>
                </div>
            </div>
        </div>
    @endif
</div>
