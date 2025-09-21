document.addEventListener("DOMContentLoaded", () => {
    setupTabSwitching();
    setupHamburgerMenu();
});

export const setupTabSwitching = () => {
    const tabButtons = document.querySelectorAll(".js-tab-button");
    const tabPanels = document.querySelectorAll(".js-tab-panel1");

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const tabIndex = button.getAttribute("data-tab");

            // タブボタンの色を一度リセット　→ 全て青にする
            tabButtons.forEach((btn) => {
                btn.classList.remove("bg-custom-pink");
                btn.classList.add("bg-custom-blue");
            });

            // 押されたボタンだけピンクに変更する
            button.classList.remove("bg-custom-blue");
            button.classList.add("bg-custom-pink");

            // 紐づいたタブに切り替える
            tabPanels.forEach((panel) => {
                panel.classList.add("hidden");
                if (panel.getAttribute("data-panel") === tabIndex) {
                    panel.classList.remove("hidden");
                }
            });
        });
    });

    // 初期状態：data-tab="0"(左のタブ)をデフォルトでアクティブ状態
    // ただし、フォーム送信時は現在のアクティブタブを保持する
    const activePanel = document.querySelector(".js-tab-panel1:not(.hidden)");
    if (!activePanel) {
        // アクティブなパネルがない場合のみ、デフォルトタブを設定
        const defaultTab = document.querySelector(
            '.js-tab-button[data-tab="0"]'
        );
        if (defaultTab) {
            defaultTab.click();
        }
    } else {
        // アクティブなパネルに対応するタブボタンをアクティブ状態にする
        const activeIndex = activePanel.getAttribute("data-panel");
        const activeTab = document.querySelector(
            `.js-tab-button[data-tab="${activeIndex}"]`
        );
        if (activeTab) {
            // タブボタンの色を一度リセット
            const allTabs = document.querySelectorAll(".js-tab-button");
            allTabs.forEach((btn) => {
                btn.classList.remove("bg-custom-pink");
                btn.classList.add("bg-custom-blue");
            });
            // アクティブタブをピンクに
            activeTab.classList.remove("bg-custom-blue");
            activeTab.classList.add("bg-custom-pink");
        }
    }
};

export const setupHamburgerMenu = () => {
    const hamburgerBtn = document.getElementById("hamburger-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    const menuOverlay = document.getElementById("menu-overlay");
    const closeMenuBtn = document.getElementById("close-menu-btn");

    if (!hamburgerBtn || !mobileMenu || !menuOverlay) return;

    const openMenu = () => {
        // オーバーレイとメニューを表示
        menuOverlay.classList.remove("hidden");
        mobileMenu.classList.remove("hidden");

        // アニメーション用のタイムアウト
        setTimeout(() => {
            menuOverlay.classList.add("opacity-100");
            mobileMenu.classList.remove("translate-x-full");
        }, 10);
    };

    const closeMenu = () => {
        // メニューを右に移動
        mobileMenu.classList.add("translate-x-full");
        menuOverlay.classList.remove("opacity-100");

        // アニメーション完了後に非表示
        setTimeout(() => {
            mobileMenu.classList.add("hidden");
            menuOverlay.classList.add("hidden");
        }, 300);

        // ハンバーガーアイコンを元に戻す
        const spans = hamburgerBtn.querySelectorAll("span");
        spans[0].style.transform = "rotate(0deg) translateY(0)";
        spans[1].style.opacity = "1";
        spans[2].style.transform = "rotate(0deg) translateY(0)";
    };

    // ハンバーガーボタンクリック
    hamburgerBtn.addEventListener("click", () => {
        const isOpen = !mobileMenu.classList.contains("hidden");

        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    // 閉じるボタンクリック
    if (closeMenuBtn) {
        closeMenuBtn.addEventListener("click", closeMenu);
    }

    // オーバーレイクリックで閉じる
    menuOverlay.addEventListener("click", closeMenu);
};
