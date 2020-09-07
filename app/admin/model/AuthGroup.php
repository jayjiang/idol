<?php


namespace app\admin\model;


use think\Model;

class AuthGroup extends Model
{
    public static function created($data)
    {
        $result = self::create([
            'title' => $data['title'],
            'status' => $data['status']?$data['status']:1,
            'rules' => isset($data['rules'])?$data['rules']:''
        ]);
        return $result;
    }
    public static function getAllGroup($is_all = false,$limit=15,$page=1){
        if ($is_all){
            return self::select();
        }
        return self::paginate([
            'list_rows'=> $limit,
            'page'=>$page
        ])->toArray();
    }
    public static function getGroupById($id){
        $res = self::where('id',$id)->find();
        return $res;
    }
    public static function modify($data){
        $map['title'] = $data['title'];
        $map['status'] = $data['status']?$data['status']:1;
        if (isset($data['rules']) && $data['rules']){
            $map['rules'] = $data['rules'];
        }
        $res = self::where('id',$data['id'])->save($map);
        return $res;
    }
    public static function deleted($ids){
        if (!is_array($ids)){
            return false;//如果传递的非数组
        }
        $res = self::where([
            ['id','in',$ids]
        ])->delete();
        return $res;
    }
    public static function modifyRules($uid,$rules){
        if (!is_array($rules)){
            return false;
        }
        $rules = implode($rules,",");
        $res = self::where('id',$uid)->save(['rules'=>$rules]);
        return $res;
    }
}