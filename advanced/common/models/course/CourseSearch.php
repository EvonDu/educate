<?php

namespace common\models\course;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\course\Course;

/**
 * CourseSearch represents the model behind the search form of `common\models\course\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price', 'instructor_id', 'type_id', 'level', 'next_term_at', 'created_at', 'updated_at'], 'integer'],
            [['num', 'name', 'image', 'abstract', 'content', 'requirements_prerequisites', 'requirements_textbooks', 'requirements_software', 'requirements_hardware'], 'safe'],
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
        $query = Course::find();

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
            'id' => $this->id,
            'price' => $this->price,
            'instructor_id' => $this->instructor_id,
            'type_id' => $this->type_id,
            'level' => $this->level,
            'next_term_at' => $this->next_term_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'num', $this->num])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'requirements_prerequisites', $this->requirements_prerequisites])
            ->andFilterWhere(['like', 'requirements_textbooks', $this->requirements_textbooks])
            ->andFilterWhere(['like', 'requirements_software', $this->requirements_software])
            ->andFilterWhere(['like', 'requirements_hardware', $this->requirements_hardware]);

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
        $query = Course::find();

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
            'id' => $this->id,
            'price' => $this->price,
            'instructor_id' => $this->instructor_id,
            'type_id' => $this->type_id,
            'level' => $this->level,
            'next_term_at' => $this->next_term_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'num', $this->num])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'requirements_prerequisites', $this->requirements_prerequisites])
            ->andFilterWhere(['like', 'requirements_textbooks', $this->requirements_textbooks])
            ->andFilterWhere(['like', 'requirements_software', $this->requirements_software])
            ->andFilterWhere(['like', 'requirements_hardware', $this->requirements_hardware]);

        return $dataProvider;
    }
}
