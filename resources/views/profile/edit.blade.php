<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-4 sm:px-6 md:px-8 lg:px-24 py-3 sm:py-4 md:py-5 mx-auto">
            <div class="relative mb-10 sm:mb-8 md:mb-0 sm:min-h-[140px] md:min-h-[160px] sm:flex sm:items-center sm:justify-center">
                <h1 class="text-2xl sm:text-3xl md:text-h1 2xl:text-5xl font-bold text-center mb-3 sm:mb-0 sm:py-6 md:py-8 indent-[0.2em] lg:indent-[0.5em] tracking-[0.2em] lg:tracking-[0.5em]">アカウント設定</h1>
                <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-sm sm:text-base md:text-xl px-3 sm:px-4 md:px-6 py-2 indent-[0.2em] sm:indent-[0.4em] tracking-[0.2em] sm:tracking-[0.4em] rounded-full hover:bg-green-500 shadow">
                    戻る
                </a>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                <!-- プロフィール情報更新 -->
                <div class="bg-white border-2 border-custom-gray rounded-lg p-6 sm:p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- パスワード変更 -->
                <div class="bg-white border-2 border-custom-gray rounded-lg p-6 sm:p-8">
                    @include('profile.partials.update-password-form')
                </div>

                <!-- アカウント削除 -->
                <div class="bg-white border-2 border-custom-gray rounded-lg p-6 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </main>
    @include('components.my-footer')
    @livewire('child-manage-modal')
</x-app-layout>
