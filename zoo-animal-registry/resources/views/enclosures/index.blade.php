@extends('layouts.app')

@section('title', 'Enclosures | Zoo Registry')

@section('content')
    @auth
        @if (Auth::user()->admin)
            <div class="w-full flex justify-center mb-4 mt-8">
                <a href="{{ route('enclosures.create') }}"
                    class="px-3 py-2 bg-indigo-500 text-lg text-white rounded hover:bg-indigo-600 ">
                    Create an enclosure
                </a>
            </div>
        @endif
    @endauth
    <h1 class="text-4xl font-bold mb-4 mt-6 text-center">Enclosures assigned to <span
            class="text-red-600 font-extrabold">you!</span></h1>

    <div class="w-full flex justify-center mb-8">
        <table class="table-auto text-xl w-fit max-w-4xl mx-auto my-4 bg-white shadow-md rounded-xl ">
            <thead class="text-center table-light">
                <tr>
                    <th class="p-4">Enclosure name</th>
                    <th class="p-4">Animal limit</th>
                    <th class="p-4">Current animals</th>
                    <th class="p-4">For predators</th>
                    <th class="p-4"></th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($enclosures as $enclosure)
                    <tr class="border">
                        <td class="px-8 py-4 text-center">
                            <span class="text-indigo-500 font-extrabold">{{ $enclosure->name }}</span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">{{ $enclosure->limit }}</span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">{{ $enclosure->animals_count }}</span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">
                                @if ($enclosure->for_predators)
                                    yes
                                @else
                                    no
                                @endif
                            </span>
                        </td>
                        <td class="px-8 py-4">
                            <a href="{{ route('enclosures.show', $enclosure->id) }}"
                                class="text-red-600 hover:text-red-700 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 w-full max-w-4xl mx-auto">
        {{ $enclosures->links() }}
    </div>
@endsection
