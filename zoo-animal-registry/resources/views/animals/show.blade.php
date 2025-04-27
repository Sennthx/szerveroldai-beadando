@extends('layouts.app')

@section('title', 'Enclosure | Zoo Registry')

@section('content')
    @include('layouts.toast')
    <h1 class="text-4xl font-bold mb-6 mt-8 text-center">Current Animal: <span
            class="text-red-600 font-extrabold">{{ $animal->name }}</span></h1>

    @if ($animal->is_predator)
        <div
            class="bg-red-100 text-red-800 border border-red-800 font-semibold px-4 py-2 rounded text-center max-w-xl mx-auto mb-6">
            ⚠️ This animal is a predator!
        </div>
    @else
        <div
            class="bg-green-100 text-green-800 border border-green-800 font-semibold px-4 py-2 rounded text-center max-w-xl mx-auto mb-6">
            ✅ This animal is not a predator!
        </div>
    @endif
    @if(isset($animal->deleted_at))
        <div
            class="bg-gray-200 text-gray-600 border border-gray-800 font-semibold px-4 py-2 rounded text-center max-w-xl mx-auto mb-4">
            ⚠️ This animal is archived!
        </div>
        <div class="max-w-xl mx-auto mx-auto m-8 p-6 bg-white shadow-md rounded-xl">
            <form action="{{ route('animals.restore', $animal->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Enclosure assign -->
                <div
                    class="bg-green-100 text-green-800 border border-green-800 font-semibold px-4 py-2 rounded text-center mb-2">
                    Assign an enclosre to restore this archived animal
                </div>
                <div class="mb-4">
                    <x-input-label for="enclosure_id" :value="__('Enclosures')" />
                    <select id="enclosure_id" name="enclosure_id" class="w-full mt-1 border rounded text-lg">
                        @foreach($enclosures as $enclosure)
                            <option value="{{ $enclosure->id }}"
                                {{ (old('enclosure_id', $animal->enclosure_id) == $enclosure->id) ? 'selected' : '' }}>
                                id: {{ $enclosure->id }} | Name: {{ $enclosure->name }}
                                @if($enclosure->for_predators)
                                    (For predators)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('enclosure_id')" class="mt-2" />
                </div>
                <button type="submit" class="px-3 py-2 bg-red-500 text-m text-white rounded hover:bg-red-600">
                    Restore this animal
                </button>
            </form>
        </div>
    @endif
    @if(!isset($animal->deleted_at))
        @auth
            @if (Auth::user()->admin)
                <div class="w-full flex justify-center mb-4 mt-8">
                    <a href="{{ route('animals.edit', $animal->id) }}"
                        class="px-3 py-2 mx-2 bg-indigo-500 text-lg text-white rounded hover:bg-indigo-600 ">
                        Edit this animal
                    </a>

                    <form action="{{ route('animals.destroy', $animal->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this animal?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 mx-2 bg-red-500 text-lg text-white rounded hover:bg-red-600">
                            Delete this animal
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    @endif

    <div class="max-w-4xl mx-auto m-8 p-6 bg-white shadow-md rounded-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-lg ">
            <div>
                <label class="text-xl font-extrabold">Name:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $animal->name }}</p>
            </div>
            <div>
                <label class="text-xl font-extrabold">Animal species:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $animal->species }}</p>
            </div>
            <div>
                <label class="text-xl font-extrabold">Born at:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $animal->born_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <label class="text-xl font-extrabold">Is predator:</label>
                <p class="text-lg text-red-600 font-extrabold">{{ $animal->is_predator ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    </div>

    <div class="flex justify-center mb-6 relative">
        <img
            src="{{ $animal->image_hash ? asset('storage/animals/images/' . $animal->image_hash) : asset('storage/placeholder-animal.jpg') }}"
            alt="{{ $animal->name }}"
            class="w-80 aspect-[16/10] object-cover rounded shadow-lg"
        >
    </div>

@endsection
