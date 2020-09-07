<?php


namespace app\admin\controller;

use app\admin\middleware\Auth;
use app\BaseController;
use think\App;
use think\facade\View;

class Base extends BaseController
{
    use \liliuwei\think\Jump;
    protected $middleware = [
        Auth::class => ['except' 	=> ['login','outLogin'] ]
    ];
    protected $dev = [];
    public function __construct(App $app)
    {
        $this->setDevConfig();
        View::assign("dev",$this->dev);
        View::assign("admin",request()->user);
        View::assign("base_url",base_url());
        View::assign("admin_url",url('/admin'));
        parent::__construct($app);
    }
    public function setDevConfig(){
        $this->dev = config("dev");
    }
}