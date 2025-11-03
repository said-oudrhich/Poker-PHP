<?php
require 'Pokerldv_fun.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Nombres de los jugadores
    $jugadores = [
        $nombre1 = limpiar($_POST['nombre1']),
        $nombre2 = limpiar($_POST['nombre2']),
        $nombre3 = limpiar($_POST['nombre3']),
        $nombre4 = limpiar($_POST['nombre4'])
    ];
    
    $bote = limpiar($_POST['bote']);
}

$cartasJugadores = repartirCartas($jugadores);

foreach ($cartasJugadores as $nombre => $cartas) {
    //$puntuacionJugadoros = 
    evaluarMano($nombre, $cartas);
}

?>