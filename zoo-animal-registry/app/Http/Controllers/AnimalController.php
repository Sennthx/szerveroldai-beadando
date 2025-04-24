<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    public function index()
    {

        $animals = Animal::orderBy('species')
                    ->orderBy('birth_date')
                    ->paginate(5);

        $animals->map(function ($animal) {
                $animal->birth_date = Carbon::parse($animal->birth_date)->format('Y-m-d');
                return $animal;
            });

        return view('animals.index', compact('animals'));
    }

    public function show($id)
    {
        $animal = Animal::withTrashed()->find($id);

        if (!$animal) {
            return redirect()->route('animals.index')->withErrors('Animal not found.');
        }

        if (isset($animal->deleted_at) && !Auth::user()->admin) {
            return redirect()->route('animals.index')->withErrors('Animal not found.');
        }

        return view('animals.show', compact('animal'));
    }

    public function archived() {
        $enclosure = Enclosure::find(1);

        if (!$enclosure) {
            return redirect()->route('animals.index')->withErrors('Archive enclosure not found.');
        }

        $archived_animals = $enclosure->animals()
            ->orderBy('species')
            ->orderBy('birth_date')
            ->paginate(5);

        return view('animals.archived', compact('archived_animals'));
    }

    public function create()
    {
        $enclosures = Enclosure::where('id', '!=', 1)->get();
        return view('animals.create', compact('enclosures'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_predator' => $request->has('is_predator'),
        ]);

        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
            'species' => 'required|string|max:20',
            'born_at' => 'required|date_format:Y-m-d',
            'is_predator' => 'boolean',
            'enclosure_id' => [
                'required',
                'exists:enclosures,id',
                function ($attribute, $value, $fail) use ($request) {
                    $enclosure = Enclosure::find($value);

                    if (!$enclosure) return;

                    if ($request->boolean('is_predator') && !$enclosure->for_predators) {
                        $fail('Predators can only be assigned to predator enclosures.');
                    }

                    if (!$request->boolean('is_predator') && $enclosure->for_predators) {
                        $fail('Non-predators can only be assigned to non-predator enclosures.');
                    }
                }
            ],
        ]);

        if ($validated->fails()) {
            return back()->withErrors($validated)->withInput();
        }

        Animal::create($validated->validated());

        return redirect()->route('animals.index')
            ->with('success', 'Animal created successfully.');
    }

    public function edit($id)
    {
        $animal = Animal::find($id);

        if (!$animal) {
            return redirect()->route('animals.index')->withErrors('Animal not found.');
        }

        $enclosures = Enclosure::all();

        return view('animals.edit', compact('animal', 'enclosures'));
    }

    public function update(Request $request, $id)
    {
        $enclosure = Enclosure::find($id);

        if (!$enclosure) {
            return redirect()->route('enclosures.index')->withErrors('Enclosure not found.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'limit' => 'required|integer|min:1',
            'feeding_at' => 'required|date_format:H:i',
            'caretakers' => 'nullable|array',
            'caretakers.*' => 'exists:users,id',
        ]);

        $enclosure->update($validated);

        if ($request->has('caretakers')) {
            $enclosure->users()->sync($request->input('caretakers'));
        }

        return redirect()->route('animals.index')
            ->with('success', 'Animal edited successfully.');
    }

    public function destroy(Request $request, $id)
    {
        $animal = Animal::find($id);

        if (!$animal) {
            return redirect()->route('animals.index')->withErrors('Animal not found.');
        }

        $animal->archive();

        if ($request->has('redirect_back')) {
            return redirect()->back()
                ->with('success', 'Animal archived successfully.');
        }

        return redirect()->route('animals.index')
            ->with('success', 'Animal archived successfully.');
    }
}
