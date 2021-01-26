<?php
include "projektverwaltung.inc.php";
$Tabelle="Projekt";
$SQLString="";

$ProjektNr=isset($_GET["ProjektNr"])?intval($_GET["ProjektNr"]):"";
$Beschreibung=isset($_GET["Beschreibung"])?$_GET["Beschreibung"]:"";
$Starttermin=isset($_GET["Starttermin"])?$_GET["Starttermin"]:"";
$Endtermin=isset($_GET["Endtermin"])?$_GET["Endtermin"]:"";

$Verbindung=mysqli_connect("$Server:$Port",$User,$Password,$Schema);
if (mysqli_connect_errno()==0) {
    mysqli_set_charset($Verbindung, "UTF8");
    if ($Aktion==="Suchen") {
        $SQLString="select ProjektNr, Beschreibung, Starttermin, Endtermin from $Tabelle";
    } if ($ProjektNr>0) {
        $SQLString=$SQLString." where ProjektNr=$ProjektNr";
    }
    $SQLString=$SQLString.";";
    $Liste=executeSQL($Verbindung, $SQLString);
    switch(count($Liste)) {
        case 1: $ProjektNr=$Liste[0]["ProjektNr"];
                $Beschreibung=$Liste[0]["Beschreibung"];
                $Starttermin=$Liste[0]["Starttermin"];
                $Endtermin=$Liste[0]["Endtermin"];
                $Readonly="readonly";
                $_SESSION["ProjektNr"]=$ProjektNr;
        case 0: $Hidden="hidden"; 
            break;
        default:$ProjektNr="";$Hidden=""; 
            break;
    }
} else if ($Aktion === "Einfügen"){
    $SQLString="insert into $Tabelle (Beschreibung, Starttermin, Endtermin)";
    $SQLString=$SQLString."values ('$Beschreibung', '$Starttermin', '$Endtermin');";
    executeSQL($Verbindung, $SQLString);
    $ProjektNr=mysqli_insert_id($Verbindung);
    $Readonly="readonly";
} else if ($Aktion === "Ändern") {
    $SQLString="update $Tabelle set Beschreibung='$Beschreibung', Starttermin='$Starttermin',";
    $SQLString=$SQLString."Endtermin='$Endtermin'";
    $SQLString=$SQLString." where ProjektNr=$ProjektNr;";
    executeSQL($Verbindung, $SQLString);
    $Readonly="readonly";
} else if ($Aktion === "Löschen") {
    $SQLString="delete from $Tabelle";
    $SQLString=$SQLString." where ProjektNr=$ProjektNr;";
    $Return=executeSQL($Verbindung, $SQLString);
    $Required="required";
    if (count($Return)==0) {
        $ProjektNr="";
        $Beschreibung="";
        $Starttermin="";
        $Endtermin="";
    } else {
        $ProjektNr="";
        $Beschreibung="";
        $Starttermin="";
        $Endtermin="";
        $Hidden="hidden";
        $Readonly="";
        $Required="";
    }
    switch (mysqli_errno($Verbindung)) {
        case 0:
        case 2019:
            break;
        default: $Fehlertext=mysqli_errno($Verbindung).":".mysqli_error($Verbindung);
            break;
    }
    mysqli_close($Verbindung);
} else {
    $Fehlertext=mysqli_connect_error($Verbindung);
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        label {
            display:inline-block; 
            width:10em;
        }
    </style>
    <title>Projekt</title>
</head>

<body>
    <h1><?php echo $Aktion;?></h1>
    <form method="get" action="Projekt.html.php" name="Projekt">
        <fieldset form="Projekt">
            <legend>Projekt</legend>
            <label for="ProjektNr">ProjektNr</label>
            <input id="ProjektNr" name="ProjektNr" type="text" value="<?php echo $ProjektNr;?>"/> <br>
            <label for="Beschreibung">Beschreibung</label>
            <input id="Beschreibung" name="Beschreibung" type="text" value="<?php echo $Beschreibung;?>"/> <br>
            <label for="Starttermin">Starttermin</label>
            <input id="Starttermin" name="Starttermin" type="date" value="<?php echo $Starttermin;?>"/> <br>
            <label for="Endtermin">Endtermin</label>
            <input id="Endtermin" name="Endtermin" type="date" value="<?php echo $Endtermin;?>"/> <br>
        </fieldset>
        <fieldset>
            <input name="action" type="submit" value="Neu"/>
            <input name="action" type="submit" value="Suchen"/>
            <input name="action" type="submit" value="Einfügen"/>
            <input name="action" type="submit" value="Ändern"/>
            <input name="action" type="submit" value="Löschen"/>
        </fieldset>
    </form>
    <?php if (count($Liste) > 1): ?>
    <table <?php echo $Hidden;?> border="2" style="border-collapse:collapse;">
        <caption><h1>Projektliste</h1></caption>
        <tr>
            <?php foreach($Liste[0] as $Spalte => $Zelle):?>
            <th><?php echo $Spalte;?></th>
            <?php endforeach;?>
            <th>Details</th>
        </tr>
        <?php foreach($Liste as $Zeile):?>
        <tr>
            <?php foreach($Liste as $Zelle):?>
            <td><?php echo $Zelle;?></td>
            <?php endforeach; ?>
            <td>
                <a href="Projekt.html.php?action=Suchen&ProjektNr=<?php echo $Zeile["ProjektNr"];?>"><?php echo $Zeile["ProjektNr"];?></a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php endif;?>
    <?php echo $Fehlertext;?>
</body>
</html>