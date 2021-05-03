<?php
namespace Models\Team;

function all(\PDO $connection): array
{
    $teamsRequest = 'SELECT * FROM teams ORDER BY name';
    $pdoSt = $connection->query($teamsRequest);

    return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id): \stdClass
{
    $teamRequest = 'SELECT * FROM teams WHERE id = :id';
    $pdoSt = $connection->prepare($teamRequest);
    $pdoSt->execute([':id' => $id]);

    return $pdoSt->fetch();
}


function save(\PDO $connection, array $team)
{
    $insertTeamRequest = 'INSERT INTO teams(`name`, `slug`) VALUES (:name, :slug)';
    $pdoSt = $connection->prepare($insertTeamRequest);
    $pdoSt->execute([':name' => $team['name'], ':slug' => $team['slug']]);
}