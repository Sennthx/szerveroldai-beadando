<?php

namespace App\Http\Controllers;

use App\Models\Enclosure;
use App\Models\User;
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

    public function show($id)
    {
        $enclosure = Enclosure::find($id);

        if (!$enclosure) {
            return redirect()->route('enclosures.index')->withErrors('Enclosure not found.');
        }

        if (!Auth::user()->enclosures->contains($enclosure->id)) {
            return redirect()->route('enclosures.index')->withErrors('You are not assigned to this enclosure.');
        }

        $animals = $enclosure->animals
            ->sortBy([
                ['species', 'asc'],
                ['born_at', 'asc'],
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
            'name' => 'required|string|max:20',
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
        $enclosure = Enclosure::find($id);

        if (!$enclosure) {
            return redirect()->route('enclosures.index')->withErrors('Enclosure not found.');
        }

        $users = User::all();

        return view('enclosures.edit', compact('enclosure', 'users'));
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

        if ($request->has('redirect_back')) {
            return redirect()->to($request->input('redirect_back'))
                ->with('success', 'Enclosure updated successfully.');
        }

        return redirect()->route('enclosures.index')
            ->with('success', 'Enclosure updated successfully.');
    }

    public function destroy($id)
    {
        $enclosure = Enclosure::find($id);

        if (!$enclosure) {
            return redirect()->route('enclosures.index')->withErrors('Enclosure not found.');
        }

        if ($enclosure->animals->count() > 0) {
            return redirect()->back()
                ->withErrors('Cannot delete enclosure with animals in it. Please move them first.');
        }

        $enclosure->delete();

        return redirect()->route('enclosures.index')
            ->with('success', 'Enclosure deleted successfully.');
    }
}
