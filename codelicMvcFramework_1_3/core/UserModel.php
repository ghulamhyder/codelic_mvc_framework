<?php
namespace app\core;

Abstract class UserModel extends DbModel {

abstract public function userDisplayName():string;

}


?>