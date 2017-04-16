<?php
namespace DataBase;

class Conexao
{
	private static $banco = null;
	private $conexao;

	private $debug 	= FALSE; //colocar para false na producao
	// private $servidor	= "localhost";
	// private $login		= "root";
	// private $senha		= "1234";
	// private $database	= "task-list";
	

	private function __construct()
	{			
		$config = parse_ini_file('./.env.ini');
		if($config == false) die("não existe arquivo de configuração");
		try{
			$this->conexao = new \PDO('mysql:host='.$config['DB_HOST'].';dbname='.$config['DB_NAME'].';',$config['DB_LOGIN'],$config['DB_PASS']);
			$this->conexao->query("SET lc_time_names = 'pt_BR'"); //util para nomes de datas em portugues			
			if($this->debug) $this->conexao->setAttribute(\PDO::ATTR_ERRMODE);
		}catch(\PDOException $e){
			require_once('./pages/502.php');
			exit;
			if($this->debug) echo $e->getMessage();
		}
	}

	private function __clone()
	{
		
	}

	public static function getInstancia()
	{

		if(self::$banco == null) self::$banco = new Conexao();
		return self::$banco;
	}

	public function getConexao()
	{
		return $this->conexao;
	}
}