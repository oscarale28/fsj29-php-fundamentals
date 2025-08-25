<?php
function generarFibonacci($n)
{
    // Inicializar los primeros dos números de la secuencia
    $numero1 = 0;
    $numero2 = 1;

    // Validar el número de términos, asegurando que sea positivo
    if ($n <= 0) {
        echo "Por favor, ingrese un número mayor que 0.";
        return;
    }

    // Bucle repetido n veces para generar la sucesión
    for ($i = 0; $i < $n; $i++) {
        // Genera el siguiente número de la secuencia
        $numero3 = $numero1 + $numero2;
        // Imprime el número actual de la secuencia
        echo $numero1 . " ";
        // Actualiza los números para la siguiente iteración
        $numero1 = $numero2;
        $numero2 = $numero3;
    }
}

function esPrimo($numero)
{
    // Si el número es menor o igual a 1, se descarta rápidamente como número primo
    if ($numero <= 1) return false;

    // Verificar si el número es divisible por algún número menor que él
    for ($i = 2; $i < $numero; $i++) {
        if ($numero % $i == 0) return false;
    }
    return true;
}

function esPalindromo($texto)
{
    // Eliminar espacios y convertir a minúsculas
    $texto = strtolower(str_replace(' ', '', $texto));
    $i = 0;
    // Recorrer cadena modificada 
    while ($i < strlen($texto)) {
        // Evaluar carácter actual con su correspondiente en el reverso
        if ($texto[$i] !== $texto[strlen($texto) - 1 - $i]) {
            return false;
        }
        $i++;
    }
    return true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios Estructuras de Datos PHP - Guía 2</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <h1>Ejercicios de Lógica PHP - Guía 2</h1>
    <!-- Sección Secuencia de Fibonacci -->
    <section>
        <h1>Secuencia de Fibonacci</h1>
        <!-- Formulario para facilitar la entrada del parámetro -->
        <form method="POST" action="">
            <label for="n_fibonacci">Número de términos:</label>
            <!-- Se setea por defecto el valor de la variable correspondiente, o uno placeholder -->
            <input type="number" id="n_fibonacci" name="n_fibonacci" value="<?php echo isset($_POST['n_fibonacci']) ? $_POST['n_fibonacci'] : '10'; ?>">
            <input type="submit" value="Generar">
        </form>
        <p>
            <!-- Llamada a la función para imprimir la secuencia -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['n_fibonacci'])) {
                // Obtener el número ingresado en el formulario
                $n = intval($_POST["n_fibonacci"]);
                generarFibonacci($n);
            }
            ?>
        </p>
    </section>
    <hr>
    <!-- Sección Verificación de Número Primo -->
    <section>
        <h1>Número primo</h1>
        <form method="POST" action="">
            <label for="numero_primo">Número a verificar:</label>
            <!-- Se setea por defecto el valor de la variable correspondiente, o uno placeholder -->
            <input type="number" id="numero_primo" name="numero_primo" value="<?php echo isset($_POST['numero_primo']) ? $_POST['numero_primo'] : '2'; ?>">
            <input type="submit" value="Verificar">
        </form>
        <p>
            <!-- Resultado de la verificación -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero_primo'])) {
                $n = intval($_POST["numero_primo"]);
                // Mostrar el número ingresado junto al resultado textual de la verificación.
                if (esPrimo($n)) {
                    echo $n . " es un número primo.";
                } else {
                    echo $n . " no es un número primo.";
                }
            }
            ?>
        </p>
    </section>
    <hr>
    <!-- Sección Verificación de Palíndromos -->
    <section>
        <h1>Verificación de Palíndromos</h1>
        <form method="POST" action="">
            <label for="palindromo">Texto o número a verificar:</label>
            <!-- Se setea por defecto el valor de la variable correspondiente, o uno placeholder -->
            <input type="text" id="palindromo" name="palindromo" value="<?php echo isset($_POST['palindromo']) ? htmlspecialchars($_POST['palindromo']) : ''; ?>">
            <input type="submit" value="Verificar">
        </form>
        <p>
            <!-- Resultado de la verificación -->
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['palindromo'])) {
                $texto = $_POST["palindromo"];
                $resultado = esPalindromo($texto);
                // Mostrar el texto original junto al resultado textual de la verificación.
                echo "\"" . htmlspecialchars($texto) . "\"";
                if ($resultado) {
                    echo " es un palíndromo.";
                } else {
                    echo " no es un palíndromo.";
                }
            }
            ?>
        </p>
    </section>

</body>

</html>