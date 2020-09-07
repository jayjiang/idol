<?php


namespace app\admin\controller;


use app\admin\model\AuthRule;

class Rule extends Base
{
    /**
     * 列表
     * @return \think\response\View
     */
    public function lists(){
        if (request()->isAjax()){
            $rule = AuthRule::getAllRule(true);
            return toJson("数据获取成功",200,$rule,true);
        }else{
            return view();
        }
    }

    /**
     * 创建
     * @return \think\response\View|void
     */
    public function created(){
        if (request()->isAjax()){
            $post = input("post.");
            $result = AuthRule::created($post);
            if ($result){
                return toJson("创建成功",200);
            }
            return toJson("创建失败");
        }else{
            $pid = input("get.pid");
            $rule = AuthRule::getAllRule(true);
            $rule = sort_tree($rule->toArray());
            return view('created',compact('rule','pid'));
        }
    }

    /**
     * 编辑
     * @return \think\response\View|void
     */
    public function modify(){
        if (request()->isAjax()){
            $post = input("post.");
            $result = AuthRule::modify($post);
            if ($result){
                return toJson("编辑成功",200);
            }
            return toJson("编辑失败");
        }else{
            $id = input("get.id");
            $rule = AuthRule::getRuleById($id);
            $allRule = AuthRule::getAllRule(true);
            $allRule = sort_tree($allRule->toArray());
            return view('modify',compact('allRule','rule','id'));
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
        $result = AuthRule::deleted($ids);
        if ($result){
            return toJson("删除成功",200);
        }
        return toJson("删除失败");
    }
}