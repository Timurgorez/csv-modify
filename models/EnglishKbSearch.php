<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EnglishKb;

/**
 * EnglishKbSearch represents the model behind the search form of `app\models\EnglishKb`.
 */
class EnglishKbSearch extends EnglishKb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['article_id', 'title', 'answer', 'label', 'context', 'related_article'], 'safe'],
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
        $query = EnglishKb::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5000,
            ],
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
        ]);

        $query->andFilterWhere(['like', 'article_id', $this->article_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'related_article', $this->related_article]);

        return $dataProvider;
    }
}
