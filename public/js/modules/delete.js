document.addEventListener("DOMContentLoaded", () => {
    setupDeleteButtons();
    setupUpdateButtons();
});

// 更新ボタン押下後、チェック済みタスクを取得
// フォーム送信を行う
const setupUpdateButtons = () => {
    document.querySelectorAll(".update-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            // フォームから直接 child_id を取得
            const updateForm = document.getElementById("update-form");
            const childId = updateForm.querySelector('input[name="child_id"]').value;

            const checked = Array.from(
                document.querySelectorAll(".task-checkbox:checked")
            ).map((cb) => cb.value);

            if (checked.length === 0) {
                alert("更新するタスクを選択してください");
                return;
            }

            // チェック済みIDをhiddenにセットしてフォーム送信
            document.getElementById('update_ids').value =
                checked.join(",");
            updateForm.submit();
        });
    });
};

// 削除ボタン押下後、チェック数を判定
// 確認用モーダルウィンドウを開く。
const setupDeleteButtons = () => {
    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", () => {

            // ボタンが属するパネルを取得
            const deleteForm = document.getElementById("delete-form");
            const childId = deleteForm.querySelector('input[name="child_id"]').value;
            const checked = Array.from(
                document.querySelectorAll(".task-checkbox:checked")
            ).map((cb) => cb.value);

            if (checked.length === 0) {
                alert("削除するタスクを選択してください");
                return;
            }

            // チェック済みIDをグローバル変数に保存（モーダルのOKボタンで使用）
            window.checkedDeleteIds = checked;
            window.currentChildId = childId;

            // Livewireでモーダル表示
            console.log("Livewire.dispatch前", checked, childId);
            Livewire.dispatch("openDeleteModal");
        });
    });
};

// モーダルのOKボタンで呼び出される関数
window.confirmDelete = () => {
    if (window.checkedDeleteIds && window.checkedDeleteIds.length > 0) {
        document.getElementById('delete_ids').value =
            window.checkedDeleteIds.join(",");
        document
            .getElementById('delete-form')
            .submit();
    }
};
