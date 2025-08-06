// 性別ボタンのクリック処理(`gender_${childId}`)
document.addEventListener("DOMContentLoaded", function () {
    const genderButtons = document.querySelectorAll(".gender-btn"); // 男・女ボタンを全て取得する
    const hiddenInput = document.getElementById("gender"); // buttonの入力値を格納し、フォーム送信するようの変数
    // 男女ボタンにそれぞれ機能を追加
    // クリックされるとdata-genderの値を取得し、hidden inputの値を更新（valueにdata-genderの値を入れる）
    genderButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const gender = this.dataset.gender;

            // 同じ行のボタンの色をリセット
            const parentDiv = this.parentElement;
            const buttons = parentDiv.querySelectorAll(".gender-btn");

            buttons.forEach(btn => {
                btn.classList.remove("bg-custom-blue", "bg-custom-pink");
                btn.classList.add("bg-gray-300");
            })
            // クリックされたボタンの色を変更
            if (gender === "boy") {
                this.classList.remove("bg-gray-300");
                this.classList.add("bg-custom-blue");
            } else {
                this.classList.remove("bg-gray-300");
                this.classList.add("bg-custom-pink");
            }

            // hidden inputの値を更新
            hiddenInput.value = gender;
        });
    });
});
