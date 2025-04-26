@extends('layouts.app')

@section('title', 'Edit Enclosure | Zoo Registry')

@section('content')
    <h1 class="text-4xl font-bold mb-6 mt-8 text-center">Editing <span class="text-red-600">{{ $animal->name }}!</span>
    </h1>

    <div class="max-w-xl mx-auto">
        <form method="POST" action="{{ route('animals.update', $animal->id) }}" novalidate>
            @csrf
            @method('PUT')

            @if(request('redirect_back'))
                <input type="hidden" name="redirect_back" value="{{ request('redirect_back') }}">
            @endif

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    :value="old('name', $animal->name)"
                    required
                    autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Species -->
            <div class="mb-4">
                <x-input-label for="species" :value="__('Animal Species')" />
                <x-text-input id="species" name="species" type="text" class="mt-1 block w-full"
                    :value="old('species', $animal->species)"
                    required />
                <x-input-error :messages="$errors->get('species')" class="mt-2" />
            </div>

            <!-- Born date -->
            <div class="mb-4">
                <x-input-label for="born_at" :value="__('Born Date')" />
                <x-text-input id="born_at" name="born_at" type="date" class="mt-1 block w-full"
                    :value="old('born_at', $animal->born_at->format('Y-m-d'))"
                    required />
                <x-input-error :messages="$errors->get('born_at')" class="mt-2" />
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
            </div>

            <!-- Is Predator -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_predator"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ old('is_predator', $animal->is_predator ) ? 'checked' : '' }}>
                    <span class="ms-2 text-sm text-gray-600">Is predator?</span>
                </label>
                <x-input-error :messages="$errors->get('is_predator')" class="mt-2" />
                <x-input-error :messages="$errors->get('enclosure_id')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <x-primary-button>
                    {{ __('Update Animal') }}
                </x-primary-button>
                <a href="{{ url()->previous() }}" class="text-indigo-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
