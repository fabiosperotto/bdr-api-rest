<?php
namespace App;

abstract class AbstractAPI
{
	//protected $metodo;
	//protected $request = array();
	

	public function __construct()
	{
		//        
        //$this->request = explode('/', rtrim($request, '/'));
        //$this->metodo = $metodo;
        // echo 'argumentos';
        // print_r($this->request);
        // echo 'method';
        // print_r($this->metodo);
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	// public function setRequest($request)
	// {
	// 	$this->request = $request;
	// }

	private function statusCode($codigo){

		$mensagem = '';		
		if($codigo == 200) $mensagem ='OK';
        if($codigo == 400) $mensagem ='Bad Request';
        if($codigo == 401) $mensagem ='Unauthorized';
        if($codigo == 404) $mensagem ='Not Found';
        if($codigo == 405) $mensagem ='Method Not Allowed';
        if($codigo == 500) $mensagem ='Internal Server Error';
        if($codigo == 502) $mensagem ='Service temporarily overloaded';
        return $mensagem;
	}


	protected function response($data, $status = 200) {

		header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json"); 
        header("HTTP/1.1 " . $status . " " . $this->statusCode($status));
        return json_encode($data);
    }




    /**
     * Obriga a todas as classes que estenderem desta, implementar um metodo para validar inputs, principalmente do verbo POST
     * @param array $colunas      
     */
    public abstract function checkData($colunas);


}