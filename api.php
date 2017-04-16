<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';

use DataBase\Conexao;
use App\TarefaAPI as Tarefa;



if(isset($_REQUEST['request'])){

	$argumentos = explode('/', rtrim($_REQUEST['request'], '/'));
	
	switch ($argumentos[0]) {
		case 'tarefas':
			tarefas(getallheaders(), $_SERVER['REQUEST_METHOD'], $argumentos);
			break;
		
		default:
			erro(array('mensagem' => 'Não existe caminho requisitado'), 404, 'Not Found');
			break;
	}
}

function erro($data, $codigo, $textoCodigo)
{
  	header("Access-Control-Allow-Orgin: *");
	header("Access-Control-Allow-Methods: *");
	header("Content-Type: application/json"); 
	header("HTTP/1.1 " . $codigo . " " . $textoCodigo);
	echo json_encode($data);
	exit;
}

function tarefas($headers, $method, $argumentos)
{
	
	if($method == 'GET') echo listagemTarefas($headers);
	if( $method == 'POST' && !isset($argumentos[1]) ) echo salvarTarefa($headers);
	if($method == 'DELETE') echo excluirTarefa($headers, $argumentos);
	if( $method == 'POST' && isset($argumentos[1]) ) echo atualizarTarefa($headers, $argumentos);

}

function listagemTarefas($headers)
{
	$tarefa = new Tarefa($headers);	
	return $tarefa->get();
}

function salvarTarefa($headers)
{
	$tarefa = new Tarefa($headers);
	if($tarefa->checkData($_POST) == true){
		$tarefa->setTitulo(sanitizar($_POST['titulo']));
	  	$tarefa->setDescricao(sanitizar($_POST['descricao']));
	  	return $tarefa->save();
	}
	return $tarefa->setResponse(array('mensagem' => 'Verifique os atributos enviados na requisição'), 400);
}

function excluirTarefa($headers, $argumentos)
{	
	$id = null;
	if(isset($argumentos[1])) $id = sanitizar($argumentos[1]);
	$tarefa = new Tarefa($headers);
	return $tarefa->delete($id);

}

function atualizarTarefa($argumentos)
{	
	
	$id = null;
	$tarefa = new Tarefa($headers);
	if(isset($argumentos[1])) $id = sanitizar($argumentos[1]);
	if($tarefa->checkData($_POST) == true){
		$tarefa->setTitulo(sanitizar($_POST['titulo']));
	  	$tarefa->setDescricao(sanitizar($_POST['descricao']));
		return $tarefa->update($id);
	}	
	return $tarefa->setResponse(array('mensagem' => 'Verifique os atributos (campos e ID) enviados na requisição'), 400);

}

function sanitizar($value)
{
  $value = trim($value);
  return strip_tags($value);
}
