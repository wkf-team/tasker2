<?php

namespace app\controllers;

use Yii;
use app\models\Ticket;
use app\models\WorkflowStep;
use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex($table_view = false)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Ticket::find()->where(['owner_user_id'=>Yii::$app->user->id])
                ->andWhere(Ticket::getFilterByStatus()),
			'pagination' => [
				'pageSize' => 20,
			],
        ]);

        return $this->render($table_view ? 'admin' : 'index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionWorkflowStep($id, $action)
	{
		$model=$this->findModel($id);
		if (isset($_POST['Ticket']))
		{
			$model->resolution_id = (int)$_POST['Ticket']['resolution_id'];
			$model->worked_time = (int)$_POST['Ticket']['worked_time'];
			if (WorkflowStep::IsActionWithResolution($action)) $model->resolved_version = $_POST['Ticket']['resolved_version'];
		}
		$user_id = Yii::$app->user->id;
		$prevOwner = $model->owner_user_id;
		if (Yii::$app->user->Identity->CheckLevel(20) ||
			$model->owner_user_id == $user_id ||
			$model->responsible_user_id == $user_id ||
			$model->author_user_id == $user_id)
		{
			$model->makeWorkflowAction($action);
			if (isset($_POST['Comment']) && $_POST['Comment'] > '')
			{
				$comment = new Comment();
				$comment->attributes=$_POST['Comment'];
				$comment->SetDefault($id);
				$comment->save();
			}
			$addUserNotification = null;
			$removeUserNotification = null;
			if ($prevOwner != $model->owner_user_id)
			{
				//Sendmail::mailAssignTicket($model, isset($comment) ? $comment->text : null);
				$addUserNotification = $prevOwner;
				$removeUserNotification = $model->owner_user_id;
			}
			//Sendmail::mailMakeWFTicket($model, isset($comment) ? $comment->text : null, $addUserNotification, $removeUserNotification);
		}
		$this->redirect(['view','id'=>$model->id]);
	}

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Ticket::create();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
