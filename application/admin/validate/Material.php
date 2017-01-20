<?php
namespace app\admin\validate;

use think\Validate;

/**
 * Material 验证
 */
class Material extends Validate
{
	
	protected $rule = [

		'name' => 'require';

	];
}