<?php

namespace app\models;

use Yii;

/**
 *
 * @property string $url
 * @property string $type_request
 * @property string $json_data
 * @property string $kb_name
 */
class ApiModel extends \yii\db\ActiveRecord
{

    public $url;
    public $type_request;
    public $json_data;
    public $kb_name;

    const SCENARIO_FILTER = 'filter';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'english_kb';
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_FILTER] = ['json_data'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'type_request', 'json_data'], 'required'],
            [['url', 'type_request', 'json_data', 'kb_name'], 'string'],

            // username и password требуются в сценарии "login"
            [['json_data'], 'required', 'on' => self::SCENARIO_FILTER],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'url' => Yii::t('app', 'Url'),
            'type_request' => Yii::t('app', 'Type of request(GET or POST)'),
            'json_data' => Yii::t('app', 'Json data'),
            'kb_name' => Yii::t('app', 'kb_name'),
        ];
    }
}
