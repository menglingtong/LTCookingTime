<?php
namespace app\admin\controller;

use think\Controller;

use app\admin\model\Material as MaterialModel;

use app\admin\model\MaterialType as MaterialTypeModel;

/**
* Material
*/
class Material extends Controller
{

	function __construct($foo = null)
	{
		# TP使用构造函数，必须这么写
		parent::__construct();
	}
	
	/**************** 原料 ****************/
	/**
	 * 渲染添加原料页面
	 */
	public function addMaterial()
	{
		$typeList = MaterialTypeModel::all(['is_del'=>0]);

		$title = '添加原材料';

		$this->assign('title', $title);

		$this->assign('typeList', $typeList);

		$this->view->replace([
			'__PUBLIC__' => '/tp5/public'
		]);
		
		return $this->fetch();
	}

	/**
	 * 添加原料数据入库
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function insertMaterial()
	{
		$materialModel = new MaterialModel;

		echo input('post.price');

		// var_dump(input('post.'));die();

		if (false !== $materialModel->save(input('post.'))) {
			
			$result = ['info' => '添加成功！', 'status' => '1', 'url' => url('addMaterial')];

			return $result;

		} else {
			
			$result = ['info' => '添加失败！', 'status' => '2', 'url' => url('addMaterial')];

			return $result;

		}


	}

	/**
	 * 编辑原料库存方法
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function updateMaterial($value='')
	{
		$id = input('post.editId');

		$material = MaterialModel::get($id);

		// 判断该条原料存在数据库
		if ($material){

			// 存储近期价格
			$material->latest_price = $material->price;
			// 保存信息
			$material->name = input('post.name');
			$material->price = input('post.price');
			$material->unit = input('post.unit');
			$material->inventory = input('post.inventory');
			$material->type = input('post.type');
			$material->producer = input('post.producer');

			if (false !== $material->save()) {
				
				$result = [

					'status' => 1,
					'info'	 => '更新成功！',
					'url'	 => url('showMaterialList'),

				];

				return $result;

			} else {
				
				$result = [

					'status' => 3,
					'info'	 => '编辑失败！',
					'url'	 => url('showMaterialList'),

				];

			}

			return $result;

		} else {
			
			$result = [

				'status' => 2,
				'info'	 => '该原料不存在！',
				'url'	 => url('showMaterialList'),

			];

			return $result;

		}
		
	}

	/**
	 * 是否停用该原料
	 * @param  [type] $id    [原料id]
	 * @param  [type] $isDel [是否停用 0：启用 1：停用]
	 * @return [type]        [description]
	 */
	public function delMaterial($id, $isDel)
	{
		$material = MaterialModel::get($id);

		if ($material) {
			
			$delStr = '';

			if ($isDel == 0) {
				
				$delStr = "停用";

				$material -> is_del = 1;

			} else {
				
				$delStr = "启用";

				$material -> is_del = 0;
			}

			if (false !== $material->save()) {
				
				$result = [

					'info' => '原料'.$delStr.'成功！',

					'status' => '1',

					'url' => url('showMaterialList'),

				];

				return $result;
			}
			else{

				return $material-> getError();
			}
			

		}else{

			$result = ['info' => '原料分类不存在！', 'status' => '2', 'url' => url('showMaterialList')];

			return $result;
		}
	}

	/**
	 * 根据id查询原料
	 * @param  [type] $materialId [原料id]
	 * @return [type]             [description]
	 */
	public function readMaterialById($materialId)
	{
		$material = MaterialModel::get(['id' => $materialId]);

		if ($material) {
			
			$result = [
				'status' => 1,
				'info'	 => '查询成功',
				'obj'	 => $material,
				'url'	 => '',
			];

			return $result;

		} else {
			
			$result = [
				'status' => 2,
				'info'	 => '该条信息不存在！',
				'url'	 => '',
			];

			return $result;

		}
	}

	/**
	 * 展示原料列表页面
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function showMaterialList($value='')
	{
		$materialList = MaterialModel::paginate(8);

		$typeList = MaterialTypeModel::all(['is_del' => 0]);

		$this->assign('list', $materialList);

		$this->assign('typeList', $typeList);

		$title = '原料列表';

		$this->assign('title', $title);

		$this->view->replace([
			'__PUBLIC__' => '/tp5/public',
		]);

		return $this->fetch();
	}

	/****************** 原料分类 ****************/
	/**
	 * 渲染添加原料分类页面
	 * @param string $value [description]
	 */
	public function addMaterialType($value='')
	{

		$materialTypeList = MaterialTypeModel::paginate(5);

		$this->assign('list', $materialTypeList);

		$title = '添加原料类型';

		$this->assign('title', $title);

		$this->view->replace([
			'__PUBLIC__' => '/tp5/public',
		]);

		return $this->fetch();
	}

	/**
	 * 停用原料分类
	 * @param  string $id [原料分类id]
	 * @param  string $isDel [是否停用 0：不停用  1：停用]
	 * @return [type]     [description]
	 */
	public function delMaterialType($id, $isDel)
	{
		
		$materialTypeModel = MaterialTypeModel::get($id);

		if ($materialTypeModel) {
			$delStr = '';
			// 原来未停用
			if ($isDel == 0) {
				
				// 停用
				$materialTypeModel -> is_del = 1;

				$delStr = "停用";
			} else {
				
				// 启用
				$materialTypeModel -> is_del = 0;

				$delStr = "启用";
			}
			
			if (false !== $materialTypeModel->save()) {
				
				$result['info'] = '原料分类'.$delStr.'成功！';
				$result['status'] = '1';
				$result['url'] = url('addMaterialType');

				return $result;
			} else {

				return $materialTypeModel->getError();
			}

		} else {
			
			$result = ['info' => '原料分类不存在！', 'status' => '2', 'url' => url('addMaterialType')];

			return $result;
		}
		
	}

	/**
	 * 添加原料分类入库
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function insertMaterialType()
	{
		$materialTypeModel = new MaterialTypeModel;

		if ($materialTypeModel -> save(input('post.'))) {

			$result = ['info' => '原料添加成功！', 'status' => '1', 'url' => url('addMaterialType')];
			
			return $result;

		} else {
			return $materialTypeModel->getError();
		}
		
	}

	/**
	 * 更新原料分类
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function updateMaterialType()
	{

		$id = input('post.editId');
		
		$materialTypeModel = MaterialTypeModel::get($id);

		if ($materialTypeModel) {
			
			$materialTypeModel->name = input('post.name');

			if (false !== $materialTypeModel->save()) {
				
				$result = ['info' => '原料更新成功！', 'status' => '1', 'url' => url('addMaterialType')];

				return $result;

			} else {
				
				return $materialTypeModel->getError();
			}
			
			
		} else {

			return $materialTypeModel->getError();
		}
		
	}

}