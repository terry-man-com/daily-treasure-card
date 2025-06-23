// タスクパネルのタブ切り替え
const setupTabSwitching = () => {
  const tabButtons = document.querySelectorAll(".js-tab-button");
  const tabPanels = document.querySelectorAll(".js-tab-panel1");

  tabButtons.forEach(button => {
    button.addEventListener("click", () => {
      const tabIndex = button.getAttribute("data-tab");

      // タブボタンの色を一度リセット　→ 全て青にする
      tabButtons.forEach(btn => {
        btn.classList.remove("bg-custom-pink");
        btn.classList.add("bg-custom-blue");
      });

      // 押されたボタンだけピンクに変更する
      button.classList.remove("bg-custom-blue");
      button.classList.add("bg-custom-pink");

      // 紐づいたタブに切り替える
      tabPanels.forEach(panel => {
        panel.classList.add("hidden");
        if (panel.getAttribute("data-panel") === tabIndex) {
          panel.classList.remove("hidden")
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

// ○×ボタンが押下されたかを判定し、
// 全ての○×ボタンが押された時にガチャボタンを活性化させる
const updateRewardButton = (panel) => {
  const allButtons = panel.querySelectorAll(".js-judge-button");
  const isAllJudged = Array.from(allButtons).every(btn => btn.disabled);
  const rewardButton = panel.querySelector(".js-reward-button");
  if (rewardButton) {
    rewardButton.disabled = !isAllJudged;
  }
};

// タスク判定ボタン
const setupJudgeButtons = () => {
  const tabPanels = document.querySelectorAll("[data-panel]");

  tabPanels.forEach(panel => {
    const judgeButtons = panel.querySelectorAll(".js-judge-button");

    judgeButtons.forEach(button => {
      button.addEventListener("click", () => {
        const result = button.dataset.result; // "true" or "false"
        const buttonArea = button.closest(".judge-button-area");
        const task = buttonArea.closest(".task");
        const wrapper = task.querySelector(".js-judge-wrapper");

        // ボタン無効化&非表示
        buttonArea.querySelectorAll(".js-judge-button").forEach(btn => {
          btn.disabled = true;
          btn.classList.add("hidden");
        });

        // 判定メッセージ表示
        wrapper.classList.remove("hidden");
        const resultSpan = wrapper.querySelector(`[data-result="${result}"]`);
        if (resultSpan) {
          resultSpan.classList.remove("hidden");

          const innerSpan = resultSpan.querySelector("span");
          if (innerSpan) {
            innerSpan.classList.remove("hidden");
          }
        }

        // ガチャボタンの活性化判定（タブ内限定）
        updateRewardButton(panel);
      });
    });
  });
};


// 判定リセット
const pushedResetButton = () => {
  const resetButton = document.getElementById("reset-button");

  resetButton.addEventListener("click", () => {
      // 判定ボタンを全て復活
      document.querySelectorAll(".js-judge-button").forEach((btn) => {
          btn.classList.remove("hidden");
          btn.disabled = false;
      });

      // 判定結果ラッパーとその中の span を全て非表示
      document.querySelectorAll(".js-judge-wrapper").forEach((wrapper) => {
        wrapper.classList.add("hidden");

        // wrapper内のspanタグも非表示にする
        wrapper.querySelectorAll("span").forEach((span) => {
            span.classList.add("hidden");
        });
      });
  });
};


document.addEventListener("DOMContentLoaded", () => {
  setupTabSwitching();
  setupJudgeButtons();
  pushedResetButton();
});