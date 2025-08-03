<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-24 py-5 mx-auto">
            <div class="relative mb-20">
                <h1 class="text-h1 font-bold text-center indent-[0.5em] tracking-[0.5em]">こども編集</h1>
                <a href="{{ route('children.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white font-bold text-xl px-6 py-2 rounded-full hover:bg-green-400/50">
                    こども一覧
                </a>
            </div>

            @if (session('success'))
                <div class="text-center text-green-400 mb-2">{{ session('success') }}</div>
            @endif

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
                <div class="flex flex-col bg-white border-2 border-custom-gray p-10 max-w-3xl mx-auto min-h-[400px]">
                    <!-- 子ども情報エリア -->
                    <form method="POST" action="{{ route('children.update') }}" class="flex flex-col flex-between">
                        @csrf
                        @method("PUT")
                        <div class="flex-1 flex flex-col gap-6 items-center px-2">
                            @foreach ($children as $index => $child)
                            <div class="flex justify-between items-center w-full">
                                <input type="text" class="font-bold text-base indent-[0.2em] tracking-[0.2em] w-1/2 pl-2 border-2 rounded-lg @error('children.' . $child->id . '.child_name') border-red-400 border-2 @enderror" name="children[{{ $child->id }}][child_name]" value="{{ $child->child_name }}"></input>
                                {{-- 性別選択ボタン --}}
                                <div class="flex flex-end gap-4">
                                    <input type="hidden" name="children[{{ $child->id }}][gender]" value="{{ $child->child_gender }}" id="gender_{{ $child->id }}">
                                    <button type="button"
                                            class="gender-btn px-8 py-2 rounded-full font-bold text-white {{ $child->child_gender === 'boy' ? 'bg-custom-blue' : 'bg-gray-300' }}"
                                            data-index="{{ $child->id }}"
                                            data-gender="boy">
                                        男の子
                                    </button>
                                    <button type="button" 
                                            class="gender-btn px-8 py-2 rounded-full font-bold text-white {{ $child->child_gender === 'girl' ? 'bg-custom-pink' : 'bg-gray-300' }}"
                                            data-index="{{ $child->id }}"
                                            data-gender="girl">
                                        女の子
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    <!-- ボタンエリア（常に下に配置） -->
                        <div class="flex justify-center mt-10">
                            <button type="submit"
                                class="text-white font-bold text-center mt-10  bg-custom-pink w-2/5 px-6 py-2 rounded-full indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/60">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
        </div>
    </main>
    @include('components.my-footer')
    <script type="module" src="{{ asset('js/modules/gender.js') }}"></script>
</x-app-layout> 