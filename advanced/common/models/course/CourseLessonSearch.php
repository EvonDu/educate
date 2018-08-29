<?php

namespace common\models\course;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\course\CourseLesson;

/**
 * CourseLessonSearch represents the model behind the search form of `common\models\course\CourseLesson`.
 */
class CourseLessonSearch extends CourseLesson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'lesson'], 'integer'],
            [['title', 'abstract', 'video', 'doc'], 'safe'],
            [['is_public', 'is_homework'], 'boolean'],
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
        $query = CourseLesson::find();

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
            'course_id' => $this->course_id,
            'lesson' => $this->lesson,
            'is_public' => $this->is_public,
            'is_homework' => $this->is_homework,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'video', $this->video])
            ->andFilterWhere(['like', 'doc', $this->doc]);

        return $dataProvider;
    }
}
