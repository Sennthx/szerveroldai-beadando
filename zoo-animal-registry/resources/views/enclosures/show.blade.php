@extends('layouts.app')

@section('title', 'Enclosure | Zoo Registry')

@section('content')
    @include('layouts.toast')
    <h1 class="text-4xl font-bold mb-6 mt-8 text-center">Current Enclosure: <span
            class="text-red-600 font-extrabold">{{ $enclosure->name }}</span></h1>

    @if ($enclosure->for_predators)
        <div
            class="bg-red-100 text-red-800 border border-red-800 font-semibold px-4 py-2 rounded text-center max-w-xl mx-auto mb-6">
            ⚠️ This enclosure contains predators!
        </div>
    @else
        <div
            class="bg-green-100 text-green-800 border border-green-800 font-semibold px-4 py-2 rounded text-center max-w-xl mx-auto mb-6">
            ✅ This enclosure does not contain predators!
        </div>
    @endif
    @auth
        @if (Auth::user()->admin)
            <div class="w-full flex justify-center mb-4 mt-8">
                <a href="{{ route('enclosures.edit', ['enclosure' => $enclosure->id, 'redirect_back' => url()->full()]) }}"
                    class="px-3 py-2 mx-2 bg-indigo-500 text-lg text-white rounded hover:bg-indigo-600">
                     Edit this enclosure
                 </a>

                <form action="{{ route('enclosures.destroy', $enclosure->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this enclosure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-2 mx-2 bg-red-500 text-lg text-white rounded hover:bg-red-600">
                        Delete this enclosure
                    </button>
                </form>
            </div>
        @endif
    @endauth

    <div class="max-w-4xl mx-auto m-8 p-6 bg-white shadow-md rounded-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-lg ">
            <div>
                <label class="text-xl font-extrabold">Name:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $enclosure->name }}</p>
            </div>
            <div>
                <label class="text-xl font-extrabold">Animal Limit:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $enclosure->limit }}</p>
            </div>
            <div>
                <label class="text-xl font-extrabold">Current Animals:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $enclosure->animals->count() }}</p>
            </div>
            <div>
                <label class="text-xl font-extrabold">For Predators:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $enclosure->for_predators ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    </div>

    {{-- Animals List --}}
    <h2 class="text-2xl font-bold mb-4 text-center">Animals in this Enclosure</h2>

    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-4 mb-8">
        @forelse ($animals as $animal)
            <div class="bg-white shadow shadow-md rounded-xl p-6 flex flex-col items-center">
                <img src="{{ $animal->image_url ?? asset('images/placeholder-animal.jpg') }}" alt="{{ $animal->name }}"
                    class="object-cover rounded-xl mb-4">

                <div class="text-center">
                    <h3 class="text-xl font-semibold">{{ $animal->name }}</h3>
                    <p class="text-gray-700">{{ $animal->species }}</p>
                    <p class="text-gray-600 text-sm">Born at:
                        {{ $animal->birth_date }}</p>
                </div>

                <div class="mt-4 flex gap-2">
                    @auth
                        @if (Auth::user()->admin)
                            <a href="{{ route('animals.edit', ['animal' => $animal->id, 'redirect_back' => url()->full()]) }}"
                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                Edit
                            </a>

                            <form action="{{ route('animals.destroy', $animal->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="redirect_back" value="1">
                                <button type="submit"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                    Archive
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @empty
            <p class="text-center col-span-full text-gray-500">No animals currently in this enclosure.</p>
        @endforelse
    </div>
@endsection
