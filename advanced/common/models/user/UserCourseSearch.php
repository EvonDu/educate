<?php

namespace common\models\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\user\UserCourse;

/**
 * UserCourseSearch represents the model behind the search form of `common\models\user\UserCourse`.
 */
class UserCourseSearch extends UserCourse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'course_id', 'tryed_at', 'created_at'], 'integer'],
            [['try'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserCourse::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'try' => $this->try,
            'tryed_at' => $this->tryed_at,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search_api($params)
    {
        $query = UserCourse::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params,"");

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'try' => $this->try,
            'tryed_at' => $this->tryed_at,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
