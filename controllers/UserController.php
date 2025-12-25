<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use app\models\User;

class UserController extends Controller
{
    public function actionIndex()
    {
        $users = [];
        foreach (User::getAllUsers() as $user) {  // FIXED: ActiveRecord object
            $users[] = [
                'id'         => $user->id,
                'fullname'   => $user->fullname ?? $user->username,
                'email'      => $user->email   ?? '',
                'mobile'     => $user->mobile  ?? '',
                'role'       => $user->role    ?? 'Super Admin',
                'status'     => $user->status  ?? 10,
                'created_at' => $user->created_at ?? null,
            ];
        }

        $dataProvider = new ArrayDataProvider([
            'allModels'  => $users,
            'pagination' => ['pageSize' => 20],
            'sort'       => ['attributes' => ['id', 'fullname']],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $userData = User::findUserById($id);
        if (!$userData) {
            throw new NotFoundHttpException('User not found.');
        }

        return $this->render('view', [
            'model' => (object)$userData,
        ]);
    }

    public function actionCreate()
    {
        $model = new \stdClass();
        $model->id           = null;
        $model->fullname     = '';
        $model->email        = '';
        $model->country_code = '+91';
        $model->mobile       = '';
        $model->password     = '';
        $model->role         = 'superadmin';
        $model->status       = 10;
        $model->address      = '';
        $model->country      = 'India';
        $model->state        = '';
        $model->city         = '';
        $model->zip          = '';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            User::createUser([
                'fullname' => $post['fullname'] ?? '',
                'password' => $post['password'] ?? '',
                'email'    => $post['email'] ?? '',
                'mobile'   => $post['mobile'] ?? '',
                'role'     => $post['role'] ?? 'superadmin',
                'status'   => $post['status'] ?? 10,
            ]);

            Yii::$app->session->setFlash('success', 'User created successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $userData = User::findUserById($id);
        if (!$userData) {
            throw new NotFoundHttpException('User not found.');
        }

        $model = (object)$userData;
        $model->password = '';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            User::updateUser($id, [
                'fullname' => $post['fullname'] ?? $model->fullname,
                'password' => $post['password'] ?? '',
                'email'    => $post['email'] ?? $model->email,
                'mobile'   => $post['mobile'] ?? $model->mobile,
                'role'     => $post['role'] ?? $model->role,
                'status'   => $post['status'] ?? $model->status,
            ]);

            Yii::$app->session->setFlash('success', 'User updated successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        // Super Admin protection
        if ($id == 1) {
            Yii::$app->session->setFlash('danger', 'Super Admin cannot be deleted!');
            return $this->redirect(['index']);
        }
        
        // FIXED: Get correct ID from URL parameter
        $deleteId = Yii::$app->request->get('id', $id);
        
        // Call static method correctly
        $result = \app\models\User::deleteUser($deleteId);
        
        if ($result) {
            Yii::$app->session->setFlash('success', 'User deleted successfully!');
        } else {
            Yii::$app->session->setFlash('danger', 'Failed to delete user!');
        }
        
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $userData = User::findUserById($id);
        if (!$userData) {
            throw new NotFoundHttpException('User not found.');
        }
        return (object)$userData;
    }
}
