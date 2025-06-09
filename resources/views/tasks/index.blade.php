<x-app-layout>
    @include('components.task-header')
        <main class="text-custom-gray flex-grow">
            <div class="container px-24 py-5 mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-h1 font-bold mb-4 tracking-widest">きょうのやくそく</h1>
                </div>

                <!-- タブ部分 -->
                <div class="flex gap-2 mb-4">
                    <button onclick="showTab(0)" class="tab-btn active">ひなみ</button>
                    <button onclick="showTab(1)" class="tab-btn">げんりゅうさい</button>
                    <button onclick="showTab(2)" class="tab-btn">ゆいと</button>
                </div>

                <!-- タスク表示部分 -->
                <div class="tab-content">
                    <div class="tab-panel" id="tab-0">子ども1のタスク5件</div>
                    <div class="tab-panel hidden" id="tab-1">子ども2のタスク5件</div>
                    <div class="tab-panel hidden" id="tab-2">子ども3のタスク5件</div>
                </div>
            </div>
        </main> 
    @include('components.my-footer')
</x-app-layout>