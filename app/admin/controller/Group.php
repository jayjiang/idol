<?php


namespace app\admin\controller;


use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use libs\toTree;

class Group extends Base
{
    /**
     * 权限组列表
     * @return \think\response\View|void
     */
    public function lists(){
        if (request()->isAjax()){
            $rule = AuthGroup::getAllGroup(false,input("limit"),input("page"));
            return toJson("数据获取成功",200,$rule);
        }else{
            return view();
        }
    }

    /**
     * 创建权限组
     * @return \think\response\View|void
     */
    public function created(){
        if (request()->isAjax()){
            $post = input("post.");
            $result = AuthGroup::created($post);
            if ($result){
                return toJson("创建成功",200);
            }
            return toJson("创建失败");
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
            $result = AuthGroup::modify($post);
            if ($result){
                return toJson("编辑成功",200);
            }
            return toJson("编辑失败");
        }else{
            $id = input("get.id");
            $group = AuthGroup::getGroupById($id);
            return view('modify',compact('group','id'));
        }
    }
    /**
     * 删除
     * @throws \Exception
     */
    public function deleted(){
        $ids = input("post.ids");
        if (!$ids){
            return toJson("参数错误");
        }
        $ids = explode(",",$ids);//拆分数组
        $ids = array_filter($ids);//过滤空数组
        $result = AuthGroup::deleted($ids);
        if ($result){
            return toJson("删除成功",200);
        }
        return toJson("删除失败");
    }

    /**
     * 权限规则
     * @return \think\response\View|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function rules(){
        if (request()->isAjax()){
            $id = input("id");
            $group = AuthRule::getAllRule(true);
            $user = AuthGroupAccess::getUidByGroupId($id);
            $rules = AuthGroupAccess::getRuleByUid($user['uid']);
            return toJson("数据获取成功",200,['list'=>$group,'checkedId'=>array_values($rules)]);
        }else{
            $id = input("id");
            return view("rules",compact('id'));
        }
    }

    /**
     * 更新权限组规则
     */
    public function modifyRules(){
        $ids = input("post.ids");
        $res = AuthGroup::modifyRules(input("post.id"),$ids);
        if ($res){
            return toJson("更新成功",200);
        }else{
            return toJson("更新失败");
        }
    }
}