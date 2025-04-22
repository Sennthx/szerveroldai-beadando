@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>

    <div class="grid grid-cols-1 gap-4 mb-8">
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold mb-2">Number of enclosures</h2>
            <p class="text-2xl text-red-600 font-extrabold">{{ $enclosureCount }}</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-lg font-semibold mb-2">Number of animals</h2>
            <p class="text-2xl text-red-600 font-extrabold">{{ $animalCount }}</p>
        </div>
        <div class="bg-white p-4 shadow rounded">
            <h2 class="text-xl font-extrabold mb-2">Your tasks (upcoming feedings)</h2>
            @if($feedingTasks->isEmpty())
                <p>There are no upcoming feedings.</p>
            @else
                <ul class="list-disc pl-5 space-y-2">
                    @foreach ($feedingTasks as $task)
                        <li>
                            {{ $task->name }} – feedin: <span class="text-red-600 font-extrabold">{{ $task->feeding_at }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
