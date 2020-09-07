<?php


namespace app\admin\controller;

use \app\admin\model\Picture as model;

class Picture extends Base
{

    public function lists()
    {
        if (request()->isAjax()) {
            $list = model::where('user_id',request()->user['id'])->order("pic_id","desc")->paginate([
                'page' => input("page",1),
                'list_rows' => 10
            ]);
            if ($list->isEmpty()) {
                return toJson("暂无更多数据");
            } else {
                return toJson("数据获取成功", 200, $list);
            }
        } else {
            return view();
        }
    }

    /**
     * 删除图片
     * @throws \Exception
     */
    public function deleted()
    {
        $res = model::where('pic_id',input("id"))->delete();
        if ($res){
            return toJson("删除成功",200);
        }else{
            return toJson("删除失败");
        }
    }
}