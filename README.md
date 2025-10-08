# ワクワク宝集め / 親子向けタスク管理サービス

ワクワク宝集めは、「子どもの日々の約束（タスク）達成を楽しくサポートする」という想いから作られた、親子向けタスク管理 Web アプリケーションです。

パパ・ママと決めた約束（タスク）を達成するとガチャを引いて、ご褒美の宝石をゲットできます。また、ゲットしたアイテムは宝箱で確認することができます。

子どもイヤイヤ期に、毎日の歯磨きやお片付け、着替えといった基本的な生活習慣をつけるのに苦労した経験から、「親子で楽しく習慣づけるサービスがあったらいいな」と思った経験から生まれています。**約束を守る → ガチャを引く → 宝石を集める**にするというステップを通じて、お子さまが生活習慣を楽しく身につけることをサポートします。

※ 本アプリケーションは、スマートフォンおよび PC に対応したレスポンシブデザインを採用しています。

---

## スクリーンショット

### トップページ

![service-image](./docs/images/top-page.jpeg)

### 約束（タスク）確認

![約束確認画面](docs/images/task-index.jpeg)

### ご褒美ガチャ

![ガチャ紹介](docs/images/gacha.gif)

### たからばこ（獲得アイテム参照）

![たからばこ](docs/images/reward-collection.gif)

### レスポンシブデザイン

![レスポンシブ](docs/images/responsive.jpg)

## 主な機能

### ① 　タスク（約束）管理機能

登録した約束を確認して、達成できたか判定できます。

![タスク管理機能](docs/images/task-index.jpeg)

### ② 　タスク（約束）登録・編集機能

新規登録では約束を最大５個まで一括登録できます。

![タスク管理機能](docs/images/task-create.jpeg)

### ③ 　ガチャ機能

約束達成でガチャ実行できます。ガチャで抽選されるアイテムは約束の達成度で変わります。

![ガチャ機能](docs/images/gacha.gif)

### ④ 　獲得アイテム確認機能

カレンダーで獲得アイテムを表示。モーダル画面で拡大表示できます。

![宝箱](docs/images/reward-collection.gif)

### ⑤ 　子ども登録・編集機能（最大 3 人）

最大３人まで子供を登録できます。登録した子どもの名前が ①〜④ のタブに反映され、表示を切り替えることができます。

![子ども登録](docs/images/child-create.jpeg)

## URL

現在、Fly.io にてデプロイ準備中

### テストアカウント（デプロイ後利用可能）

-   メールアドレス: `test@example.com`
-   パスワード: `password`

---

## ローカルセットアップ手順

### 必要な環境

-   Docker Desktop
-   Git

### セットアップ

```bash
# 1. リポジトリのクローン
git clone [repository-url]
cd daily-treasure-card

# 2. 環境変数の設定
cp .env.example .env

# 3. Composerのインストール
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs

# 4. Dockerコンテナの起動
./vendor/bin/sail up -d

# 5. PostgreSQL起動を待つ
sleep 10

# 6. データベースのマイグレーション＆シーディング
./vendor/bin/sail artisan migrate --seed

# 7. npmパッケージのインストール
./vendor/bin/sail npm install

# 8. Vite起動（別ターミナルで実行）
./vendor/bin/sail npm run dev

# 9. ブラウザでアクセス
# http://localhost
```

### トラブルシューティング

**PostgreSQL 接続エラーが出る場合:**

```bash
# キャッシュクリア
./vendor/bin/sail artisan config:clear

# コンテナ再起動
./vendor/bin/sail down
./vendor/bin/sail up -d
sleep 10

# 接続確認
./vendor/bin/sail artisan db:show
```

## 使用技術

### バックエンド

-   PHP 8.4
-   Laravel 12
-   Livewire 3.6
-   Composer

### フロントエンド

-   HTML5/CSS3
-   Tailwind CSS 3
-   JavaScript（ES6+）
-   Vite 5
-   Axios（HTTP 通信）
-   FullCalendar.js（カレンダー表示）
-   Node.js/npm

### データベース

-   PostgreSQL

### 開発環境・インフラ

-   Docker
-   Git/GitHub

---

## 📊 ER 図

![データベースER図](docs/images/database-schema.jpg)

---

## 🔄 今後の予定

ガチャで獲得できる景品やレアリティをユーザーごとに編集できる「ガチャ編集機能」を実装する予定です。
