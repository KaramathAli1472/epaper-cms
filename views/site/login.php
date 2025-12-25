<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */

$this->title = 'Login';
$this->context->layout = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 2px solid #e9ecef;
        }
        
        .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(to right, #4361ee, #3a0ca3);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 15px;
        }
        
        .btn-login:hover {
            background: linear-gradient(to right, #3a0ca3, #4361ee);
        }
        
        .forgot-link {
            text-align: center;
            display: block;
            margin-top: 15px;
            color: #4361ee;
            text-decoration: none;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 class="login-title">Login to Your Account</h2>
        
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label mt-3'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback d-block'],
            ],
        ]); ?>
        
        <?= $form->field($model, 'username')->textInput([
            'autofocus' => true,
            'placeholder' => 'Enter your email or username',
        ])->label('Email or Username') ?>
        
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => 'Enter your password',
        ])->label('Password') ?>
        
        <?= $form->field($model, 'rememberMe')->checkbox()->label(' Remember me') ?>
        
        <div class="form-group">
            <?= Html::submitButton('Login', [
                'class' => 'btn btn-login btn-primary',
                'name' => 'login-button',
            ]) ?>
        </div>
        
        <div class="text-center mt-3">
            <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'forgot-link']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
        
        <?php if ($model->hasErrors()): ?>
            <div class="alert alert-danger mt-3">
                <strong>Login Failed!</strong> Please check your credentials.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
