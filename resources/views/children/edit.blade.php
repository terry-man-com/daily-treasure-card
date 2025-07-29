<x-app-layout>
    @include('components.task-header')
    <main class="text-custom-gray flex flex-grow">
        <div class="container px-24 py-5 mx-auto">
            <div class="relative mb-10">
                <h1 class="text-h1 font-bold text-center indent-[0.5em] tracking-[0.5em]">こども編集・削除</h1>
                <a href="{{ route('tasks.index') }}" class="absolute right-0 top-1/2 -translate-y-1/2 bg-green-400 text-white text-xl px-6 py-2 indent-[0.4em] tracking-[0.4em] rounded-full hover:bg-green-400/50 shadow">
                    戻る
                </a>
            </div>

            @if (session('success'))
                <div class="text-center text-green-400 mb-2">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="text-center text-red-400 mb-2">{{ session('error') }}</div>
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

            @if($children->count() > 0)
                <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
                    <form method="POST" action="{{ route('children.update', 0) }}">
                        @csrf
                        @method('PUT')
                        
                        @foreach($children as $child)
                            <div class="border-b border-gray-200 py-6 last:border-b-0">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold">子供 {{ $loop->iteration }}</h3>
                                    <form method="POST" action="{{ route('children.destroy', $child->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-400 text-white px-4 py-2 rounded-full hover:bg-red-500 transition"
                                                onclick="return confirm('本当に削除しますか？')">
                                            削除
                                        </button>
                                    </form>
                                </div>
                                
                                <input type="hidden" name="children[{{ $loop->index }}][id]" value="{{ $child->id }}">
                                
                                <div class="mb-4">
                                    <label class="block text-lg font-bold mb-2">名前</label>
                                    <input type="text" name="children[{{ $loop->index }}][child_name]" 
                                           class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-custom-pink focus:outline-none"
                                           value="{{ $child->child_name }}" maxlength="20" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-lg font-bold mb-2">性別</label>
                                    <div class="flex gap-4">
                                        <label class="flex items-center">
                                            <input type="radio" name="children[{{ $loop->index }}][gender]" value="男の子" 
                                                   {{ $child->gender == '男の子' ? 'checked' : '' }} required class="mr-2">
                                            <span>男の子</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="radio" name="children[{{ $loop->index }}][gender]" value="女の子" 
                                                   {{ $child->gender == '女の子' ? 'checked' : '' }} required class="mr-2">
                                            <span>女の子</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="text-center mt-8">
                            <button type="submit" 
                                    class="bg-green-400 text-white font-bold py-3 px-8 rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-green-500 transition">
                                更新
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-xl text-gray-600 mb-4">登録されている子供がいません</p>
                    <a href="{{ route('children.create') }}" 
                       class="bg-custom-pink text-white font-bold py-3 px-8 rounded-full text-xl indent-[0.4em] tracking-[0.4em] hover:bg-custom-pink/80 transition">
                        子供を登録する
                    </a>
                </div>
            @endif
        </div>
    </main>
    @include('components.my-footer')
</x-app-layout> 