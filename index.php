<?php
use function Models\Team\all as teamAll;
use function Models\Match\allWithTeams as allMatchesWithTeams;
use function Models\Match\allMatchesWithTeamsGrouped as allMatchesWithTeamsGrouped;
use function Controllers\Match\store as storeMatch;
use function Controllers\Team\store as storeTeam;

require('vendor/autoload.php');

require('configs/config.php');
require('utils/dbaccess.php');
require('utils/standings.php');

require('models/team.php');
require('models/match.php');
require('controllers/match.php');
require('controllers/team.php');

$pdo = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traiter les trucs en POST
    if (isset($_POST['action']) && isset($_POST['resource'])) {
        if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {
            storeMatch($pdo);
        }elseif($_POST['action'] === 'store' && $_POST['resource'] === 'team'){
            storeTeam($pdo);
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Traiter les trucs en GET
    if (!isset($_GET['action']) && !isset($_GET['resource'])) {
        // HOMEPAGE
        $standings = [];

        $matches2 = allMatchesWithTeamsGrouped(allMatchesWithTeams($pdo));
        $teams = teamAll($pdo);

        foreach ($matches2 as $match) {
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


    }
} else {
    // Si ni POST ni GET alors rediriger à Index (accueil) et Stopper l'execution du script
    header('Location: index.php');
    exit();
}

require('views/vue.php');