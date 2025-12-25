<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Media Manager';
?>

<div class="media-page-wrapper">

    <!-- LEFT: MAIN CONTENT (TITLE + TOOLBAR + GRID) -->
    <div class="media-index box-style">

        <!-- Title -->
        <div class="page-header-row">
            <div class="page-title">
                <?= Html::encode($this->title) ?>
            </div>
        </div>

        <!-- Top toolbar (buttons + search) -->
        <div class="media-toolbar">

            <!-- LEFT: Upload + Manage Media Tags -->
            <div class="toolbar-left">

                <!-- Visible Upload button (file dialog open karega) -->
                <button type="button"
                        class="btn btn-sm btn-primary btn-upload"
                        id="btn-upload-direct">
                    Upload...
                </button>

                <?= Html::a('Manage Media Tags', ['media-tag/index'], [
                    'class' => 'btn btn-sm btn-info btn-tags',
                ]) ?>
            </div>

            <!-- RIGHT: Search controls -->
            <div class="toolbar-right">
                <form method="get" class="form-inline">

                    <!-- Search By Title dropdown -->
                    <select name="search_by" class="form-control input-sm search-by-select">
                        <option value="title">Search By Title</option>
                        <option value="file_name">Search By File Name</option>
                    </select>

                    <!-- Search text -->
                    <input type="text"
                           name="q"
                           class="form-control input-sm search-input"
                           placeholder="Search...">

                    <!-- Sort direction button (dummy icon) -->
                    <button type="button" class="btn btn-sm btn-default sort-btn">
                        <i class="fa fa-sort"></i>
                    </button>

                    <!-- Go -->
                    <button type="submit" class="btn btn-sm btn-primary go-btn">Go</button>

                    <!-- Reset -->
                    <a href="<?= \yii\helpers\Url::to(['media/index']) ?>"
                       class="btn btn-sm btn-default reset-btn">Reset</a>
                </form>
            </div>

        </div>

        <!-- HIDDEN DIRECT UPLOAD FORM -->
        <?php $directForm = ActiveForm::begin([
            'id' => 'direct-upload-form',
            'action' => ['media/upload'],
            'options' => [
                'enctype' => 'multipart/form-data',
                'style'   => 'display:none;',
            ],
        ]); ?>

        <?= $directForm->field($uploadModel, 'uploadFile')
            ->fileInput(['id' => 'direct-upload-input'])
            ->label(false) ?>

        <?php ActiveForm::end(); ?>

        <!-- IMAGE GALLERY GRID -->
        <div class="media-grid" id="media-grid">
            <?php foreach ($dataProvider->getModels() as $model): ?>
                <?php if (!$model->file_path) continue; ?>
                <div class="media-grid-item"
                     data-id="<?= $model->id ?>"
                     data-title="<?= Html::encode($model->title) ?>"
                     data-caption="<?= Html::encode($model->caption ?? '') ?>"
                     data-src="<?= Html::encode($model->file_path) ?>">
                    <div class="media-thumb-wrapper">
                        <img src="<?= Html::encode($model->file_path) ?>"
                             alt="<?= Html::encode($model->file_name) ?>"
                             class="media-thumb-img">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- RIGHT: DETAILS PANEL -->
    <div class="media-side-panel box-style" id="media-side-panel">
        <div class="side-panel-header">
            <span>Selected Media</span>
            <!-- Delete button with data-id attribute -->
            <a href="#" class="btn btn-xs btn-danger" id="btn-side-delete" style="display:none;" data-id="">Delete</a>
        </div>

        <div class="side-panel-body" id="side-panel-body">

            <div class="side-preview" id="side-preview">
                <span class="side-placeholder-text">Click any image to edit</span>
            </div>

            <div class="side-form" id="side-form" style="display:none;">
                <div class="form-group">
                    <label>Edit Title</label>
                    <input type="text" id="side-title" class="form-control input-sm">
                </div>

                <div class="form-group">
                    <label>Edit Caption</label>
                    <textarea id="side-caption" class="form-control input-sm" rows="4"></textarea>
                </div>

                <button type="button"
                        class="btn btn-sm btn-primary"
                        id="btn-side-save">
                    Save
                </button>
            </div>

        </div>
    </div>

</div>

<?php
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
?>

<?php
// Get CSRF token
$csrfToken = Yii::$app->request->csrfToken;
$csrfParam = Yii::$app->request->csrfParam;

// Get URLs using Url::to()
$deleteUrl = Url::to(['media/delete']);
$updateUrl = Url::to(['media/update-ajax']);

// JS: upload + image click -> side panel + delete + update
$js = <<<JS
// Upload button click -> hidden file input open
$('#btn-upload-direct').on('click', function() {
    $('#direct-upload-input').click();
});

// File select hone ke baad automatic form submit
$('#direct-upload-input').on('change', function() {
    if (this.files.length > 0) {
        $('#direct-upload-form').submit();
    }
});

