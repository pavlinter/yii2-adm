<?php

namespace pavlinter\adm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthRuleSearch represents the model behind the search form about `frontend\models\AuthRule`.
 */
class AuthRuleSearch extends AuthRule
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'data'], 'safe'],
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
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
