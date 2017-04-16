<?php
namespace App;

use DataBase\Conexao;

class TarefaAPI extends AbstractAPI
{
	private $banco = null;
	private $titulo;
	private $descricao;

	public function __construct($headers)
	{
		parent::__construct($headers);
		$this->banco = Conexao::getInstancia();
		$conexao = $this->banco->getConexao();	
		if($conexao == null) return $this->response(array('mensagem'=> 'Problemas na conexão'), 502);
		if($this->verificaAutorizacao($headers) === false){
			echo $this->response(array('mensagem'=> 'Acesso proibido'), 403);
			exit;			
		}
	}

	private function verificaAutorizacao($headers)
	{
		if( !isset($headers['Authorization']) ) return false;
		if( isset($headers['Authorization']) ){
			$conexao = $this->banco->getConexao();
			$consulta = $conexao->prepare('SELECT id FROM chaves WHERE token = ? AND status = 1');
			$consulta->bindValue(1,$headers['Authorization'],\PDO::PARAM_STR);
			$consulta->execute();
			$registro = $consulta->fetch(\PDO::FETCH_OBJ);

			return $registro;

		}
		return false;
	}

	public function checkData($inputs)
	{
		if(empty($inputs)) return false;		
		if( !isset($inputs['titulo']) || !isset($inputs['descricao']) ) return false;
		return true;

	}

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}


	public function get()
	{		
		$conexao = $this->banco->getConexao();			
		if($conexao == null) return $this->response(array('mensagem'=> 'Problemas na conexão'), 502);
		$consulta = $conexao->query('SELECT * FROM tarefas ORDER BY prioridade ASC');
		$consulta->execute();
		$dados = $consulta->fetchAll(\PDO::FETCH_OBJ);
		return $this->response($dados, 200);
	}

	public function save()
	{
		$conexao = $this->banco->getConexao();
		if($conexao == null) return  $this->response(array('mensagem'=> 'Problemas na conexão'), 502);
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
			return $this->response(array('mensagem'=> 'Registro criado com sucesso'), 200);
			
		}		
		return $this->response(array('mensagem'=> 'Não é possível processar a inserção de registro no momento'), 500);
		
	}

	public function delete($id)
	{
		if($id == null) return $this->response(array('mensagem'=> 'ID do recurso não identificado'), 400);
		$conexao = $this->banco->getConexao();
		if($conexao == null) return  $this->response(array('mensagem'=> 'Problemas na conexão'), 502);	
		$consulta = $conexao->prepare("DELETE FROM tarefas WHERE id = ?");
		$consulta->bindValue(1,$id,\PDO::PARAM_INT);
		$consulta->execute();
		if($consulta->rowCount() > 0) return $this->response(array('mensagem'=> 'Registro excluido com sucesso'), 200);
		return $this->response(array('mensagem'=> 'Registro para o ID informado não foi encontrado'), 200);		
	}

	public function update($id)
	{
		if($id == null) return $this->response(array('mensagem'=> 'ID do recurso não identificado'), 400);
		$conexao = $this->banco->getConexao();
		if($conexao == null) return  $this->response(array('mensagem'=> 'Problemas na conexão'), 502);
		$consulta = $conexao->prepare("UPDATE tarefas SET titulo = ?, descricao = ? WHERE id = ?");
		$consulta->bindValue(1,$this->titulo,\PDO::PARAM_STR);
		$consulta->bindValue(2,$this->descricao,\PDO::PARAM_STR);
		$consulta->bindValue(3,$id,\PDO::PARAM_INT);
		$consulta->execute();
		if($consulta->rowCount() > 0) return $this->response(array('mensagem'=> 'Registro atualizado com sucesso'), 200);
		return $this->response(array('mensagem'=> 'Registro para o ID informado não foi encontrado'), 200);		
	}


	public function setResponse($data, $codigo)
	{
		return $this->response($data, $codigo);
	}
}