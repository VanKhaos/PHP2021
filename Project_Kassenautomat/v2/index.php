<?php
    session_start();


    // Parameter auslesen
    $Preis = isset($_GET["preis"])?doubleval($_GET["preis"]):6.12;
    $Betrag = isset($_GET["betrag"])?doubleval($_GET["betrag"]):10.00;
    $Restgeld = ceil(($Betrag-$Preis)*100); // funktion ceil(number) (int)(number+0.5)
    $Muenzwerte = array(200,100,50,20,10,5,2,1);
    $Anzahl = array();
    $Index = -1;

    $dateipath = "Muenzbestand.dat";

    if (file_exists($dateipath)) {
        $datei = fopen($dateipath, "w");
        $dateiw = fputs($datei,"");

        if ($Restgeld > 0) {
            foreach ($Muenzwerte as $Muenzwert) {
                $Anzahl[] = (int)($Restgeld / $Muenzwert);
                $Restgeld = $Restgeld % $Muenzwert;

            }

            // Muenzwert in Datei Schreiben und Schließen
            $dateiw = fputs($datei, implode(",",$Anzahl) . ",");
            fclose($datei);
        }
        // Datei Laden und Muenzwert in Variablen Speicher
        // Ausgabe erfolgt unten im HTML Bereich
        $dateir = fopen($dateipath, "r");
        $dateiMuenzwert = fgets($dateir);

        $c200 = explode(",",$dateiMuenzwert)[0];
        $c100 = explode(",",$dateiMuenzwert)[1];
        $c050 = explode(",",$dateiMuenzwert)[2];
        $c020 = explode(",",$dateiMuenzwert)[3];
        $c010 = explode(",",$dateiMuenzwert)[4];
        $c005 = explode(",",$dateiMuenzwert)[5];
        $c002 = explode(",",$dateiMuenzwert)[6];
        $c001 = explode(",",$dateiMuenzwert)[7];
    } else {
        echo $dateipath . " ist nicht erstellt! - Bitte Seite neuladen!";
        $datei = fopen($dateipath, "w");
        fclose($datei);
    }
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8"/>
            <style>
                label {
                    width:3em;
                    display:inline-block;
                    text-align:right;
                }
            </style>
        <title>Kassenautomat</title>
    </head>
    <body>
        <form method="get" action="">
            <fieldset>
                <legend>Eingabe</legend>
                <label id="lPreis" for="Preis">Preis</label>
                <input id="Preis" name="preis" type="text" placeholder="0000.00" required
                        pattern="[0-9]{1}[0-9]{0,7}[.,]{0,1}[0-9]{2}" value="<?php echo number_format($Preis,2);?>"
                        maxlength="10"
                  /> &euro;
                <br/>
                <label id="lBetrag" for="Betrag">Betrag</label>
                <input id="Betrag" name="betrag" title="Mehr" type="text" placeholder="0000.00" required
                        pattern="[1-9]{1}[0-9]{0,7}[.,]{0,1}[0-9]{2}" value="<?php echo number_format($Betrag,2);?>"
                        maxlength="10"
                  /> &euro;
                <br/>
                <input type="submit" value="berechnen"/>
            </fieldset><br/>
            <fieldset>
                <label id="lc200" for="C200">2 &euro;</label>
                <input id="C200" type="text" readonly value="<?php echo $c200;?>"/>
                <label id="lc100" for="C100">1 &euro;</label>
                <input id="C100" type="text" readonly value="<?php echo $c100;?>"/>
                <label id="lc050" for="C050">50 &cent;</label>
                <input id="C050" type="text" readonly value="<?php echo $c050;?>"/>
                <label id="lc020" for="C020">20 &cent;</label>
                <input id="C020" type="text" readonly value="<?php echo $c020;?>"/><br/>
                <label id="lc010" for="C010">10 &cent;</label>
                <input id="C010" type="text" readonly value="<?php echo $c010;?>"/>
                <label id="lc005" for="C005"> 5 &cent;</label>
                <input id="C005" type="text" readonly value="<?php echo $c005;?>"/>
                <label id="lc002" for="C002"> 2 &cent;</label>
                <input id="C002" type="text" readonly value="<?php echo $c002;?>"/>
                <label id="lc001" for="C001"> 1 &cent;</label>
                <input id="C001" type="text" readonly value="<?php echo $c001;?>"/><br/>
            </fieldset>
        </form>
    </body>
</html>