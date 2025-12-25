<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class EditionSearch extends Edition
{
    public function rules()
    {
        return [
            [['id', 'epaper_id'], 'integer'],
            [['title', 'category', 'status', 'date'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Edition::find()->orderBy(['date' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // URL / form se values load
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Agar controller se epaper_id set kiya hai to yahan already aa jayega
        if (!empty($this->epaper_id)) {
            $query->andWhere(['epaper_id' => $this->epaper_id]);
        }

        // ID filter (normally blank rahega)
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        // Title LIKE search
        $query->andFilterWhere(['like', 'title', $this->title]);

        // Exact match filters
        $query->andFilterWhere(['category' => $this->category]);
        $query->andFilterWhere(['status'   => $this->status]);

        // Date exact (agar tum later date-range chaho to yahan change kar sakte ho)
        if (!empty($this->date)) {
            $query->andFilterWhere(['date' => $this->date]);
        }

        return $dataProvider;
    }
}

