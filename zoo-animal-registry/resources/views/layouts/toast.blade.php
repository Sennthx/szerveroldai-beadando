@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-24 right-8 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50 max-w-sm break-words">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="fixed top-24 right-8 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50 max-w-sm break-words">
        {{ $errors->first() }}
    </div>
@endif
