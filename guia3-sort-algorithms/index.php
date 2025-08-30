<?php
// Constantes para evitar duplicación de literales
define('ARRAY_ORIGINAL_LABEL', 'Array original: [');
define('ARRAY_SORTED_LABEL', 'Array ordenado');

function showResult($originalList, $sortedList, $sort)
{
    echo ARRAY_ORIGINAL_LABEL . implode(', ', $originalList) . "]<br>";
    echo ARRAY_SORTED_LABEL . " ($sort): [" . implode(', ', $sortedList) . "]<br>";
}

// Función auxiliar para validar entrada de arrays numéricos
function validateNumericArray($input)
{
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
        // Bandera de mensaje de excepción, para evitar hacer un return por cada if
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

// Función auxiliar para validar entrada de arrays de texto
function validateTextArray($input)
{
    // Convertir string a array si es necesario
    if (is_string($input)) {
        $array = explode(',', $input);
        $array = array_map('trim', $array);
    } else {
        $array = $input;
    }

    // Validar que no esté vacío
    if (empty($array)) {
        return ['valid' => false, 'message' => 'Por favor, ingrese al menos un elemento.', 'array' => []];
    }

    // Filtrar elementos vacíos
    $validElements = [];
    foreach ($array as $element) {
        if ($element !== '' && $element !== null) {
            $validElements[] = $element;
        }
    }

    if (empty($validElements)) {
        return ['valid' => false, 'message' => 'No se permiten valores vacíos.', 'array' => []];
    }

    return ['valid' => true, 'message' => '', 'array' => $validElements];
}

// Algoritmo Bubble Sort para números (orden descendente)
function bubbleSort($inputNumbers)
{
    // Validar entrada
    $validation = validateNumericArray($inputNumbers);

    if (!$validation['valid']) {
        echo $validation['message'];
        return;
    }

    $numbers = $validation['array'];
    $originalNumbers = $numbers; // Guardar copia del array original

    $n = count($numbers);

    // Implementación del Bubble Sort (descendente)
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            // Comparar elementos adyacentes (> para descendente)
            if ($numbers[$j] < $numbers[$j + 1]) {
                // Intercambiar elementos
                $temp = $numbers[$j];
                $numbers[$j] = $numbers[$j + 1];
                $numbers[$j + 1] = $temp;
            }
        }
    }

    // Mostrar resultado
    showResult($originalNumbers, $numbers, 'descendente');
    // echo ARRAY_ORIGINAL_LABEL . implode(', ', $originalNumbers) . "]<br>";
    // echo ARRAY_SORTED_LABEL . " (descendente): [" . implode(', ', $numbers) . "]<br>";
}

// Algoritmo Merge Sort para palabras (orden alfabético)
function mergeSort($arr)
{
    if (count($arr) <= 1) {
        return $arr;
    }

    $mid = floor(count($arr) / 2);
    $left = array_slice($arr, 0, $mid);
    $right = array_slice($arr, $mid);

    return merge(mergeSort($left), mergeSort($right));
}

function merge($left, $right)
{
    $result = [];
    $leftIndex = 0;
    $rightIndex = 0;

    while ($leftIndex < count($left) && $rightIndex < count($right)) {
        if (strcasecmp($left[$leftIndex], $right[$rightIndex]) <= 0) {
            $result[] = $left[$leftIndex];
            $leftIndex++;
        } else {
            $result[] = $right[$rightIndex];
            $rightIndex++;
        }
    }

    // Agregar elementos restantes
    while ($leftIndex < count($left)) {
        $result[] = $left[$leftIndex];
        $leftIndex++;
    }

    while ($rightIndex < count($right)) {
        $result[] = $right[$rightIndex];
        $rightIndex++;
    }

    return $result;
}

function mergeSortWords($inputWords)
{
    // Validar entrada
    $validation = validateTextArray($inputWords);

    if (!$validation['valid']) {
        echo $validation['message'];
        return;
    }

    $words = $validation['array'];
    $originalWords = $words; // Guardar copia del array original

    // Aplicar Merge Sort
    $sortedWords = mergeSort($words);

    // Mostrar resultado
    showResult($originalWords, $sortedWords, 'alfabético');
}

