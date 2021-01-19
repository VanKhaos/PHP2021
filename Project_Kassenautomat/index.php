<?php

    session_start();

    // Daten aus dem Formular in Variablen speichern
    $preis = (isset($_GET["preis"]) ? floatval($_GET["preis"]) : 0 );
    $betrag = (isset($_GET["betrag"]) ? floatval($_GET["betrag"]) : 0 );

    $restgeld = floor(($betrag - $preis) * 100);

    $e200 = floor(($restgeld / 200));
    $restgeld = $restgeld % 200;

    $e100 = floor(($restgeld / 100));
    $restgeld = $restgeld % 100;

    $e050 = floor(($restgeld / 50));
    $restgeld = $restgeld % 50;

    $e020 = floor(($restgeld / 20));
    $restgeld = $restgeld % 20;

    $e010 = floor(($restgeld / 10));
    $restgeld = $restgeld % 10;

    $e005 = floor(($restgeld / 5));
    $restgeld = $restgeld % 5;

    $e002 = floor(($restgeld / 2));
    $restgeld = $restgeld % 2;

    $e001 = floor($restgeld);


?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Kassenautomat</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<h1>Kassenautomat</h1>
<form method="get" action="">

    <fieldset class="eingabe">
        <legend>Eingabe</legend>

        <img src="images/cash-register.png" alt="Kasse"/><br/>

        <label for="preis">Preis &euro;:</label><br/>
        <input type="number" name="preis" id="preis" step="0.01" placeholder="0,00" required value="<?php echo $preis; ?>"><br/>

        <label for="betrag">Betrag &euro;:</label><br/>
        <input type="number" name="betrag" id="betrag" step="0.01" placeholder="0,00" required value="<?php echo $betrag; ?>"><br/>

        <input type="submit" id="berechnen" value="Berechnen">

    </fieldset>

    <fieldset class="ausgabe">
        <legend>Ausgabe</legend>

        <img src="images/euro-coins-euro-coins.jpg" alt="Restgeld"/>
        <div class="box">
            <label>2,00 € x </label> <label id="e200"><?php echo $e200; ?></label><br/>
            <label>1,00 € x </label> <label id="e100"><?php echo $e100; ?></label><br/>
            <label>0,50 € x </label> <label id="e050"><?php echo $e050; ?></label><br/>
            <label>0,20 € x </label> <label id="e020"><?php echo $e020; ?></label><br/>
        </div>

        <div class="box">
            <label>0,10 € x </label> <label id="e010"><?php echo $e010; ?></label><br/>
            <label>0,05 € x </label> <label id="e005"><?php echo $e050; ?></label><br/>
            <label>0,02 € x </label> <label id="e002"><?php echo $e002; ?></label><br/>
            <label>0,01 € x </label> <label id="e001"><?php echo $e001; ?></label><br/>
        </div>

    </fieldset>
</form>


</body>
</html>