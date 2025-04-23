<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnclosureController extends Controller
{
    public function index()
    {

        $enclosures = new Collection();
        if (Auth::user()->admin) {
            $enclosures = Enclosure::orderBy('name')->get();
        } else {
            $enclosures = Auth::user()->enclosures
                ->sortBy('name');
        }

        $enclosures = $enclosures->map(function ($enclosure) {
            $enclosure->current_animals_count = Animal::where('enclosure_id', '=', $enclosure->id)->get()->count();
            return $enclosure;
        });

        return view('enclosures.index', compact('enclosures'));
    }

    public function show($id)
    {

        $enclosure = Enclosure::find($id);

        $animals = $enclosure->animals
            ->sortBy([
                ['species', 'asc'],
                ['birth_date', 'asc'],
            ]);


        return view('enclosures.show', compact('enclosure', "animals"));
    }

    public function create()
    {
        return view('enclosures.create');
    }

    public function edit($id)
    {
        $enclosure = Enclosure::find($id)->first();
        return view('enclosures.edit', compact('enclosure'));
    }
}
