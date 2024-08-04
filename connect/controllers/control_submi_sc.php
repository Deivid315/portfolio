<?php


declare(strict_types=1);

session_start();
ob_start();

function redirectToIndex(string $message = ""): void {
    $queryParams = http_build_query(['logado' => 'false', 'message' => $message]);
    header("Location: ../views/admin/index.php?$queryParams");
    session_destroy();
    exit();
}

function redirectWithError(string $message): void {
    $queryParams = http_build_query(['incorrect' => 'true', 'message' => $message]);
    header("Location: ../views/admin/inicial.php?$queryParams");
    exit();
}

function redirectWithValidationErrors(array $validationErrors): void {
    $queryParams = http_build_query(array_map(function ($index) use ($validationErrors) {
        return "error[$index]=" . urlencode($validationErrors[$index]);
    }, array_keys($validationErrors)));
    header("Location: ../views/admin/inicial.php?nsl&$queryParams");
    exit();
}

function cleanInput(string $input): string {
    return preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $input);
}

function saveData(string $tab, string $estat, array $data): void {
    foreach ($data as $name => $value) {
        require_once __DIR__ . "../../models/filtro_mostre.php";
        $fraseLimpa = cleanInput($value);

        $alt = new Fill;
        $alt->get_alterar($estat, $tab, $name, $value);
    }
        header("Location: ../views/admin/inicial.php?bda=salvo");
        exit();
}

function validateInputData(array $data): array {
    $validationErrors = [];
    foreach ($data as $name => $val) {
        if (trim($val) === '') {
            $validationErrors[] = "O campo $name está vazio.";
        } else {
            $fraseLimpa = cleanInput($val);
            $length = strlen($fraseLimpa);
            if ($name === "cidade" || $name === "matricula") {
                if ($length <= 2 || $length >= 200) {
                    $validationErrors[] = "O campo $name deve ter entre 3 e 200 caracteres.";
                }
            } else {
                if ($length <= 2 || $length >= 40) {
                    $validationErrors[] = "O campo $name deve ter entre 3 e 40 caracteres.";
                }
            }
        }
    }
    return $validationErrors;
}

// Verifica se o usuário está logado
if (!isset($_SESSION['nome_admin']) || !isset($_SESSION['id_admin'])) {
    redirectToIndex("Você não está logado.");
}

// Verifica se os dados foram passados via GET
if (empty($_GET)) {
    redirectWithError("Nenhum dado foi recebido.");
}

// Verifica se o parâmetro 'escola' está presente nos dados GET
if (!isset($_GET['escola']) && !isset($_GET['estado'])) {
    redirectWithError("O parâmetro 'escola' é obrigatório.");
}

$tab = $_GET['escola'];
$estat = $_GET['estado'];
unset($_GET['escola']);
unset($_GET['estado']);

// Verifica se o comprimento de 'escola' é válido
if (!(strlen($tab) === 3 || strlen($tab) === 4) && !(strlen($estat) === 2)) {
    redirectWithError("O parâmetro 'escola' deve ter 3 ou 4 caracteres ou o parametro
    estado deve ter 2 caracteres");
}

// Valida os dados de entrada
$validationErrors = validateInputData($_GET);

// Se houver erros de validação, redireciona de volta com os erros
if (!empty($validationErrors)) {
    redirectWithValidationErrors($validationErrors);
}

// Se não houver erros, salva os dados
saveData($tab, $estat, $_GET);



/*
session_start();
ob_start();


if ((!isset($_SESSION['nome_admin'])) && (!isset($_SESSION['id_admin']))) {
    header("location: ../views/index.php?logado=false");
    session_destroy();
    exit();
}

if (!empty($_GET)) {

    if (isset($_GET['escola'])) {

        $tab = $_GET['escola'];
        unset($_GET['escola']);

        if ((strlen($tab) === 3) || (strlen($tab) === 4)) {

            $rept = 1;
            $ar = array();
            $rept3 = 1;
            $ar3 = array();
            foreach ($_GET as $nome => $val) {
                if (trim($val) == '') {
                    $ws = "vazio" . $rept;
                    $ar[$ws] = $nome;
                    $rept++;
                } else {
                    if ($nome === "cidade" || $nome === "matricula") {
                        $fraseLimpa = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $val);

                        if (strlen($fraseLimpa) >= 200) {
                            $ws = "maior_q_200_" . $rept3;
                            $ar3[$ws] = $nome;
                            $rept3++;
                        }
                    } else {

                        $fraseLimpa = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $val);
                        if (strlen($fraseLimpa) <= 4) {
                            $ws = "menor_q_3_" . $rept3;
                            $ar3[$ws] = $nome;
                            $rept3++;
                        } else if (strlen($fraseLimpa) >= 41) {
                            $ws = "maior_q_40_" . $rept3;
                            $ar3[$ws] = $nome;
                            $rept3++;
                        }
                    }
                }
            }
            if (empty($ar) && empty($ar3)) {

                foreach ($_GET as $nome => $val) {

                    require_once __DIR__ . "../../models/filtro_mostre.php";
                    $fraseLimpa = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $val);

                    $alt = new Fill;
                    $alt->get_alterar($tab, $nome, $val);
                    echo $alt->fim;
                    if ($alt->fim === "salvo") {
                        header("location: ../views/inicial.php?bda=" . $alt->fim);
                    }
                }
            } else {
                header("location: ../views/inicial.php?nsl&" . http_build_query(array_merge($ar, $ar3)));
                exit();
            }
        } else {
            header("location: ../views/inicial.php?incorrect=true");
            exit;
        }
    } else {
        header("location: ../views/inicial.php?incorrect=true");
        exit;
    }
} else {
    header("location: ../views/inicial.php?incorrect=true");
    exit;
}
*/