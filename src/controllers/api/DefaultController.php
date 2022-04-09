<?php

namespace portalium\content\controllers\api;

use Yii;
use portalium\content\Module;
use portalium\content\models\Content;
use portalium\rest\ActiveController as RestActiveController;

class DefaultController extends RestActiveController
{
    public $modelClass = 'portalium\content\models\Content';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return $actions;
    }

    //before action
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        switch ($action->id) {
            case 'view':
                if (!Yii::$app->user->can('contentApiDefaultView')) 
                    throw new \yii\web\ForbiddenHttpException(Module::t('You do not have permission to view this content.'));
                break;
            case 'create':
                if (!Yii::$app->user->can('contentApiDefaultCreate')) 
                    throw new \yii\web\ForbiddenHttpException(Module::t('You do not have permission to create this content.'));
                break;
            case 'update':
                if (!Yii::$app->user->can('contentApiDefaultUpdate')) 
                    throw new \yii\web\ForbiddenHttpException(Module::t('You do not have permission to update this content.'));
                break;
            case 'delete':
                if (!Yii::$app->user->can('contentApiDefaultDelete'))
                    throw new \yii\web\ForbiddenHttpException(Module::t('You do not have permission to delete this content.'));
                break;
            default:
                if (!Yii::$app->user->can('contentApiDefaultIndex'))
                    throw new \yii\web\ForbiddenHttpException(Module::t('You do not have permission to delete this content.'));
                break;
        }
        
        return true;
    }

    public function actionIndex($id = null)
    {
        if ($id == null) {
            $data = Content::find()->all();
        } else {
            $data = Content::find()->where(['id_category' => $id])->all();
        }
        return $data;
    }
}