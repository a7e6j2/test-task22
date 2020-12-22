<?php
	
namespace micro\models;

use Yii;
use yii\base\NotSupportedException;

use yii\web\IdentityInterface;

class User implements IdentityInterface{

	public static function findIdentity($id){
		
        //MARK: Wait for implementation ***
    }

    public static function findIdentityByAccessToken($token, $type = null){

         //MARK: Wait for implementation ***
    }
}
   