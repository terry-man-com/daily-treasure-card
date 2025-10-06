<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
            <!-- タイトルと戻るボタン -->
            <div class="relative sm:mb-4 md:mb-6 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">お問い合わせ</h1>
                <a href="{{ route('home') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl px-3 sm:px-4 md:px-6 py-2 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-green-500 shadow">
                    戻る
                </a>
            </div>

            <!-- Googleフォーム -->
            <div class="flex justify-center py-10 sm:py-0">
                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeeGiKP1DBvPTDPJho-_5BBRcjtF_KGdl9QhSp4SU05vmClzQ/viewform?embedded=true" 
                        class="w-full max-w-4xl h-[60vh] border-0 bg-gray-100 rounded-lg shadow-sm" 
                        frameborder="0" 
                        marginheight="0" 
                        marginwidth="0">
                    読み込んでいます…
                </iframe>
            </div>
        </div>
    </main>
    @include('components.my-footer')
</x-app-layout>

