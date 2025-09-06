class GachaAnimationSystem {
    constructor() {
        this.init();
    }

    init() {
        console.log("🎬 GachaAnimationSystem initialized");

        // 即座にイベントリスナーを設定
        if (typeof Livewire !== "undefined") {
            console.log("🔗 Setting up Livewire event listeners immediately");
            this.setupEventListeners();
        }

        // Livewire初期化後にも設定（保険）
        document.addEventListener("livewire:init", () => {
            console.log("🔗 Livewire initialized, setting up event listeners");
            this.setupEventListeners();
        });
    }

    setupEventListeners() {
        // Livewire v3 の正しい形式
        document.addEventListener("triggerGachaAnimation", (event) => {
            console.log(
                "🎯 triggerGachaAnimation event received:",
                event.detail
            );
            this.handleGachaAnimation(event.detail);
        });

        // 旧形式も試行（保険）
        if (typeof Livewire !== "undefined" && Livewire.on) {
            Livewire.on("triggerGachaAnimation", (data) => {
                console.log(
                    "🎯 triggerGachaAnimation event received (old format):",
                    data
                );
                this.handleGachaAnimation(data);
            });
        }
    }

    async handleGachaAnimation(data) {
        console.log("🎮 handleGachaAnimation called with:", data);
        const { step, childId, trueCount, totalTasks } = data;

        switch (step) {
            case "start":
                console.log("🎬 Starting gacha machine animation");
                await this.showGachaMachine();
                console.log("🎭 Starting excitement animation");
                await this.playExcitementAnimation();

                // ✅ RewardController API呼び出し
                try {
                    const response = await fetch("/gacha/draw", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                        body: JSON.stringify({
                            child_id: childId,
                            true_count: trueCount,
                            total_tasks: totalTasks,
                        }),
                    });

                    const result = await response.json();
                    console.log("🎉 API response received:", result);

                    // カプセルアニメーション開始
                    await this.showCapsuleAnimation(result.rarity);

                    // 結果を直接表示（シンプルアプローチ）
                    this.showResultDirectly(result);
                } catch (error) {
                    console.error("ガチャAPIエラー:", error);
                    Livewire.dispatch("showError", {
                        message: "ガチャの実行中にエラーが発生しました",
                    });
                }
                break;

            case "capsule":
                await this.showCapsuleAnimation(data.rarity);

                // Livewireに結果表示を通知
                Livewire.dispatch("triggerAnimation", { step: "result" });
                break;
        }
    }

    // 🎬 Step 1: ガチャマシン表示
    async showGachaMachine() {
        // DOM要素が表示されるまで少し待つ
        await new Promise((resolve) => setTimeout(resolve, 100));

        const machine = document.querySelector(".gacha-machine");
        console.log("🔍 Machine element found:", machine);
        console.log(
            "🔍 All gacha-related elements:",
            document.querySelectorAll('[class*="gacha"]')
        );

        if (!machine) {
            console.error("❌ .gacha-machine element not found!");
            console.log(
                "🔍 Modal container:",
                document.querySelector('[wire\\:click\\.self="closeModal"]')
            );
            return;
        }

        // 初期状態を設定
        machine.style.transform = "scale(0)";
        machine.style.opacity = "0";

        // マシン登場アニメーション
        console.log("🎬 Starting machine appearance animation");
        await anime({
            targets: machine,
            scale: [0, 1],
            opacity: [0, 1],
            duration: 800,
            easing: "easeOutBack",
        }).finished;
        console.log("✅ Machine animation completed");
    }

    // 🎬 Step 2: ワクワク演出
    async playExcitementAnimation() {
        const machine = document.querySelector(".gacha-machine");

        // 小刻みに揺れる
        await anime({
            targets: machine,
            translateX: [0, -5, 5, -3, 3, 0],
            translateY: [0, -2, 2, -1, 1, 0],
            duration: 1500,
            easing: "easeInOutQuad",
        }).finished;
    }

    // 🎬 Step 3: カプセル出現・消失
    async showCapsuleAnimation(rarity) {
        const capsule = document.querySelector(".gacha-capsule");
        const rarityColors = {
            perfect: "#FFD700",
            partial: "#87CEEB",
            fail: "#DDA0DD",
        };

        // カプセルの色を設定
        capsule.style.backgroundColor = rarityColors[rarity];
        capsule.classList.remove("hidden");

        // カプセル出現（回転しながら落下）
        await anime({
            targets: capsule,
            translateY: [-100, 0],
            rotate: "2turn",
            scale: [0, 1],
            opacity: [0, 1],
            duration: 1200,
            easing: "easeOutBounce",
        }).finished;

        // 少し待つ
        await new Promise((resolve) => setTimeout(resolve, 800));

        // カプセル消失（フェードアウト）
        await anime({
            targets: capsule,
            scale: [1, 0],
            opacity: [1, 0],
            duration: 600,
            easing: "easeInQuad",
        }).finished;

        capsule.classList.add("hidden");
    }

    // レアリティ別エフェクト
    playRarityEffect(rarity) {
        const resultArea = document.querySelector(".gacha-result");

        if (rarity === "perfect") {
            // ゴールドの輝き
            anime({
                targets: resultArea,
                boxShadow: [
                    "0 0 20px rgba(255, 215, 0, 0.8)",
                    "0 0 40px rgba(255, 215, 0, 0.4)",
                    "0 0 20px rgba(255, 215, 0, 0.8)",
                ],
                duration: 2000,
                direction: "alternate",
                loop: true,
            });
        } else if (rarity === "partial") {
            // ブルーのパルス
            anime({
                targets: resultArea,
                scale: [1, 1.05, 1],
                duration: 1500,
                direction: "alternate",
                loop: 3,
            });
        }
    }

    // 純粋なJavaScriptで結果を直接表示
    showResultDirectly(result) {
        console.log("🎯 Showing result directly with JavaScript");

        // 既存の結果表示エリアを探す
        const resultArea = document.querySelector(".gacha-result");
        if (resultArea) {
            // 既存の結果エリアを更新
            this.updateResultContent(resultArea, result);
        } else {
            // 新しい結果エリアを作成
            this.createResultModal(result);
        }
    }

    updateResultContent(resultArea, result) {
        // 画像を更新
        const itemImage = resultArea.querySelector(".result-item-image");
        if (itemImage) {
            itemImage.src = result.item.item_image_path;
            itemImage.alt = result.item.item_name;
        }

        // テキストを更新
        const itemName = resultArea.querySelector("h3");
        if (itemName) itemName.textContent = result.item.item_name;

        const rarityDisplay = resultArea.querySelector(".text-lg");
        if (rarityDisplay) {
            const rarityNames = {
                perfect: "★★★ パーフェクト！",
                partial: "★★ がんばった！",
                fail: "★ またあした！",
            };
            rarityDisplay.textContent =
                rarityNames[result.rarity] || result.rarity;
        }

        const message = resultArea.querySelector(".text-sm");
        if (message) message.textContent = result.message;

        console.log("✅ Result content updated successfully");
    }

    createResultModal(result) {
        // モーダルコンテナを取得
        const modalContainer = document.querySelector(
            '[wire\\:click\\.self="closeModal"]'
        );
        if (!modalContainer) {
            console.error("❌ Modal container not found");
            return;
        }

        // 既存のコンテンツを非表示
        const existingContent = modalContainer.children;
        for (let child of existingContent) {
            child.style.display = "none";
        }

        // 結果表示HTMLを作成
        const resultHTML = this.createResultHTML(result);
        modalContainer.insertAdjacentHTML("beforeend", resultHTML);

        console.log("✅ Result modal created successfully");
    }

    createResultHTML(result) {
        const rarityNames = {
            perfect: "★★★ パーフェクト！",
            partial: "★★ がんばった！",
            fail: "★ またあした！",
        };

        return `
            <div class="gacha-result bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
                <h2 class="text-3xl font-bold mb-6 text-custom-gray">おめでとう！</h2>
                
                <div class="relative mb-6">
                    <img src="${result.item.item_image_path}" 
                         alt="${result.item.item_name}"
                         class="result-item-image w-40 h-40 mx-auto rounded-lg shadow-lg">
                </div>
                
                <h3 class="text-2xl font-bold mb-3 text-custom-gray">${
                    result.item.item_name
                }</h3>
                <p class="text-lg mb-3 font-semibold">${
                    rarityNames[result.rarity] || result.rarity
                }</p>
                <p class="text-sm text-gray-600 mb-6">${result.message}</p>
                
                <div class="flex gap-4 justify-center">
                    <button onclick="this.closeGachaModal()" 
                            class="bg-custom-pink text-white px-6 py-3 rounded-full hover:bg-custom-pink/80 font-bold">
                        戻る
                    </button>
                    <button onclick="window.location.href='/rewards'" 
                            class="bg-custom-blue text-white px-6 py-3 rounded-full hover:bg-custom-blue/80 font-bold">
                        たからばこを見る
                    </button>
                </div>
            </div>
        `;
    }

    closeGachaModal() {
        const modalContainer = document.querySelector(
            '[wire\\:click\\.self="closeModal"]'
        );
        if (modalContainer) {
            modalContainer.style.display = "none";
        }
    }
}

// 初期化
document.addEventListener("DOMContentLoaded", () => {
    new GachaAnimationSystem();
});
