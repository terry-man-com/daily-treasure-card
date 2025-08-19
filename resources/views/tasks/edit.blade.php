<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex flex-grow">
            <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
                <div class="relative mb-10 sm:mb-8 md:mb-0 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                    <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">おやくそく編集</h1>
                    <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl px-3 sm:px-4 md:px-6 py-2 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-green-500 shadow">
                        戻る
                    </a>
                </div>
                {{-- 成功メッセージ --}}
                @if (session('success'))
                    <div class="text-center pb-2 text-red-400 font-bold">{{ session('success')}}</div>
                @endif
                {{-- エラーメッセージ --}}
                @error("contents")
                    <div class="text-center pb-2 text-red-400 font-bold">{{ $message }}</div>
                @enderror
                @error("contents.*")
                    <div class="text-center pb-2 text-red-400 font-bold">{{ $message }}</div>
                @enderror
                <!-- タブ部分 -->
                @if($children->count() > 0)
                    {{-- タブ切り替えボタン --}}
                    <div class="flex flex-row justify-between sm:justify-center gap-1 sm:gap-4 text-white font-medium z-10 relative">
                        @foreach ($children as $index => $child)
                            <button data-tab="{{ $index }}" class="js-tab-button flex-1 sm:flex-none sm:w-[180px] md:w-[216px] px-2 sm:px-6 py-2 rounded-t-lg {{ $index === 0 ? 'bg-custom-pink' : 'bg-custom-blue '}} text-xs sm:text-base">{{ $child->child_name }}</button>
                        @endforeach
                    </div>
                    <!-- タスク表示部分 -->
                    @foreach ($children as $panelIndex => $child)
                        <div data-panel="{{ $panelIndex }}" class="js-tab-panel1 {{ $panelIndex === 0 ? '' : 'hidden' }} flex flex-col bg-gray-100 border-custom-gray text-center font-medium h-[60vh] px-4 lg:px-20 py-6 sm:py-8 md:py-10 border-2 overflow-y-auto relative z-0">
                            {{-- 更新用フォーム --}}
                            <form id="update-form-{{ $child->id }}" method="POST" action="{{ route('tasks.bulkUpdate') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="child_id" value="{{ $child->id }}">
                                <input type="hidden" name="update_ids" id="update_ids_{{ $child->id }}">
                            </form>
                            {{-- 削除用フォーム --}}
                            <form id="delete-form-{{ $child->id }}" method="POST" action="{{ route('tasks.bulkDelete') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="delete_ids" id="delete_ids_{{ $child->id }}">
                            </form>
                            {{-- タスク一覧（上寄せ） --}}
                            <div class="flex flex-col gap-4 px-2 sm:px-8 md:px-12 lg:px-20 flex-1">
                                @foreach ($child->tasks as $task)
                                <div class="flex flex-col sm:flex-row justify-center items-center py-2 gap-3 sm:gap-6 bg-white sm:bg-transparent p-3 sm:p-0">
                                    <input type="checkbox" class="task-checkbox w-5 sm:w-6 h-5 sm:h-6 accent-gray-400 order-2 sm:order-1" value="{{ $task->id }}">
                                    <input type="text" form="update-form-{{ $child->id }}" name="contents[{{ $task->id }}]" class="task-name pl-2 tracking-[0.2em] sm:tracking-[0.5em] w-full sm:w-4/5 border-1 text-base font-bold order-1 sm:order-2 rounded-lg @error('contents.' .$task->id) border-red-400 border-2 @enderror" value="{{ $task->contents }}">
                                </div>
                                @endforeach
                            </div>
                            {{-- ボタンエリア（下部固定） --}}
                            <div class="flex flex-col sm:flex-row justify-center items-center text-white text-base font-bold text-center mt-6 sm:mt-10 gap-4 sm:gap-6">
                                <button type="button" 
                                    class="update-btn font-bold bg-green-400 w-4/5 sm:w-[200px] px-4 py-2 rounded-full indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] hover:bg-green-400/60 text-center">
                                    更新
                                </button>
                                <button type="button"
                                    class="delete-btn w-4/5 sm:w-[200px] px-4 py-2 bg-red-400 border border-transparent rounded-full hover:bg-red-400/60 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] text-center">
                                    削除
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- 子どもが登録されていない場合のデフォルトパネル -->
                    <div data-panel="0" class="js-tab-panel1 flex flex-col justify-center items-center bg-gray-100 border-custom-gray text-center font-medium h-[60vh] border-2 overflow-y-auto">
                        <div class="flex items-center justify-center h-full">
                            <p class="text-xl text-custom-gray">まずは「こども管理」からお子さまを登録してください</p>
                        </div>
                    </div>
                @endif
        </main> 
    @include('components.my-footer')
    @push('scripts')
    <script type="module" src="{{ asset('js/modules/delete.js') }}"></script>
    @endpush
    @livewire('delete-confirm-modal')
    @livewire('child-manage-modal')
</x-app-layout>