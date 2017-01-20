<?php
namespace app\index\controller;

use think\Controller;

use think\Db;

class Index extends Controller
{
    public function hello($name = 'MLT')
    {

    	$this->assign('name', $name);

    	$data = Db::name('Settings')->find();

    	$this->assign('result', $data);

    	return $this->fetch();

    }

    

    
}
