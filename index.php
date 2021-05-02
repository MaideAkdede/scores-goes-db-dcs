<?php

use function Team\all as teamAll;
use function Match\allWithTeams as allMatchesWithTeams;
use function Match\allMatchesWithTeamsGrouped as allMatchesWithTeamsGrouped;

require('configs/config.php');
require('utils/dbaccess.php');
require('models/team.php');
require('models/match.php');

$pdo = getConnection();

$standings = [];
$matches2 =  allMatchesWithTeamsGrouped(allMatchesWithTeams($pdo));
$teams = teamAll($pdo);

function getEmptyStatsArray()
{
    return [
        'games' => 0,
        'points' => 0,
        'wins' => 0,
        'losses' => 0,
        'draws' => 0,
        'GF' => 0,
        'GA' => 0,
        'GD' => 0,
    ];
}

foreach ($matches2 as $match){
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

uasort($standings, function ($homeTeam, $awayTeam) {
    if ($homeTeam['points'] === $awayTeam['points']) {
        if ($homeTeam['GD'] > $awayTeam['GD']) {
            return -1;
        } else {
            return 1;
        }
    }
    return $homeTeam['points'] > $awayTeam['points'] ? -1 : 1;
});

require('views/vue.php');