<header class="bg-pink-300 shadow-md flex justify-between">
    <div class="max-w-7xl pl-12 py-3 flex justify-between items-center">
        <a href="#" class="text-[#007BFF] font-bold" style="text-shadow: 1px 1px 0 beige, -1px -1px 0 beige, 1px -1px 0 beige, -1px 1px 0 beige;">
            ワクワク宝集め
        </a>
    </div>

    <div class="flex text-[#ffffff] text-small-base font-bold my-3 mr-4 gap-3 indent-[0.2em] tracking-[0.2em]">
        <a href="#" class="flex justify-center items-center px-4 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-200">
            ガチャ編集
        </a>
        <a href="#" class="flex justify-center items-center px-4 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/60 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-200">
            こども登録
        </a>
        <a href="#" class="flex justify-center items-center px-4 bg-fuchsia-400 border border-transparent rounded-full hover:bg-fuchsia-400/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-200">
            アカウント
        </a>
        <form method="POST" action="{{ route('logout')}}">
            @csrf
            <button type="submit" class="flex justify-center items-center px-4 py-2 bg-custom-brown border border-transparent rounded-full hover:bg-custom-brown/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-200">
                ログアウト
            </button>
        </form>
    </div>
</header>