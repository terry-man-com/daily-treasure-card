<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
                <div class="text-center mb-6 sm:mb-8 md:mb-0 2xl:mb-16 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                    <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">きょうのおやくそく</h1>
                </div>
                @if (session('success'))
                    <div class="text-center text-red-400 font-bold mb-2">{{ session('success')}}</div>
                @endif
                <!-- タブ部分 -->
                @if($children->count() > 0)
                    {{-- タブ切り替えボタン --}}
                    {{-- for文でリファクタリング --}}
                    <div class="flex flex-row justify-between sm:justify-center gap-1 sm:gap-4 text-white font-medium z-10 relative">
                        @foreach ($children as $index => $child)
                            <button data-tab="{{ $index }}" class="js-tab-button flex-1 sm:flex-none sm:w-[180px] md:w-[216px] px-2 sm:px-6 py-2 rounded-t-lg {{ $index === 0 ? 'bg-custom-pink' : 'bg-custom-blue '}} text-xs sm:text-base">{{ $child->child_name }}</button>
                        @endforeach
                    </div>
                    <!-- タスク表示部分 -->
                    @foreach ($children as $index => $child)
                        <div data-panel="{{ $index }}" class="js-tab-panel1 flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 overflow-y-auto {{ $index === 0 ? '' : 'hidden' }}">
                            <div class="flex flex-col gap-4 sm:gap-6 mt-6 sm:mt-10 px-4 lg:px-20">
                                @foreach($child->tasks as $task)
                                    <div class="js-task flex flex-col xl:flex-row justify-between items-center px-4 xl:px-20 py-2 xl:py-1 min-h-[60px] xl:h-10 bg-white xl:bg-transparent rounded xl:rounded-none mb-2 xl:mb-0">
                                        <div class="tracking-[0.2em] xl:tracking-[0.5em] text-center xl:text-left text-base mb-2 xl:mb-0 flex-1">
                                            {{ $task->contents }}
                                        </div>
                                        <div class="judge-button-area flex justify-center items-center gap-2 text-white">
                                            <button data-result="true" class="js-judge-button w-16 xl:w-24 h-8 xl:h-10 bg-custom-pink rounded-full hover:bg-custom-pink/50 text-lg xl:text-base">◯</button>
                                            <button data-result="false" class="js-judge-button w-16 xl:w-24 h-8 xl:h-10 bg-custom-blue rounded-full hover:bg-custom-blue/50 text-lg xl:text-base">✖︎</button>
                                        </div>
                                        {{-- ○×ボタン押下後、表示される --}}
                                        <div class="js-judge-wrapper w-full xl:w-1/4 text-center bg-white xl:bg-white indent-[0.2em] tracking-[0.2em] hidden mt-2 xl:mt-0 rounded xl:rounded-none">
                                            <span data-result="true" class="text-yellow-400 hidden text-base xl:text-base">★&nbsp;<span class="text-custom-gray">できた</span>&nbsp;★</span>
                                            <span data-result="false" class="text-custom-gray hidden text-base xl:text-base">またあした</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-5">
                                <button class="js-reward-button block text-2xl md:text-3xl text-white text-center font-bold bg-yellow-400 mx-auto mt-0 py-3 sm:py-4 px-4 sm:px-6 rounded-full w-full max-w-xs sm:max-w-2xl indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] disabled:opacity-50 disabled:cursor-not-allowed" onclick="triggerGacha({{ $child->id }})" disabled>
                                    ★<span class="text-custom-gray disabled:text-custom-gray/40">ごほうびガチャ</span>★
                                </button>
                                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-8 text-white text-base sm:text-lg font-bold py-2 mb-2 mt-6">
                                    <button href="#" onclick="Livewire.dispatch('openModal');" class="w-4/5 sm:w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60 text-center">約束の登録・編集</button>
                                    <a href="{{ route('rewards.index') }}" class="w-4/5 sm:w-[200px] px-4 py-2 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] text-center">たからばこ</a>
                                    <button id="reset-button" class="w-4/5 sm:w-[200px] px-4 py-2 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/50 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] text-center">リセット</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- 子どもが登録されていない場合のデフォルトパネル -->
                    <div data-panel="0" class="js-tab-panel1 flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 overflow-y-auto">
                        <div class="flex flex-col gap-4 sm:gap-6 mt-6 sm:mt-10 px-4 lg:px-20">
                            <div class="flex items-center justify-center h-full">
                                <p class="text-xl text-custom-gray">まずは「こども管理」から子どもを登録してください</p>
                            </div>
                        </div>
                        <div class="mt-5">
                            <button class="js-reward-button block text-2xl md:text-3xl text-white text-center font-bold bg-yellow-400 mx-auto mt-0 py-3 sm:py-4 px-4 sm:px-6 rounded-full w-full max-w-xs sm:max-w-2xl indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] disabled:opacity-50 disabled:cursor-not-allowed" onclick="triggerGacha({{ $child->id }})" disabled>
                                ★<span class="text-custom-gray disabled:text-custom-gray/40">ごほうびガチャ</span>★
                            </button>
                            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-8 text-white text-base sm:text-lg font-bold py-2 mb-2 mt-6">
                                <button href="#" onclick="Livewire.dispatch('openModal');" class="w-4/5 sm:w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60 text-center">約束の登録・編集</button>
                                <a href="{{ route('rewards.index') }}" class="w-4/5 sm:w-[200px] px-4 py-2 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] text-center">たからばこ</a>
                                <button id="reset-button" class="w-4/5 sm:w-[200px] px-4 py-2 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/50 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] text-center">リセット</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    @include('components.my-footer')
    @push('scripts')
    <script type="module" src="{{ asset('js/modules/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script type="module" src="{{ asset('js/modules/collect-task-results.js') }}"></script>
    <script type="module" src="{{ asset('js/modules/gacha.js') }}"></script>
    @endpush
    @livewire('child-manage-modal')
    @livewire('modal')
    @livewire('gacha-modal')
</x-app-layout>