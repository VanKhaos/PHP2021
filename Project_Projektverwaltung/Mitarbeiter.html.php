<?php
include "projektverwaltung.inc.php";
$Tabelle="Mitarbeiter";
$SQLString="";

$PersNr=isset($_GET["PersNr"])?intval($_GET["PersNr"]):"";
$Nachname=isset($_GET["Nachname"])?$_GET["Nachname"]:"";
$Vorname=isset($_GET["Vorname"])?$_GET["Vorname"]:"";
$Geburtsdatum=isset($_GET["Geburtsdatum"])?$_GET["Geburtsdatum"]:"";
$FK_Abteilung=isset($_GET["FK_Abteilung"])?$_GET["FK_Abteilung"]:"";

$Verbindung=mysqli_connect("$Server:$Port",$User,$Password,$Schema);
if (mysqli_connect_errno()==0) {
    mysqli_set_charset($Verbindung, "UTF8");
    if ($Aktion==="Suchen") {
        $SQLString="select PersNr, Nachname, Vorname, Geburtsdatum, FK_Abteilung from $Tabelle";
    } if ($PersNr>0) {
        $SQLString=$SQLString." where PersNr=$PersNr";
    }
    $SQLString=$SQLString.";";
    $Liste=executeSQL($Verbindung, $SQLString);
    switch(count($Liste)) {
        case 1: $PersNr=$Liste[0]["PersNr"];
                $Nachname=$Liste[0]["Nachname"];
                $Vorname=$Liste[0]["Vorname"];
                $Geburtsdatum=$Liste[0]["Geburtsdatum"];
                $FK_Abteilung=$Liste[0]["FK_Abteilung"];
                $Readonly="readonly";
                $_SESSION["PersNr"]=$PersNr;
        case 0: $Hidden="hidden"; 
            break;
        default:$PersNr="";$Hidden=""; 
            break;
    }
} else if ($Aktion === "Einfügen"){
    $SQLString="insert into $Tabelle (Nachname, Vorname, Geburtsdatum, FK_Abteilung)";
    $SQLString=$SQLString."values ('$Nachname', '$Vorname', '$Geburtsdatum', '$FK_Abteilung');";
    executeSQL($Verbindung, $SQLString);
    $PersNr=mysqli_insert_id($Verbindung);
    $Readonly="readonly";
} else if ($Aktion === "Ändern") {
    $SQLString="update $Tabelle set Nachname='$Nachname', Vorname='$Vorname',";
    $SQLString=$SQLString."Geburtsdatum='$Geburtsdatum', FK_Abteilung='$FK_Abteilung'";
    $SQLString=$SQLString." where PersNr=$PersNr;";
    executeSQL($Verbindung, $SQLString);
    $Readonly="readonly";
} else if ($Aktion === "Löschen") {
    $SQLString="delete from $Tabelle";
    $SQLString=$SQLString." where PersNr=$PersNr;";
    $Return=executeSQL($Verbindung, $SQLString);
    $Required="required";
    if (count($Return)==0) {
        $PersNr="";
        $Nachname="";
        $Vorname="";
        $Geburtsdatum="";
        $FK_Abteilung="";
    } else {
        $PersNr="";
        $Nachname="";
        $Vorname="";
        $Geburtsdatum="";
        $FK_Abteilung="";
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
    <title>Mitarbeiter</title>
</head>

<body>
    <h1><?php echo $Aktion;?></h1>
    <form method="get" action="Mitarbeiter.html.php" name="Mitarbeiter">
        <fieldset form="Mitarbeiter">
            <legend>Mitarbeiter</legend>
            <label for="PersNr">PersNr</label>
            <input id="PersNr" name="PersNr" type="text" value="<?php echo $PersNr;?>"/> <br>
            <label for="Nachname">Nachname</label>
            <input id="Nachname" name="Nachname" type="text" style="text-transform:capitalize;" value="<?php echo $Nachname;?>"/> <br>
            <label for="Vorname">Vorname</label>
            <input id="Vorname" name="Vorname" type="text" style="text-transform:capitalize;" value="<?php echo $Vorname;?>"/> <br>
            <label for="Geburtsdatum">Geburtsdatum</label>
            <input id="Geburtsdatum" name="Geburtsdatum" type="date" value="<?php echo $Geburtsdatum;?>"/> <br>
            <label for="FK_Abteilung">FK_Abteilung</label>
            <input id="FK_Abteilung" name="FK_Abteilung" type="text" value="<?php echo $FK_Abteilung;?>"/> <br>
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
        <caption><h1>Mitarbeiterliste</h1></caption>
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
                <a href="Mitarbeiter.html.php?action=Suchen&PersNr=<?php echo $Zeile["PersNr"];?>"><?php echo $Zeile["PersNr"];?></a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php endif;?>
    <?php echo $Fehlertext;?>
</body>
</html>