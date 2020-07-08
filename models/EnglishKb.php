<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "english_kb".
 *
 * @property int $id
 * @property string $article_id
 * @property string $title
 * @property string $answer
 * @property string $label
 * @property string $context
 * @property string $related_article
 * @property string $phrasings
 * @property string $notes
 */
class EnglishKb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'english_kb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id', 'title', 'answer', 'notes'], 'required'],
            [['answer', 'label', 'article_id', 'title', 'context', 'related_article', 'phrasings', 'notes'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'article_id' => Yii::t('app', 'externalId'),
            'title' => Yii::t('app', 'title'),
            'answer' => Yii::t('app', 'answer'),
            'label' => Yii::t('app', 'label'),
            'context' => Yii::t('app', 'context:prodId'),
            'phrasings' => Yii::t('app', 'phrasing'),
            'related_article' => Yii::t('app', 'Related_article'),
            'notes' => Yii::t('app', 'notes'),
        ];
    }
}
