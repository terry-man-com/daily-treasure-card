// タスク結果収集とガチャトリガー機能

// グローバル関数として定義（HTMLから呼び出し可能にするため）
window.triggerGacha = function (childId) {
    console.log("🎯 Gacha button clicked for child:", childId);
    const panel = event.target.closest(".js-tab-panel1");
    const taskResults = collectTaskResults(panel);
    console.log("📊 Task results:", taskResults);

    // Livewireコンポーネントにガチャ開始を通知
    console.log("🔗 Dispatching openGachaModal event");
    Livewire.dispatch("openGachaModal", [
        childId,
        taskResults.trueCount,
        taskResults.totalTasks,
    ]);
};

function collectTaskResults(panel) {
    const judgeWrappers = panel.querySelectorAll(".js-judge-wrapper");
    let trueCount = 0;
    let totalTasks = judgeWrappers.length;

    judgeWrappers.forEach((wrapper) => {
        const trueSpan = wrapper.querySelector('[data-result="true"]');
        if (trueSpan && !trueSpan.classList.contains("hidden")) {
            trueCount++;
        }
    });

    return { trueCount, totalTasks };
}
