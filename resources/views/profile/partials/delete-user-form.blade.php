<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-custom-gray mb-4">
            アカウント削除
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            アカウントを削除すると、すべてのデータが完全に削除されます。
        </p>
    </header>

    <button type="button"
        class="bg-red-500 text-white px-6 py-2 rounded-full font-bold hover:bg-red-500/60 indent-[0.2em] tracking-[0.2em]"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >アカウント削除</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-custom-gray">
                本当にアカウントを削除しますか？
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                アカウントを削除すると、すべてのデータが完全に削除されます。
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="button" 
                    class="bg-gray-500 text-white px-4 py-2 rounded-full font-bold hover:bg-gray-500/60"
                    x-on:click="$dispatch('close')">
                    キャンセル
                </button>

                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full font-bold hover:bg-red-500/60">
                    削除する
                </button>
            </div>
        </form>
    </x-modal>
</section>
