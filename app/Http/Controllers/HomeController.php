<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\AllCountry;
use App\Models\TopCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        $responseCurrentPopulation = Http::withHeaders(
            [
                'X-RapidAPI-Key' => 'ed74e2be46msha0be35e5f345febp17ac10jsn4262a33cbe07'
            ])->get('https://world-population.p.rapidapi.com/worldpopulation');
        $currentPopulation = $responseCurrentPopulation->json();
        $currentPopulation = $currentPopulation['body']['world_population'];

        $top20 = TopCountry::all();
        $countries = Country::paginate(10);
        
        return view('index', compact('countries', 'currentPopulation', 'top20'));
    }
}
