<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\HistoryofTable;

/**
 * HistoryofTableSearch represents the model behind the search form about `frontend\models\HistoryofTable`.
 */
class HistoryofTableSearch extends HistoryofTable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jumlah_hits', 'flag'], 'integer'],
            [['nama_tabel'], 'safe'],
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
        $query = HistoryofTable::find();

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
            'jumlah_hits' => $this->jumlah_hits,
            'flag' => $this->flag,
        ]);

        $query->andFilterWhere(['like', 'nama_tabel', $this->nama_tabel]);

        return $dataProvider;
    }
}
