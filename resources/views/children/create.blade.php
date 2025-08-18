<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
            <div class="relative mb-20 sm:mb-16 md:mb-10 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">こども登録</h1>
                <a href="{{ route('children.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl font-bold px-3 sm:px-4 md:px-6 py-2 rounded-full hover:bg-green-400/50">
                    こども一覧
                </a>
            </div>

            @if ($errors->any())
                <div class="text-center text-red-400 font-bold">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- 常に表示するパネル --}}
            <div class="flex flex-col bg-white border-2 border-custom-gray p-6 sm:p-8 md:p-10 max-w-full sm:max-w-2xl md:max-w-3xl mx-auto min-h-[300px] mx-4 sm:mx-auto">
                <div class="flex-1 flex flex-col gap-6 items-center px-2">
                    @if($children->count() < 3)
                        {{-- 入力フォーム（3人未満の場合のみ表示） --}}
                        <form method="POST" action="{{ route('children.store') }}" class="w-full">
                            @csrf
                            <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-4 sm:gap-0">
                                <input type="text" 
                                       class="font-bold text-base indent-[0.2em] tracking-[0.2em] w-full sm:w-1/2 pl-2 border-2 rounded-lg order-1" 
                                       name="child_name" 
                                       value="{{ old('child_name')}}"
                                       placeholder="7文字以内で入力">
                                {{-- 性別選択ボタン --}}
                                <div class="flex justify-center sm:justify-end text-xl sm:text-base gap-2 sm:gap-4 w-full sm:w-auto order-2">
                                    <input type="hidden" name="child_gender" value="" id="gender">
                                    <button type="button"
                                            class="gender-btn px-4 sm:px-6 md:px-8 py-2 rounded-full font-bold text-white bg-gray-300 flex-1 sm:flex-none"
                                            data-gender="boy">
                                        男の子
                                    </button>
                                    <button type="button" 
                                            class="gender-btn px-4 sm:px-6 md:px-8 py-2 rounded-full font-bold text-white bg-gray-300 flex-1 sm:flex-none"
                                            data-gender="girl">
                                        女の子
                                    </button>
                                </div>
                            </div>
                           @endif
                            {{-- 登録状況表示（常に表示） --}}
                            <div class="flex-1 flex-col text-sm sm:text-lg text-center mt-8">
                                @if($children->count() < 3)
                                <p class="font-bold">お子さまは<span class="text-red-500">３人まで</span>登録できます</p>
                                @endif
                                <p class="text-gray-600">現在、{{ $children->count() }}人登録されています</p>
                                @if($children->count() >= 3)
                                    <p class="text-red-500 font-bold">登録上限に達しています</p>
                                @endif
                            </div>
                            {{-- 登録ボタン --}}
                            <div class="flex justify-center mt-10 w-full">
                                @if ($children->count() < 3)
                                <button type="submit" 
                                        class="text-white font-bold text-center bg-custom-pink w-[200px] px-6 py-2 rounded-full indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/60">
                                    登録
                                </button>
                                @else
                                <a href="{{ route('children.index') }}" class="text-white font-bold text-center bg-green-400 w-[200px] px-6 py-2 rounded-full hover:bg-green-400/50">
                                     こども一覧
                                </a>
                                @endif
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </main>
    @include('components.my-footer')
    <script type="module" src="{{ asset('js/modules/create-gender.js') }}"></script>
</x-app-layout>