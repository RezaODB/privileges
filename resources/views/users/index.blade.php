<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl 2xl:max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <a href="{{ route('users.export_users') }}" class="px-4 py-2 bg-gray-600 rounded-md text-white inline-block">Export to CSV</a>
                    <livewire:users-table />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
