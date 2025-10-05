<header class="bg-pink-300 shadow-md">
    <div class="flex justify-between items-center px-4 sm:px-6 md:px-12 py-2 sm:py-3">
        <!-- ロゴ -->
        <div class="flex items-center">
            <a href="{{ route('tasks.index') }}" class="text-[#007BFF] font-bold text-sm sm:text-base" style="text-shadow: 1px 1px 0 beige, -1px -1px 0 beige, 1px -1px 0 beige, -1px 1px 0 beige;">
                ワクワク宝集め
            </a>
        </div>

        <!-- デスクトップ用ナビゲーション (xl以上で表示) -->
        <div class="hidden xl:flex text-[#ffffff] text-small-base font-bold gap-3 indent-[0.1em] tracking-[0.1em]">
            {{-- <a href="#" class="flex justify-center items-center px-4 py-0 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60 text-center">
                ガチャ編集
            </a> --}}
            <button onclick="Livewire.dispatch('openChildModal');" class="flex justify-center items-center px-4 py-0 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/60 text-center">
                こども管理
            </button>
            <a href="{{ route('profile.edit') }}" class="flex justify-center items-center px-4 py-0 bg-fuchsia-400 border border-transparent rounded-full hover:bg-fuchsia-400/50 text-center">
                アカウント
            </a>
            <form method="POST" action="{{ route('logout')}}" class="inline">
                @csrf
                <button type="submit" class="flex justify-center items-center px-4 py-2 bg-custom-brown border border-transparent rounded-full hover:bg-custom-brown/50">
                    ログアウト
                </button>
            </form>
        </div>

        <!-- ハンバーガーメニューボタン (xl未満で表示) -->
        <button id="hamburger-btn" class="xl:hidden flex flex-col justify-center items-center w-8 h-8 space-y-1 focus:outline-none">
            <span class="block w-6 h-0.5 bg-white transition-transform duration-300"></span>
            <span class="block w-6 h-0.5 bg-white transition-transform duration-300"></span>
            <span class="block w-6 h-0.5 bg-white transition-transform duration-300"></span>
        </button>
    </div>

    <!-- モバイル用オーバーレイメニュー (xl未満で表示) -->
    <div id="mobile-menu" class="xl:hidden hidden fixed top-0 right-0 h-auto max-h-screen w-1/2 sm:w-1/3 bg-pink-200 shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out pb-8">
        <!-- 閉じるボタン -->
        <div class="flex justify-end p-4">
            <button id="close-menu-btn" class="flex items-center justify-center w-8 h-8 text-white hover:bg-pink-400/50 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- メニュー項目 -->
        <div class="flex flex-col text-[#ffffff] text-sm font-bold px-4 space-y-3 indent-[0.1em] tracking-[0.1em]">
            {{-- <a href="#" class="flex justify-center items-center py-3 bg-green-400 border border-transparent rounded-full hover:bg-green-400/60 text-center transition-colors">
                ガチャ編集
            </a> --}}
            <button onclick="Livewire.dispatch('openChildModal'); console.log('Livewireイベント発火')" class="flex justify-center items-center py-3 bg-custom-blue border border-transparent rounded-full hover:bg-custom-blue/60 text-center transition-colors">
                こども管理
            </button>
            <a href="{{ route('profile.edit') }}" class="flex justify-center items-center py-3 bg-fuchsia-400 border border-transparent rounded-full hover:bg-fuchsia-400/50 text-center transition-colors">
                アカウント
            </a>
            <form method="POST" action="{{ route('logout')}}">
                @csrf
                <button type="submit" class="flex justify-center items-center py-3 bg-custom-brown border border-transparent rounded-full hover:bg-custom-brown/50 w-full text-center transition-colors">
                    ログアウト
                </button>
            </form>
        </div>
    </div>

    <!-- オーバーレイ背景 -->
    <div id="menu-overlay" class="xl:hidden hidden fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity duration-300"></div>
</header>