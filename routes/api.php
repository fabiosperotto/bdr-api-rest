<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../vendor/autoload.php');

use DataBase\Conexao;
use App\TarefaAPI as Tarefa;
$method = $_SERVER['REQUEST_METHOD'];
$tarefa = new Tarefa($_REQUEST['request'], $_SERVER['REQUEST_METHOD']);



//print_r($_REQUEST);

