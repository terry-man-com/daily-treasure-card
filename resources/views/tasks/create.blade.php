<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
                <div class="relative mb-10 sm:mb-8 md:mb-0 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                    <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">おやくそく登録</h1>
                    <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl px-3 sm:px-4 md:px-6 py-2 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-green-500 shadow">
                        戻る
                    </a>
                </div>
                @error("contents")
                    <div class="text-center pb-2 text-red-400 font-bold">{{ $message }}</div>
                @enderror
                @error("contents.*")
                    <div class="text-center pb-2 text-red-400 font-bold">{{ $message }}</div>
                @enderror
                <!-- タブ部分 -->
                @if($children->count() > 0)
                    {{-- タブ切り替えボタン --}}
                    {{-- for文でリファクタリング --}}
                    <div class="flex flex-row justify-between sm:justify-center gap-1 sm:gap-4 text-white text-base font-medium z-10 relative">
                        @foreach ($children as $index => $child)
                            <button data-tab="{{ $index }}" class="js-tab-button flex-1 sm:flex-none sm:w-[180px] md:w-[216px] px-2 sm:px-6 py-2 rounded-t-lg {{ $index === 0 ? 'bg-custom-pink' : 'bg-custom-blue '}} text-xs sm:text-base">{{ $child->child_name }}</button>
                        @endforeach
                    </div>
                    <!-- タスク表示部分 -->
                    @foreach ($children as $panelIndex => $child)
                        <div data-panel="{{ $panelIndex }}" class="js-tab-panel1 {{ $panelIndex === 0 ? '' : 'hidden' }} flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 relative z-0">
                            <form method="post" action="{{ route('tasks.store') }}" class="flex flex-col h-full">
                                @csrf
                                <div class="flex-1 flex flex-col gap-4 px-4 sm:px-8 md:px-12 lg:px-20 py-6 sm:py-8 md:py-10 overflow-y-auto">
                                    <!-- 正しいchild_idを設定 -->
                                    <input type="hidden" name="child_id" value="{{ $children[$panelIndex]->id }}">
                                    
                                    <div class="js-task flex flex-col sm:flex-row justify-between items-center py-2 gap-3 sm:gap-0 bg-white sm:bg-transparent rounded sm:rounded-none p-3 sm:px-6 md:px-12">
                                        <input type="text" name="contents[]" class="task-name pl-2 tracking-[0.2em] sm:tracking-[0.5em] w-full sm:w-4/5 border-1 rounded-lg text-base sm:text-xl @error('contents.' ."0") border-red-400 border-2 @enderror order-1" placeholder="15文字以内で入力してください" value="{{ old('contents.0') }}">
                                        <div class="judge-button-area flex justify-center items-center text-white w-full sm:w-1/4 order-2">
                                            <button type="button" class="js-task-reset w-3/4 h-8 sm:h-10 bg-custom-blue indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-custom-blue text-lg sm:text-base">消す</button>
                                        </div>
                                    </div>
                                    {{-- 所持タスク数問わずフォームを５つ表示させるため --}}
                                    {{-- $iの初期値を０にするとタスク数が５個未満ときにフォームが消える --}}
                                    @for ($i = 1; $i < 5; $i++) 
                                        <div class="js-task flex flex-1 flex-col sm:flex-row justify-between items-center py-2 gap-3 sm:gap-0 bg-white sm:bg-transparent rounded sm:rounded-none p-3 sm:px-6 md:px-12">
                                            <input type="text" name="contents[]" class="task-name pl-2 tracking-[0.2em] sm:tracking-[0.5em] w-full sm:w-4/5 border-1 rounded-lg text-base sm:text-xl @error('contents.' .$i) border-red-400 border-2 @enderror order-1" value="{{ old('contents.' . $i) }}">
                                            <div class="judge-button-area flex justify-center items-center text-white w-full sm:w-1/4 order-2">
                                                <button type="button" class="js-task-reset w-3/4 h-8 sm:h-10 bg-custom-blue indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-custom-blue text-lg sm:text-base">消す</button>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                {{-- 登録ボタン（下固定） --}}
                                <div class="flex-none px-4 sm:px-8 md:px-12 lg:px-20 py-4 sm:py-6">
                                    <button type="submit" class="block text-lg sm:text-2xl md:text-3xl text-white text-center font-bold bg-custom-pink mx-auto py-3 sm:py-4 px-4 sm:px-6 rounded-full w-full max-w-xs sm:max-w-xl indent-[0.2em] sm:indent-[2.0em] tracking-[0.2em] sm:tracking-[2.0em]">
                                        登録
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                @else
                    <!-- 子どもが登録されていない場合のデフォルトパネル -->
                    <div data-panel="0" class="js-tab-panel1 flex flex-col justify-center items-center bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 relative z-0">
                        <div class="flex items-center justify-center h-full">
                            <p class="text-xl text-custom-gray">まずは「こども管理」から子どもを登録してください</p>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    @include('components.my-footer')
    @push('scripts')
    <script type="module" src="{{ asset('js/modules/create.js') }}"></script>
    @endpush
    @livewire('child-manage-modal')
</x-app-layout>