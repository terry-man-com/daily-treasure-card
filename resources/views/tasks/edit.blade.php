<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-24 py-5 mx-auto">
                <div class="relative mb-10">
                    <h1 class="text-h1 font-bold text-center indent-[0.5em] tracking-[0.5em]">おやくそく編集</h1>
                    <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white  text-xl px-6 py-2 indent-[0.4em] tracking-[0.4em] rounded-full hover:bg-green-400/50 shadow">
                        戻る
                    </a>
                </div>
                @if (session('success'))
                    <div class="message">{{ session('success')}}</div>
                @endif
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
                                        @foreach ($child->tasks as $task)
                                        <div class="flex justify-center items-center py-2 gap-6">
                                            <input type="hidden" name="child_id" value="{{ $child->id }}">
                                            <input type="checkbox" class="task-checkbox w-6 h-6 accent-gray-400" value="{{ $task->id }}">
                                            <input type="type" name="contents[]" class="task-name pl-2 tracking-[0.5em] w-4/5 border-2" value="{{ $task->contents }}">
                                        </div>
                                        @endforeach
                                    <div class="flex justify-center text-white font-bold text-center mt-10 gap-6">
                                        <button type="submit" class="font-bold bg-green-400 w-2/5 px-6 py-2 rounded-full indent-[0.4em] tracking-[0.4em] hover:bg-green-400/60 shadow">
                                            更新
                                        </button>
                                        <button type="button" onclick="openDeleteModal()" class="w-[300px] px-4 py-2 bg-red-400 border border-transparent rounded-full hover:bg-red-400/60">削除</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
        </main> 
    @include('components.my-footer')
        @push('scripts')
    <script type="module" src="{{ asset('js/modules/delete.js') }}"></script>
    @endpush
    @livewire('delete-confirm-modal')
</x-app-layout>