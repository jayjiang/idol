<?php


namespace app\admin\controller;


use app\admin\model\Admin;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use think\facade\Db;

class User extends Base
{
    /**
     * 用户列表
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lists(){
        if (request()->isAjax()){
            $res = Admin::getAllAdmin(true);
            return toJson("数据获取成功",200,$res);
        }else{
            return view();
        }
    }
    /**
     * 编辑
     * @return \think\response\View|void
     */
    public function modify(){
        if (request()->isAjax()){
            $post = input("post.");
            Db::startTrans();
            $admin = Admin::modifyById($post['id'],$post);
            $access = AuthGroupAccess::modifyById($post['id'],$post['group_id']);
            if ($admin && ($access || $access == 0)){
                Db::commit();
                return toJson("编辑成功",200);
            }
            Db::rollback();
            return toJson("编辑失败");
        }else{
            $id = input("get.id");
            $user = Admin::getUserByID($id);
            $group = AuthGroup::getAllGroup(true);
            return view('modify',compact('group','user','id'));
        }
    }

    /**
     * 创建新的用户
     * @return \think\response\View|void
     */
    public function created(){
        if (request()->isAjax()){
            $post = input("post.");
            Db::startTrans();
            $user = Admin::created($post);
            $access = AuthGroupAccess::created($user->id,$post['group_id']);
            if ($access && $user){
                Db::commit();
                return toJson("创建成功",200);
            }
            Db::rollback();
            return toJson("创建失败");
        }else{
            $group = AuthGroup::getAllGroup(true);
            return view('created',compact('group'));
        }
    }

    /**
     * 单个删除或批量删除
     * @throws \Exception
     */
    public static function deleted(){
        $ids = input("post.ids");
        if (!$ids){
            return toJson("参数错误");
        }
        $ids = explode(",",$ids);//拆分数组
        $ids = array_filter($ids);//过滤空数组
        $result = Admin::deleted($ids);
        if ($result){
            return toJson("删除成功",200);
        }
        return toJson("删除失败");
    }

    /**
     * 用户登录
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(){
        if (request()->isAjax()){
            $post = input("post.");
            if(!captcha_check($post['captcha'])){
                return toJson("验证码错误");
            }
            $user = Admin::getUserByUserName($post['username']);
            if (!$user){
                return toJson("用户不存在");
            }
            if (think_decrypt($user['password']) !== $post['password']){
                return toJson("密码错误");
            }
            cache('user', json_encode($user), 604800000);
            return toJson("登录成功",200);
        }else{
            return view();
        }
    }

    /**
     * 退出登录
     */
    public function outLogin(){
        cache("user",null);
        return $this->success("退出成功");
    }
}