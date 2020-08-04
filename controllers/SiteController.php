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



class SiteController extends Controller
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
        $model = new FileUpload();
        $arrData = [];
        if(Yii::$app->request->isPost) {
            $fileName = $_FILES["FileUpload"]["tmp_name"]["exFile"];
            $model->load(Yii::$app->request->post());


            $excelReader = IOFactory::createReaderForFile($fileName);
            $excelObj = $excelReader->load($fileName);
            $worksheet = $excelObj->getSheet(0);
            $lastRow = $worksheet->getHighestRow();
            $lastCell = $worksheet->getHighestColumn();




            $arrLetter = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];


            $firstRow = 1;

            if(isset(Yii::$app->request->post('FileUpload')['spliter']) && Yii::$app->request->post('FileUpload')['spliter'] == '1'){
                $tableHTML = '<div class="table-responsive"><table class="table table-bordered table-hover table-condensed">';
                for ($row = 1; $row <= $lastRow; $row++) {
                    if($row === 1) {
                        $tableHTML .= '<thead style="background:grey; color:#fff;">';
                        $tableHTML .= "<tr>";
                            for($cell = 0; $cell <= array_search($lastCell, $arrLetter); $cell++){
                            $tableHTML .= "<th>";
                            $tableHTML .= $worksheet->getCell($arrLetter[$cell].$row)->getValue();
                            $tableHTML .= "</th>";
                            }
                        $tableHTML .= "</tr>";
                        $tableHTML .= "</thead>";
                    } else {
                        $arrCurrent = [];
                        $tableHTML .= "<tr>";
                        for($cell = 0; $cell <= array_search($lastCell, $arrLetter); $cell++){
                            $tableHTML .= "<td>";
                            $tableHTML .= $worksheet->getCell($arrLetter[$cell].$row)->getValue();
                            $tableHTML .= "</td>";
                            $check = is_string($worksheet->getCell($arrLetter[$cell].$row)->getValue()) || is_numeric($worksheet->getCell($arrLetter[$cell].$row)->getValue());
                            $val = $check ? $worksheet->getCell($arrLetter[$cell].$row)->getValue() : null;
                            $key = str_replace(" ", "_", $worksheet->getCell($arrLetter[$cell].$firstRow)->getValue());
                            $key1 = str_replace("-", "_", $key);
                            $keyFinal = str_replace(":", "_", $key1);
                            $arrCurrent[$keyFinal] = $val;
                        }
                        array_push($arrData, $arrCurrent);
                        $tableHTML .= "</tr>";
                    }

                };
                $tableHTML .= "</table></div>";

            }else{

                for ($row = 1; $row <= $lastRow; $row++) {
                    if($row === 1) {
                        for($cell = 0; $cell <= array_search($lastCell, $arrLetter); $cell++){

                        }
                    } else {
                        $arrCurrent = [];
                        for($cell = 0; $cell <= array_search($lastCell, $arrLetter); $cell++){
                            $check = is_string($worksheet->getCell($arrLetter[$cell].$row)->getValue()) || is_numeric($worksheet->getCell($arrLetter[$cell].$row)->getValue());
                            $val = $check ? $worksheet->getCell($arrLetter[$cell].$row)->getValue() : null;
                            $key = str_replace(" ", "_", $worksheet->getCell($arrLetter[$cell].$firstRow)->getValue());
                            $key1 = str_replace("-", "_", $key);
                            $keyFinal = str_replace(":", "_", $key1);
                            $arrCurrent[$keyFinal] = $val;
                        }

                        if(Yii::$app->request->post('FileUpload')['column'] == '1') {
                            $modelKb = new EnglishKb();
                            $modelKb->article_id = $arrCurrent['External_ID'];

                            $title = str_replace('_x000D_', '', $arrCurrent['Title']);
                            $title1 = str_replace('”', '`', $title);
                            $title2 = str_replace('“', '`', $title1);
                            $title3 = str_replace("'", '`', $title2);
                            $modelKb->title = str_replace('"', '`', $title3);

                            $answer = str_replace('&nbsp;', '', $arrCurrent['Answer']);
                            $answer1 = str_replace('\r', '', $answer);
                            $modelKb->answer = str_replace('_x000D_', '', $answer1);

                            $modelKb->label = str_replace('_x000D_', '', $arrCurrent['Label']);

                            $modelKb->context = $arrCurrent['Context'];

                            $phrasings = str_replace('_x000D_', '', $arrCurrent['Phrasing']);
                            $phrasings1 = str_replace('“', '`', $phrasings);
                            $phrasings2 = str_replace('“', '`', $phrasings1);
                            $phrasings3 = str_replace("'", '`', $phrasings2);
                            $modelKb->phrasings = str_replace('"', '`', $phrasings3);

                            $modelKb->related_article = $arrCurrent['Related_Item'];
                            $modelKb->notes = $arrCurrent['External_ID'];
                            $modelKb->validate();
                            $modelKb->save();
                        }
                        if(Yii::$app->request->post('FileUpload')['column'] == '2') {
//                            var_dump($arrCurrent);
                            if(!EnglishNanorep::find()->where( [ 'internalId' => $arrCurrent['Article_ID'] ] )->exists()) {
                                $modelNano = new EnglishNanorep();
                                $modelNano->internalId = $arrCurrent['Article_ID'];
                                $modelNano->context = $arrCurrent['prodId'];
                                $modelNano->question = $arrCurrent['Question'];
                                $modelNano->plain_text_answer = $arrCurrent['Notes'];
                                $modelNano->html_answer = str_replace('_x000D_', '', $arrCurrent['HTML_Answer']);
                                $modelNano->external_id = $arrCurrent['ExternalId'];
                                $labels = str_replace(", ", "|", $arrCurrent['Labels']);
                                $modelNano->labels = $labels;
                                $modelNano->phrasings = $arrCurrent['Phrasings'];
                                $modelNano->validate();
                                $modelNano->save();
                            }
//                            if(!$modelNano->save()){
//                                var_dump($arrCurrent);
//                            }
                        }
                        array_push($arrData, $arrCurrent);
                    }
                }
                $tableHTML = '';
            };

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
                'model' => $model,
                'worksheet' => $worksheet,
                'lastRow' => $lastRow,
                'lastCell' => $lastCell,
                'spliter' => $model->spliter,
                'arrData' => $arrData,
                'tableHTML' => $tableHTML,
            ]);
        };
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
            'model' => $model,
            'arrData' => $arrData,
        ]);
    }

    public function actionWriteNanorep ()
    {
        if(Yii::$app->request->isPost) {
            $arrData = json_decode(Yii::$app->request->post('FileUpload')['data']);

            foreach ($arrData as $key => $value) {
                if(!EnglishNanorep::find()->where(['internalId' => $value->Article_ID])->exists()) {
                    $model = new EnglishNanorep();
                    $model->internalId = $value->Article_ID;
                    $model->context = $value->prodId;
                    $model->question = $value->Question;
                    $model->plain_text_answer = $value->Plain_Text_Answer;
                    $model->html_answer = $value->HTML_Answer;
                    $model->external_id = $value->ExternalId;
                    $labels = str_replace(",", "|", $value->Labels);
                    $model->labels = $labels;
                    $model->phrasings = $value->Phrasings;
                    $model->validate();
                    $model->save();
                }
            }
            \Yii::$app->getSession()->setFlash('success', 'Recording was successful');
        }
        return $this->redirect(['english-nanorep/index']);

    }


    public function actionWriteCustomer ()
    {
        if(Yii::$app->request->isPost) {
            $arrData = json_decode(Yii::$app->request->post('FileUpload')['data']);

            foreach ($arrData as $key => $value){
                if(!EnglishKb::find()->where(['article_id' => $value->externalId])->exists()) {
                    $model = new EnglishKb();
                    $model->article_id = $value->External_ID;
                    $model->title = $value->Title;
                    $model->answer = $value->Answer;
                    $model->label = $value->Label;
                    $model->context = $value->Context;
                    $model->phrasings = $value->Phrasing;
                    $model->related_article = $value->Related_Item;
                    $model->validate();
                    $model->save();
                }
            }
            \Yii::$app->getSession()->setFlash('success', 'Recording was successful');
        }
        return $this->redirect(['english-kb/index']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionShowTables()
    {
//        $db = EnglishKb::find()->all();
//        var_dump($db);


        $dataProvider = new ActiveDataProvider([
            'query' => EnglishKb::find(),
        ]);
        $dataProvider->sort = ['defaultOrder' => ['date_event' => SORT_ASC]];

        $dataProviderNano = new ActiveDataProvider([
            'query' => EnglishNanorep::find(),
        ]);
        $dataProviderNano->sort = ['defaultOrder' => ['date_event' => SORT_ASC]];

        return $this->render('show', [
            'dataProvider' => $dataProvider,
            'dataProviderNano' => $dataProviderNano,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionJoinTables()
    {
        $counter = 0;

        $englishKbRelatedArticles = EnglishKb::find()->select(['related_article','article_id'])->where(['!=','related_article', ''])->all();

//        $this_art_changed = '';

        foreach ($englishKbRelatedArticles as $relatedArticle){

            $nano_article = EnglishNanorep::find()->where(['external_id' => $relatedArticle->article_id])->one();
//            var_dump($nano_article);
//            die();
            $str_related_article = '<hr><p class="related-article">相关项目:</p><ul>';

            $check = false;

            if(strrpos($relatedArticle->related_article, "|")){
                $arr_related_article = explode('|', $relatedArticle->related_article);
                foreach ($arr_related_article as $key => $one_related_article){
                    $art_which_add = EnglishNanorep::find()->select(['internalId', 'question', 'external_id'])->where(['external_id' => trim($one_related_article)])->one();
                    if($art_which_add){
                        $str_related_article .= '<li><a href="javascript:void(0)"  nanoreplinkid="'.$art_which_add->internalId .'">'.$art_which_add->question.'</a></li>';
                        $check = true;
                    }
                }
            }else{
                $art_which_add = EnglishNanorep::find()->select(['internalId', 'question', 'external_id'])->where(['external_id' => trim($relatedArticle->related_article)])->one();
                if($art_which_add) {
                    $str_related_article .= '<li><a href="javascript:void(0)"  nanoreplinkid="' . $art_which_add->internalId . '">' . $art_which_add->question . '</a></li>';
                    $check = true;
                }
            }
            $str_related_article .= '</ul>';

            if($nano_article->html_answer
                && !strrpos($nano_article->html_answer, $str_related_article)
                && $check
            ){

                $nano_article->html_answer = $nano_article->html_answer . $str_related_article;
                if(!$nano_article->save()){
                    var_dump($nano_article);
                    die();
                }else{
                    $counter++;
                }
            }
//            else{
//                $this_art_changed .= $nano_article->question .' ;';
//            }

        }
//        if($this_art_changed){
//            \Yii::$app->getSession()->setFlash('warning', 'This articles already has changes: '. $this_art_changed);
//        }
//        var_dump($counter);
        \Yii::$app->getSession()->setFlash('success', 'Related articles have been added - '.$counter);
        return $this->redirect(['english-nanorep/index']);
    }

    public function actionJoinLabelContext ()
    {
        if(Yii::$app->request->isPost) {
            $arrData = json_decode(Yii::$app->request->post('FileUpload')['data']);

            $newArr =[];
            foreach ($arrData as $key => $value){
                $newArr[$key] = $value;
                $arrNameLabel = explode('|', $value->Related_KB_Name);
                $arrNameContext = explode('|', $value->Related_KB_ID);
                for($i = 0; $i < count($arrNameLabel); $i++){
                    $newArr[$key]->new_labels .= $arrNameContext[$i].':'.$arrNameLabel[$i].'|';
                }

            }

//            var_dump($newArr);

            \Yii::$app->getSession()->setFlash('success', 'Recording was successful');
            $dataProvider = new ArrayDataProvider([
                'allModels' => $newArr,
                'pagination' => [
                    'pageSize' => 1000,
                ],
            ]);


            return $this->render('joinLabelContext', [
                'dataProvider' => $dataProvider,
            ]);
        }
    }



}
