@extends('layouts.app')

@section('title', 'Create Enclosure | Zoo Registry')

@section('content')
    <h1 class="text-4xl font-bold mb-6 mt-8 text-center">Create an <span class="text-red-600">Enclosure!</span></h1>

    <div class="max-w-xl mx-auto">
        <form method="POST" action="{{ route('enclosures.store') }}" novalidate>
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required
                    autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Limit -->
            <div class="mb-4">
                <x-input-label for="limit" :value="__('Animal Limit')" />
                <x-text-input id="limit" name="limit" type="number" class="mt-1 block w-full" :value="old('limit')"
                    required />
                <x-input-error :messages="$errors->get('limit')" class="mt-2" />
            </div>

            <!-- Feeding At -->
            <div class="mb-4">
                <x-input-label for="feeding_at" :value="__('Feeding Time')" />
                <x-text-input id="feeding_at" name="feeding_at" type="time" class="mt-1 block w-full" :value="old('feeding_at')"
                    required />
                <x-input-error :messages="$errors->get('feeding_at')" class="mt-2" />
            </div>

            <!-- For Predators -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="for_predators"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ old('for_predators') ? 'checked' : '' }}>
                    <span class="ms-2 text-sm text-gray-600">For Predators?</span>
                </label>
                <x-input-error :messages="$errors->get('for_predators')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <x-primary-button>
                    {{ __('Create Enclosure') }}
                </x-primary-button>
                <a href="{{ route('enclosures.index') }}" class="text-indigo-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
