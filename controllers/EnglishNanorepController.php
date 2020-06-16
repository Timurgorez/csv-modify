<?php

namespace app\controllers;

use app\models\EnglishKb;
use app\models\Test;
use Yii;
use app\models\EnglishNanorep;
use app\models\EnglishNanorepSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnglishNanorepController implements the CRUD actions for EnglishNanorep model.
 */
class EnglishNanorepController extends Controller
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
     * Lists all EnglishNanorep models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EnglishNanorepSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EnglishNanorep model.
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
     * Creates a new EnglishNanorep model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EnglishNanorep();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EnglishNanorep model.
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
     * Deletes an existing EnglishNanorep model.
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
     * Finds the EnglishNanorep model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EnglishNanorep the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EnglishNanorep::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAddPathImg()
    {
        $modals = EnglishNanorep::find()->filterWhere(['like', 'html_answer', '/srvs/images'])->orFilterWhere(['like', 'html_answer', '/srvs/Images'])->all();

        foreach ($modals as $modal){
            $position = strrpos($modal->html_answer, '="/srvs/images');
            if($position){
                $result = str_replace('="/srvs/images', '="http://m1-onlinesupport.fujixerox.com/srvs/images', $modal->html_answer);
                $modal->html_answer = $result;
                $modal->save();
            }
            $position = strrpos($modal->html_answer, '="/srvs/Images');
            if($position){
                $result = str_replace('="/srvs/Images', '="http://m1-onlinesupport.fujixerox.com/srvs/Images', $modal->html_answer);
                $modal->html_answer = $result;
                $modal->save();
            }
        }
        \Yii::$app->getSession()->setFlash('success', 'All paths was updated.');
        return $this->redirect(['index']);
    }


    public function actionChangePhrasings()
    {
        $modals = EnglishNanorep::find()->all();
        foreach ($modals as $modal){
            $strToUpload = [];

            $arr = json_decode($modal->phrasings);
            if($arr){
                for($i = 0; $i < count($arr); $i++){
                    if($i > 0){
                        $result = str_replace('“', '"', $arr[$i]->text);
                        $result1 = str_replace('”', '"', $result);
                        $arrPhrase = json_decode($result1);
                        if(is_array($arrPhrase) && count($arrPhrase) > 0){
                            foreach($arrPhrase as $phrase){
                                if(!in_array(trim($phrase->text), $strToUpload)){
                                    $strToUpload[] = trim($phrase->text);
                                }
                            }
                        }
                    }else{
                        $strToUpload[] = trim($arr[$i]->text);
                    }
                }
            }

            if(count($strToUpload) > 0){
                $modal->phrasings = implode('|', $strToUpload);
                $modal->save();
            }
        };
        \Yii::$app->getSession()->setFlash('success', 'All phrasings has been changed.');
        return $this->redirect(['index']);
    }

    public function actionTrancateTable()
    {
        $countOfRow = EnglishNanorep::deleteAll();
//        $model = new Test();
//        $model->title = 'title 23';
//        $model->content = 'content 23';
//        $model->save();
        \Yii::$app->getSession()->setFlash('success', $countOfRow.' rows in table has been deleted.');
        return $this->redirect(['index']);
    }

    public function actionDel ()
    {
        $modals = EnglishNanorep::find()->filterWhere(['like', 'html_answer', '<hr><p class="related-article">Related article:</p><ul></ul>'])->all();

        foreach ($modals as $modal){
            $position = strrpos($modal->html_answer, '<hr><p class="related-article">Related article:</p><ul></ul>');
//            var_dump(substr($modal->html_answer, 0, $position));
            if($position){
                $result = substr($modal->html_answer, 0, $position);
                $modal->html_answer = $result;
                $modal->save();
            }
        }
        \Yii::$app->getSession()->setFlash('success', 'All empty Related articles are deleted');
        return $this->redirect(['index']);
    }

}
