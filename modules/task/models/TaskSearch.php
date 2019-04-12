<?php

namespace app\modules\task\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\task\models\Task;

/**
 * TaskSearch represents the model behind the search form of `app\modules\task\models\Task`.
 */
class TaskSearch extends Task
{
    public $id;
    public $status;
    public $date_from;
    public $date_to;
    public $date_from1;
    public $date_to1;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'project_id', 'context_id', 'user_id', 'status'], 'integer'],
            [['title', 'description'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
            [['date_from1', 'date_to1'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['>=', 'updated_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'updated_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'created_at', $this->date_from1 ? strtotime($this->date_from1 . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to1 ? strtotime($this->date_to1 . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
