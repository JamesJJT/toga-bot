<?php

namespace App\Football;

use GuzzleHttp\Client;

class FootballAPI{

    public static function run($uri,$type = 'GET')
    {
        $client = new Client([
            'base_uri'  =>  'http://api.football-data.org/',
            'headers'   =>  [
                'X-Auth-Token' => getenv('FOOTBALL_API_TOKEN')
            ]
        ]);
        return json_decode($client->request($type,$uri)->getBody());
    }

    public static function getLeagues( array $filter = ['stage' => ''])
    {
        $leagueTeams = self::run("v2/competitions"."?".http_build_query($filter));
        return collect($leagueTeams->competitions);
    }

    public static function getLeague(int $leagueID, array $filter = ['areas' => ''])
    {
        $league = self::run("v2/competitions/{$leagueID}"."?".http_build_query($filter));
        return collect($league);
    }

    public static function getLeagueStandings(int $leagueID)
    {
        $leagueStandings = self::run("v2/competitions/{$leagueID}/standings");
        return collect($leagueStandings->standings)[0]->table;
    }
}
