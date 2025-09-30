{{-- @dd($selectedChild->id); --}}
<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
            <div class="relative  sm:mb-8 md:mb-0 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">たからばこ</h1>
                <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl px-3 sm:px-4 md:px-6 py-2 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-green-500 shadow">
                    戻る
                </a>
            </div> 
            <!-- タブ部分 -->
            @if($children->count() > 0)
                {{-- タブ切り替えボタン --}}
                <div class="flex flex-row justify-between sm:justify-center gap-1 sm:gap-4 text-white font-medium z-10 relative">
                    @foreach ($children as $index => $child)
                        <button data-tab="{{ $index }}" data-child-id="{{ $child->id }}" class="js-tab-button flex-1 sm:flex-none sm:w-[180px] md:w-[216px] px-2 sm:px-6 py-2 rounded-t-lg {{ $index === 0 ? 'bg-custom-pink' : 'bg-custom-blue '}} text-xs sm:text-base">{{ $child->child_name }}</button>
                    @endforeach
                </div>
                {{-- カレンダー表示エリア --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if($selectedChild)
                            <div id="calendar"></div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </main> 
    @include('components.my-footer')
    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    {{-- PHP側で取得した$selectedChild->idをreward-calendar.jsに渡す --}}
    <script>
        // グローバル変数として設定
        window.currentChildId = {{ $selectedChild->id ?? 'null' }};
    </script>
    <script type="module" src="{{ asset('js/modules/rewards-calendar.js') }}"></script>
    @endpush
    @livewire('reward-modal')
</x-app-layout>
