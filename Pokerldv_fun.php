<?php
function limpiar($dato) {
    return htmlspecialchars(stripslashes(trim($dato)));
}

//**************************************************************************************************************************************************
// Función para repartir cartas a los jugadores
// @param array $jugadores Array con los nombres de los jugadores
// @return array Array asociativo con los nombres de los jugadores y sus cartas
function repartirCartas($jugadores){
    // mazo completo
    $mazo = [
        '1C1', '1C2', '1D1', '1D2', '1P1', '1P2', '1T1', '1T2',
        'JC1', 'JC2', 'JD1', 'JD2', 'JP1', 'JP2', 'JT1', 'JT2',
        'KC1', 'KC2', 'KD1', 'KD2', 'KP1', 'KP2', 'KT1', 'KT2',
        'QC1', 'QC2', 'QD1', 'QD2', 'QP1', 'QP2', 'QT1', 'QT2'
    ];

    // barajar el mazo
    shuffle($mazo);

    // repartir a cada jugador
    $cartasJugadores = [];
    $indice = 0;

    foreach ($jugadores as $nombre) {
        $cartasJugadores[$nombre] = [];
        for ($i = 0; $i < 4; $i++) {
            $cartasJugadores[$nombre][] = $mazo[$indice];
            $indice++;
        }
    }

    return $cartasJugadores;
}

//**************************************************************************************************************************************************
// Función para evaluar la mano de un jugador
// @param array $cartas Array con las cartas del jugador
function evaluarMano($nombre, $cartas){
    // Aquí iría la lógica para evaluar la mano del jugador
    echo "Evaluando mano de $nombre...";
    echo "<br>";
    foreach ($cartas as $carta) {
        echo $carta . "<br>";
    }

}


function evaluarGanadores(){
    echo "Evaluando ganadores...";
}