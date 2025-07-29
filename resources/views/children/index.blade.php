<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-24 py-5 mx-auto">
                <div class="relative mb-20">
                    <h1 class="text-h1 font-bold text-center indent-[0.5em] tracking-[0.5em]">こども情報</h1>
                    <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white  text-xl px-6 py-2 indent-[0.4em] tracking-[0.4em] rounded-full hover:bg-green-400/50 shadow">
                        戻る
                    </a>
                </div>
                @if (session('success'))
                    <div class="text-center text-red-400 mb-2">{{ session('success')}}</div>
                @endif
                    <!-- こども表示部分 + ボタンエリア: 全体を白いカードで囲う -->
                <div class="bg-white border rounded-lg shadow p-10 max-w-2xl mx-auto flex flex-col min-h-[400px]">
                    <!-- 子ども情報エリア -->
                    <div class="flex-1 flex flex-col gap-6 justify-center items-center">
                        @foreach ($children as $child)
                            <div class="flex items-center text-center">
                                <p class="font-bold mb-2">{{ $child->child_name }}</p>
                                @if ($child->child_gender === 'girl')
                                    <span class="inline-block px-3 font-bold text-white bg-custom-pink rounded-full">女の子</span>
                                @elseif ($child->child_gender === 'boy')
                                    <span class="inline-block px-3 font-semibold text-white bg-custom-blue rounded-full">男の子</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- ボタンエリア（常に下に配置） -->
                    <div class="flex justify-center text-white font-bold text-center mt-10 gap-6">
                        <button type="button" 
                            class="update-btn font-bold bg-custom-pink w-[200px] px-6 py-2 rounded-full indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/60 shadow">
                            新規登録
                        </button>
                        <button type="button"
                            class="w-[200px] px-4 py-2 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60">
                            編集・削除
                        </button>
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