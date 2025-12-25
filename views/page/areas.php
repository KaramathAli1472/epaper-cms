<?php
use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $areas app\models\PageArea[] */

$this->title = 'Create Area Maps - ' . $model->edition->title . ' - Page ' . $model->page_no;

// controller se aaye areas ko JS ke liye encode
$areas = isset($areas) && is_array($areas) ? $areas : [];
$areasJson = Json::encode($areas);
?>

<div class="page-areas">

    <h1><?= Html::encode($this->title) ?></h1>

    <div style="margin-bottom:15px;">
        <?= Html::a('All Editions »', ['edition/index', 'epaper_id' => $model->edition->epaper_id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Edit Edition »', ['edition/update', 'id' => $model->edition_id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Upload/Manage Pages »', ['page/index', 'edition_id' => $model->edition_id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Edit Area Maps »', ['page/areas', 'id' => $model->id], ['class' => 'btn btn-default active']) ?>
        <?= Html::a('View »', ['page/view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <div style="margin-bottom:10px;">
        <a class="btn btn-primary">New Editor</a>
        <a class="btn btn-default">Classic Editor</a>
    </div>

    <div class="alert alert-info" style="margin-bottom:15px;">
        This new editor can be used on touch devices like mobile phones too.
    </div>

    <!-- Buttons -->
    <div style="margin-bottom:10px;">
        <button id="btn-add-area" class="btn btn-danger">Add Area Map</button>
        <button id="btn-save-areas" class="btn btn-success">Save All Area Maps</button>
    </div>

    <!-- Page + overlay -->
    <div id="page-wrapper"
         style="position:relative; border:1px solid #ddd; padding:10px; background:#fff; overflow:auto;">
        <?php if ($model->image): ?>
              <img id="page-image"
                  src="<?= Html::encode($model->image) ?>"
                  alt="Page image"
                  style="max-width:100%; height:auto; display:block; margin:0 auto; transform-origin: top left; position:relative; z-index:1;">

              <div id="area-layer"
                  style="position:absolute; left:10px; top:10px; right:10px; bottom:10px; pointer-events:auto; z-index:5;"></div>
        <?php else: ?>
            <p>No page image available.</p>
        <?php endif; ?>
    </div>

    <!-- Zoom control -->
    <div style="position:fixed; right:20px; bottom:20px; width:180px; background:#f5f5f5;
                border:1px solid #ccc; padding:5px; text-align:center; z-index:1000;">
        <small>Zoom Control</small>
        <input id="zoom-range" type="range" min="25" max="200" value="50" step="5" style="width:100%;">
        <div><small><span id="zoom-value">50</span>%</small></div>
    </div>

    <!-- Fixed Save Button (always visible) -->
    <div id="save-fixed" class="btn btn-success" style="position:fixed; left:20px; bottom:20px; z-index:1001;">
        Save Areas
    </div>

</div>

<?php
$saveUrl  = \yii\helpers\Url::to(['page/save-areas', 'id' => $model->id]);
$csrf     = Yii::$app->request->getCsrfToken();
$pageId   = (int)$model->id;

// JS: zoom + create area on click + drag/resize + auto-link + save [web:69][web:66]
$js = <<<JS
document.addEventListener('DOMContentLoaded', function() {
    var PAGE_ID    = $pageId;
    var img        = document.getElementById('page-image');
    var range      = document.getElementById('zoom-range');
    var zoomLabel  = document.getElementById('zoom-value');
    var areaLayer  = document.getElementById('area-layer');
    var btnAdd     = document.getElementById('btn-add-area');
    var btnSave    = document.getElementById('btn-save-areas');
    var btnSaveFixed = document.getElementById('save-fixed');

    if (!img || !range || !areaLayer || !btnAdd || !btnSave) return;

    // ensure currentScale exists before applyZoom/use
    var currentScale = 1;

    var dirty = false;
    function markDirty() {
        dirty = true;
        if (btnSaveFixed) btnSaveFixed.classList.add('dirty');
    }
    function clearDirty() {
        dirty = false;
        if (btnSaveFixed) btnSaveFixed.classList.remove('dirty');
    }

    // central save function used by both buttons
    function saveAreas() {
        var payload = areas.map(function(a) {
            return {
                x: parseInt(a.element.style.left, 10),
                y: parseInt(a.element.style.top, 10),
                width: parseInt(a.element.style.width, 10),
                height: parseInt(a.element.style.height, 10),
                link: a.link,
                title: a.title
            };
        });

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '$saveUrl', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.setRequestHeader('X-CSRF-Token', '$csrf');

        xhr.onload = function() {
            try {
                var res = JSON.parse(xhr.responseText);
                if (res.success) {
                    alert('Area maps saved successfully.');
                    clearDirty();
                } else {
                    alert('Save failed: ' + (res.message || 'Unknown error'));
                }
            } catch (e) {
                alert('Save failed.');
            }
        };

        xhr.send('areas=' + encodeURIComponent(JSON.stringify(payload)));
    }

    if (btnSaveFixed) {
        btnSaveFixed.addEventListener('click', saveAreas);
    }
    // keep original button working too
    if (btnSave) {
        btnSave.addEventListener('click', saveAreas);
    }

    // ------------ ZOOM -------------
    function applyZoom() {
        var val = range.valueAsNumber || 50;
        var scale = val / 50;
        currentScale = scale;
        img.style.transform = 'scale(' + scale + ')';
        areaLayer.style.transform = 'scale(' + scale + ')';
        areaLayer.style.transformOrigin = 'top left';
        zoomLabel.textContent = val;
    }
    range.addEventListener('input', applyZoom);
    range.addEventListener('change', applyZoom);
    applyZoom();

    // helper: convert client coords to unscaled coordinates relative to areaLayer
    function clientToLayerCoords(clientX, clientY) {
        var r = areaLayer.getBoundingClientRect();
        return {
            x: (clientX - r.left) / currentScale,
            y: (clientY - r.top) / currentScale
        };
    }

    // ------------ AREAS -------------
    var areas = [];
    var existing = $areasJson || [];
    if (!Array.isArray(existing)) existing = [];

    existing.forEach(function(a) {
        createAreaBox(a.x, a.y, a.width, a.height, a.link, a.title);
    });

    // ek box + resize handles + drag
    function createAreaBox(x, y, w, h, link, title) {
        var box = document.createElement('div');
        box.className = 'area-box';
        box.style.position = 'absolute';
        box.style.border = '2px solid #ff0000';
        box.style.background = 'rgba(255,0,0,0.10)';
        box.style.left   = (x || 0) + 'px';
        box.style.top    = (y || 0) + 'px';
        box.style.width  = (w || 100) + 'px';
        box.style.height = (h || 50) + 'px';
        box.style.cursor = 'move';

        // 4 resize handles
        var handles = ['nw','ne','sw','se'];
        handles.forEach(function(pos) {
            var hdl = document.createElement('div');
            hdl.className = 'resize-handle resize-' + pos;
            hdl.dataset.pos = pos;
            box.appendChild(hdl);
        });

        areaLayer.appendChild(box);

        var areaObj = {
            element: box,
            link: link || '',
            title: title || ''
        };
        areas.push(areaObj);

        // new area -> mark dirty
        markDirty();

        // ---- drag move ----
        var dragging = false, offX = 0, offY = 0;

        box.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('resize-handle')) return; // resize ke liye
            dragging = true;

            var start = clientToLayerCoords(e.clientX, e.clientY);
            offX = start.x - parseFloat(box.style.left || 0);
            offY = start.y - parseFloat(box.style.top || 0);

            e.preventDefault();
        });

        // ---- resize ----
        var resizing = false;
        var resizePos = null;
        var startRect = null;
        var startX = 0, startY = 0;

        box.querySelectorAll('.resize-handle').forEach(function(hdl) {
            hdl.addEventListener('mousedown', function(e) {
                resizing = true;
                resizePos = this.dataset.pos;

                var bRect = box.getBoundingClientRect();
                var layerRect = areaLayer.getBoundingClientRect();
                startRect = {
                    left: (bRect.left - layerRect.left) / currentScale,
                    top:  (bRect.top  - layerRect.top)  / currentScale,
                    width: bRect.width  / currentScale,
                    height: bRect.height / currentScale
                };

                startX = e.clientX;
                startY = e.clientY;
                e.stopPropagation();
                e.preventDefault();
            });
        });

        document.addEventListener('mousemove', function(e) {
            if (!dragging && !resizing) return;

            if (dragging) {
                var p = clientToLayerCoords(e.clientX, e.clientY);
                var nx = p.x - offX;
                var ny = p.y - offY;
                box.style.left = Math.max(0, nx) + 'px';
                box.style.top  = Math.max(0, ny) + 'px';
            } else if (resizing) {
                var dx = (e.clientX - startX) / currentScale;
                var dy = (e.clientY - startY) / currentScale;

                var left   = startRect.left;
                var top    = startRect.top;
                var width  = startRect.width;
                var height = startRect.height;

                if (resizePos.indexOf('e') !== -1) {
                    width = Math.max(20, startRect.width + dx);
                }
                if (resizePos.indexOf('s') !== -1) {
                    height = Math.max(20, startRect.height + dy);
                }
                if (resizePos.indexOf('w') !== -1) {
                    width = Math.max(20, startRect.width - dx);
                    left  = startRect.left + dx;
                }
                if (resizePos.indexOf('n') !== -1) {
                    height = Math.max(20, startRect.height - dy);
                    top    = startRect.top + dy;
                }

                box.style.left   = Math.max(0, left) + 'px';
                box.style.top    = Math.max(0, top) + 'px';
                box.style.width  = width + 'px';
                box.style.height = height + 'px';
            }
        });

        document.addEventListener('mouseup', function() {
            // if user moved or resized, mark dirty
            if (dragging || resizing) markDirty();
            dragging = false;
            resizing = false;
        });

        // double click delete
        box.addEventListener('dblclick', function() {
            if (box.parentNode) areaLayer.removeChild(box);
            areas = areas.filter(function(ar) { return ar.element !== box; });
            markDirty();
        });
    }

    // ------------ ADD NEW AREA (auto link) -------------
    var addMode = false;

    btnAdd.addEventListener('click', function() {
        addMode = true;
        areaLayer.style.cursor = 'crosshair';
    });

    areaLayer.addEventListener('mousedown', function(e) {
        if (!addMode) return;
        addMode = false;
        areaLayer.style.cursor = 'default';

        var pos = clientToLayerCoords(e.clientX, e.clientY);
        var x = pos.x;
        var y = pos.y;

        var w = 250;
        var h = 120;

        var index = areas.length + 1;
        // Yahan apna real link pattern lagao
        var link  = '/epaper/page/' + PAGE_ID + '/area/' + index;
        var title = 'Area ' + index;

        createAreaBox(x, y, w, h, link, title);
    });

});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>

<style>
#area-layer .area-box {
    box-sizing: border-box;
}
.resize-handle {
    position:absolute;
    width:8px;
    height:8px;
    background:#fff;
    border:1px solid #f00;
}
.resize-nw { left:-5px;  top:-5px;  cursor:nwse-resize; }
.resize-ne { right:-5px; top:-5px;  cursor:nesw-resize; }
.resize-sw { left:-5px;  bottom:-5px; cursor:nesw-resize; }
.resize-se { right:-5px; bottom:-5px; cursor:nwse-resize; }
</style>
