<?php


namespace app\admin\model;


use think\Model;

class Admin extends Model
{
    public function access(){
        return $this->hasOne(AuthGroupAccess::class,"uid","id");
    }
    /**
     * 获取所有用户数据
     * @param bool $is_all
     * @param int $limit
     * @param int $page
     * @return array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAllAdmin($is_all = false,$limit=15,$page=1){
        if ($is_all){
            return self::select();
        }
        return self::paginate([
            'list_rows'=> $limit,
            'page'=>$page
        ])->toArray();
    }

    /**单个删除或批量删除
     * @param $ids
     * @return bool
     * @throws \Exception
     */
    public static function deleted($ids){
        if (!is_array($ids)){
            return false;//如果传递的非数组
        }
        $res = self::where([
            ['id','in',$ids]
        ])->delete();
        return $res;
    }
    /**
     * 根据用户名获取数据
     * @param $username
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getUserByUserName($username){
        if (!$username){
            return false;
        }
        $res = self::with([
            'access'=>['groups']
        ])->where('username',$username)->find();
        return $res;
    }

    /**
     * 根据ID获取数据
     * @param $id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getUserByID($id){
        if (!$id){
            return false;
        }
        $res = self::where('id',$id)->find();
        return $res;
    }
    public static function modifyById($id,$data){
        $user = self::where('id',$id)->find();
        if ($data['password'] !== $user['password']){
            $data['password'] = think_encrypt($data['password']);//如果密码不相等则说明是新密码
        }
        $res = $user->save([
            'username'=>$data['username'],
            'fullname'=>$data['fullname'],
            'headimg'=>$data['headimg'],
            'email'=>$data['email'],
            'password'=>$data['password'],
            'login_number'=>1
        ]);
        return $res;
    }
    public static function created($data){
        $data['password'] = think_encrypt($data['password']);//密码加密
        $res = self::create([
            'username'=>$data['username'],
            'fullname'=>$data['fullname'],
            'headimg'=>$data['headimg'],
            'email'=>$data['email'],
            'password'=>$data['password'],
            'login_number'=>1
        ]);
        return $res;
    }
}