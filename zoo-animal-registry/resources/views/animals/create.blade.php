@extends('layouts.app')

@section('title', 'Create Enclosure | Zoo Registry')

@section('content')
    <h1 class="text-4xl font-bold mb-6 mt-8 text-center">Create an <span class="text-red-600">Animal!</span></h1>

    <div class="max-w-xl mx-auto">
        <form method="POST" action="{{ route('animals.store') }}"
            enctype="multipart/form-data" novalidate>
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name')"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Species -->
            <div class="mb-4">
                <x-input-label for="species" :value="__('Animal Species')" />
                <x-text-input id="species" name="species" type="text" class="mt-1 block w-full"
                    :value="old('species')"
                    required />
                <x-input-error :messages="$errors->get('species')" class="mt-2" />
            </div>

            <!-- Feeding Date -->
            <div class="mb-4">
                <x-input-label for="born_at" :value="__('Born Date')" />
                <x-text-input id="born_at" name="born_at" type="date" class="mt-1 block w-full"
                    :value="old('born_at')"
                    required />
                <x-input-error :messages="$errors->get('born_at')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="enclosure_id" :value="__('Enclosures')" />
                <select id="enclosure_id" name="enclosure_id" class="w-full mt-1 border rounded text-lg">
                    @foreach($enclosures as $enclosure)
                        <option value="{{ $enclosure->id }}" {{ old('enclosure_id') == $enclosure->id ? 'selected' : '' }}>
                            id: {{ $enclosure->id }} | Name: {{ $enclosure->name }}
                            @if($enclosure->for_predators)
                                (For predators)
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Is Predator -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_predator"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ old('is_predator') ? 'checked' : '' }}>
                    <span class="ms-2 text-sm text-gray-600">Is predator?</span>
                </label>
                <x-input-error :messages="$errors->get('is_predator')" class="mt-2" />
                <x-input-error :messages="$errors->get('enclosure_id')" class="mt-2" />
            </div>

            <div class="mb-6">
                <x-input-label for="image" :value="__('Animal Image')" />
                <input type="file" id="image" name="image"
                    class="block w-full text-sm text-gray-500
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-full file:border-0
                           file:text-sm file:font-semibold
                           file:bg-indigo-50 file:text-indigo-700
                           hover:file:bg-indigo-100" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <x-primary-button>
                    {{ __('Create Animal') }}
                </x-primary-button>
                <a href="{{ route('animals.index') }}" class="text-indigo-500 hover:underline">Cancel</a>
            </div>

        </form>
    </div>
@endsection
