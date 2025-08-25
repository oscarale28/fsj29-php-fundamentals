<?php
// Funcion auxiliar para validar entrada de arrays numericos
function validateNumericArray($input) {
    // Convertir string a array si es necesario
    if (is_string($input)) {
        $array = explode(',', $input);
        $array = array_map('trim', $array);
    } else {
        $array = $input;
    }
    
    // Validar que no esté vacío
    if (empty($array)) {
        return ['valid' => false, 'message' => 'Por favor, ingrese al menos un número.', 'array' => []];
    }
    
    // Validar que todos los elementos sean numéricos
    $validNumbers = [];
    foreach ($array as $element) {
        // Bandera de mensaje de excepción, para evitar hacer un return por cada if y así cumplir la regla de <= 3 returns (sonarlint)
        $exceptionMessage = '';
        if ($element === '' || $element === null) {
            $exceptionMessage = 'No se permiten valores vacíos.';
        }
        
        if (!is_numeric($element)) {
            $exceptionMessage = "El valor '$element' no es un número válido.";
        }

        if ($exceptionMessage !== '') {
            return ['valid' => false, 'message' => $exceptionMessage, 'array' => []];
        }

        // Convertir a número (mantiene decimales si los hay)
        $validNumbers[] = is_float($element + 0) ? floatval($element) : intval($element);
    }
    
    return ['valid' => true, 'message' => '', 'array' => $validNumbers];
}

function invertedList($inputNumbers) {
    // Validar entrada con funcion auxiliar
    $validation = validateNumericArray($inputNumbers);

    // Imprimir mensaje de excepcion de validacion
    if (!$validation['valid']) {
        echo $validation['message'];
        return;
    }

    // Obtener numeros validos
    $validNumbers = $validation['array'];

    // Validar que el array tenga al menos dos caracteres
    if (count($validNumbers) <= 1) {
        echo "Por favor, ingrese al menos dos números.";
        return;
    }

    // Invertir el array
    $invertArray = [];
    for ($i = count($validNumbers) - 1; $i >= 0; $i--) {
        $currentNumber = $validNumbers[$i];
        $invertArray[] = $currentNumber;
    }
    
    // Mostrar resultado
    echo "Array original: [" . implode(', ', $validNumbers) . "]<br>";
    echo "Array invertido: [" . implode(', ', $invertArray) . "]";
}

function evenNumbersAddition($inputNumbers) {
    // Validar entrada de numeros con funcion auxiliar
    $validation = validateNumericArray($inputNumbers);
    
    // Imprimir mensaje de excepcion de validacion
    if (!$validation['valid']) {
        echo $validation['message'];
        return;
    }

    $validNumbers = $validation['array'];
    
    // Acumuladores para suma y agrupacion de numeros pares
    $result = 0;
    $evenNumbers = [];
    
    // Encontrar números pares y sumarlos
    foreach ($validNumbers as $number) {
        if ($number % 2 == 0) {
            $result += $number;
            $evenNumbers[] = $number;
        }
    }
    
    // Mostrar resultado
    echo "Array: [" . implode(', ', $validNumbers) . "]<br>";
    if (!empty($evenNumbers)) {
        echo "Números pares: [" . implode(', ', $evenNumbers) . "]<br>";
        echo "Suma de números pares: " . $result;
    } else {
        echo "No se encontraron números pares.<br>";
        echo "Suma: 0";
    }
}

function charactesFrequency($inputText) {
    // Validar que el texto no esté vacío
    if (empty($inputText)) {
        echo "Por favor, ingrese un texto.";
        return;
    }

    // Acumulador para la frecuencia por caracter
    $frequency = [];
    
    // Contar la frecuencia de cada carácter
    for ($i = 0; $i < strlen($inputText); $i++) {
        $character = $inputText[$i];
        if (isset($frequency[$character])) {
            $frequency[$character]++;
        } else {
            $frequency[$character] = 1;
        }
    }
    
    // Mostrar resultado
    echo "Texto: \"" . htmlspecialchars($inputText) . "\"<br>";
    echo "Frecuencia de caracteres:<br>";
    echo "<ul>";
    foreach ($frequency as $character => $quantity) {
        $characterToShow = ($character === ' ') ? 'espacio' : htmlspecialchars($character);
        echo "<li>'" . $characterToShow . "': " . $quantity . "</li>";
    }
    echo "</ul>";
}

