<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
                <div class="relative mb-20 sm:mb-16 md:mb-10 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                    <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">こども情報</h1>
                    <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl px-3 sm:px-4 md:px-6 py-2 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-green-400/50 shadow">
                        戻る
                    </a>
                </div>
                @if (session('success'))
                    <div class="text-center text-red-400 font-bold">{{ session('success')}}</div>
                @endif

                <!-- こども表示部分 + ボタンエリア: 全体を白いカードで囲う -->
                <div class="flex flex-col bg-white border-2 border-custom-gray p-6 sm:p-8 md:p-10 max-w-full sm:max-w-lg mx-auto min-h-[400px] mx-4 sm:mx-auto">
                    <!-- 子ども情報エリア -->
                    <div class="flex-1 flex flex-col gap-6 items-center px-2">
                        @foreach ($children as $child)
                            <div class="flex flex-col sm:flex-row justify-between items-center w-full gap-3 sm:gap-0">
                                <p class="font-bold indent-[0.2em] tracking-[0.2em] text-center sm:text-left">{{ $child->child_name}}</p>
                                <div class="flex justify-center items-center gap-5 text-xl sm:text-base">
                                    @if ($child->child_gender === 'girl')
                                        <span class="inline-block px-8 py-1.5 font-bold text-white bg-custom-pink rounded-full">女の子</span>
                                    @elseif ($child->child_gender === 'boy')
                                        <span class="inline-block px-8 py-1.5 font-bold text-white bg-custom-blue rounded-full">男の子</span>
                                    @endif
                                    <form method="POST" action="{{ route('children.destroy', $child) }}" onsubmit="return confirm('削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ボタンエリア（常に下に配置） -->
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-3 sm:gap-0 text-white text-xl sm:text-base font-bold text-center mt-10 ">
                        <a href="{{ route('children.create')}}" 
                            class="update-btn font-bold bg-custom-pink w-[200px] px-6 py-2 rounded-full indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/60">
                            新規登録
                        </a>
                        <a href="{{ route('children.edit') }}"
                            class="font-bold bg-green-400 w-[200px] px-4 py-2 rounded-full indent-[0.6em] tracking-[0.6em] hover:bg-green-400/60">
                            編集
                        </a>
                    </div>
                </div>
            </div>
        </main> 
    @include('components.my-footer')
    @push('scripts')
    <script type="module" src="{{ asset('js/modules/delete.js') }}"></script>
    @endpush
    @livewire('child-manage-modal')

</x-app-layout>