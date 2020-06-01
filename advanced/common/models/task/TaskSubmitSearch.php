<?php

namespace common\models\task;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\task\TaskSubmit;

/**
 * TaskSubmitSearch represents the model behind the search form of `common\models\task\TaskSubmit`.
 */
class TaskSubmitSearch extends TaskSubmit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'task_id', 'user_id', 'course_id', 'status', 'submit_at', 'reply_at'], 'integer'],
            [['submit_content', 'submit_file', 'submit_audio', 'reply_content', 'reply_file', 'reply_audio'], 'safe'],
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
        $query = TaskSubmit::find();

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
            'task_id' => $this->task_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'submit_at' => $this->submit_at,
            'reply_at' => $this->reply_at,
        ]);

        $query->andFilterWhere(['like', 'submit_content', $this->submit_content])
            ->andFilterWhere(['like', 'submit_file', $this->submit_file])
            ->andFilterWhere(['like', 'submit_audio', $this->submit_audio])
            ->andFilterWhere(['like', 'reply_content', $this->reply_content])
            ->andFilterWhere(['like', 'reply_file', $this->reply_file])
            ->andFilterWhere(['like', 'reply_audio', $this->reply_audio]);

        return $dataProvider;
    }
}
