<?php
//**************************************************************************************************************************************************
/*
 * Reparte cartas a los jugadores
 *
 * @param array $jugadores Array con los nombres de los jugadores
 * @return array Array asociativo con los nombres de los jugadores y sus cartas
 */
function repartirCartas($jugadores){
    // mazo completo con cartas numeradas y figuras
    $mazo = [
        '1C1', '1C2', '1D1', '1D2', '1P1', '1P2', '1T1', '1T2',
        'JC1', 'JC2', 'JD1', 'JD2', 'JP1', 'JP2', 'JT1', 'JT2',
        'KC1', 'KC2', 'KD1', 'KD2', 'KP1', 'KP2', 'KT1', 'KT2',
        'QC1', 'QC2', 'QD1', 'QD2', 'QP1', 'QP2', 'QT1', 'QT2'
    ];

    shuffle($mazo); // barajar el mazo

    $cartasJugadores = [];
    $indice = 0;

    // repartir 4 cartas a cada jugador
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
/*
 * Evalúa la mano de todos los jugadores
 *
 * @param array $cartasJugadores Array con las cartas de cada jugador
 * @return array Array asociativo con la puntuación y tipo de mano de cada jugador
 */
function evaluarMano($cartasJugadores){
    $resultado = [];

    foreach ($cartasJugadores as $nombre => $cartas) {
        $valores = [];

        foreach ($cartas as $carta) {
            $valor = substr($carta, 0, -2); // extraer solo el valor de la carta
            $valores[] = $valor;
        }

        // Evalúa la mano del jugador
        $resultado[$nombre] = evaluarCartas($valores);
    }
    return $resultado;
}

//**************************************************************************************************************************************************
/*
 * Evalúa una mano concreta
 *
 * @param array $cartas Array de valores de cartas
 * @return array Array con nombre de la jugada y su rango numérico
 */
function evaluarCartas($cartas){
    $conteo = array_count_values($cartas); // contar cuántas veces aparece cada valor
    $pares = 0;
    $trio = false;
    $poker = false;

    foreach ($conteo as $cantidad) {
        if ($cantidad == 2) 
            $pares++;
        if ($cantidad == 3) 
            $trio = true;
        if ($cantidad == 4) 
            $poker = true;
    }

    if ($poker) return ["Poker", 4];
    if ($trio) return ["Trío", 3];
    if ($pares == 2) return ["Doble pareja", 2];
    if ($pares == 1) return ["Pareja", 1];
    return ["Nada", 0];
}

//**************************************************************************************************************************************************
/*
 * Calcula el premio según la jugada ganadora
 *
 * @param float $bote Bote total
 * @param int $tipoJugada Rango de la jugada (0-4)
 * @return float Premio correspondiente
 */
function calcularPremio($bote, $tipoJugada) {
    return match ($tipoJugada) {
        4 => $bote,        // Poker gana todo
        3 => $bote * 0.7,  // Trío gana 70%
        2 => $bote * 0.5,  // Doble pareja gana 50%
        default => 0
    };
}

//**************************************************************************************************************************************************
/*
 * Obtiene los jugadores ganadores y su rango
 *
 * @param array $puntuacionJugadores Array con las puntuaciones de los jugadores
 * @return array Primer elemento: array de ganadores, Segundo elemento: rango máximo
 */
function obtenerGanadores($puntuacionJugadores){
    $maxRango = 0;
    $ganadores = [];
    
    // Encontrar el rango máximo
    foreach ($puntuacionJugadores as $jugador => $puntuacion) {
        if ($puntuacion[1] > $maxRango) { // [1] representa el rango del jugador. (0,1,2,3,4)
            $maxRango = $puntuacion[1];
        }
    }
    
    // Recoger todos los jugadores que tienen ese rango máximo
    foreach ($puntuacionJugadores as $jugador => $puntuacion) {
        if ($puntuacion[1] == $maxRango) {
            $ganadores[] = $jugador;
        }
    }
    
    return [$ganadores,$maxRango];
}

//**************************************************************************************************************************************************
/*
 * Muestra los resultados del juego en HTML
 *
 * @param array $cartasJugadores Array con las cartas de cada jugador
 * @param array $puntuacionJugadores Array con la puntuación de cada jugador
 * @param float $bote Bote total del juego
 */
function mostrar($cartasJugadores, $puntuacionJugadores, $bote) {
    echo "<h2>Resultados del Juego</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>Jugador</th><th>Cartas</th><th>Puntuación</th></tr>";

    foreach ($cartasJugadores as $jugador => $cartas) {
        echo "<tr>";
        echo "<td>$jugador</td>";
        echo "<td>";
        foreach ($cartas as $carta) {
            $ruta = "./images/" . $carta . ".PNG"; // ruta de la imagen de la carta
            echo "<img src='$ruta' alt='$carta' width='80'>";
        }
        echo "</td>";
        echo "<td>" . $puntuacionJugadores[$jugador][0] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    [$ganadores, $maxRango] = obtenerGanadores($puntuacionJugadores);

    $premio = calcularPremio($bote, $maxRango);
    $premioIndividual = count($ganadores) > 0 ? $premio / count($ganadores) : 0;

    echo "<p>Bote total: $bote €</p>";
    if (!empty($ganadores)) {
        echo "<p>Ganador(es): " . implode(", ", $ganadores) . "</p>";
        echo "<p>Premio total: $premio €</p>";
        echo "<p>Premio por ganador: $premioIndividual €</p>";
    } else {
        echo "<p>No hay ganadores.</p>";
    }

    echo "<p><a href='index.html'><button>Volver a jugar</button></a></p>";
}

//*************************************************************************************************************************************************
/*
 * Limpia un dato recibido de un formulario
 *
 * @param string $dato Dato a limpiar
 * @return string Dato limpio
 */
function limpiar($dato) {
    return htmlspecialchars(stripslashes(trim($dato)));
}

?>
