 <?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

use DataBase\Conexao;
use App\Tarefa;

//print_r($_SERVER['REQUEST_METHOD']);
//print_r($tarefas);
if(!isset($_REQUEST['rota'])) tarefas();


if(isset($_REQUEST['rota'])){

  $rota = $_REQUEST['rota'];
  $operacao = null;
  if(!isset($_REQUEST['op'])) $operacao = 'listar';
  if(isset($_REQUEST['op'])) $operacao = $_REQUEST['op'];
  
  switch ($rota) {
    case 'tarefas':
      tarefas($operacao);      
      break;
    
    default:
      erro(404);
      break;
  }
}

function tarefas($operacao = 'listar')
{
  if($operacao == 'listar') return listarTarefas();  
  if($operacao == 'enviar') inserirTarefa();
  if($operacao == 'ordenar') ordenarTarefas();
  if($operacao == 'excluir') removerTarefa();
}


function erro($codigo)
{
  require_once('pages/'.$codigo.'.php');
}

function listarTarefas()
{
  $tarefa = new Tarefa();
  $tarefas = $tarefa->get();
  require_once('pages/tarefas.php');
}


function inserirTarefa()
{
  $tarefa = new Tarefa();
  $tarefa->setTitulo(sanitizar($_POST['titulo']));
  $tarefa->setDescricao(sanitizar($_POST['descricao']));
  $resposta = $tarefa->save();
  echo json_encode($resposta);
}

function ordenarTarefas()
{
  $tarefa = new Tarefa();
  $tarefa->sort($_POST['ordenacoes']); 
}


function removerTarefa()
{
  $tarefa = new Tarefa();
  $resposta = $tarefa->delete(sanitizar($_POST['id']));  
  echo json_encode($resposta);
}


function sanitizar($value)
{
  $value = trim($value);
  return strip_tags($value);
}
