<?php
require 'Pokerldv_fun.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nombres de los jugadores
    $jugadores = [
        limpiar($_POST['nombre1']),
        limpiar($_POST['nombre2']),
        limpiar($_POST['nombre3']),
        limpiar($_POST['nombre4'])
    ];

    $bote = limpiar($_POST['bote']);

    // Repartir cartas y evaluar manos
    $cartasJugadores = repartirCartas($jugadores);
    $puntuacionJugadores = evaluarMano($cartasJugadores);
    
    // Mostrar resultados
    mostrar($cartasJugadores, $puntuacionJugadores, $bote);
}
?>