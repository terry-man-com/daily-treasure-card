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
    const defaultTab = document.querySelector('.js-tab-button[data-tab="0"]');
    if (defaultTab) {
        defaultTab.click();
    }
};
