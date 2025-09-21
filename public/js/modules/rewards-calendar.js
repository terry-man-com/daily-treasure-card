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
        console.log(this.currentChildId);
    }
    initializeCalendar() {
        const calendarEl = document.getElementById("calendar");
        if (!calendarEl) return;

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
            events: (info, successCallback, failureCallback) => {
                if (!this.currentChildId) {
                    successCallback([]);
                    return;
                }

                fetch(
                    `/api/rewards/28/events?start=${info.startStr}&end=${info.endStr}`,
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
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `HTTP error! status: ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        console.log("Events loaded:", data);
                        successCallback(data);
                    })
                    .catch((error) => {
                        console.error("Error loading events:", error);
                        failureCallback(error);
                    });
            },
            eventContent: (arg) => {
                // ガチャ実行日のみflower-stampを表示
                const hasGacha = arg.event.extendedProps.hasGacha;
                const rarity =
                    arg.event.extendedProps.rarity?.rarity_name || "fail";

                if (hasGacha) {
                    return {
                        html: `
                            <div class="gacha-stamp-container stamp-bg-${rarity}">
                                <img src="/images/stamp-card-items/flower-stamp.png" 
                                     class="flower-stamp" 
                                     alt="ガチャ実績">
                            </div>
                        `,
                    };
                }
                return null; // ガチャなしの日は何も表示しない
            },
            eventClick: (info) => {
                this.showRewardDetail(info.event);
            },
        });

        this.calendar.render();
    }

    switchChild(childId) {
        this.currentChildId = childId;

        // タブの表示を更新
        document.querySelectorAll(".child-tab").forEach((tab) => {
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

    showRewardDetail(event) {
        // Livewireイベントを発火（後でLivewireモーダルと連携）
        const item = event.extendedProps.item;
        const earnedAt = event.extendedProps.earned_at;

        // 一時的に既存のモーダル表示を使用
        const modal = document.getElementById("reward-modal");
        const title = document.getElementById("modal-title");
        const content = document.getElementById("modal-content");

        const earnedDate = new Date(earnedAt);
        title.textContent = `${earnedDate.toLocaleDateString("ja-JP")} の景品`;

        content.innerHTML = `
            <img src="${item.item_image_path}" alt="${item.item_name}"
                 class="w-32 h-32 mx-auto mb-4 rounded-lg shadow-lg">
            <h4 class="text-lg font-bold mb-2">${item.item_name}</h4>
            <p class="text-sm text-gray-600 mb-2">レアリティ: ${this.getRarityDisplayName(
                item.rarity.rarity_name
            )}</p>
            <p class="text-sm text-gray-600">カテゴリ: ${
                item.category.category_name
            }</p>
            <p class="text-xs text-gray-400 mt-2">獲得時刻: ${earnedDate.toLocaleTimeString(
                "ja-JP"
            )}</p>
        `;

        modal.classList.remove("hidden");
    }

    getRarityDisplayName(rarity) {
        const rarityNames = {
            perfect: "★★★ パーフェクト！",
            partial: "★★ がんばった！",
            fail: "★ またあした！",
        };
        return rarityNames[rarity] || rarity;
    }

    closeRewardModal() {
        document.getElementById("reward-modal").classList.add("hidden");
    }
}

// グローバル関数として公開（HTMLから呼び出し可能にするため）
window.switchChild = function (childId) {
    if (window.rewardsCalendar) {
        window.rewardsCalendar.switchChild(childId);
    }
};

window.closeRewardModal = function () {
    if (window.rewardsCalendar) {
        window.rewardsCalendar.closeRewardModal();
    }
};

// ESCキーでモーダルを閉じる
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        window.closeRewardModal();
    }
});

// DOMContentLoadedで初期化
document.addEventListener("DOMContentLoaded", function () {
    window.rewardsCalendar = new RewardsCalendar();
});
