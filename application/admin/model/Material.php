<?php
namespace app\admin\model;

use think\Model;

/**
* 原材料
*/
class Material extends Model
{
	// 设置数据库表名
	protected $table = 'CT_Material';

	protected $dateFormat = 'Y-m-d';

	protected $type = [

		'price'			=>	'float',	// 设置价格为浮点型
		'latest_price'	=>	'float',	// 设置近期价格为浮点型

	];

	// 更新时间读取器
	protected function getUpdateTimeAttr($updateTime)
	{
		return date('Y-m-d', $updateTime);
	}
	
}