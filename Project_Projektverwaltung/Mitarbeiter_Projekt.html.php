<?php
include "projektverwaltung.inc.php";
$Tabelle="Mitarbeiter_Projekt";
$SQLString="";

$ID=isset($_GET["ID"])?intval($_GET["ID"]):"";
$FK_PersNr=isset($_GET["FK_PersNr"])?$_GET["FK_PersNr"]:"";
$FK_ProjektNr=isset($_GET["FK_ProjektNr"])?intval($_GET["FK_ProjektNr"]):"";

$Verbindung=mysqli_connect("$Server:$Port",$User,$Password,$Schema);
if (mysqli_connect_errno()==0) {
    mysqli_set_charset($Verbindung, "UTF8");
    if ($Aktion==="Suchen") {
        $SQLString="select ID, FK_PersNr, FK_ProjektNr from $Tabelle";
    } if ($ID>0) {
        $SQLString=$SQLString." where ID=$ID";
    }
    $SQLString=$SQLString.";";
    $Liste=executeSQL($Verbindung, $SQLString);
    switch(count($Liste)) {
        case 1: $ID=$Liste[0]["ID"];
                $FK_PersNr=$Liste[0]["FK_PersNr"];
                $FK_ProjektNr=$Liste[0]["FK_ProjektNr"];
                $Readonly="readonly";
                $_SESSION["ID"]=$ID;
        case 0: $Hidden="hidden"; 
            break;
        default:$ID="";$Hidden=""; 
            break;
    }
} else if ($Aktion === "Einfügen"){
    $SQLString="insert into $Tabelle (FK_PersNr, FK_ProjektNr)";
    $SQLString=$SQLString."values ('$FK_PersNr', '$FK_ProjektNr');";
    executeSQL($Verbindung, $SQLString);
    $ID=mysqli_insert_id($Verbindung);
    $Readonly="readonly";
} else if ($Aktion === "Ändern") {
    $SQLString="update $Tabelle set FK_PersNr='$FK_PersNr', FK_ProjektNr='$FK_ProjektNr',";
    $SQLString=$SQLString." where ID=$ID;";
    executeSQL($Verbindung, $SQLString);
    $Readonly="readonly";
} else if ($Aktion === "Löschen") {
    $SQLString="delete from $Tabelle";
    $SQLString=$SQLString." where ID=$ID;";
    $Return=executeSQL($Verbindung, $SQLString);
    $Required="required";
    if (count($Return)==0) {
        $ID="";
        $FK_PersNr="";
        $FK_ProjektNr="";
    } else {
        $ID="";
        $FK_PersNr="";
        $FK_ProjektNr="";
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
    <title>Mitarbeiter_Projekt_Projekt</title>
</head>

<body>
    <h1><?php echo $Aktion;?></h1>
    <form method="get" action="Mitarbeiter_Projekt.html.php" name="Mitarbeiter_Projekt">
        <fieldset form="Mitarbeiter_Projekt">
            <legend>Mitarbeiter_Projekt</legend>
            <label for="ID">ID</label>
            <input id="ID" name="ID" type="text" value="<?php echo $ID;?>"/> <br>
            <label for="FK_PersNr">FK_PersNr</label>
            <input id="FK_PersNr" name="FK_PersNr" type="text" style="text-transform:capitalize;" value="<?php echo $FK_PersNr;?>"/> <br>
            <label for="FK_ProjektNr">FK_ProjektNr</label>
            <input id="FK_ProjektNr" name="FK_ProjektNr" type="text" style="text-transform:capitalize;" value="<?php echo $FK_ProjektNr;?>"/> <br>
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
        <caption><h1>Mitarbeiter_Projektliste</h1></caption>
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
                <a href="Mitarbeiter_Projekt.html.php?action=Suchen&ID=<?php echo $Zeile["ID"];?>"><?php echo $Zeile["ID"];?></a>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php endif;?>
    <?php echo $Fehlertext;?>
</body>
</html>