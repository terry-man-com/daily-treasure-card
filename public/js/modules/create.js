import { setupTabSwitching } from "../main.js";

document.addEventListener("DOMContentLoaded", () => {
    setupTabSwitching();
    taskResetButton();
});

const taskResetButton = () => {
    const tabPanels = document.querySelectorAll("[data-panel]");
    tabPanels.forEach((panel) => {
        const resetButtons = panel.querySelectorAll(".js-task-reset");
        resetButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                const buttonArea = button.closest(".judge-button-area");
                const task = buttonArea.closest(".js-task");
                const input = task.querySelector('input[type="text"]');
                if (input) {
                    input.value = "";
                }
            });
        });
    });
}