// Algoritmo Insertion Sort para nombres (orden alfabético)
function insertionSort($inputNames)
{
    // Validar entrada
    $validation = validateTextArray($inputNames);

    if (!$validation['valid']) {
        echo $validation['message'];
        return;
    }

    $names = $validation['array'];
    $originalNames = $names; // Guardar copia del array original

    $n = count($names);

    // Implementación del Insertion Sort
    for ($i = 1; $i < $n; $i++) {
        $key = $names[$i];
        $j = $i - 1;

        // Mover elementos que son mayores que key una posición adelante
        while ($j >= 0 && strcasecmp($names[$j], $key) > 0) {
            $names[$j + 1] = $names[$j];
            $j--;
        }
        $names[$j + 1] = $key;
    }

    // Mostrar resultado
    showResult($originalNames, $names, 'alfabético');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algoritmos de Ordenamiento PHP - Guía 3</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <h1>Algoritmos de Ordenamiento PHP - Guía 3</h1>

    <!-- Sección Bubble Sort -->
    <section>
        <h1>1. Ordenamiento con Bubble Sort (Descendente)</h1>
        <p>Ordena una lista de números de forma descendente utilizando el algoritmo Bubble Sort.</p>
        <form method="POST" action="">
            <label for="bubble_numbers">Números (separados por comas):</label>
            <input type="text" id="bubble_numbers" name="bubble_numbers"
                value="<?php echo isset($_POST['bubble_numbers']) ? htmlspecialchars($_POST['bubble_numbers']) : '64, 34, 25, 12, 22, 11, 90, -5'; ?>"
                placeholder="Ej: 64, 34, 25, 12, 22, 11, 90, -5">
            <input type="submit" value="Ordenar con Bubble Sort">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bubble_numbers'])) {
            echo "<div class='resultado'>";
            $numbers = $_POST["bubble_numbers"];
            bubbleSort($numbers);
            echo "</div>";
        }
        ?>
    </section>

    <hr>

    <!-- Sección Merge Sort -->
    <section>
        <h1>2. Ordenamiento con Merge Sort (Alfabético)</h1>
        <p>Ordena una lista de palabras alfabéticamente utilizando el algoritmo Merge Sort.</p>
        <form method="POST" action="">
            <label for="merge_words">Palabras (separadas por comas):</label>
            <input type="text" id="merge_words" name="merge_words"
                value="<?php echo isset($_POST['merge_words']) ? htmlspecialchars($_POST['merge_words']) : 'manzana, banana, cereza, durazno, uva, kiwi'; ?>"
                placeholder="Ej: manzana, banana, cereza, durazno, uva, kiwi">
            <input type="submit" value="Ordenar con Merge Sort">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['merge_words'])) {
            echo "<div class='resultado'>";
            $words = $_POST["merge_words"];
            mergeSortWords($words);
            echo "</div>";
        }
        ?>
    </section>

    <hr>

    <!-- Sección Insertion Sort -->
    <section>
        <h1>3. Ordenamiento con Insertion Sort (Alfabético)</h1>
        <p>Ordena una lista de nombres en orden alfabético utilizando el algoritmo Insertion Sort.</p>
        <form method="POST" action="">
            <label for="insertion_names">Nombres (separados por comas):</label>
            <input type="text" id="insertion_names" name="insertion_names"
                value="<?php echo isset($_POST['insertion_names']) ? htmlspecialchars($_POST['insertion_names']) : 'Juan, María, Carlos, Ana, Pedro, Sofía, Luis'; ?>"
                placeholder="Ej: Juan, María, Carlos, Ana, Pedro, Sofía, Luis">
            <input type="submit" value="Ordenar con Insertion Sort">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertion_names'])) {
            echo "<div class='resultado'>";
            $names = $_POST["insertion_names"];
            insertionSort($names);
            echo "</div>";
        }
        ?>
    </section>

</body>

</html>