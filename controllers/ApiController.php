<?php

namespace app\controllers;

use app\models\English;
use app\models\EnglishKb;
use app\models\EnglishNanorep;
use function Matrix\trace;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\FileUpload;
use yii\web\UploadedFile;
use moonland\phpexcel\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



class ApiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {



        $arrData = [];
        $arrDataId = [];

        $homepage = file_get_contents('https://fujixerox.nanorep.co/api/kb/labels/v1/getUserLabels?kb=2142016383&apiKey=91f7850d-3ac9-4b64-9b2d-42c33c17eb7a');


        foreach (json_decode ($homepage) as $elem){
            if( preg_match( '/O[1-9]/', $elem->name)){
//                var_dump($elem->id);
                $arrData[] = $elem;
                $arrDataId[] = $elem->id;
            };
        }
//        var_dump($arrDataId);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fujixerox.nanorep.co/api/kb/labels/v1/saveUserLabels?kb=2142016383&apiKey=91f7850d-3ac9-4b64-9b2d-42c33c17eb7a&sid=4130370340053538485');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"delete":'.$arrDataId.'}');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $out = curl_exec($ch);
        curl_close($ch);

        echo $out;

        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrData,
            'pagination' => [
                'pageSize' => 10000,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'arrData' => $arrData,
        ]);
    }




}
