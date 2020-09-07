<?php


namespace app\admin\model;


use think\Model;

class AuthGroupAccess extends Model
{
    public function groups(){
        return $this->hasOne(AuthGroup::class,"id","group_id");
    }
    public static function getUidByGroupId($id){
        return self::where('group_id',$id)->field("uid")->find();
    }
    /**
     * 获取当前用户的权限
     * @param $uid 用户ID
     * @param bool $is_menu  是否查询其他字段用于菜单显示
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getRuleByUid($uid,$is_menu=false){
        $access = self::where('uid',$uid)->find();
        if (!$access){
            return false;
        }
        $group_id = $access['group_id'];
        $group = AuthGroup::getGroupById($group_id);
        $rules = array_map('intval', explode(',', $group['rules']));
        if ($is_menu){
            $rules = AuthRule::getRuleById($rules);
            foreach ($rules as $key=>$val){
                if ($val['status'] == 1 && $val['is_menu'] == 1){
                    $val['name'] = url($val['name']);
                    $menu[] = $val;
                }
            }
            $rules = $menu;
        }
        return $rules;
    }

    public static function created($uid,$group_id){
        return self::create([
            'group_id'=>$group_id,
            'uid'=>$uid,
        ]);
    }
    public static function modifyById($uid,$group_id){
        return self::where('uid',$uid)->save([
            'group_id'=>$group_id
        ]);
    }
}