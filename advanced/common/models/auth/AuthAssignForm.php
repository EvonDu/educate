<?php
namespace common\models\auth;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Auth assign form
 */
class AuthAssignForm extends Model
{
    public $role_id;    //这个role_id，其实为AuthItem的name属性
    public $auths;
    private $list;

    /**
     * AuthAssignForm constructor.
     * @param array $role_id
     * @param array $config
     */
    public function __construct($role_id, array $config = [])
    {
        //获取角色
        $this->role_id = $role_id;
        //获取拥有权限
        $search = AuthItemChild::findAll(["parent"=>$role_id]);
        $this->auths = ArrayHelper::getColumn($search, 'child');

        parent::__construct($config);
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        //处理auths，防止清空分配的发生load返回false情况
        $scope = $formName === null ? $this->formName() : $formName;
        if($data && !isset($data[$scope]["auths"])){
            $data[$scope]["auths"] = [];
        }
        //调用父函数
        return parent::load($data, $formName);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auths'], 'safe'],
        ];
    }

    /**
     * @return bool
     */
    public function save(){
        if($this->role_id){
            AuthItemChild::deleteAll(["parent"=>$this->role_id]);
            if(is_array($this->auths)){
                foreach ($this->auths as $auth){
                    $item = new AuthItemChild();
                    $item->parent = $this->role_id;
                    $item->child = $auth;
                    $item->save();
                }
            }
        }
        return true;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色ID',
            'auths' => '权限列表',
        ];
    }

    /**
     * @return array
     */
    public function getList(){
        if(empty($this->list)){
            $search = AuthItem::findAll(['type'=>"2"]);
            $this->list = ArrayHelper::map($search, 'name', 'description');
        }

        return $this->list;
    }
}