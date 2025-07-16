import { setupTabSwitching } from "../main.js";

document.addEventListener("DOMContentLoaded", () => {
    setupTabSwitching();
    openDeleteModal();
});

const openDeleteModal = () => {
    const nodeList = document.querySelectorAll(".task-checkbox:checked");
    const checked = Array.from(nodeList).map((cd) => cd.value);

    Livewire.dispatch("openDeleteModal", { checkedTasks: checked });
};
