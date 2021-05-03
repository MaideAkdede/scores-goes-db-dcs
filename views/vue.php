<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Premier League 2020</title>
</head>
<body>
<h1>Premier League 2020</h1>
<?php if(count($matches2)) : ?>
<section>
    <h2>Standings</h2>
    <table>
        <thead>
        <tr>
            <td></td>
            <th scope="col">Équipe</th>
            <th scope="col">Matchs</th>
            <th scope="col">Points</th>
            <th scope="col">Victoires</th>
            <th scope="col">Défaites</th>
            <th scope="col">Match Nul</th>
            <th scope="col"><abbr title="Goals en Faveur">GF</abbr></th>
            <th scope="col"><abbr title="Goals Adverses/contres">GA</abbr></th>
            <th scope="col"><abbr title="Différences de Goal">GD</abbr></th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($standings as $team => $teamStats): ?>
            <tr>
                <td><?= $i++ ?></td>
                <th scope="row"><?= $team ?></th>
                <td><?= $teamStats['games'] ?></td>
                <td><?= $teamStats['points'] ?></td>
                <td><?= $teamStats['wins'] ?></td>
                <td><?= $teamStats['losses'] ?></td>
                <td><?= $teamStats['draws'] ?></td>
                <td><?= $teamStats['GF'] ?></td>
                <td><?= $teamStats['GA'] ?></td>
                <td><?= $teamStats['GD'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php endif; ?>

<section>
    <h2>Matchs joués le <?= TODAY ?></h2>
    <?php if(count($matches2)) : ?>
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Équipe Locale</th>
            <th>Goals Équipe Locale</th>
            <th>Goals Équipe Adverse</th>
            <th>Équipe Adverse</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($matches2 as $match): ?>
            <tr>
                <td><?= ($match->match_date)->format('j-m-Y') ?></td>
                <td><?= $match->home_team; ?></td>
                <td><?= $match->home_team_goals; ?></td>
                <td><?= $match->away_team_goals; ?></td>
                <td><?= $match->away_team; ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <?php else: ?>
    <p>Aucun match n'a été joué à ce jour</p>
    <?php endif; ?>

</section>
<section>
    <h2>Encodage d’un nouveau match</h2>
    <form action="../index.php" method="post">
        <label for="match-date">Date du match</label>
        <input type="text" id="match-date" name="match-date" placeholder="<?= FORMAT_DATE ?>">
        <br>
        <label for="home-team">Équipe à domicile</label>
        <select name="home-team" id="home-team">
            <?php foreach ($teams as $team): ?>
                <option value="<?= $team->id ?>"><?= $team->name ?> [<?= $team->slug ?>]</option>
            <?php endforeach; ?>
        </select>
        <label for="home-team-unlisted">Équipe non listée&nbsp;?</label>
        <input type="text" name="home-team-unlisted" id="home-team-unlisted" placeholder="Nouvelle équipe">
        <br>
        <label for="home-team-goals">Goals de l’équipe à domicile</label>
        <input type="text" id="home-team-goals" name="home-team-goals" placeholder="0">
        <br>
        <label for="away-team">Équipe visiteuse</label>
        <select name="away-team" id="away-team">
            <?php foreach ($teams as $team): ?>
                <option value="<?= $team->id ?>"><?= $team->name ?> [<?= $team->slug ?>]</option>
            <?php endforeach; ?>
        </select>
        <label for="away-team-unlisted">Équipe non listée&nbsp;?</label>
        <input type="text" name="away-team-unlisted" id="away-team-unlisted" placeholder="Nouvelle équipe">
        <br>
        <label for="away-team-goals">Goals de l’équipe visiteuse</label>
        <input type="text" id="away-team-goals" name="away-team-goals" placeholder="0">
        <br>
        <input type="submit" value="Ajouter ce match">
        <input type="hidden" name="action" value="store">
        <input type="hidden" name="resource" value="match">
    </form>
</section>
</body>
</html>