<?php
    // Datenbank Daten direkt in der Datei
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbport = 3306;
    $db = "rentmobil";

    /*
    Datenbank Daten aus einer Datei z.B. db.config
    Der Name ist frei wählbar
    Inhalt der Datei ist in diesem Beispiel wie folgt aufgebaut:

    Host,Username,Passwort,Port,Datenbank

    WICHTIG: Die Parameter müssen mit Komma (,) getrennt werden.
    Wenn z.B. kein Passwort angebeben werden muss so bleibt der Platz leer.
    bsp.: Username,,Port,Datenbank
    */

    // db.config Datei mit Leserechte öffnen
    $dbconfig = fopen("db.config","r");

    // Liest die Datei in eine Variable zur Weiterverarbeitung
    $dbpara = fgets($dbconfig);

    // Nach dem Auslesen brauchen wir die Datei nicht mehr und diese wird geschlossen
    fclose($dbconfig);

    /*
    Zuweisen der Daten aus der Datei in die Variablen
    explode braucht einen Seperator in diesem Fall das Komma in Gänsefüße " "
    explode("SEPERATOR",VARIABLE)
    Die [0] gibt an das bis zum ersten Komma der Inhalt in unsere Variable geschrieben werden soll

    WICHTIG:
    Die Parameter in der Variable sollten auch mit der Anzahl der Variablen die wir befüllen wollen
    übereinstimmen, ansonsten gibt es ein fehler.
    Auch die Reihenfolge ist wichtig in der Datei, nicht das der User bei Passwort steht.
    */
    $dbhost = explode(",",$dbpara)[0];
    $dbuser = explode(",",$dbpara)[1];
    $dbpass = explode(",",$dbpara)[2];
    $dbport = explode(",",$dbpara)[3];
    $db = explode(",",$dbpara)[4];


    // Datenbank Verbindung Herstellen
    $conn = mysqli_connect("$dbhost:$dbport",$dbuser,$dbpass,$db);

    // CharSet setzten für die Verbindung
    mysqli_set_charset($conn,"UTF8");

    // Einfache SELECT Anweisung (Query)
    $sql = "SELECT kundennummer,nachname,vorname,geburtsdatum,fuehrerscheinklasse FROM kunde";

    // SQL QUERY Ausführen | mysqli_query(VERBINDUNG,SQLQUERY)
    $result = mysqli_query($conn, $sql);

    // Daten in ARRAY von der Tabelle Kunde
    $datak = array();
    foreach ($result as $row){
        $datak[]= $row;
    }

    // Speicher wieder Freigeben
    mysqli_free_result($result);

    // Daten für Verträge
    $sql = "SELECT * FROM vertrag";
    $result = mysqli_query($conn, $sql);

    $datav = array();
    foreach ($result as $row){
        $datav[]= $row;
    }

    mysqli_free_result($result);

    // Daten für Fahrzeuge
    $sql = "SELECT * FROM fahrzeug";
    $result = mysqli_query($conn, $sql);

    $dataf = array();
    foreach ($result as $row){
        $dataf[]= $row;
    }

    mysqli_free_result($result);


    // Prüfen welcher Button gedrückt wurde
    $action = isset($_GET["action"]) ? $_GET["action"] : "";

?>


