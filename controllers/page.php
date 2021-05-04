<?php
namespace Controllers\Page;

use function Models\Team\all;
use function Models\Match\allWithTeams;
use function Models\Match\allMatchesWithTeamsGrouped;

require('models/team.php');
require('models/match.php');
require('utils/standings.php');

function dashboard(\PDO $pdo){

    $standings = [];
    $matches = allMatchesWithTeamsGrouped(allWithTeams($pdo));
    $teams = all($pdo);
    $view = './views/view.php';


    foreach ($matches as $match) {
        $homeTeam = $match->home_team;
        $awayTeam = $match->away_team;

        if (!array_key_exists($homeTeam, $standings)) {
            $standings[$homeTeam] = getEmptyStatsArray();
        }
        if (!array_key_exists($awayTeam, $standings)) {
            $standings[$awayTeam] = getEmptyStatsArray();
        }
        $standings[$homeTeam]['games']++;
        $standings[$awayTeam]['games']++;

        if ($match->home_team_goals === $match->away_team_goals) {
            $standings[$homeTeam]['points']++;
            $standings[$awayTeam]['points']++;
            $standings[$homeTeam]['draws']++;
            $standings[$awayTeam]['draws']++;
        } elseif ($match->home_team_goals > $match->away_team_goals) {
            $standings[$homeTeam]['points'] += 3;
            $standings[$homeTeam]['wins']++;
            $standings[$awayTeam]['losses']++;
        } else {
            $standings[$awayTeam]['points'] += 3;
            $standings[$awayTeam]['wins']++;
            $standings[$homeTeam]['losses']++;
        }
        $standings[$homeTeam]['GF'] += $match->home_team_goals;
        $standings[$homeTeam]['GA'] += $match->away_team_goals;
        $standings[$awayTeam]['GF'] += $match->away_team_goals;
        $standings[$awayTeam]['GA'] += $match->home_team_goals;
        $standings[$homeTeam]['GD'] += $standings[$homeTeam]['GF'] - $standings[$homeTeam]['GA'];
        $standings[$awayTeam]['GD'] += $standings[$awayTeam]['GF'] - $standings[$awayTeam]['GA'];

    }

    uasort($standings, static function ($homeTeam, $awayTeam) {
        if ($homeTeam['points'] === $awayTeam['points']) {
            if ($homeTeam['GD'] > $awayTeam['GD']) {
                return -1;
            } else {
                return 1;
            }
        }
        return $homeTeam['points'] > $awayTeam['points'] ? -1 : 1;
    });

    return compact('standings', 'matches', 'teams', 'view');
}