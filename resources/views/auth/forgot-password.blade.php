<x-guest-layout>
    <h2 class="mb-5 text-center">パスワードリセット</h2>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-10">
            <x-primary-button class="my-5 bg-custom-blue hover:bg-custom-blue/60 text-small-base font-normal w-full focus:ring-2 focus:ring-offset-2 focus:ring-blue-200">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                ログイン画面に戻る
            </a>
        </div>
    </form>
</x-guest-layout>
