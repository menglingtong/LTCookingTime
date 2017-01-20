<?php

namespace app\index\model;

use think\Model;

/**
* 
*/
class User extends Model
{

	// 设置数据表（不含前缀）
	protected $name = 'User';

	protected $dateFormat = 'Y-m-d';

	protected $type = [

		// 设置birthday的类型为时间戳类型（整形）
		'birthday' => 'timestamp',

	];

	// 定义时间戳字段名
	// protected $createTime = 'create_at'; 
	// protected $updateTime = 'update_at';
	
	// 定义自动完成的属性
	protected $insert = ['status' => 1];


	// 读取器 get方法
	protected function getUserBirthdayAttr($value, $data)
	{
		return date('Y-m-d', $data['birthday']);
	}
	
	// 修改器 set方法
	protected function setBirthdayAttr($value)
	{
		return strtotime($value);
	}

}