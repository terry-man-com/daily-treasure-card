import { setupTabSwitching } from "../main.js";

  document.addEventListener("DOMContentLoaded", () => {
      setupTabSwitching();
      // 削除ボタンに直接イベントリスナーを付与
      const deleteBtns = document.querySelectorAll(".delete-btn");
      deleteBtns.forEach((btn) => {
          btn.addEventListener("click", (event) => {
              event.preventDefault();
              const nodeList = document.querySelectorAll(
                  ".task-checkbox:checked"
              );
              const checked = Array.from(nodeList).map((cd) => cd.value);
              console.log("checked", checked);
              Livewire.dispatch("openDeleteModal", { checkedTasks: checked });
          });
      });
  });