// Image click -> side panel fill
$(document).on('click', '.media-grid-item', function() {
    var id      = $(this).data('id');
    var title   = $(this).data('title');
    var caption = $(this).data('caption');
    var src     = $(this).data('src');

    // active border
    $('.media-grid-item').removeClass('media-active');
    $(this).addClass('media-active');

    // preview
    $('#side-preview').html('<img src=\"' + src + '\" class=\"side-preview-img\">');

    // form values
    $('#side-title').val(title);
    $('#side-caption').val(caption);

    // show form + delete button
    $('#side-form').show();
    $('#btn-side-delete').show().attr('data-id', id);
});

// Delete button click
$(document).on('click', '#btn-side-delete', function(e) {
    e.preventDefault();
    
    var id = $(this).attr('data-id');
    if (!id) {
        alert('No media selected.');
        return;
    }
    
    if (confirm('Are you sure you want to delete this media?')) {
        // Show loading
        var deleteBtn = $(this);
        var originalText = deleteBtn.text();
        deleteBtn.text('Deleting...').prop('disabled', true);
        
        $.ajax({
            url: '$deleteUrl',
            type: 'POST',
            data: {
                id: id,
                $csrfParam: '$csrfToken'
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Remove the item from grid
                    $('.media-grid-item[data-id=\"' + id + '\"]').fadeOut(300, function() {
                        $(this).remove();
                    });
                    
                    // Reset side panel
                    $('#side-preview').html('<span class=\"side-placeholder-text\">Click any image to edit</span>');
                    $('#side-form').hide();
                    $('#btn-side-delete').hide().attr('data-id', '');
                    
                    alert(response.message);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while deleting. Please check console for details.');
                console.error('Delete error:', error);
                console.error('Response:', xhr.responseText);
            },
            complete: function() {
                deleteBtn.text(originalText).prop('disabled', false);
            }
        });
    }
});

// Save button (AJAX update)
$(document).on('click', '#btn-side-save', function() {
    var id = $('#btn-side-delete').attr('data-id');
    var title = $('#side-title').val();
    var caption = $('#side-caption').val();
    
    if (!id) {
        alert('Please select an image first.');
        return;
    }
    
    // Show loading
    var saveBtn = $(this);
    var originalText = saveBtn.text();
    saveBtn.text('Saving...').prop('disabled', true);
    
    $.ajax({
        url: '$updateUrl',
        type: 'POST',
        data: {
            id: id,
            title: title,
            caption: caption,
            $csrfParam: '$csrfToken'
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update the grid item data
                var gridItem = $('.media-grid-item[data-id=\"' + id + '\"]');
                gridItem.data('title', title);
                gridItem.data('caption', caption);
                alert(response.message);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred while saving. Please check console for details.');
            console.error('Save error:', error);
            console.error('Response:', xhr.responseText);
        },
        complete: function() {
            saveBtn.text(originalText).prop('disabled', false);
        }
    });
});

// Refresh page after upload
$(document).on('ajaxComplete', function(event, xhr, settings) {
    if (settings.url.indexOf('upload') !== -1) {
        setTimeout(function() {
            location.reload();
        }, 1000);
    }
});

JS;

$this->registerJs($js);
?>

<style>
/* Page layout: left grid + right panel */
.media-page-wrapper {
    display: grid;
    grid-template-columns: 3fr 1.2fr;
    grid-gap: 15px;
}

/* Left main card */
.media-index {
    background: #f3f4f6;
    padding: 20px;
}

.box-style {
    background: #ffffff;
    border-radius: 6px;
    padding: 15px 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}

.page-header-row {
    margin-bottom: 8px;
}

.page-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

/* top toolbar */
.media-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

/* left buttons */
.toolbar-left .btn {
    margin-right: 5px;
    padding: 8px 18px;
    font-size: 12px;
    border-radius: 4px;
}

.btn-upload {
    background: #4f46e5;
    border-color: #4f46e5;
}

.btn-tags {
    background: #0ea5e9;
    border-color: #0ea5e9;
}

/* right search controls */
.toolbar-right .form-control,
.toolbar-right .btn {
    margin-left: 4px;
}

.search-by-select {
    min-width: 140px;
}

.search-input {
    min-width: 160px;
}

/* IMAGE GRID */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    grid-gap: 4px;
    max-height: calc(100vh - 220px);
    overflow-y: auto;
}

.media-grid-item {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    padding: 2px;
    cursor: pointer;
    transition: border-color 0.2s;
}

.media-grid-item:hover {
    border-color: #fbbf24;
}

.media-grid-item.media-active {
    border: 2px solid #fbbf24;
}

.media-thumb-wrapper {
    width: 100%;
    padding-top: 100%;          /* square */
    position: relative;
    overflow: hidden;
}

.media-thumb-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* RIGHT SIDE PANEL */
.media-side-panel {
    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 80px);
    overflow-y: auto;
}

.side-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 14px;
}

.side-panel-body {
    font-size: 13px;
}

.side-preview {
    border: 1px solid #e5e7eb;
    padding: 8px;
    text-align: center;
    margin-bottom: 10px;
    min-height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.side-preview-img {
    max-width: 100%;
    max-height: 200px;
    object-fit: contain;
}

.side-placeholder-text {
    color: #9ca3af;
    font-size: 13px;
}

.side-form .form-group {
    margin-bottom: 8px;
}

.side-form label {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.side-form .form-control {
    font-size: 12px;
    padding: 6px 8px;
}
</style>