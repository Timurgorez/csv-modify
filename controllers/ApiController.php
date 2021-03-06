<?php

namespace app\controllers;

use app\models\ApiModel;
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
        $model = new ApiModel();

        $allData = null;

        $arrDataUpdate = [];
        $arrDataId = [];

        if(Yii::$app->request->isPost) {

            $url = Yii::$app->request->post('ApiModel')['url'];
            $type_request = Yii::$app->request->post('ApiModel')['type_request'];
            $json_data = Yii::$app->request->post('ApiModel')['json_data'];
//            $kb_name = Yii::$app->request->post('ApiModel')['kb_name'];


            if($type_request == "GET"){
                $allData = [];
                $homepage = file_get_contents($url);

                foreach (json_decode ($homepage) as $key => $elem){
                    if( preg_match( '/O[1-9]/', $elem->name)){
    //                var_dump( json_encode( $elem) );
                        $arrDataId[] = json_encode( $elem->id );
                    }else{
                        $arrDataUpdate[] = json_encode( $elem);
                    };
                    $allData[] = $elem;
                }
                $data = '{"update":['.implode(',', $arrDataUpdate).'],"delete":['.implode(',', $arrDataId).']}';

//              print_r($data);
            }else{
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_POST, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                $out = curl_exec($ch);
                curl_close($ch);
//                var_dump( json_decode($out) );
                $allData = json_decode($out);
            }




            if(!is_array($allData) && empty($allData)){
                var_dump($allData);
            }



            $dataProvider = new ArrayDataProvider([
                'allModels' => $allData,
                'pagination' => [
                    'pageSize' => 10000,
                ],
                'sort' => [
                    'attributes' => ['id', 'name'],
                ],
            ]);

            return $this->render('index', [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]);

        }

        return $this->render('index', [
            'model' => $model,
        ]);

    }


    public function actionFilterJson()
    {
        $model = new ApiModel(['scenario' => ApiModel::SCENARIO_FILTER]);

        $allData = null;

        $arrDataUpdate = [];
        $arrDataId = [];

        if(Yii::$app->request->isPost) {

            $json = Yii::$app->request->post('ApiModel')['json_data'];


            $allData = [];


            foreach (json_decode ($json) as $key => $elem){
                if( preg_match( '/O[1-9]/', $elem->name)){
                    //                var_dump( json_encode( $elem) );
                    $arrDataId[] = $elem->id;
                }else{
                    if($elem->id == '2142250273') continue;
                    $name = str_replace('"', "'", $elem->name );
                    $json_str = json_encode($elem);
                    $posStart = strripos($json_str, '"name":"') + 8;
                    $posEnd = strripos($json_str, '","id"');
                    $nameRemove = substr($json_str, $posStart, $posEnd - $posStart);
                    $new_json_str = str_replace($nameRemove, $name, $json_str );
                    $arrDataUpdate[] = $new_json_str;
//                    var_dump($name);
                };
                $allData[] = $elem;
            }
            $data = '{"update":['.implode(',', $arrDataUpdate).'],"delete":['.implode(',', $arrDataId).']}';

//            phpinfo();
            echo '<pre>';
          var_dump($data);
            echo '</pre>';





//            if(!is_array($allData) && empty($allData)){
//                var_dump($allData);
//            }

            return $this->render('filter', [
                'model' => $model,
            ]);

        }

        return $this->render('filter', [
            'model' => $model,
        ]);

    }


    public function actionMiddlewareDyson($country, $serialNumberPrefix)
    {
//        var_dump($country);
//        var_dump($serialNumberPrefix);
//        $url = "https://www.dyson.co.jp/serialprefixlookupapi/serialprefixlookup/internal?country=" .
//            strtoupper($country) .
//            "&serialNumberPrefix=" . $serialNumberPrefix;

        $url = "https://api.dyson.com/apiman-gateway/dyson/machines/1.0/de/serialprefix/mt6?baseSiteId";
        $data = file_get_contents($url);
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        $data = curl_exec($ch);
//        curl_close($ch);
        var_dump($data);
    }



}
