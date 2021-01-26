<?php
session_start(); // generiert für die Sitzung eine eindeutige SessionId immer die erste Anweisung
//Parameterliste der URL Parsen mit
/*
http://localhost/BasisPHPScript.php?Parametername=Wert&...
$_POST["Parametername"]; // nur wenn mit method="post" verschickt wurde
$_GET["Parametername"]; // nur wenn mit method="get" verschickt wurde
$_REQUEST["Parametername"]; // wenn mit post oder get verschickt wurde sollte man aus Sicherheitsgründen nicht verwenden
Prüfen, ob Parameter in URL enthalten mit
isset($_POST["Parametername"]) liefert true oder false
Werte in den Richtigen Typ umwandeln
// z.B. wenn Wert numerisch
$Variable=(int)($_POST["Parametername"]); oder intval($_POST["Parametername"])
oder
$Variable=(double)($_POST["Parametername"]); oder doubleval($_POST["Parametername"])
 */
// Verarbeitung durchführen
$Nachname = (isset($_POST["nachname"]) ? $_POST["nachname"] : "");
$Mwst = (isset($_POST["zahl"]) ? (int)($_POST["zahl"]) : 0);
$Netto =(isset($_POST["geld"]) ? doubleval($_POST["geld"]) : 0);
$Mwst =$Mwst/100.0; // Typ ändert sich von int auf double
$Brutto =$Netto*(1+$Mwst);
?>
<!doctype html>
<html lang="de">
    <head>
        <meta charset="utf-8"/>
        <title>BasisPHPScript</title>
    </head>
    <body>
        <!-- Formular füllen -->
        <label><?php echo $Nachname ?></label>
        <br/>
        <?php
            echo "<label>Mwst. </label>$Mwst<br/>";
            echo $Brutto."<br/>";
        ?>
    </body>
</html>