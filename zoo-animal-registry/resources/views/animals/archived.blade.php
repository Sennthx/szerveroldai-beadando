@extends('layouts.app')

@section('title', 'Archived Animals | Zoo Registry')

@section('content')
    @include('layouts.toast')
    <h1 class="text-4xl font-bold mb-4 mt-6 text-center">List of all archived <span
            class="text-red-600 font-extrabold">Animals!</span></h1>

    <div class="w-full flex justify-center mb-8">
        <table class="table-auto text-xl w-fit max-w-4xl min-w-[60rem] mx-auto my-4 bg-white shadow-md rounded-xl ">
            <thead class="text-center table-light">
                <tr>
                    <th class="p-4">Animal name</th>
                    <th class="p-4">Species</th>
                    <th class="p-4">Born at</th>
                    <th class="p-4">Is predator</th>
                    <th class="p-4">Archived at</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($archived_animals as $animal)
                    <tr class="border">
                        <td class="px-8 py-4 text-center">
                            <span class="text-indigo-500 font-extrabold">{{ $animal->name }}</span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">{{ $animal->species }}</span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">{{ $animal->born_at->format('Y-m-d') }}</span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">
                                @if ($animal->is_predator)
                                    yes
                                @else
                                    no
                                @endif
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="badge rounded-pill bg-info fs-6">{{ $animal->deleted_at }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <a href="{{ route('animals.show', $animal->id) }}"
                                class="text-red-600 hover:text-red-700 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($archived_animals->count() == 0)
        <div class="text-4xl font-semibold text-black mb-4 mt-6 text-center">There are no <span
                class="text-red-600">archived</span> animals...</div>
    @endif
    <div class="mt-4 w-full max-w-4xl mx-auto">
        {{ $archived_animals->links() }}
    </div>
@endsection