function asterisksPyramid($height) {
    // Validar que la altura sea positiva
    // Ya se hace una validacion preliminar en el input, pero por si acaso
    if ($height <= 0) {
        echo "Por favor, ingrese un número mayor que 0.";
        return;
    }

    echo "Pirámide de " . $height . " niveles:<br>";
    echo "<pre>";
    
    // Crear la pirámide
    for ($i = 1; $i <= $height; $i++) {
        // Imprimir espacios para centrar
        for ($j = 1; $j <= ($height - $i); $j++) {
            echo " ";
        }
        
        // Imprimir asteriscos
        for ($k = 1; $k <= (2 * $i - 1); $k++) {
            echo "*";
        }
        
        echo "\n";
    }
    
    echo "</pre>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios de Lógica PHP - Guía 2</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <h1>Ejercicios de Lógica PHP - Guía 2</h1>
    
    <!-- Sección Lista Invertida -->
    <section>
        <h1>1. Lista Invertida</h1>
        <form method="POST" action="">
            <label for="lista_numeros">Números (separados por comas):</label>
            <input type="text" id="lista_numeros" name="lista_numeros"
                   value="<?php echo isset($_POST['lista_numeros']) ? htmlspecialchars($_POST['lista_numeros']) : '1, 2, 3, 4, 5'; ?>"
                   placeholder="Ej: 1, 2, 3, 4, 5">
            <input type="submit" value="Invertir Lista">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lista_numeros'])) {
            echo "<div class='resultado'>";
            $numeros = $_POST["lista_numeros"];
            invertedList($numeros);
            echo "</div>";
        }
        ?>
    </section>
    
    <hr>
    
    <!-- Sección Suma de Números Pares -->
    <section>
        <h1>2. Suma de Números Pares</h1>
        <form method="POST" action="">
            <label for="numeros_pares">Números enteros (separados por comas):</label>
            <input type="text" id="numeros_pares" name="numeros_pares"
                   value="<?php echo isset($_POST['numeros_pares']) ? htmlspecialchars($_POST['numeros_pares']) : '1, 2, 3, 4, 5, 6, 7, 8'; ?>"
                   placeholder="Ej: 1, 2, 3, 4, 5, 6, 7, 8">
            <input type="submit" value="Sumar Pares">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numeros_pares'])) {
            echo "<div class='resultado'>";
            $numeros = $_POST["numeros_pares"];
            evenNumbersAddition($numeros);
            echo "</div>";
        }
        ?>
    </section>
    
    <hr>
    
    <!-- Sección Frecuencia de Caracteres -->
    <section>
        <h1>3. Frecuencia de Caracteres</h1>
        <form method="POST" action="">
            <label for="texto_frecuencia">Texto a analizar:</label>
            <input type="text" id="texto_frecuencia" name="texto_frecuencia"
                   value="<?php echo isset($_POST['texto_frecuencia']) ? htmlspecialchars($_POST['texto_frecuencia']) : ''; ?>"
                   placeholder="Ingrese un texto para analizar">
            <input type="submit" value="Analizar Frecuencia">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['texto_frecuencia'])) {
            echo "<div class='resultado'>";
            $texto = $_POST["texto_frecuencia"];
            charactesFrequency($texto);
            echo "</div>";
        }
        ?>
    </section>
    
    <hr>
    
    <!-- Sección Pirámide de Asteriscos -->
    <section>
        <h1>4. Pirámide de Asteriscos</h1>
        <form method="POST" action="">
            <label for="altura_piramide">Altura de la pirámide:</label>
            <input type="number" id="altura_piramide" name="altura_piramide" min="1" max="20"
                   value="<?php echo isset($_POST['altura_piramide']) ? $_POST['altura_piramide'] : '5'; ?>">
            <input type="submit" value="Generar Pirámide">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['altura_piramide'])) {
            echo "<div class='resultado'>";
            $altura = intval($_POST["altura_piramide"]);
            asterisksPyramid($altura);
            echo "</div>";
        }
        ?>
    </section>

</body>
</html>