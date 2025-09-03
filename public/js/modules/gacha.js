class GachaSystem {
  constructor() {
    this.isAnimating = false;
    this.init();
  }

  // ガチャボタンのイベントリスナー設定
  init() {
    document.querySelectorAll("js-reward-button").forEach((button) => {
      button.addEventListener("click", (e) => this.handleGachaClick(e));
    });
  }

  async handleGachaClick(event) {
    if (this.isAnimating) return; // 重複実行防止

    const button = event.target;
    const panel = button.closest(".js-tab-panel1");

    // 現在アクティブな子どものIDを取得
    const childId = this.getCurrentChildId();
    if (!childId) {
      alert("子供が選択されていません");
      return;
    }

    // タスク結果を収集　
    const taskResults = this.collectTaskResults(panel);

    try {
      this.isAnimating = true;
      button.disabled = true;
    }
  }
}