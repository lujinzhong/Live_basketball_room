<?php
 namespace app\common\lib;
  /**
  * api datatype
  *@param status 1 0
  *@param message ok flase
  *@param data json
  */
  class Util 
  {
  	
  	public static function show($status,$message='',$data=[])
  	{

      $result=[
      	'status'=>$status,
      	'message'=>$message,
      	'data'=>$data,

      ];
      echo json_encode($result);
  	}

  }