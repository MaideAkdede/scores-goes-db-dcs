<?php
namespace Match;

function all(\PDO $connection): array
{

    $matchesRequest = 'SELECT * FROM matches ORDER BY date';
    $pdoSt = $connection->query($matchesRequest);

    return $pdoSt->fetchAll();
}

function find(\PDO $connection, string $id): \stdClass
{
    $matchRequest = 'SELECT * FROM matches WHERE id = :id';
    $pdoSt = $connection->prepare($matchRequest);
    $pdoSt->execute([':id' => $id]);

    return $pdoSt->fetch();
}

function allWithTeams(PDO $connection): array
{
    $matchesInfosRequest = 'SELECT * 
                            FROM matches 
                            JOIN participations p ON matches.id = p.match_id
                            JOIN teams t ON p.teams_id = t.id
                            ORDER BY matches.id';
    $pdoSt = $connection->query($matchesInfosRequest);

    return $pdoSt->fetchAll();
}