<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
            <div class="relative mb-20 sm:mb-16 md:mb-10 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">こども編集</h1>
                <a href="{{ route('children.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl font-bold px-3 sm:px-4 md:px-6 py-2 rounded-full hover:bg-green-400/50">
                    こども一覧
                </a>
            </div>

            @if (session('error'))
                <div class="text-center text-red-400 mb-2">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="text-center text-red-400 mb-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                    <!-- こども表示部分 + ボタンエリア: 全体を白いカードで囲う -->
                    <!-- 子ども情報エリア -->
                    <form method="POST" action="{{ route('children.update') }}" class="flex flex-col bg-white border-2 border-custom-gray p-10 max-w-3xl mx-auto min-h-[400px]">
                        @csrf
                        @method("PUT")
                        <div class="flex-1 flex flex-col gap-6 items-center px-2">
                            @foreach ($children as $index => $child)
                            <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4 sm:gap-0">
                                <input type="text" class="font-bold text-base indent-[0.2em] tracking-[0.2em] w-full sm:w-1/2 pl-2 border-2 rounded-lg order-1 @error('children.' . $child->id . '.child_name') border-red-400 border-2 @enderror" name="children[{{ $child->id }}][child_name]" value="{{ $child->child_name }}"></input>
                                {{-- 性別選択ボタン --}}
                                <div class="flex justify-center sm:justify-end text-xl sm:text-base gap-2 sm:gap-4 w-full sm:w-auto order-2">
                                    <input type="hidden" name="children[{{ $child->id }}][gender]" value="{{ $child->child_gender }}" id="gender_{{ $child->id }}">
                                    <button type="button"
                                            class="gender-btn px-4 sm:px-6 md:px-8 py-2 rounded-full font-bold text-white flex-1 sm:flex-none {{ $child->child_gender === 'boy' ? 'bg-custom-blue' : 'bg-gray-300' }}"
                                            data-index="{{ $child->id }}"
                                            data-gender="boy">
                                        男の子
                                    </button>
                                    <button type="button" 
                                            class="gender-btn px-4 sm:px-6 md:px-8 py-2 rounded-full font-bold text-white flex-1 sm:flex-none {{ $child->child_gender === 'girl' ? 'bg-custom-pink' : 'bg-gray-300' }}"
                                            data-index="{{ $child->id }}"
                                            data-gender="girl">
                                        女の子
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    <!-- ボタンエリア（常に下に配置） -->
                        <div class="flex justify-center mt-0 sm:mt-10">
                            <button type="submit"
                                class="text-white font-bold text-center mt-10  bg-custom-pink w-[200px] px-6 py-2 rounded-full indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/60">
                                更新
                            </button>
                        </div>
                    </form>
        </div>
    </main>
    @include('components.my-footer')
    <script type="module" src="{{ asset('js/modules/update-gender.js') }}"></script>
</x-app-layout> 