<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-24 py-5 mx-auto">
            <div class="relative mb-20">
                <h1 class="text-h1 font-bold text-center indent-[0.5em] tracking-[0.5em]">こども登録</h1>
                <a href="{{ route('children.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-xl font-bold px-6 py-2 rounded-full hover:bg-green-400/50">
                    こども一覧
                </a>
            </div>

            @if (session('success'))
                <div class="text-center text-green-400 mb-2">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="text-center text-red-400 mb-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
                <form method="POST" action="{{ route('children.store') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="child_name" class="block text-lg font-bold mb-2">名前</label>
                        <input type="text" id="child_name" name="child_name" 
                               class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-custom-pink focus:outline-none"
                               value="{{ old('child_name') }}" placeholder="子供の名前を入力" maxlength="20" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-lg font-bold mb-2">性別</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="男の子" {{ old('gender') == '男の子' ? 'checked' : '' }} required
                                       class="mr-2">
                                <span>男の子</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="gender" value="女の子" {{ old('gender') == '女の子' ? 'checked' : '' }} required
                                       class="mr-2">
                                <span>女の子</span>
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" 
                                class="bg-custom-pink text-white font-bold py-3 px-8 rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/80 transition">
                            登録
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    @include('components.my-footer')
</x-app-layout>
