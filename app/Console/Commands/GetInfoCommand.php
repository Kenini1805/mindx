<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\AllCountry;
use App\Models\TopCountry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        AllCountry::truncate();
        TopCountry::truncate();
        Country::truncate();
        $response = Http::withHeaders(
            [
                'X-RapidAPI-Key' => 'ed74e2be46msha0be35e5f345febp17ac10jsn4262a33cbe07'
            ])->get('https://world-population.p.rapidapi.com/allcountriesname');
        $countries = $response->json();
        $allCountry = $countries['body']['countries'];
        foreach ($allCountry as $key => $country) {
            if ($key < 20) {
                TopCountry::create([
                    'name' => $country,
                ]);
            }
            AllCountry::create([
                'name' => $country,
            ]);
        }

        $countries = AllCountry::all();
        foreach ($countries as $country) {
            $responseCountry = Http::withHeaders(
                [
                    'X-RapidAPI-Key' => 'ed74e2be46msha0be35e5f345febp17ac10jsn4262a33cbe07'
                ])->get('https://world-population.p.rapidapi.com/population', [
                    'country_name' => $country->name
                ]);
            Country::create($responseCountry->json()['body']);
        }
    }
}
