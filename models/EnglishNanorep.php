<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "english_nanorep".
 *
 * @property int $id
 * @property int $internalId
 * @property string $question
 * @property string $plain_text_answer
 * @property string $html_answer
 * @property string $labels
 * @property string $phrasings
 * @property string $context
 * @property string $external_id
 */
class EnglishNanorep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'english_nanorep';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['internalId', 'question', 'external_id'], 'required'],

            [['phrasings','plain_text_answer', 'html_answer', 'plain_text_answer', 'html_answer', 'context', 'external_id', 'question', 'internalId' ], 'safe'],
//            [['plain_text_answer', 'html_answer', 'context', 'external_id', 'question', 'internalId'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'internalId' => Yii::t('app', 'internalId'),
            'question' => Yii::t('app', 'title'),
            'plain_text_answer' => Yii::t('app', 'Plain Text Answer'),
            'html_answer' => Yii::t('app', 'answer'),
            'labels' => Yii::t('app', 'label'),
            'phrasings' => Yii::t('app', 'phrasing'),
            'context' => Yii::t('app', 'context:prodId'),
            'external_id' => Yii::t('app', 'externalId'),
        ];
    }

}
