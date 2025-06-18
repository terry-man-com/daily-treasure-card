<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-24 py-5 mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-h1 font-bold mb-4 tracking-[0.5em]">きょうのおやくそく</h1>
                </div>
                @if (session('success'))
                    <div class="message">{{ session('success')}}</div>
                @endif
                <!-- タブ部分 -->
                    {{-- タブ切り替えボタン --}}
                    {{-- for文でリファクタリング --}}
                    <div class="flex justify-center gap-4 text-white text-lx font-medium">
                        <button data-tab="0" class="js-tab-button w-[216px] px-6 py-2 rounded-t-lg bg-custom-pink">ひなみ</button>
                        <button data-tab="1" class="js-tab-button w-[216px] px-6 py-2 rounded-t-lg bg-custom-blue">げんりゅうさい</button>
                        <button data-tab="2" class="js-tab-button w-[216px] px-6 py-2 rounded-t-lg bg-custom-blue">ゆいと</button>
                    </div>
                    <!-- タスク表示部分 -->
                    <div data-panel="0" class="js-tab-panel1 flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 overflow-y-auto">
                        <ul class="list-disc px-20 mt-5">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="task flex justify-center gap-10 py-3">
                                    <li class="tracking-[0.5em]">
                                            日南テストテストテストテストテスト
                                            {{-- {{$task->contents}} --}}
                                    </li>
                                    <div class="judge-button-area flex items-center gap-2 text-white">
                                        <button data-result="true" class="js-judge-button flex justify-center items-center w-24 h-10 bg-custom-pink rounded-full hover:bg-custom-pink/50">◯</button>
                                        <button data-result="false" class="js-judge-button flex justify-center items-center w-24 h-10 text-white bg-custom-blue px-5 rounded-full hover:bg-custom-blue">✖︎</button>
                                    </div>
                                    {{-- 判定結果表示（初期は非表示） --}}
                                    <div class="js-judge-wrapper w-[200px] text-center bg-white indent-[0.2em] tracking-[0.2em] hidden">
                                        <span data-result="true" class="text-yellow-400 hidden">★&nbsp;<span class="text-custom-gray">できた</span>&nbsp;★</span>
                                        <span data-result="false" class="text-custom-gray hidden">またあした</span>
                                    </div>
                                </div>
                            @endfor
                        </ul>
                        <button class="block text-3xl text-white text-center font-bold bg-yellow-400 mx-auto mt-10 py-4 px-6 rounded-full w-full max-w-2xl indent-[0.4em] tracking-[0.4em] disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            ★<span class="text-custom-gray disabled:text-custom-gray/40">ごほうびガチャ</span>★
                        </button>
                        <div class="flex justify-center items-center gap-8 text-white text-lg font-bold py-2 mb-2">
                            <a href="#" class="w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60">約束の登録・編集</a>
                            <a href="#" class="w-[200px] px-4 py-2 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50 indent-[0.4em] tracking-[0.4em]">たからばこ</a>
                            <button id="reset-button" class="w-[200px] px-4 py-2 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/50 indent-[0.4em] tracking-[0.4em]">リセット</button>
                        </div>
                    </div>
                    <div data-panel="1" class="js-tab-panel1 flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 overflow-y-auto hidden">
                        <ul class="list-disc px-20 mt-5">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="task flex justify-center gap-10 py-3">
                                    <li class="tracking-[0.5em]">
                                            源流歳テストテストテストテスト
                                            {{-- {{$task->contents}} --}}
                                    </li>
                                    <div class="flex items-center gap-2 text-white">
                                            <button class="flex justify-center items-center w-24 h-10 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50">◯</button>
                                            <button class="w-24 h-10 flex items-center justify-center text-white bg-custom-blue px-5 rounded-full hover:bg-custom-blue/60 leading-none">✖︎</button>
                                    </div>
                                </div>
                            @endfor
                        </ul>
                        <button class="block text-3xl text-white text-center font-bold bg-yellow-400 mx-auto mt-10 py-4 px-6 rounded-full w-full max-w-2xl indent-[0.4em] tracking-[0.4em]">
                            ★<span class="text-custom-gray">ごほうびガチャ</span>★
                        </button>
                        <div class="flex justify-center items-center gap-8 text-white text-lg font-bold py-2 mb-2">
                            <a href="#" class="w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60">約束の登録・編集</a>
                            <a href="#" class="w-[200px] px-4 py-2 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50 indent-[0.4em] tracking-[0.4em]">たからばこ</a>
                            <button id="reset-button" class="w-[200px] px-4 py-2 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/50 indent-[0.4em] tracking-[0.4em]">リセット</button>
                        </div>
                    </div>
                    <div data-panel="2" class="js-tab-panel1 hidden flex flex-col justify-between bg-white border-custom-gray text-center h-[60vh] border-2 overflow-y-auto">
                        <ul class="list-disc px-20 mt-5">
                            @for ($i = 0; $i < 5; $i++)
                                <div class="flex justify-between py-3">
                                    <li class="tracking-[0.5em]">
                                            ゆいとテストテストテストテストテスト
                                            {{-- {{$task->contents}} --}}
                                    </li>
                                    <div class="flex items-center gap-2 text-white">
                                            <button class="flex justify-center items-center w-24 h-10 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50">◯</button>
                                            <button class="w-24 h-10 flex items-center justify-center text-white bg-custom-blue px-5 rounded-full hover:bg-custom-blue/60 leading-none">✖︎</button>
                                    </div>
                                </div>
                            @endfor
                        </ul>
                        <button class="block text-3xl text-white text-center font-bold bg-yellow-400 mx-auto mt-10 py-4 px-6 rounded-full w-full max-w-2xl indent-[0.4em] tracking-[0.4em]">
                            ★<span class="text-custom-gray">ごほうびガチャ</span>★
                        </button>
                        <div class="flex justify-center items-center gap-8 text-white text-lg font-bold py-2 mb-2">
                            <a href="#" class="w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60">約束の登録・編集</a>
                            <a href="#" class="w-[200px] px-4 py-2 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50 indent-[0.4em] tracking-[0.4em]">たからばこ</a>
                            <button id="reset-button" class="w-[200px] px-4 py-2 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/50 indent-[0.4em] tracking-[0.4em]">リセット</button>
                        </div>
                    </div>
            </div>
        </main> 
    @include('components.my-footer')
</x-app-layout>