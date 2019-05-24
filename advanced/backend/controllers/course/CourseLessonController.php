<?php

namespace backend\controllers\course;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\course\Task;
use common\models\course\Course;
use common\models\course\CourseLesson;
use common\models\course\CourseLessonSearch;

/**
 * CourseLessonController implements the CRUD actions for CourseLesson model.
 */
class CourseLessonController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
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
     * Lists all CourseLesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseLessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseLesson model.
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
     * Creates a new CourseLesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($course_id)
    {
        $model = new CourseLesson();
        $model->course_id = $course_id;
        $model->autoGetLesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing CourseLesson model.
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
     * Deletes an existing CourseLesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //获取
        $model = $this->findModel($id);
        $course_id = $model->course_id;

        //删除
        $this->findModel($id)->delete();

        //跳转
        return $this->redirect(['list',"course_id"=>$course_id]);
    }

    /**
     * @param $course_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionList($course_id){
        //获取课程
        $course = Course::findOne(["id"=>$course_id]);
        if(!$course)
            throw new NotFoundHttpException("课程不存在.");

        //获取所有章节
        $lessons = ArrayHelper::toArray($course->courseLessons);

        //显示到视图
        return $this->render('list', [
            'course' => $course,
            'lessons' => $lessons,
        ]);
    }

    /**
     * Finds the CourseLesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseLesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseLesson::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
