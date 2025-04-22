@extends('layouts.app')

@section('title', 'Home | Zoo Registry')

@section('content')
    <h1 class="text-4xl font-bold mb-4 mt-4">Welcome, <span class="text-red-600">{{ Auth::user()->name }}!</span></h1>

    <div class="grid grid-cols-1 gap-4 mb-8">
        <div class="bg-white p-4 mb-2 shadow rounded">
            <h2 class="text-2xl font-semibold mb-2">Number of enclosures</h2>
            <p class="text-4xl text-red-600 font-extrabold">{{ $enclosureCount }}</p>
        </div>
        <div class="bg-white p-4 mb-2 shadow rounded">
            <h2 class="text-2xl font-semibold mb-2">Number of animals</h2>
            <p class="text-4xl text-red-600 font-extrabold">{{ $animalCount }}</p>
        </div>
        <div class="bg-white p-4 mb-2 mt-4 shadow rounded">
            <h2 class="text-2xl font-extrabold mb-2">Your tasks (upcoming feedings)</h2>
            @if($feedingTasks->isEmpty())
                <p class="text-lg mt-4">There are no upcoming feedings.</p>
            @else
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($feedingTasks as $task)
                        <li class="text-xl">
                            {{ $task->name }}
                            – feeding at:
                            <span class="text-indigo-500 font-extrabold">{{ $task->feeding_at }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
@endsection