<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>RentMobil - Autovermietung</title>
    </head>

    <body>
        <!-- NEUER KUNDE -->
        <form method="get" action="">
            <fieldset>
                <legend>Kundenstammblatt</legend>

                <label for="kundennummer">Kundennummer</label>
                <input type="text" name="kundennummer" placeholder="1001" required>
                <br/>

                <label for="nachname">Nachnname</label>
                <input type="text" name="nachname">
                <br/>

                <label for="vorname">Vorname</label>
                <input type="text" name="vorname">
                <br/>

                <label for="geburtsdatum">Geburtsdatum</label>
                <input type="date" name="geburtsdatum">
                <br/>

                <label for="fuehrerscheinklasse">Führerscheinklasse</label>
                <input type="text" name="fuehrerscheinklasse">
                <br/>
                <input name="action" type="submit" value="Neuer Kunde"/>
            </fieldset>
        </form>

        <!-- NEUER VERTRAG -->
        <form method="get" action="">
            <fieldset>
                <legend>Neuer Vertrag</legend>

                <label for="vertragsnummer">Vertragsnummer</label>
                <input type="text" name="vertragsnummer" placeholder="454517" required>
                <br/>

                <label for="start">Start</label>
                <input type="datetime-local" name="start">
                <br/>

                <label for="ende">Ende</label>
                <input type="datetime-local" name="ende">
                <br/>

                <label for="gefahrene_kilometer">Gefahrene Kilometer</label>
                <input type="text" name="gefahrene_kilometer" placeholder="145477">
                <br/>

                <label for="vertragsabschluss">Vertragsabschluss</label>
                <input type="datetime-local" name="vertragsabschluss">
                <br/>


                <label for="kundennummer">Kundennummer</label>
                <input type="text" name="kundennummer" placeholder="1001" required>
                <br/>

                <label for="kennzeichen">Kennzeichen</label>
                <input type="text" name="kennzeichen" placeholder="E-JK 2547" required>
                <br/>

                <input name="action" type="submit" value="Neuer Vertrag"/>
            </fieldset>
        </form>

        <!-- NEUES FAHRZEUG -->
        <form method="get" action="">
            <fieldset>
                <legend>Neues Fahrzeug</legend>

                <label for="kennzeichen">Kennzeichen</label>
                <input type="text" name="kennzeichen" placeholder="E-JK 2547" required>
                <br/>

                <label for="hersteller">Hersteller</label>
                <input type="text" name="hersteller" >
                <br/>

                <label for="typ">Typ</label>
                <input type="text" name="typ" >
                <br/>

                <label for="kilometerstand">Kilometerstand</label>
                <input type="text" name="kilometerstand" >
                <br/>

                <label for="zulassungsdatum">Zulassungsdatum</label>
                <input type="date" name="zulassungsdatum">
                <br/>

                <input name="action" type="submit" value="Neues Fahrzeug"/>
            </fieldset>
        </form>


        <fieldset>
            <legend>Kunden</legend>
        <table>
            <tr>
                <th>Kundennummer</th>
                <th>Nachname</th>
                <th>Vorname</th>
                <th>Geburtsdatum</th>
                <th>Führerscheinklasse</th>
            </tr>

            <?php foreach($datak as $row): ?>
                <tr>
                    <td><?php echo $row["kundennummer"];?></td>
                    <td><?php echo $row["nachname"];?></td>
                    <td><?php echo $row["vorname"];?></td>
                    <td><?php echo $row["geburtsdatum"];?></td>
                    <td><?php echo $row["fuehrerscheinklasse"];?></td>
                </tr>
            <?php endforeach;?>
        </table>
        </fieldset>

        <fieldset>
            <legend>Verträge</legend>
        <table>
            <tr>
                <th>Vertragsnummer</th>
                <th>Start</th>
                <th>Ende</th>
                <th>Gefahrene Kilometer</th>
                <th>Vertragsabschluss</th>
                <th>Kundennummer</th>
                <th>Kennzeichen</th>
            </tr>

            <?php foreach($datav as $row): ?>
                <tr>
                    <td><?php echo $row["vertragsnummer"];?></td>
                    <td><?php echo $row["start"];?></td>
                    <td><?php echo $row["ende"];?></td>
                    <td><?php echo $row["gefahrene_kilometer"];?></td>
                    <td><?php echo $row["vertragsabschluss"];?></td>
                    <td><?php echo $row["kundennummer"];?></td>
                    <td><?php echo $row["kennzeichen"];?></td>

                </tr>
            <?php endforeach;?>
        </table>
        </fieldset>

        <fieldset>
            <legend>Fahrzeuge</legend>
            <table>
                <tr>
                    <th>Kennzeichen</th>
                    <th>Hersteller</th>
                    <th>Typ</th>
                    <th>Kilometerstand</th>
                    <th>Zulassungsdatum</th>
                </tr>

                <?php foreach($dataf as $row): ?>
                    <tr>
                        <td><?php echo $row["kennzeichen"];?></td>
                        <td><?php echo $row["hersteller"];?></td>
                        <td><?php echo $row["typ"];?></td>
                        <td><?php echo $row["kilometerstand"];?></td>
                        <td><?php echo $row["zulassungsdatum"];?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </fieldset>

    </body>
</html>
