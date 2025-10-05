document.addEventListener("DOMContentLoaded", () => {
    taskResetButton();
});

const taskResetButton = () => {
    // ページ全体から .js-task-reset を取得
    const resetButtons = document.querySelectorAll(".js-task-reset");
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
};
