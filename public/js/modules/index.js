import { setupTabSwitching } from "../main.js";

document.addEventListener("DOMContentLoaded", () => {
    setupTabSwitching();
    setupJudgeButtons();
    pushedResetButton();
});

function updateRewardButton(panel) {
    const allButtons = panel.querySelectorAll(".js-judge-button");
    const isAllJudged = Array.from(allButtons).every((btn) => btn.disabled);
    const rewardButton = panel.querySelector(".js-reward-button");
    if (rewardButton) {
        rewardButton.disabled = !isAllJudged;
    }
}

function setupJudgeButtons() {
    const tabPanels = document.querySelectorAll("[data-panel]");
    tabPanels.forEach((panel) => {
        const judgeButtons = panel.querySelectorAll(".js-judge-button");
        judgeButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const result = button.dataset.result;
                const buttonArea = button.closest(".judge-button-area");
                const task = buttonArea.closest(".js-task");
                const wrapper = task.querySelector(".js-judge-wrapper");
                buttonArea
                    .querySelectorAll(".js-judge-button")
                    .forEach((btn) => {
                        btn.disabled = true;
                        btn.classList.add("hidden");
                    });
                wrapper.classList.remove("hidden");
                const resultSpan = wrapper.querySelector(
                    `[data-result="${result}"]`
                );
                if (resultSpan) {
                    resultSpan.classList.remove("hidden");
                    const innerSpan = resultSpan.querySelector("span");
                    if (innerSpan) {
                        innerSpan.classList.remove("hidden");
                    }
                }
                updateRewardButton(panel);
            });
        });
    });
}

function pushedResetButton() {
    const tabPanels = document.querySelectorAll("[data-panel]");
    tabPanels.forEach((panel) => {
        const resetButton = panel.querySelector("#reset-button");
        if (!resetButton) return;
        resetButton.addEventListener("click", () => {
            panel.querySelectorAll(".js-judge-button").forEach((btn) => {
                btn.classList.remove("hidden");
                btn.disabled = false;
            });
            panel.querySelectorAll(".js-judge-wrapper").forEach((wrapper) => {
                wrapper.classList.add("hidden");
                wrapper.querySelectorAll("span").forEach((span) => {
                    span.classList.add("hidden");
                });
            });
            const rewardButton = panel.querySelector(".js-reward-button");
            if (rewardButton) rewardButton.disabled = true;
        });
    });
}
