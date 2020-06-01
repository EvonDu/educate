<?php
namespace common\models\auth;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Auth assign form
 */
class RoleAssignForm extends Model
{
    public $user_id;
    public $roles;
    private $list;

    /**
     * RoleAssignForm constructor.
     * @param array $id
     * @param array $config
     */
    public function __construct($id, array $config = [])
    {
        //获取用户
        $this->user_id = $id;
        //获取拥有权限
        $search = AuthAssignment::findAll(['user_id'=>$id]);
        $this->roles = ArrayHelper::getColumn($search, 'item_name');

        parent::__construct($config);
    }

    /**
     * @param array $data
     * @param null $formName
     * @return bool
     */
    public function load($data, $formName = null)
    {
        //处roles，防止清空分配的发生load返回false情况
        $scope = $formName === null ? $this->formName() : $formName;
        if($data && !isset($data[$scope]["roles"])){
            $data[$scope]["roles"] = [];
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
            [['roles'], 'safe'],
        ];
    }

    /**
     * @return bool
     */
    public function save(){
        if($this->user_id){
            AuthAssignment::deleteAll(["user_id"=>$this->user_id]);
            if(is_array($this->roles)){
                foreach ($this->roles as $role){
                    $item = new AuthAssignment();
                    $item->user_id = $this->user_id;
                    $item->item_name = $role;
                    $item->created_at = time();
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
            'user_id' => '用户ID',
            'roles' => '用户角色',
        ];
    }

    /**
     * @return array
     */
    public function getList(){
        if(empty($this->list)){
            $search = AuthItem::findAll(['type'=>"1"]);
            $this->list = ArrayHelper::map($search, 'name', 'description');
        }

        return $this->list;
    }
}