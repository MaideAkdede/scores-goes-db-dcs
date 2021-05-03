<?php
namespace Controllers\Match;

use function Models\Match\save as saveMatch;

function store(\PDO $pdo)
{
    $matchDate = $_POST['match-date'] ?: FORMAT_DATE;
    $homeTeam = $_POST['home-team'];
    $awayTeam = $_POST['away-team'];
    $homeTeamGoals = $_POST['home-team-goals'] ?: "0";
    $awayTeamGoals = $_POST['away-team-goals'] ?: "0";

    $match = [
        'date' => $matchDate,
        'home-team' => $homeTeam,
        'home-team-goals' => $homeTeamGoals,
        'away-team-goals' => $awayTeamGoals,
        'away-team' => $awayTeam
    ];

    saveMatch($pdo, $match);
    header('Location: index.php');
    exit();
}
