<?php


namespace app\admin\middleware;


use app\admin\model\AuthGroupAccess;
use libs\toTree;

class Auth
{
    public function handle($request, \Closure $next)
    {
        $request->user = $this->getCacheUser();
        $menu = $this->getMenu($request->user['id']);
        $request->menu = toTree::toLayer($menu);
        return $next($request);
    }

    /**
     * 获取登录的用户信息
     * @return mixed|void
     */
    public function getCacheUser(){
        try {
            $user = json_decode(cache("user"),true);
            if (!$user){
                header("Location:".url("User/login"));
                exit();
            }
            $this->checkAuth($user['id']);
            return $user;
        }catch (\Exception $e){
            return toJson($e->getMessage());
        }
    }

    /**
     * 检测当前用户的权限
     * @param $uid
     */
    public function checkAuth($uid){
        $auth = new \liliuwei\think\Auth();
        $controller = strtolower(request()->controller());
        $action = strtolower(request()->action());
        $url = $controller . "/" . $action;
        if (!$auth->check($url,$uid)) {
            // 判断访问方式
            if (request()->isGet()){
                exit('<div><img width="100%" height="100%" src="/static/admin/img/error.svg"/></div><div style="position:absolute;left:calc(50% - 80px);top:50%;text-align: center;color: #fff;font-weight: bolder;">抱歉，暂无权限访问哟</div><script>setTimeout(() => {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }, 3000)</script>');
            }
            return toJson("暂无权限访问");
        }
    }

    /**
     * 获取当前用户能访问的菜单项
     * @param $uid
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getMenu($uid){
        $menu = AuthGroupAccess::getRuleByUid($uid,true);
        return $menu;
    }
}