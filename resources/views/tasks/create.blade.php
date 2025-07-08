<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-24 py-5 mx-auto">
                <div class="relative mb-10">
                    <h1 class="text-h1 font-bold text-center indent-[0.5em] tracking-[0.5em]">おやくそく登録</h1>
                    <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white  text-xl px-6 py-2 indent-[0.4em] tracking-[0.4em] rounded-full hover:bg-green-500 shadow">
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
                    {{-- タブ切り替えボタン --}}
                    {{-- for文でリファクタリング --}}
                    <div class="flex justify-center gap-4 text-white text-lx font-medium z-10 relative">
                        @foreach ($children as $index => $child)
                            <button data-tab="{{ $index }}" class="js-tab-button w-[216px] px-6 py-2 rounded-t-lg {{ $index === 0 ? 'bg-custom-pink' : 'bg-custom-blue '}} ">{{ $child->child_name }}</button>
                        @endforeach
                    </div>
                    <!-- タスク表示部分 -->
                    @foreach ($children as $panelIndex => $child)
                        <div data-panel="{{ $panelIndex }}" class="js-tab-panel1 {{ $panelIndex === 0 ? '' : 'hidden' }} flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] px-20 py-10 border-2 overflow-y-auto relative z-0">
                            <form method="post" action="{{ route('tasks.store') }}">
                                @csrf
                                <div class="flex flex-col gap-4 px-20">
                                    <div class="task flex justify-between items-center py-2">
                                        <input type="hidden" name="child_id" value="{{ $child->id }}">
                                        <input type="text" name="contents[]" class="task-name pl-2 tracking-[0.5em] w-4/5 border-1 rounded-lg text-xl @error('contents.' ."0") border-red-400 border-2 @enderror" placeholder="15文字以内で入力してください" value="{{ old('contents.0') }}">
                                        <div class="judge-button-area flex justify-center items-center text-white w-1/4">
                                            <button type="button" class="js-task-reset w-3/4 h-10 bg-custom-blue indent-[0.4em] tracking-[0.4em] rounded-full hover:bg-custom-blue">消す</button>
                                        </div>
                                    </div>
                                    {{-- 所持タスク数問わずフォームを５つ表示させるため --}}
                                    {{-- $iの初期値を０にするとタスク数が５個未満ときにフォームが消える --}}
                                    @for ($i = 1; $i < 5; $i++) 
                                        <div class="task flex justify-between items-center py-2">
                                            <input type="hidden" name="child_id" value="{{ $child->id }}">
                                            <input type="text" name="contents[]" class="task-name pl-2 tracking-[0.5em] w-4/5 border-1 rounded-lg text-xl @error('contents.' .$i) border-red-400 border-2 @enderror" value="{{ old('contents.' . $i) }}">
                                            <div class="judge-button-area flex justify-center items-center text-white w-1/4">
                                                <button type="button" class="js-task-reset w-3/4 h-10 bg-custom-blue indent-[0.4em] tracking-[0.4em] rounded-full hover:bg-custom-blue">消す</button>
                                            </div>
                                        </div>
                                    @endfor
                                    <button type="submit" class="block text-3xl text-white text-center font-bold bg-custom-pink mx-auto mt-5 py-4 px-6 rounded-full w-full max-w-2xl indent-[0.4em] tracking-[0.4em]">
                                        登録
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div data-panel="1" class="js-tab-panel1 flex flex-col justify-between bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 overflow-y-auto hidden">
                @csrf
                <ul>
                        <li>
                            <input type="text" name="contents[]" placeholder="25文字以内で入れてください" value="{{ old('contents.0')}}">
                        </li>
                    @for($i = 1; $i < 5; $i++)
                        <li>
                            <input type="text" name="contents[]" value="{{ old('contents.' . $i)}}">
                        </li>
                    @endfor
                </ul>
                <div class="button-area">
                    <button type="submit" class="create-button">新規登録</button>
                    <a class="button back-button" href="{{ route('tasks.index') }}">戻る</a>
                </div>
            </form>
                    </div>
                    <div data-panel="2" class="js-tab-panel1 hidden flex flex-col justify-between bg-white border-custom-gray text-center h-[60vh] border-2 overflow-y-auto">
                        {{-- <div class="mt-5 px-20 flex flex-col gap-4">
                            {{-- @for ($i = 0; $i < 5; $i++)
                                <div class="grid grid-cols-3 items-center py-3">
                                    <div class="tracking-[0.5em] text-left col-span-2">
                                        ゆいとテストテストテストテストテスト
                                        {{-- {{$task->contents}} --}}
                                    {{-- </div>
                                    <div class="flex justify-end items-center gap-2 text-white">
                                        <button class="w-24 h-10 bg-custom-pink rounded-full hover:bg-custom-pink/50">◯</button>
                                        <button class="w-24 h-10 bg-custom-blue rounded-full hover:bg-custom-blue/60">✖︎</button>
                                    </div>
                                </div> --}}
                            {{-- @endfor --}}
                        {{-- </div>
                        <button class="block text-3xl text-white text-center font-bold bg-yellow-400 mx-auto mt-10 py-4 px-6 rounded-full w-full max-w-2xl indent-[0.4em] tracking-[0.4em] disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            ★<span class="text-custom-gray">ごほうびガチャ</span>★
                        </button>
                        <div class="flex justify-center items-center gap-8 text-white text-lg font-bold py-2 mb-2">
                            <a href="#" class="w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60">約束の登録・編集</a>
                            <a href="#" class="w-[200px] px-4 py-2 bg-custom-pink border border-transparent rounded-full hover:bg-custom-pink/50 indent-[0.4em] tracking-[0.4em]">たからばこ</a>
                            <button id="reset-button" class="w-[200px] px-4 py-2 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/50 indent-[0.4em] tracking-[0.4em]">リセット</button>
                        </div>　 --}}
                    </div>
            </div>
        </main> 
    @include('components.my-footer')
    @push('scripts')
    <script type="module" src="{{ asset('js/create.js') }}"></script>
    @endpush
</x-app-layout>