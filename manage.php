<?php
include('configs/config.php');

function appendArrayToCSV(array $array, string $csvFile)
{
    $handle = fopen($csvFile, 'a');
    fputcsv($handle, $array);
    fclose($handle);
}

if (isset($_POST['action']) && isset($_POST['resource'])) {
    if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {

        $matchDate = $_POST['match-date'] ?: FORMAT_DATE;
        $homeTeam = $_POST['home-team-unlisted'] === '' ? $_POST['home-team'] : $_POST['home-team-unlisted'] ;
        $awayTeam = $_POST['away-team-unlisted'] === '' ? $_POST['away-team'] : $_POST['away-team-unlisted'];
        $homeTeamGoals = $_POST['home-team-goals'] ?: 0 ;
        $awayTeamGoals = $_POST['away-team-goals'] ?: 0;

        $match = [$matchDate, $homeTeam, $homeTeamGoals, $awayTeamGoals, $awayTeam];
        appendArrayToCSV($match, FILE_PATH);
    }

}
header('Location: index.php');
exit;

