<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bingo</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="body__php">
        <div class="body__shadow"></div>

        <div class="grid__php">
            <div class="grid__php-div">
                <h1>BINGO</h1>
            </div>


            <?php

            $nParticipantes = $_POST["jugadores"];
            $nCartnones = $_POST["cartones"];



                //No tiene que estar aqui, pero se tiene que generar en html
                function dbg_mostrar_matriz($matriz, $titulo) {
                    echo "<div class='grid__php-div'>";
                    echo "<p>$titulo</p>";
                    echo "<table class='grid__php-table'>";

                    for ($i = 0; $i < count($matriz); $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < count($matriz[0]); $j++) {
                            echo "<td class='grid__php-td'>".$matriz[$i][$j]."</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                    echo "</div>";
                }

                function generar_participantes($num_jugadores, $num_cartones) {
                    $participantes = [];

                    for ($i = 0; $i < $num_jugadores; $i++) {
                        for ($j = 0; $j < $num_cartones; $j++) {
                            $participantes[$i][$j] = generar_carton(); // Crea 3 cartones para cada jugador
                            // Hace la jugada y tacha los numeros    
                        }
                    }

                    return $participantes;
                }

                function generar_carton() {
                    $repetidos = array_fill(1, 60, false);
                    $carton = [];
                    
                    $vacios = 0;
                    while($vacios < 6) {
                        $i = rand(0, 2);
                        $j = rand(0, 6);

                        if (!isset($carton[$i][$j])) {
                            $carton[$i][$j] = '';
                            $vacios++;
                        }
                    }

                    for ($i = 0; $i < 3; $i++) {
                        for ($j = 0; $j < 7; $j++) {
                            if (isset($carton[$i][$j])) continue;
                            
                            $valor = 0;
                            do {
                                $valor = rand(1, 60);
                            } while ($repetidos[$valor]);

                            $repetidos[$valor] = true;
                            $carton[$i][$j] = $valor;
                        }
                    }

                    return $carton;
                }


                //Todo esto esta mal, porque partimos de un array de 3x7 en vez de un array lineal
                function jugada(&$participantes) {
                    $ganador = false;
                    $numeros_sacados = [];
                
                    while (!$ganador) {
                        // Generar número aleatorio que no haya salido
                        $num_bola = rand(1, 60);
                        for ($jugador = 0; $jugador < count($participantes); $jugador++) // Jugadores
                        {
                            for ($carton = 0; $carton < count($participantes[$jugador]); $carton++) // Cartones
                            {
                                $contador = 0; // Hay 15 numeros (para cada carton se inicializa a 0)
                                
                                for ($fila = 0; $fila < count($participantes[$jugador][$carton]); $fila++) // Recorremos filas
                                {
                                    for ($col = 0; $col < count($participantes[$jugador][$carton][$fila]); $col++) // Recorremos columnas
                                    {
                                        $valor = $participantes[$jugador][$carton][$fila][$col];

                                        // Tacha 
                                        if ($valor == $num_bola) {
                                            $participantes[$jugador][$carton][$fila][$col] = "<s class='tachado'>$valor</s>";
                                        }   
                                        // Comprueba si existe un elemento de esa clase
                                        if (strpos($participantes[$jugador][$carton][$fila][$col], 'tachado') !== false) {
                                            $contador++;
                                        }                                                                                                        
                                    }
                                }
                

                                //NO PUEDE HABER ESTILOS NI HTML EN LÓGICA
                                // Si el cartón tiene 15 números tachados → hay ganador
                                if ($contador == 15) {
                                    echo "<div class='grid__php-div'>";
                                    echo "<h2>El ganador es el jugador ".($jugador + 1)." <br> con el cartón ".($carton + 1)."</h2>";
                                    echo "</div>";
                                    $ganador = true;

                                    //ERROR , NO SE USAN BREAKS
                                    break 2; // salir de ambos for
                                }
                            }//cartones
                        }//jugadores
                    }
                

                    //NO PUEDE HABER VISUAL EN L LÓGICO
                    // Mostrar resultado final: todos los cartones con sus X
                    foreach ($participantes as $i => $jugador) {
                        foreach ($jugador as $j => $carton) {
                            dbg_mostrar_matriz($carton, "Jugador ".($i + 1).", Cartón ".($j + 1));
                        }
                    }
                }

                $participantes = generar_participantes($nParticipantes, $nCartnones);
                jugada($participantes);


            ?>      

        </div>

    </body>
</html>