<?php
namespace App;

use DataBase\Conexao;

class Tarefa
{
	private $banco = null;
	private $titulo;
	private $descricao;

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
	

	public function __construct()
	{
		$this->banco = Conexao::getInstancia();
		$conexao = $this->banco->getConexao();		
		if($conexao != null) $conexao->query("SET NAMES UTF8"); //corrige charset do banco para acentos
	}

	public function get()
	{		
		$conexao = $this->banco->getConexao();		
		if($conexao == null) return false;
		$consulta = $conexao->query('SELECT * FROM tarefas ORDER BY prioridade ASC');
		$consulta->execute();
		return $consulta->fetchAll(\PDO::FETCH_OBJ);
	}

	public function save()
	{
		$conexao = $this->banco->getConexao();
		$response = array(
			'erros' => 1,
		);
		if($conexao == null) return $response;	
		$consulta = $conexao->query('SELECT MAX(prioridade) as maxima FROM tarefas');
		$consulta->execute();
		$registro = $consulta->fetch(\PDO::FETCH_OBJ);
		$prioridade = 1;
		if($registro->maxima != null) $prioridade = $registro->maxima + 1;
		$consulta = $conexao->prepare("INSERT INTO tarefas (id,titulo, descricao, prioridade) 
										VALUES (null, ?, ?, ?)");
		$consulta->bindValue(1,$this->titulo,\PDO::PARAM_STR);
		$consulta->bindValue(2,$this->descricao,\PDO::PARAM_STR);
		$consulta->bindValue(3,$prioridade,\PDO::PARAM_INT);
		$consulta->execute();
		
		if($consulta->rowCount() > 0){
			$response['erros'] = 0;
			$response['item'] = array(
				'id' => $conexao->lastInsertId(),
				'titulo' => $this->titulo,
				'descricao' => $this->descricao,
				'prioridade' => $prioridade
			);
		}
		return $response;

	}

	public function sort($ordens)
	{		
		if(!is_array($ordens)) return false;
		$conexao = $this->banco->getConexao();		
		if($conexao == null) return false;	
		foreach ($ordens as $key=>$value) {
			$consulta = $conexao->prepare("UPDATE tarefas SET prioridade = ? WHERE id = ?");
			$consulta->bindValue(1,$key,\PDO::PARAM_INT);
			$consulta->bindValue(2,$value,\PDO::PARAM_INT);
			$consulta->execute();
			
		}
		return true;
	}

	public function delete($id)
	{
		
		$response = array(
			'erros' => 1,
		);
		$conexao = $this->banco->getConexao();		
		if($conexao == null) return $response;
		$consulta = $conexao->prepare("DELETE FROM tarefas WHERE id = ?");
		$consulta->bindValue(1,$id,\PDO::PARAM_INT);
		$consulta->execute();
		if($consulta->rowCount() > 0){
			$response['erros'] = 0;
			$response['item'] = array(
				'id' => $id
			);
		}
		return $response;
	}
}