<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Animal;
use App\Models\Enclosure;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $title = config('app.name');
        $enclosures = Auth::user()->enclosures;

        $enclosureCount = Enclosure::count();
        $animalCount = Animal::count();

        $now = Carbon::now('Europe/Budapest')->format('H:i:s');

/*         $feedingTasks = $enclosures->filter(function ($enclosure) use ($now) {
            $feedingTime = Carbon::parse($enclosure->feeding_at);
            return $feedingTime->isAfter($now);
        });

        $feedingTasks = $feedingTasks->map(function ($enclosure) {
            $enclosure->feeding_at = $enclosure->feeding_at ? Carbon::parse($enclosure->feeding_at)->format('H:i') : 'Missing';
            return $enclosure;
        }); */

        $feedingTasks = Auth::user()->enclosures
            ->where('feeding_at', '>', $now) // Filter feeding times after now
            ->sortBy('feeding_at') // Order enclosures by feeding_at time in ascending order
            ->map(function ($enclosure) {
                // Format the feeding time for display
                $enclosure->formatted_feeding_at = $enclosure->feeding_at ? Carbon::parse($enclosure->feeding_at)->format('H:i') : 'Missing';
                return $enclosure;
            });


        return view('home', compact('title', 'enclosureCount', 'animalCount', 'feedingTasks'));
    }
}
