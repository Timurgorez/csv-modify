<?php

namespace app\controllers;

use app\models\EnglishNanorepSearch;
use Yii;
use app\models\EnglishKb;
use app\models\EnglishKbSearch;
use yii\data\ArrayDataProvider;
use yii\debug\models\timeline\DataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnglishKbController implements the CRUD actions for EnglishKb model.
 */
class EnglishKbController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EnglishKb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EnglishKbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EnglishKb model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EnglishKb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EnglishKb();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EnglishKb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EnglishKb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EnglishKb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EnglishKb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EnglishKb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionTrancateTable()
    {
        $countOfRow = EnglishKb::deleteAll();
//        $model = new Test();
//        $model->title = 'title 23';
//        $model->content = 'content 23';
//        $model->save();
        \Yii::$app->getSession()->setFlash('success', $countOfRow.' rows in table has been deleted.');
        return $this->redirect(['index']);
    }

    public function actionAddPathImg()
    {
        $modals = EnglishKb::find()->filterWhere(['like', 'answer', '="/srvs/images'])->orFilterWhere(['like', 'answer', '="/srvs/Images'])->all();

        foreach ($modals as $modal){
            $position = strrpos($modal->answer, '="/srvs/images');
            if($position){
                $result = str_replace('="/srvs/images', '="http://m1-onlinesupport.fujixerox.com/srvs/images', $modal->answer);
                $modal->answer = $result;
                $modal->save();
            }
            $position = strrpos($modal->answer, '="/srvs/Images');
            if($position){
                $result = str_replace('="/srvs/Images', '="http://m1-onlinesupport.fujixerox.com/srvs/Images', $modal->answer);
                $modal->answer = $result;
                $modal->save();
            }
        }
        \Yii::$app->getSession()->setFlash('success', 'All paths was updated.');
        return $this->redirect(['index']);
    }

    public function actionModifyPhrasings ()
    {
        $arrData = EnglishKb::find()->where(['not', ['phrasings' => '']])->all();

        foreach ($arrData as $key => $value){
            $arr = explode('|', $value->phrasings);
            if(count($arr) > 0){
                $json = '[{"text":"'.$value->title.'","autoComplete":true}';
                foreach ($arr as $ar){
                    if($ar && trim($ar)){
                        $json .= ',{"text":"'.$ar.'","autoComplete":false}';
                    }
                }
                $json .= ']';
                $value->phrasings = $json;
                $value->save();
            }
        }
        \Yii::$app->getSession()->setFlash('success', 'Recording was successful');
        return $this->redirect(['index']);
    }

    public function actionCheckId ()
    {
        $arrData = EnglishKb::find()
            ->select(['article_id', 'COUNT(*) AS count'])
            ->groupBy('article_id')
            ->having(['>', 'count', 1])
//            ->limit(1000)->offset(0)
            ->asArray()
            ->all();

//        echo '<pre>';
//        var_dump($arrData);
//        echo '<pre>';

        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrData,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name'],
            ],
        ]);

        return $this->render('checkid', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionChangeId ()
    {
        $arrData = EnglishKb::find()
            ->select(['article_id', 'COUNT(*) AS count'])
            ->groupBy('article_id')
            ->having(['>', 'count', 1])
//            ->limit(1000)->offset(0)
            ->asArray()
            ->all();
//        var_dump($arrData);
        foreach ($arrData as $value){
            $query = EnglishKb::findAll(['article_id' => $value['article_id']]);
            for ($i = 0; $i < count($query); $i++){
                if($i >= 1){
                    $query[$i]->article_id =  $query[$i]->article_id.'-'.$i;
//                    var_dump($query[$i]->article_id);
                    $query[$i]->save();
                }

//                echo '<pre>';
//                var_dump($i);
//                var_dump($query[$i]);
//                echo '<pre>';
            }
        }

        \Yii::$app->getSession()->setFlash('success', 'Changed all ID');
        return $this->redirect(['check-id']);
    }

    public function actionRemoveTagsFromTitle ()
    {
        $arrData = EnglishKb::find()->all();

        foreach ($arrData as $value){
            $value->title = strip_tags($value->title);
//            var_dump($value->title);
            $value->save();
        }

        \Yii::$app->getSession()->setFlash('success', 'Changed all Titles');
        return $this->redirect(['index']);
    }

    public function actionFindDuplicateArticles ()
    {
        $arrData = EnglishKb::find()
            ->select(['title', 'answer', 'context', 'COUNT(*) AS count'])
            ->groupBy(['title','answer', 'context'])
            ->having(['>', 'count', 1])
//            ->limit(1000)->offset(0)
            ->asArray()
            ->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrData,
            'pagination' => [
                'pageSize' => 500,
            ],
            'sort' => [
                'attributes' => ['title', 'count','context'],
            ],
        ]);

        return $this->render('duplicate', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUniqueId ()
    {
        $arrData = EnglishKb::find()->all();
        $count = 99;
        foreach ($arrData as $value){
            $count++;
            $value->article_id = $value->article_id.'-'.$count;
            $value->save();
        }

        return $this->redirect(['index']);
    }

    public function actionJson ()
    {
        $arrData = EnglishKb::find()->filterWhere(['like', 'phrasings', '"'])->orFilterWhere(['like', 'phrasings', "'"])->asArray()->all();

        foreach ($arrData as $key => $value){
            $arr = explode('|', $value['phrasings']);
            if(count($arr) > 0){
                $title = str_replace('"', '`', $value['title']);
                $title0 = str_replace('”', '`', $title);
                $title1 = str_replace("'", '`', $title0);

                $answer = str_replace('_x000D_', '', $value['answer']);
                $answer0 = str_replace('&nbsp;', '', $answer);
                $answer1 = str_replace('&quot;', '', $answer0);
                $answer2 = str_replace('\r', '', $answer1);

                $label = str_replace('_x000D_', '', $value['label']);

                $checkPhrasing = false;

                $json = '[{"text":"'.$title1.'","autoComplete":true}';
                foreach ($arr as $ar){
                    if($ar && trim($ar)){

                        $result = str_replace('"', '`', $ar);
                        $result0 = str_replace("'", '`', $result);
                        $result1 = str_replace('“', '`', $result0);

                        $json .= ',{"text":"'.$result1.'","autoComplete":false}';
                    }else{
                        $checkPhrasing = true;
                    }
                }
                $json .= ']';
                if($checkPhrasing)$json = '';
                $arrData[$key]['title'] = $title1;
                $arrData[$key]['answer'] = $answer2;
                $arrData[$key]['label'] = $label;
                $arrData[$key]['phrasings'] = $json;
//                $value->phrasings = $json;
//                $value->save();
            }
        }
//        var_dump($arrData);
//        die();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $arrData,
            'pagination' => [
                'pageSize' => 4000,
            ],
//            'sort' => [
//                'attributes' => ['title', 'count','context'],
//            ],
        ]);

        return $this->render('dynamic_table', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionTest ()
    {
        $arrData = EnglishKb::find()->filterWhere(['not like', 'article_id', '-222'])->all();

        foreach ($arrData as $key => $value){

            $value->article_id = $value->article_id.'-222';
//            $value->save();
        }
        var_dump("All good");

    }
}
