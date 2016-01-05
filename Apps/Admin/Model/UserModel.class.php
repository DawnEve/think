<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model{
	function __construct(){
		parent::__construct();
		echo '[From Admin: Model]';
	}
}