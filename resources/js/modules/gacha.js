import axios from "axios";

class GachaAnimationSystem {
    constructor() {
        this.setupAxios();
        this.setupEventListeners();
    }

    setupAxios() {
        // CSRFトークンを自動設定
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
        }
    }

    setupEventListeners() {
        document.addEventListener("triggerGachaAnimation", (event) => {
            this.handleGachaAnimation(event.detail);
        });
    }

    async handleGachaAnimation(data) {
        const { childId, trueCount, totalTasks } = data;
        // ✅ RewardController API呼び出し
        try {
            await this.showGachaMachine();
            await this.playExcitementAnimation();

            const response = await axios.post("/gacha/draw", {
                child_id: childId,
                true_count: trueCount,
                total_tasks: totalTasks,
            });

            const result = response.data;
            console.log("🎉 API response received:", result);

            // カプセルアニメーション開始
            await this.showCapsuleAnimation(result.rarity);

            // 結果を直接表示（シンプルアプローチ）
            await this.showResultDirectly(result);
        } catch (error) {
            console.error("ガチャAPIエラー:", error);
            Livewire.dispatch("showError", {
                message: "ガチャの実行中にエラーが発生しました",
            });
        }
    }

    // 🎬 Step 1: ガチャマシン表示
    async showGachaMachine() {
        // DOM要素が表示されるまで少し待つ
        await new Promise((resolve) => setTimeout(resolve, 100));

        const machine = document.querySelector(".gacha-machine");

        // マシン登場アニメーション（初期状態は既にCSSで設定済み）
        console.log("🎬 Starting machine appearance animation");
        await window.anime({
            targets: machine,
            scale: [1, 1],
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
        await window.anime({
            targets: machine,
            translateX: [0, -5, 5, -3, 3, 0],
            translateY: [0, -2, 2, -1, 1, 0],
            duration: 1500,
            easing: "easeInOutQuad",
        }).finished;
    }

    // 🎬 Step 3: ガチャマシン消失 → カプセル出現・消失
    async showCapsuleAnimation(rarity) {
        const machine = document.querySelector(".gacha-machine");
        const capsule = document.querySelector(".gacha-capsule");

        // 1. ガチャマシンを消す
        await window.anime({
            targets: machine,
            scale: [1, 0],
            opacity: [1, 0],
            duration: 500,
            easing: "easeInQuad",
        }).finished;

        // 2. カプセル画像を表示
        capsule.innerHTML =
            '<img src="/images/items/gacha_effect/cupsule.png" alt="カプセル" class="w-full h-full object-contain">';
        capsule.classList.remove("hidden");

        // 3. カプセル出現（回転しながら落下）
        await window.anime({
            targets: capsule,
            translateY: [-100, 0],
            translateX: [0, 0], // 横位置を固定
            rotate: "2turn",
            scale: [0, 1],
            opacity: [0, 1],
            duration: 1200,
            easing: "easeOutBounce",
        }).finished;

        // 4. 少し待つ
        await new Promise((resolve) => setTimeout(resolve, 800));

        // 5. カプセル消失（回転しながら消える）
        await window.anime({
            targets: capsule,
            scale: [1, 0],
            rotate: "1turn",
            opacity: [1, 0],
            duration: 2000,
            easing: "easeInQuad",
        }).finished;

        capsule.classList.add("hidden");
    }

    // 純粋なJavaScriptで結果を直接表示
    async showResultDirectly(result) {
        console.log("🎯 Showing result directly with JavaScript");

        // 新しい結果エリアを作成
        this.createResultModal(result);

        // 結果表示エリアが生成されるまで少し待つ
        await new Promise((resolve) => setTimeout(resolve, 100));

        // レアリティエフェクトを再生
        this.playRarityEffect(result.rarity);
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

        // 既存のコンテンツを削除（シンプルに）
        modalContainer.innerHTML = "";

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
                
                <p class="text-lg mb-3 font-semibold">${
                    rarityNames[result.rarity] || result.rarity
                }</p>
                <p class="text-sm text-gray-600 mb-6">${result.message}</p>
                
                <div class="flex gap-4 justify-center">
                    <button onclick="Livewire.dispatch('closeGachaModal');" 
                            class="bg-custom-pink text-white px-6 py-3 rounded-full hover:bg-custom-pink/80 font-bold">
                        戻る
                    </button>
                    <button onclick="window.location.href='/rewards'" 
                            class="bg-custom-blue text-white px-6 py-3 rounded-full hover:bg-custom-blue/80 font-bold">
                        たからばこ
                    </button>
                </div>
            </div>
        `;
    }

    // レアリティ別エフェクト
    playRarityEffect(rarity) {
        const resultArea = document.querySelector(".gacha-result");

        if (rarity === "perfect") {
            // ゴールドの輝き
            window.anime({
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
            window.anime({
                targets: resultArea,
                scale: [1, 1.05, 1],
                duration: 1500,
                direction: "alternate",
                loop: 3,
            });
        }
    }
}

// 初期化
document.addEventListener("DOMContentLoaded", () => {
    new GachaAnimationSystem();
});
