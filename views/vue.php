<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Premier League 2020</title>
</head>
<body>
<h1>Premier League 2020</h1>
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
<section>
    <h2>Matchs joués le <?= TODAY ?></h2>
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
        <?php foreach ($matches as $match): ?>
            <tr>
                <td><?= (new DateTime($match['match-date']))->format('j-m-Y') ?></td>
                <td><?= $match['home-team'] ?></td>
                <td><?= $match['home-team-goals'] ?></td>
                <td><?= $match['away-team-goals'] ?></td>
                <td><?= $match['away-team'] ?></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</section>
<section>
    <h2>Encodage d’un nouveau match</h2>
    <form action="../manage.php" method="post">
        <label for="match-date">Date du match</label>
        <input type="text" id="match-date" name="match-date" placeholder="<?= FORMAT_DATE ?>">
        <br>
        <label for="home-team">Équipe à domicile</label>
        <select name="home-team" id="home-team">
            <?php foreach ($teams as $team): ?>
                <option value="<?= $team ?>"><?= $team ?></option>
            <?php endforeach; ?>
        </select>
        <label for="home-team-unlisted">Équipe non listée&nbsp;?</label>
        <input type="text" name="home-team-unlisted" id="home-team-unlisted">
        <br>
        <label for="home-team-goals">Goals de l’équipe à domicile</label>
        <input type="text" id="home-team-goals" name="home-team-goals">
        <br>
        <label for="away-team">Équipe visiteuse</label>
        <select name="away-team" id="away-team">
            <?php foreach ($teams as $team): ?>
                <option value="<?= $team ?>"><?= $team ?></option>
            <?php endforeach; ?>
        </select>
        <label for="away-team-unlisted">Équipe non listée&nbsp;?</label>
        <input type="text" name="away-team-unlisted" id="away-team-unlisted">
        <br>
        <label for="away-team-goals">Goals de l’équipe visiteuse</label>
        <input type="text" id="away-team-goals" name="away-team-goals">
        <br>
        <input type="submit" value="Ajouter ce match">
        <input type="hidden" name="action" value="store">
        <input type="hidden" name="resource" value="match">
    </form>
</section>
</body>
</html>