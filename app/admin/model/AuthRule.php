<?php


namespace app\admin\model;


use think\Model;

class AuthRule extends Model
{
    public static function created($data)
    {
        $result = self::create([
            'icon' => $data['icon'],
            'is_verify' => $data['is_verify']==0?$data['is_verify']:1,
            'params' => $data['params'],
            'name' => $data['name'],
            'title' => $data['title'],
            'status' => $data['status']==0?$data['status']:1,
            'is_menu' => $data['is_menu']==0?$data['is_menu']:1,
            'pid' => $data['pid']?$data['pid']:0,
        ]);
        return $result;
    }

    /**
     * 获取所有菜单规则数据
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAllRule($is_all=false,$limit=15,$page=1){
        if ($is_all){
            return self::select();
        }
        return self::paginate([
            'list_rows'=> $limit,
            'page'=>$page
        ])->toArray();
    }
    public static function getRulefield($is_all=false,$limit=15,$page=1){
        if ($is_all){
            return self::field(['title','pid',''])->select();
        }
        return self::field(['title','pid',''])->paginate([
            'list_rows'=> $limit,
            'page'=>$page
        ])->toArray();
    }

    /**
     * 根据菜单规则Id获取指定数据
     * @param $id
     * @return array|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getRuleById($id){
        if (is_array($id)){
            $res = self::where([
                ['id','in',$id]
            ])->select();
        }else{
            $res = self::where('id',$id)->find();
        }
        return $res;
    }

    /**
     * 更新菜单规则
     * @param $data
     * @return bool
     */
    public static function modify($data){
        $res = self::where('id',$data['id'])->save([
            'icon' => $data['icon'],
            'is_verify' => $data['is_verify']==0?$data['is_verify']:1,
            'params' => $data['params'],
            'name' => $data['name'],
            'title' => $data['title'],
            'status' => $data['status']==0?$data['status']:1,
            'is_menu' => $data['is_menu']==0?$data['is_menu']:1,
            'pid' => $data['pid']?$data['pid']:0,
        ]);
        return $res;
    }

    /**
     * 单个或者批量删除数据
     * @param $ids
     * @return bool
     * @throws \Exception
     */
    public static function deleted($ids){
        if (!is_array($ids)){
            return false;//如果传递的非数组
        }
        foreach ($ids as $key=>$val){
            $rule = self::where([
                ['pid','=',$val]
            ])->find();
            if ($rule){
                return  false;
            }
            self::where([
                ['id','=',$val]
            ])->delete();
        }
        return true;
    }
}