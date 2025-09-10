<x-app-layout>
    @include('components.task-header')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('たからばこ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- 子ども選択タブ --}}
            @if($children->count() > 0)
                <div class="mb-6">
                    <div class="flex space-x-2 overflow-x-auto">
                        @foreach($children as $index => $child)
                            <button 
                                data-child-id="{{ $child->id }}"
                                class="child-tab px-4 py-2 rounded-full text-white whitespace-nowrap
                                    {{ $child->id === $selectedChild?->id ? 'bg-custom-pink active' : 'bg-custom-blue' }}"
                                onclick="switchChild({{ $child->id }})">
                                {{ $child->child_name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- カレンダー表示エリア --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($selectedChild)
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold">{{ $selectedChild->child_name }}の宝物カレンダー</h3>
                        </div>
                        <div id="calendar"></div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">子どもが登録されていません</p>
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline">
                                子どもを登録する
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 景品詳細モーダル --}}
            <div id="reward-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 max-w-md mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-xl font-bold"></h3>
                        <button onclick="closeRewardModal()" class="text-gray-500 hover:text-gray-700 text-2xl">✕</button>
                    </div>
                    <div id="modal-content" class="text-center"></div>
                    <div class="flex justify-center mt-6">
                        <button onclick="closeRewardModal()" 
                                class="bg-custom-pink text-white px-6 py-2 rounded-full hover:bg-custom-pink/80">
                            閉じる
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        .fc-event-title { font-size: 12px; }
        .rarity-perfect { background-color: #FFD700 !important; border-color: #FFD700 !important; }
        .rarity-partial { background-color: #87CEEB !important; border-color: #87CEEB !important; }
        .rarity-fail { background-color: #DDA0DD !important; border-color: #DDA0DD !important; }
    </style>
    @endpush

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        let calendar;
        let currentChildId = {{ $selectedChild->id ?? 'null' }};

        document.addEventListener('DOMContentLoaded', function() {
            if (currentChildId) {
                initializeCalendar();
            }
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ja',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                events: function(info, successCallback, failureCallback) {
                    if (!currentChildId) {
                        successCallback([]);
                        return;
                    }

                    fetch(`/api/rewards/${currentChildId}/events?start=${info.startStr}&end=${info.endStr}`)
                        .then(response => response.json())
                        .then(data => {
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error loading events:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    showRewardDetail(info.event);
                },
                eventClassNames: function(arg) {
                    return [`rarity-${arg.event.extendedProps.rarity.rarity_name}`];
                }
            });

            calendar.render();
        }

        function switchChild(childId) {
            currentChildId = childId;

            // タブの表示を更新
            document.querySelectorAll('.child-tab').forEach(tab => {
                tab.classList.remove('bg-custom-pink', 'active');
                tab.classList.add('bg-custom-blue');
            });
            document.querySelector(`[data-child-id="${childId}"]`).classList.remove('bg-custom-blue');
            document.querySelector(`[data-child-id="${childId}"]`).classList.add('bg-custom-pink', 'active');

            // カレンダーを再読み込み
            if (calendar) {
                calendar.refetchEvents();
            }
        }

        function showRewardDetail(event) {
            const modal = document.getElementById('reward-modal');
            const title = document.getElementById('modal-title');
            const content = document.getElementById('modal-content');

            const item = event.extendedProps.item;
            const rarity = event.extendedProps.rarity;
            const earnedAt = new Date(event.extendedProps.earned_at);

            title.textContent = `${earnedAt.toLocaleDateString('ja-JP')} の景品`;

            content.innerHTML = `
                <img src="${item.item_image_path}" alt="${item.item_name}"
                     class="w-32 h-32 mx-auto mb-4 rounded-lg shadow-lg">
                <h4 class="text-lg font-bold mb-2">${item.item_name}</h4>
                <p class="text-sm text-gray-600 mb-2">レアリティ: ${getRarityDisplayName(rarity.rarity_name)}</p>
                <p class="text-sm text-gray-600">カテゴリ: ${item.category.category_name}</p>
                <p class="text-xs text-gray-400 mt-2">獲得時刻: ${earnedAt.toLocaleTimeString('ja-JP')}</p>
            `;

            modal.classList.remove('hidden');
        }

        function closeRewardModal() {
            document.getElementById('reward-modal').classList.add('hidden');
        }

        function getRarityDisplayName(rarity) {
            const rarityNames = {
                'perfect': '★★★ パーフェクト！',
                'partial': '★★ がんばった！',
                'fail': '★ またあした！'
            };
            return rarityNames[rarity] || rarity;
        }

        // ESCキーでモーダルを閉じる
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRewardModal();
            }
        });
    </script>
    @endpush
</x-app-layout>
