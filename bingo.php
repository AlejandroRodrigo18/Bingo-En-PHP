<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bingo</title>
        <style>
            table {
                border-collapse: collapse;
                text-align: center;
                margin-bottom: 40px;
            }

            td {
                width: 70px;
                height: 20px;
                text-align: center;
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php
            function dbg_mostrar_matriz($matriz, $titulo) {
                echo "<p>$titulo<br></p>";
                echo "<table>";

                for ($i = 0; $i < count($matriz); $i++) {
                    echo "<tr>";
                    for ($j = 0; $j < count($matriz[0]); $j++) {
                        echo "<td>".$matriz[$i][$j]."</td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";
            }

            function generar_participantes($num_jugadores, $num_cartones) {
                $participantes = [];

                for ($i = 0; $i < $num_jugadores; $i++) {
                    for ($j = 0; $j < $num_cartones; $j++) {
                        $participantes[$i][$j] = generar_carton();
                        dbg_mostrar_matriz($participantes[$i][$j], "Jugador ".($i + 1).", Cartón ".($j + 1)); 
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

            $participantes = generar_participantes(4, 3);

        ?>
    </body>
</html>
