@extends('layouts.app')

@section('title', 'Edit Enclosure | Zoo Registry')

@section('content')
    <h1 class="text-4xl font-bold mb-6 mt-8 text-center">Editing <span class="text-red-600">{{ $enclosure->name }}!</span>
    </h1>

    <div class="max-w-xl mx-auto">
        <form method="POST" action="{{ route('enclosures.update', $enclosure->id) }}" novalidate>
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $enclosure->name)" required
                    autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Limit -->
            <div class="mb-4">
                <x-input-label for="limit" :value="__('Animal Limit')" />
                <x-text-input id="limit" name="limit" type="number" class="mt-1 block w-full" :value="old('limit', $enclosure->limit)"
                    required />
                <x-input-error :messages="$errors->get('limit')" class="mt-2" />
            </div>

            <!-- Feeding At -->
            <div class="mb-4">
                <x-input-label for="feeding_at" :value="__('Feeding Time')" />
                <x-text-input id="feeding_at" name="feeding_at" type="time" class="mt-1 block w-full" :value="old('feeding_at', $enclosure->feeding_at)"
                    required />
                <x-input-error :messages="$errors->get('feeding_at')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <x-primary-button>
                    {{ __('Update Enclosure') }}
                </x-primary-button>
                <a href="{{ route('enclosures.index') }}" class="text-indigo-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
