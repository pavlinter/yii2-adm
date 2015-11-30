<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.9
 */

namespace pavlinter\adm\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthAssignmentSearch represents the model behind the search form about `pavlinter\adm\models\AuthAssignment`.
 */
class AuthAssignmentSearch extends AuthAssignment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'safe'],
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

        $query = static::find()->from(['a' => '{{%auth_assignment}}'])
            ->select('*')
            ->innerJoin(['u'=>'{{%user}}'],'u.id=a.user_id')
            ->with(['user',]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user_id']['asc'] = ['u.username' => SORT_ASC];
        $dataProvider->sort->attributes['user_id']['desc'] = ['u.username' => SORT_DESC];


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'a.item_name', $this->item_name])
            ->andFilterWhere(['like', 'u.username', $this->user_id]);

        return $dataProvider;
    }
}
