<?php
session_start();

if (!isset($_SESSION["SessionID"])) {
    $_SESSION["SessionID"]=session_id();
    $_SESSION["PersNr"]="";
    $_SESSION["Abkuerzung"]="";
    $_SESSION["ProjektNr"]="";
    $_SESSION["ID"]="";
    $_SESSION["angemeldet"]=0;
}
$Aktion=isset($_GET["action"])?$_GET["action"]:"Neu";

$Readonly="";
$Required="";
$Hidden="";
$Liste=array();
$Fehlertext="";

$Server="localhost";
$Port=3306;
$User = "root";
$Password = "";
$Schema = "Projektverwaltung";

$Konfig="../$Schema.dat";
if (file_exists($Konfig)) {
    $Datei=fopen($Konfig, "r");
    $ConParameter=fgets($Datei);
    fclose($Datei);
    $User=explode(",",$ConParameter)[0];
    $Password=explode(",",$ConParameter)[1];
    $Port=explode(",",$ConParameter)[2];
}

function executeSQL($Verbindung,$SQLString) {
    $Liste=array();
    if ($Verbindung!==null) {
        $Ergebnis=mysqli_query($Verbindung, $SQLString);
        if (!is_bool($Ergebnis)) {
            foreach ($Ergebnis as $Zeile) {
                $Liste[]=$Zeile;
            }
            mysqli_free_result($Ergebnis);
        } else if(!$Ergebnis){
            $_SESSION["Fehlertext"]="Fehler: Anfrage \"SQLString\" wurde nicht ausgeführt!";
        }
    }
    return $Liste;
}
?>