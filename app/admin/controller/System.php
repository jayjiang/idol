<?php


namespace app\admin\controller;


class System extends Base
{
    public function config(){
        if (request()->isPost()){
            $config = input();
            foreach ($this->dev as $key=>$val){
                foreach ($config as $k=>$v){
                    if ($k != $key){
                        $this->dev[$k] = $v;
                    }
                }
            }
            $res = setConfigFile($this->dev,DEV_PATH);// 把配置写入文件
            // 替换文件上传相关配置
            $this->setUploadFileConfig($config);
            if ($res){
                return toJson("保存成功",200);
            }else{
                return toJson("请稍候再试");
            }
        }else{
            return view();
        }
    }
    public function setUploadFileConfig($config){
        switch ($config['upload_type']){
            case 1:
                $data['qiniu'] = [
                    'accessKey'=>$config['upload_secretId'],
                    'secretKey'=>$config['upload_secretKey'],
                    'bucket'=>$config['upload_bucket'],
                    'url'=>$config['upload_domain']
                ];
                break;
            case 2:
                $data['aliyun'] = [
                    'accessId'=>$config['upload_secretId'],
                    'accessSecret'=>$config['upload_secretKey'],
                    'bucket'=>$config['upload_bucket'],
                    'url'=>$config['upload_domain']
                ];
                break;
            case 3:
                $data['qcloud'] = [
                    'secretId'=>$config['upload_secretId'],
                    'secretKey'=>$config['upload_secretKey'],
                    'bucket'=>$config['upload_bucket'],
                    'cdn'=>$config['upload_domain'],
                    'appId'=>$config['upload_appid']
                ];
                break;
            default:
                return false;
                break;
        }
        $filesystem = config("filesystem");
        foreach ($filesystem['disks'] as $key=>$val){
            foreach ($data as $k=>$v){
                if ($k == $key){
                    foreach ($val as $x=>$y){
                        $filesystem['disks'][$k][$x] = isset($data[$k][$x])?$data[$k][$x]:$y;
                    }
                }
            }
        }
        $res = setConfigFile($filesystem,ROOT_PATH.DS.'config'.DS.'filesystem.php');// 把配置写入文件
        return $res;
    }
}