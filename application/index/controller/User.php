<?php
namespace app\index\controller;

use app\index\model\User as UserModel;

/**
* 用户管理类
*/
class User
{

	function __construct($foo = null)
	{
		// echo "hahha";
	}
	
	// 新增用户数据
	public function addUser(){

		$user = new UserModel;

		// $user->nickname = '哥流弊轰轰的路过';

		// $user->email = 'ak-7755@qq.com';

		// $user->birthday = strtotime('2016-12-31');

		if ($user->allowField(true)->validate(true)->save(input('post.'))) {
			return '用户['.$user->nickname.':'.$user->id.']新增成功';
		} else {
			return $user->getError();
		}
		
	}

	// 创建用户数据页面
	public function create($value='')
	{
		return view();
	}
}