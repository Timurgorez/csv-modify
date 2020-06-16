<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FileUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $exFile;
    public $spliter;
    public $column;

    public function rules()
    {
        return [
            [['exFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv, xlsx, xls'],
            [['spliter', 'column'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'spliter' => Yii::t('app', 'Show only structure'),
            'column' => Yii::t('app', 'In which table do you want to upload your data'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->exFile->saveAs('uploads/' . $this->exFile->baseName . '.' . $this->exFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
