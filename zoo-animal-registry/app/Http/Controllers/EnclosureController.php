<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnclosureController extends Controller
{
    public function index()
    {

        $enclosures = new Collection();
        if (Auth::user()->admin) {
            $enclosures = Enclosure::withCount('animals')
                ->orderBy('name')
                ->paginate(5);
        } else {
            $enclosures = Auth::user()->enclosures()
                ->withCount('animals')
                ->orderBy('name')
                ->paginate(5);
        }

        return view('enclosures.index', compact('enclosures'));
    }

    public function show(Request $req, $id)
    {

        $enclosure = Enclosure::find($id);

        $animals = $enclosure->animals
            ->sortBy([
                ['species', 'asc'],
                ['birth_date', 'asc'],
            ])
            ->map(function ($animal) {
                $animal->birth_date = Carbon::parse($animal->birth_date)->format('Y-m-d');
                return $animal;
            });


        return view('enclosures.show', compact('enclosure', "animals"));
    }

    public function create()
    {
        return view('enclosures.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'for_predators' => $request->has('for_predators'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'limit' => 'required|integer|min:1',
            'feeding_at' => 'required|date_format:H:i',
            'for_predators' => 'boolean',
        ]);

        Enclosure::create($validated);

        return redirect()->route('enclosures.index')
            ->with('success', 'Enclosure created successfully.');
    }

    public function edit($id)
    {
        $enclosure = Enclosure::find($id)->first();
        return view('enclosures.edit', compact('enclosure'));
    }


    public function update(Request $request, $id)
    {
        $request->merge([
            'for_predators' => $request->has('for_predators'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'limit' => 'required|integer|min:1',
            'feeding_at' => 'required|date_format:H:i',
            'for_predators' => 'boolean',
        ]);

        Enclosure::create($validated);

        return redirect()->route('enclosures.index')
            ->with('success', 'Enclosure created successfully.');
    }

    public function destroy($id)
    {
        $enclosure = Enclosure::findOrFail($id);
        $enclosure->delete();

        return redirect()->route('enclosures.index')
            ->with('success', 'Enclosure deleted successfully.');
    }
}
