<?php


namespace app\admin\controller;


use app\admin\model\Picture as model;

class Uploads extends Base
{
    /**
     * 开始上传文件
     */
    public function start(){
        $params = input();
        $files = request()->file();
        $dir = DS.'storage';//准备磁盘
        try {
            validate(['image' => 'fileSize:10240|fileExt:jpg,png,jpeg'])
                ->check($files);
            $savename = [];
            foreach ($files as $file) {
                $fileName = \think\facade\Filesystem::disk($this->getDisks())->putFile('picture', $file);
                $path = $this->getFilePath($dir,$fileName);
                model::create(['path' => $path, 'action' => 'public', 'orig_path' => $path, 'user_id' => request()->user['id']]);
                $savename[] = $path;
            }
            if ($savename) {
                if (isset($params['type']) && $params['type'] == 'layedit'){
                    return toJson("文件上传成功", 0, ['src'=>$path]);
                }
                return toJson("文件上传成功", 200, $savename);
            } else {
                return toJson("文件上传失败");
            }
        } catch (think\exception\ValidateException $e) {
            return toJson($e->getMessage());
        }
    }

    /**
     * 获取可访问的文件路径
     * @param $dir
     * @param $fileName
     * @return string
     */
    public function getFilePath($dir,$fileName){
        if ($this->dev['upload_type'] != 0){
            $fileName = rtrim($this->dev['upload_domain'],"/").DS . $fileName;
        }else{
            $fileName = $dir.DS.$fileName;
        }
        return $fileName;
    }

    /**
     * 获取上传磁盘
     * @return mixed
     */
    public function getDisks(){
        $data[0] = 'public';
        $data[1] = 'qiniu';
        $data[2] = 'aliyun';
        $data[3] = 'qcloud';
        return $data[$this->dev['upload_type']?$this->dev['upload_type']:0];
    }
}