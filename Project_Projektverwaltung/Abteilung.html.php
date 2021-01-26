<?php
include "projektverwaltung.inc.php";
$Tabelle="Abteilung";
$SQLString="";

$Abkuerzung=isset($_GET["Abkuerzung"])?$_GET["Abkuerzung"]:"";
$Beschreibung=isset($_GET["Beschreibung"])?$_GET["Beschreibung"]:"";
$FK_Leitung=isset($_GET["FK_Leitung"])?intval($_GET["FK_Leitung"]):"";

$Verbindung=mysqli_connect("$Server:$Port",$User,$Password,$Schema);
if (mysqli_connect_errno()==0) {
    mysqli_set_charset($Verbindung, "UTF8");
    if ($Aktion==="Suchen") {
        $SQLString="select Abkuerzung, Beschreibung, FK_Leitung from $Tabelle";
    } if ($Abkuerzung>0) {
        $SQLString=$SQLString." where Abkuerzung=$Abkuerzung";
    }
    $SQLString=$SQLString.";";
    $Liste=executeSQL($Verbindung, $SQLString);
    switch(count($Liste)) {
        case 1: $Abkuerzung=$Liste[0]["Abkuerzung"];
                $Beschreibung=$Liste[0]["Beschreibung"];
                $FK_Leitung=$Liste[0]["FK_Leitung"];
                $Readonly="readonly";
                $_SESSION["Abkuerzung"]=$Abkuerzung;
        case 0: $Hidden="hidden"; 
            break;
        default:$Abkuerzung="";$Hidden=""; 
            break;
    }
} else if ($Aktion === "Einfügen"){
    $SQLString="insert into $Tabelle (Abkuerzung, Beschreibung, FK_Leitung)";
    $SQLString=$SQLString."values ('$Abkuerzung', '$Beschreibung', '$FK_Leitung');";
    executeSQL($Verbindung, $SQLString);
    $Abkuerzung=mysqli_insert_id($Verbindung);
    $Readonly="readonly";
} else if ($Aktion === "Ändern") {
    $SQLString="update $Tabelle set Beschreibung='$Beschreibung', Vorname='$Vorname',";
    $SQLString=$SQLString."Geburtsdatum='$Geburtsdatum', FK_Leitung='$FK_Leitung'";
    $SQLString=$SQLString." where Abkuerzung=$Abkuerzung;";
    executeSQL($Verbindung, $SQLString);
    $Readonly="readonly";
} else if ($Aktion === "Löschen") {
    $SQLString="delete from $Tabelle";
    $SQLString=$SQLString." where Abkuerzung=$Abkuerzung;";
    $Return=executeSQL($Verbindung, $SQLString);
    $Required="required";
    if (count($Return)==0) {
        $Abkuerzung="";
        $Beschreibung="";
        $FK_Leitung="";
    } else {
        $Abkuerzung="";
        $Beschreibung="";
        $FK_Leitung="";
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
    <title>Abteilung</title>
</head>

<body>
    <h1><?php echo $Aktion;?></h1>
    <form method="get" action="Abteilung.html.php" name="Abteilung">
        <fieldset form="Abteilung">
            <legend>Abteilung</legend>
            <label for="Abkuerzung">Abkuerzung</label>
            <input id="Abkuerzung" name="Abkuerzung" type="text" value="<?php echo $Abkuerzung;?>"/> <br>
            <label for="Beschreibung">Beschreibung</label>
            <input id="Beschreibung" name="Beschreibung" type="text" value="<?php echo $Beschreibung;?>"/> <br>
            <label for="FK_Leitung">FK_Leitung</label>
            <input id="FK_Leitung" name="FK_Leitung" type="text" value="<?php echo $FK_Leitung;?>"/> <br>
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
        <caption><h1>Abteilungliste</h1></caption>
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
                <a href="Abteilung.html.php?action=Suchen&Abkuerzung=<?php echo $Zeile["Abkuerzung"];?>"><?php echo $Zeile["Abkuerzung"];?></a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php endif;?>
    <?php echo $Fehlertext;?>
</body>
</html>