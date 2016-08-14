<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\HistoryTabel;

/**
 * HistoryTabelSearch represents the model behind the search form about `frontend\models\HistoryTabel`.
 */
class HistoryTabelSearch extends HistoryTabel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtabel', 'jumlah_hits', 'flag'], 'integer'],
            [['jenis'], 'safe'],
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
        $query = HistoryTabel::find();

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
            'idtabel' => $this->idtabel,
            'jumlah_hits' => $this->jumlah_hits,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'jenis', $this->jenis]);

        return $dataProvider;
    }
}
