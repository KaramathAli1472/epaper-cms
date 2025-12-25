<?php
use yii\helpers\Html;

/** @var $model stdClass */
?>

<form method="post">
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

    <div class="user-form box-style-inner">

        <div class="user-form-grid">

            <!-- Left column -->
            <div class="uf-col">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" class="form-control"
                           value="<?= Html::encode($model->fullname) ?>">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="<?= Html::encode($model->email) ?>">
                </div>

                <div class="uf-row-2">
                    <div class="uf-col-2">
                        <div class="form-group">
                            <label>Country Code</label>
                            <select name="country_code" class="form-control">
                                <option value="+91" <?= $model->country_code == '+91' ? 'selected' : '' ?>>+91 - INDIA</option>
                                <option value="+92" <?= $model->country_code == '+92' ? 'selected' : '' ?>>+92 - PAKISTAN</option>
                            </select>
                        </div>
                    </div>
                    <div class="uf-col-2">
                        <div class="form-group">
                            <label>Mobile/Phone</label>
                            <input type="text" name="mobile" class="form-control"
                                   value="<?= Html::encode($model->mobile) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="superadmin" <?= $model->role == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                        <option value="admin"      <?= $model->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="subadmin"   <?= $model->role == 'subadmin' ? 'selected' : '' ?>>Sub-Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="10" <?= $model->status == 10 ? 'selected' : '' ?>>Active</option>
                        <option value="0"  <?= $model->status == 0  ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

            </div>

            <!-- Right column -->
            <div class="uf-col">

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="2" class="form-control"><?= Html::encode($model->address) ?></textarea>
                </div>

                <div class="uf-row-2">
                    <div class="uf-col-2">
                        <div class="form-group">
                            <label>Country</label>
                            <select name="country" class="form-control">
                                <option value="India"    <?= $model->country == 'India' ? 'selected' : '' ?>>India</option>
                                <option value="Pakistan" <?= $model->country == 'Pakistan' ? 'selected' : '' ?>>Pakistan</option>
                            </select>
                        </div>
                    </div>
                    <div class="uf-col-2">
                        <div class="form-group">
                            <label>State</label>
                            <input type="text" name="state" class="form-control"
                                   value="<?= Html::encode($model->state) ?>">
                        </div>
                    </div>
                </div>

                <div class="uf-row-2">
                    <div class="uf-col-2">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control"
                                   value="<?= Html::encode($model->city) ?>">
                        </div>
                    </div>
                    <div class="uf-col-2">
                        <div class="form-group">
                            <label>Zip</label>
                            <input type="text" name="zip" class="form-control"
                                   value="<?= Html::encode($model->zip) ?>">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="user-form-footer">
    <div class="uff-left">
        <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="btn btn-back">
            ‹ Back
        </a>
    </div>
    <div class="uff-right">
        <button type="submit" class="btn btn-save">Save</button>
    </div>
</div>
</form>

<style>
.box-style {
    background: #ffffff;
    border-radius: 6px;
    padding: 15px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.page-title {
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}
.form-card {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    padding: 15px 15px 10px 15px;
}
.box-style-inner {
    padding: 0;
    box-shadow: none;
}

/* Two column layout */
.user-form-grid {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}
.uf-col {
    flex: 1 1 50%;
}

/* Two controls in single row */
.uf-row-2 {
    display: flex;
    gap: 10px;
}
.uf-col-2 {
    flex: 1 1 50%;
}

/* Footer */
.user-form-footer {
    margin-top: 15px;
    padding: 10px 0;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;   /* left back, right save */
    align-items: center;
}

.btn-back {
    background: #6b7280;
    color: #ffffff;
    border-radius: 0;
    padding: 6px 18px;
    font-size: 12px;
    text-decoration: none;
}

.btn-save {
    background: #6366f1;
    color: #ffffff;
    border-radius: 0;
    padding: 6px 18px;
    font-size: 12px;
    border: none;
}

.btn-back:hover,
.btn-save:hover {
    opacity: 0.9;
    color: #ffffff;
}
</style>
