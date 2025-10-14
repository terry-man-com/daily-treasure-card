<x-guest-layout>
    <h2 class="text-center">新規登録</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="relative">
                {{ __('Name') }}
                <span class="bg-red-400 text-white px-2 py-0.5 text-xs rounded ml-3 font-bold">必須</span>
            </x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" class="relative">
                {{ __('Email') }}
                <span class="bg-red-400 text-white px-2 py-0.5 text-xs rounded ml-3 font-bold">必須</span>
            </x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" class="relative">
                {{ __('Password') }}
                <span class="bg-red-400 text-white px-2 py-0.5 text-xs rounded ml-3 font-bold">必須</span>
            </x-input-label>
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="relative">
                {{ __('Confirm Password') }}
                <span class="bg-red-400 text-white px-2 py-0.5 text-xs rounded ml-3 font-bold">必須</span>
            </x-input-label>
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        @for ($i = 0; $i < 3; $i++)
            <!-- ChildName1 -->
            <div class="mt-4">
                <x-input-label for="child_name_1" :value="__('Child Name') . '（7文字以内）'" />
                <x-text-input id="child_name_1" class="block mt-1 w-full" type="text" name="child_name[]" />
                <x-input-error :messages="$errors->get('child_name.' . $i)" class="mt-2" />
            </div>

            <!-- ChildGender1 -->
            <div class="mt-4">
                <x-input-label :value="__('Child Gender')" />
                <div class="flex items-center space-x-4 mt-1">
                    <label class="inline-flex items-center">
                        <input type="radio" name="child_gender[{{ $i }}]" value="boy" class="form-radio">
                        <span class="text-small-base ml-2">男の子</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="child_gender[{{ $i }}]" value="girl" class="form-radio">
                        <span class="text-small-base ml-2">女の子</span>
                    </label>
                </div>
            </div>
        @endfor

        <div class="flex flex-col items-center justify-end mt-6">
            <x-primary-button class="bg-custom-blue hover:bg-custom-blue/60 text-xl w-full focus:ring-2 focus:ring-offset-2 focus:ring-blue-200">
                {{ __('Send') }}
            </x-primary-button>
            <a class="my-5 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
