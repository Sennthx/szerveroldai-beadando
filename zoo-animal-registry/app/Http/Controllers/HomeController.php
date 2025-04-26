<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Animal;
use App\Models\Enclosure;

class HomeController extends Controller
{
    public function index()
    {
        $enclosureCount = Enclosure::count();
        $animalCount = Animal::count();

        $enclosures = [];

        if (Auth::user()->admin) {
            $enclosures = Enclosure::get();
        } else {
            $enclosures = Auth::user()->enclosures;
        }

        $now = Carbon::now('Europe/Budapest')->format('H:i');

        $feedingTasks = $enclosures
            ->where('feeding_at', '>', $now) // Filter feeding times after now
            ->sortBy('feeding_at') // Order enclosures by feeding_at time in ascending order
            ->map(function ($enclosure) {
                // Format the feeding time for display
                $enclosure->formatted_feeding_at = $enclosure->feeding_at ? Carbon::parse($enclosure->feeding_at)->format('H:i') : 'Missing';
                return $enclosure;
            });


        return view('home', compact('enclosureCount', 'animalCount', 'feedingTasks'));
    }
}
