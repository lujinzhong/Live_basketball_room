<?php
  /**
  * asyncmysql class 
  */
  class AsyncMysql
  {
  	
   public $db_res=null;
   public $config=[];
   public function __construct(){
  		$this->db_res = new swoole_mysql;
		$this->config = array(
		    'host' => '127.0.0.1',
		    'port' => 3306,
		    'user' => 'root',
		    'password' => '960801',
		    'database' => 'test',
		    'charset' => 'utf8', //指定字符集
		    'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
		);
	

  	
  	}

  	/**
  	 * add
  	 */
  	public function add(){

  	}
  	/**
  	 * del
  	 */
  	public function del(){

  	}
  	/**
  	 * update
  	 */
  	public function update(){

  	}
  	/**
  	 * select
  	 */
  	public function select(){


  	}
  	/**
  	 * excute
  	 */
  	public function excute($id,$name){
  		//connect the mysql
	    $this->db_res->connect($this->config,function($db,$r){
		
			if($r == false){
				var_dump($db->connect_error);
				die;
			}

			echo "connest".PHP_EOL;
	  		$sql="select * from user";
	  		//query()   
	  		//$r=flase error $r=result select  $r=true $r=add del update 
	   		$this->db_res->query($sql,function($db,$r){
	   			if($r === false){
	   				var_dump($db->error);
	   			}else if($r === true){
	   				var_dump($db->affected_rows);
	   			}else{
	   				var_dump($r).PHP_EOL;
	   			}
	   	    $db->close();

	  		});
         
		});

  		
  		
  		return true;

  	}


  }
  $obj = new AsyncMysql();
  $flag = $obj->excute(1,'xiaolu');
  var_dump($flag).PHP_EOL;
  echo "go".PHP_EOL;
