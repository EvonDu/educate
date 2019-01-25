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
            [['id', 'price', 'price_dollar', 'instructor_id', 'type_id', 'level', 'period', 'next_term_at', 'try_day', 'buy_day', 'created_at', 'updated_at'], 'integer'],
            [['num', 'name', 'name_en', 'image', 'synopsis', 'synopsis_en', 'abstract', 'abstract_en'], 'safe'],
            [['requirements_prerequisites', 'requirements_textbooks', 'requirements_software', 'requirements_hardware'], 'safe'],
            [['requirements_prerequisites_en', 'requirements_textbooks_en', 'requirements_software_en', 'requirements_hardware_en'], 'safe'],
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
            'price_dollar' => $this->price_dollar,
            'instructor_id' => $this->instructor_id,
            'type_id' => $this->type_id,
            'level' => $this->level,
            'next_term_at' => $this->next_term_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'num', $this->num])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis])
            ->andFilterWhere(['like', 'synopsis_en', $this->synopsis_en])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'abstract_en', $this->abstract_en])
            ->andFilterWhere(['like', 'requirements_prerequisites', $this->requirements_prerequisites])
            ->andFilterWhere(['like', 'requirements_textbooks', $this->requirements_textbooks])
            ->andFilterWhere(['like', 'requirements_software', $this->requirements_software])
            ->andFilterWhere(['like', 'requirements_hardware', $this->requirements_hardware])
            ->andFilterWhere(['like', 'requirements_prerequisites_en', $this->requirements_prerequisites_en])
            ->andFilterWhere(['like', 'requirements_textbooks_en', $this->requirements_textbooks_en])
            ->andFilterWhere(['like', 'requirements_software_en', $this->requirements_software_en])
            ->andFilterWhere(['like', 'requirements_hardware_en', $this->requirements_hardware_en]);

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
            'price_dollar' => $this->price_dollar,
            'instructor_id' => $this->instructor_id,
            'type_id' => $this->type_id,
            'level' => $this->level,
            'next_term_at' => $this->next_term_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'num', $this->num])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'synopsis', $this->synopsis])
            ->andFilterWhere(['like', 'synopsis_en', $this->synopsis_en])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'abstract_en', $this->abstract_en])
            ->andFilterWhere(['like', 'requirements_prerequisites', $this->requirements_prerequisites])
            ->andFilterWhere(['like', 'requirements_textbooks', $this->requirements_textbooks])
            ->andFilterWhere(['like', 'requirements_software', $this->requirements_software])
            ->andFilterWhere(['like', 'requirements_hardware', $this->requirements_hardware])
            ->andFilterWhere(['like', 'requirements_prerequisites_en', $this->requirements_prerequisites_en])
            ->andFilterWhere(['like', 'requirements_textbooks_en', $this->requirements_textbooks_en])
            ->andFilterWhere(['like', 'requirements_software_en', $this->requirements_software_en])
            ->andFilterWhere(['like', 'requirements_hardware_en', $this->requirements_hardware_en]);

        return $dataProvider;
    }
}
