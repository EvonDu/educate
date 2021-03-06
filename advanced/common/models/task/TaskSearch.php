<?php

namespace common\models\task;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\task\Task;

/**
 * TaskSearch represents the model behind the search form of `common\models\task\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'course_id', 'lesson_id', 'created_at', 'finish_at'], 'integer'],
            [['title', 'content', 'file', 'audio'], 'safe'],
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
        $query = Task::find();

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
            'type' => $this->type,
            'course_id' => $this->course_id,
            'lesson_id' => $this->lesson_id,
            'create_at' => $this->created_at,
            'finish_at' => $this->finish_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'audio', $this->audio]);

        return $dataProvider;
    }
}
