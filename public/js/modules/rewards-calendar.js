// リワードページ専用JavaScript - FullCalendar機能

class RewardsCalendar {
    constructor() {
        this.calendar = null;
        this.currentChildId = null;
        this.init();
    }

    init() {
        // currentChildIdをグローバル変数から取得
        if (window.currentChildId) {
            this.currentChildId = window.currentChildId;
            this.initializeCalendar();
        }
    }

    initializeCalendar() {
        const calendarEl = document.getElementById("calendar");
        if (!calendarEl) return;
        // カレンダーの初期設定
        this.calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            locale: "ja",
            fixedWeekCount: false,
            showNonCurrentDates: false,
            headerToolbar: {
                left: "prev",
                center: "title",
                right: "next",
            },

            // カレンダーを表示後の処理
            // RewardControllerのgetEventsを叩きにいき
            // 成功すれば、successCallbackに返り値を格納、失敗すれば何も返さない。
            events: (info, successCallback, failureCallback) => {
                if (!this.currentChildId) {
                    successCallback([]);
                    return;
                }

                fetch(
                    `/api/rewards/${this.currentChildId}/events?start=${info.startStr}&end=${info.endStr}`,
                    {
                        method: "GET",
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                        credentials: "same-origin",
                    }
                )
                    // HTTPレスポンスを確認し、RewardControllerからのJSONデータを抽出する
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! status: ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    // 実際のデータ（当月のガチャ情報を抽出し、successCallbackに代入する）
                    .then((data) => {
                        console.log("Events loaded:", data);
                        successCallback(data);
                    })
                    .catch((error) => {
                        console.error("Error loading events:", error);
                        failureCallback(error);
                    });
            },
            // 各日付の処理を記載
            // 今回はガチャ実施日にアイテムを表示する。
            eventContent: (arg) => {
                // 獲得したアイテムをそのまま表示
                const hasGacha = arg.event.extendedProps.hasGacha;
                const item = arg.event.extendedProps.item;

                if (hasGacha && item) {
                    return {
                        html: `
                            <div class="item-container">
                                <img src="${item.item_image_path}" 
                                     class="item-image" 
                                     alt="${item.item_name}"
                                     title="${item.item_name}">
                            </div>
                        `,
                    };
                }
                return null; // ガチャなしの日は何も表示しない
            },
            eventClick: (info) => {
                // Livewireイベントを発火
                const item = info.event.extendedProps.item;
                const earnedAt = info.event.extendedProps.earned_at;

                // プロパティを直接設定

                Livewire.dispatch("show-reward-modal", {
                    item: item,
                    earnedAt: earnedAt,
                });
            },
        });

        this.calendar.render();
    }

    switchChild(childId) {
        this.currentChildId = childId;

        // タブの表示を更新
        document.querySelectorAll(".js-tab-button").forEach((tab) => {
            tab.classList.remove("bg-custom-pink", "active");
            tab.classList.add("bg-custom-blue");
        });
        document
            .querySelector(`[data-child-id="${childId}"]`)
            .classList.remove("bg-custom-blue");
        document
            .querySelector(`[data-child-id="${childId}"]`)
            .classList.add("bg-custom-pink", "active");

        // カレンダーを再読み込み
        if (this.calendar) {
            this.calendar.refetchEvents();
        }
    }
}

// DOMContentLoadedで初期化
document.addEventListener("DOMContentLoaded", function () {
    window.rewardsCalendar = new RewardsCalendar();

    // タブ切り替えイベントを追加
    document.querySelectorAll(".js-tab-button").forEach((button) => {
        button.addEventListener("click", () => {
            const childId = parseInt(button.dataset.childId);
            const tabIndex = parseInt(button.dataset.tab);

            // カレンダーを切り替え
            window.rewardsCalendar.switchChild(childId);

        });
    });
});
