<?php

/**
 * @package yii2-adm
 * @author Pavels Radajevs <pavlinter@gmail.com>
 * @copyright Copyright &copy; Pavels Radajevs <pavlinter@gmail.com>, 2015
 * @version 1.0.10
 */

namespace pavlinter\adm\models;

use pavlinter\adm\Adm;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SourceMessageSearch represents the model behind the search form about `app\models\SourceMessage`.
 */
class SourceMessageSearch extends SourceMessage
{
    public $translation;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['category', 'message', 'translation'], 'safe'],
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
        $sourceMessageTable = static::tableName();
        $query = static::find()->from(['s' => $sourceMessageTable]);

        $sort = isset($params['sort']) ? $params['sort'] : null;
        $isTranslationSearch = isset($params['SourceMessageSearch']['translation']) && $params['SourceMessageSearch']['translation'];
        $isTranslationSort   = in_array($sort, ['-translation', 'translation']) ? $sort : null;

        if ($isTranslationSearch || $isTranslationSort) {
            $messageTable = Adm::getInstance()->manager->createMessageQuery('tableName');
            $query->innerJoin(['m'=> $messageTable],'m.id=s.id')->with(['messages']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id'=> SORT_DESC ]
            ]
        ]);

        $dataProvider->sort->attributes['translation']['asc'] = ['m.translation' => SORT_ASC];
        $dataProvider->sort->attributes['translation']['desc'] = ['m.translation' => SORT_DESC];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($isTranslationSearch) {
            $query->andFilterWhere(['like', 'm.translation', $this->translation]);
        }

        $query->andFilterWhere(['like', 's.category', $this->category])
            ->andFilterWhere(['like', 's.message', $this->message]);

        return $dataProvider;
    }
}
