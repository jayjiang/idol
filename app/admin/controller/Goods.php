<?php


namespace app\admin\controller;


use app\admin\model\Spec as SpecModel;
use app\admin\model\SpecValue as SpecValueModel;
use think\App;
use app\admin\model\Goods as GoodsModel;

class Goods extends Base
{
    /* @var SpecModel $SpecModel */
    private $SpecModel;

    /* @var SpecValueModel $SpecModel */
    private $SpecValueModel;
    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->SpecModel = new SpecModel;
        $this->SpecValueModel = new SpecValueModel;
    }

    public function lists(){
        return view();
    }
    public function created(){
        if (request()->isPost()){
            $model = new GoodsModel();
            if ($model->add(input("goods"))) {
                return toJson("添加成功",200);
            }
            return toJson('添加失败');
        }else{
            return view();
        }
    }


    /**
     * 添加规则组
     * @param $spec_name
     * @param $spec_value
     * @return array
     */
    public function addSpec($spec_name, $spec_value)
    {
        // 判断规格组是否存在
        if (!$specId = $this->SpecModel->getSpecIdByName($spec_name)) {
            // 新增规格组and规则值
            if ($this->SpecModel->add($spec_name)
                && $this->SpecValueModel->add($this->SpecModel->id, $spec_value))
                return toJson('添加成功',200,[
                    'spec_id' => (int)$this->SpecModel->id,
                    'spec_value_id' => (int)$this->SpecValueModel->id,
                ]);
            return toJson("添加失败");
        }
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($specId, $spec_value)) {
            return toJson('添加成功',200,[
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($this->SpecValueModel->add($specId, $spec_value))
            return toJson("添加成功",200,[
                'spec_id' => (int)$specId,
                'spec_value_id' => (int)$this->SpecValueModel->id,
            ]);
        return toJson("添加失败");
    }
    /**
     * 添加规格值
     * @param $spec_id
     * @param $spec_value
     * @return array
     */
    public function addSpecValue($spec_id, $spec_value)
    {
        // 判断规格值是否存在
        if ($specValueId = $this->SpecValueModel->getSpecValueIdByName($spec_id, $spec_value)) {
            return toJson('添加成功', 200, [
                'spec_value_id' => (int)$specValueId,
            ]);
        }
        // 添加规则值
        if ($this->SpecValueModel->add($spec_id, $spec_value))
            return toJson('添加成功', 200, [
                'spec_value_id' => (int)$this->SpecValueModel->id,
            ]);
        return toJson("添加失败");
    }
}