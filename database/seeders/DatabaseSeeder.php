<?php

namespace Database\Seeders;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Player::factory(240)->create();

        $teamNames = [
            'Arizona Diamondbacks',
            'Atlanta Braves',
            'Baltimore Orioles',
            'Boston Red Sox',
            'Chicago Cubs',
            'Chicago White Sox',
            'Cincinnati Reds',
            'Cleveland Guardians',
            'Colorado Rockies',
            'Detroit Tigers',
            'Houston Astros',
            'Kansas City Royals',
            'Los Angeles Angels',
            'Los Angeles Dodgers',
            'Miami Marlins',
            'Milwaukee Brewers',
            'Minnesota Twins',
            'New York Mets',
            'New York Yankees',
            'Oakland Athletics',
            'Philadelphia Phillies',
            'Pittsburgh Pirates',
            'San Diego Padres',
            'San Francisco Giants',
            'Seattle Mariners',
            'St. Louis Cardinals',
            'Tampa Bay Rays',
            'Texas Rangers',
            'Toronto Blue Jays',
            'Washington Nationals',
        ];

        foreach ($teamNames as $teamName) {
            Team::factory()->create(['name' => $teamName]);
        }
    }
}
