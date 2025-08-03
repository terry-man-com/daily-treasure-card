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
                <div class="flex flex-col bg-white border-2 border-custom-gray p-10 max-w-lg mx-auto min-h-[400px]">
                    <!-- 子ども情報エリア -->
                    <div class="flex-1 flex flex-col gap-6 items-center px-2">
                        @foreach ($children as $child)
                            <div class="flex justify-between items-center w-full">
                                <p class="font-bold indent-[0.2em] tracking-[0.2em]">{{ $child->child_name}}</p>
                                <div class="flex flex-end items-center gap-5">
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
                    <div class="flex justify-between text-white font-bold text-center mt-10">
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