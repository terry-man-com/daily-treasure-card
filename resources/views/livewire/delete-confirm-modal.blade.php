<div>
    @if($show)
        <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="relative bg-white rounded-xl px-8 py-10 shadow-lg w-[340px] flex flex-col items-center justify-center">
                <!-- 閉じるボタン（モーダル本体の右上に絶対配置） -->
                <div class="flex flex-col items-center justify-center gap-8 w-full mt-6">
                    {{-- <button wire:click="clickedDeleteButton" class="black w-full py-3 mb-4 bg-red-400 text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-red-400/40 transition">新規登録</button> --}}
                    <button wire:click="close" class="black w-full py-3 mb-4 bg-green-400 text-white font-bold rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-green-400/40 transition">戻る</button>
                </div>
            </div>
        </div>
    @endif
</div>
