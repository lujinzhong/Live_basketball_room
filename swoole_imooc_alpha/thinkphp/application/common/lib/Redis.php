<?php
 namespace app\common\lib;
  /**
   * captcha prefix
   */
  class Redis
  {
  	public static $pre="sms_";
    public static $user_pre="user_";
  	
  	public static function smsKey($phone)
  	{
  		return self::$pre.$phone;

  	}
    public static function userKey($phone)
    {
      return self::$user_pre.$phone;
    }

  }