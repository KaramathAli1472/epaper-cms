<?php
use yii\helpers\Html;

$this->title = 'Widget Shortcodes for Posts';
?>
<style>
.ws-backdrop {
    position:fixed;
    inset:0;
    background:rgba(15,23,42,0.45);
    z-index:1040;
    display:none;
    align-items:center;
    justify-content:center;
}
.ws-modal {
    background:#fff;
    border-radius:2px;
    box-shadow:0 10px 25px rgba(15,23,42,0.3);
}
.ws-modal-header {
    padding:8px 10px;
    border-bottom:1px solid #e5e7eb;
    display:flex;
    align-items:center;
    justify-content:space-between;
    font-size:13px;
    font-weight:600;
}
.ws-modal-body {
    padding:10px 12px;
}
.ws-modal-footer {
    padding:8px 12px;
    border-top:1px solid #e5e7eb;
    text-align:right;
}
</style>

<div class="box-style" style="padding:15px;">

    <h4 style="margin-top:0; margin-bottom:10px; font-weight:600;">
        <?= Html::encode($this->title) ?>
    </h4>

    <!-- Top toolbar -->
    <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">

        <button type="button"
                id="ws-open-browser"
                class="btn btn-primary btn-sm"
                style="background:#4f46e5; border-color:#4f46e5; padding:4px 14px;">
            New
        </button>

        <div style="flex:1; display:flex; gap:8px;">
            <input type="text"
                   class="form-control input-sm"
                   placeholder="Search"
                   style="max-width:420px;">

            <select class="form-control input-sm" style="max-width:220px;">
                <option>--All/Any Widget--</option>
            </select>

            <select class="form-control input-sm" style="max-width:160px;">
                <option>--All/Any Status--</option>
            </select>

            <button class="btn btn-primary btn-sm"
                    style="background:#2563eb; border-color:#2563eb; padding:4px 12px;">
                Go
            </button>
            <button class="btn btn-default btn-sm"
                    style="background:#6b7280; color:#fff; border-color:#6b7280; padding:4px 12px;">
                Reset
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive" style="border:1px solid #e5e7eb;">
        <table class="table table-bordered table-striped" style="margin:0; font-size:12px;">
            <thead style="background:#f9fafb;">
            <tr>
                <th style="width:80px;">Action</th>
                <th>Details</th>
                <th style="width:220px;">Shortcode</th>
                <th style="width:110px;">Type</th>
                <th style="width:80px;">Amp Safe</th>
                <th style="width:100px;">Render on AMP</th>
                <th style="width:90px;">Auto Insert</th>
                <th style="width:80px;">Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="8" style="text-align:center; padding:18px; color:#9ca3af;">
                    No widget shortcodes found.
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>

<!-- 1) Widget Browser modal -->
<div id="ws-browser-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:340px;">
        <div class="ws-modal-header">
            <span>Widget Browser</span>
            <button type="button"
                    id="ws-browser-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">
            <select id="ws-widget-select" class="form-control input-sm">
                <option value="menu-items" selected>Menu Items</option>
                <option value="social-links">Social Links</option>
                <option value="youtube-channel-videos">YouTube Channel Videos</option>
                <option value="rss-display">RSS Display Widget</option>
                <option value="slideshow">Slideshow</option>
                <option value="html-code-widget">HTML Code Widget</option>
                <option value="page-content-widget">Page Content Widget</option>
                <option value="image-widget">Image Widget</option>
                <option value="infobox-image">InfoBox: Image</option>
                <option value="cards">Cards</option>
                <option value="heading">Heading</option>
                <option value="button">Button</option>
                <option value="post-category-posts">Post: Category Posts</option>
                <option value="post-collection-posts">Post: Collection Posts</option>
                <option value="post-tag-posts">Post: Tag Posts</option>
                <option value="tinymce-widget">TinyMCE Widget</option>
            </select>
        </div>
        <div class="ws-modal-footer">
            <button type="button" id="ws-browser-create"
                    class="btn btn-primary btn-sm"
                    style="background:#2563eb; border-color:#2563eb;">
                Create
            </button>
        </div>
    </div>
</div>

<!-- 2) Menu Items form modal -->
<div id="ws-menu-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px;">
        <div class="ws-modal-header">
            <span>Menu Items</span>
            <button type="button"
                    id="ws-menu-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">

            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Menu</label>
                <select class="form-control input-sm">
                    <option>Home</option>
                </select>
            </div>

            <div class="form-group">
                <label>Format</label>
                <select class="form-control input-sm">
                    <option>Default</option>
                </select>
            </div>

            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>

        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-menu-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- 3) YouTube Channel Videos form modal -->
<div id="ws-youtube-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px;">
        <div class="ws-modal-header">
            <span>YouTube Channel Videos</span>
            <button type="button"
                    id="ws-youtube-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">

            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Channel ID</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Format</label>
                <select class="form-control input-sm">
                    <option>3 Videos in 1 Row</option>
                </select>
            </div>

            <div class="form-group">
                <label>Open Video In</label>
                <select class="form-control input-sm">
                    <option>Open in Popup</option>
                </select>
            </div>

            <div class="form-group">
                <label>Lazyload Thumbnails</label>
                <select class="form-control input-sm">
                    <option>No Lazyload</option>
                </select>
            </div>

            <div class="form-group">
                <label>Load More...</label>
                <input type="text" class="form-control input-sm">
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Keep this empty to disable load more button.
                </div>
            </div>

            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>

        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-youtube-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- 4) RSS Display Widget form modal -->
<div id="ws-rss-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px; max-height:90vh; overflow-y:auto;">
        <div class="ws-modal-header">
            <span>RSS Display Widget</span>
            <button type="button"
                    id="ws-rss-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">

            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Label Text</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>RSS Feed Url</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Max Count</label>
                <input type="text" class="form-control input-sm" value="50">
            </div>

            <div class="form-group">
                <label>Display Type</label>
                <select class="form-control input-sm">
                    <option>Ticker</option>
                </select>
            </div>

            <div class="form-group">
                <label>Label Background Color</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Label Text Color</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Background Color</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Text Color</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Speed Interval</label>
                <select class="form-control input-sm">
                    <option>Fast</option>
                </select>
            </div>

            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>

            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>

        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-rss-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- 5) Page Content Widget form modal -->
<div id="ws-page-content-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px;">
        <div class="ws-modal-header">
            <span>Page Content Widget</span>
            <button type="button"
                    id="ws-page-content-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Select Page</label>
                <select class="form-control input-sm">
                    <option>Contact Us</option>
                </select>
            </div>
            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>
            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>
        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-page-content-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- 6) Slideshow form modal -->
<div id="ws-slideshow-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px;">
        <div class="ws-modal-header">
            <span>Slideshow</span>
            <button type="button"
                    id="ws-slideshow-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Show ID</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Order</label>
                <select class="form-control input-sm">
                    <option>Ascending</option>
                </select>
            </div>
            <div class="form-group">
                <label>Enable Lazyload</label>
                <select class="form-control input-sm">
                    <option>Enabled</option>
                </select>
            </div>
            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>
            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>
        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-slideshow-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- 7) HTML Code Widget form modal -->
<div id="ws-html-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px;">
        <div class="ws-modal-header">
            <span>HTML Code Widget</span>
            <button type="button"
                    id="ws-html-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>HTML Code</label>
                <textarea class="form-control input-sm" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>
            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>
        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-html-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<!-- 8) Image Widget form modal -->
<div id="ws-image-backdrop" class="ws-backdrop">
    <div class="ws-modal" style="width:720px; max-height:90vh; overflow-y:auto;">
        <div class="ws-modal-header">
            <span>Image Widget</span>
            <button type="button"
                    id="ws-image-close"
                    class="btn btn-default btn-xs"
                    style="padding:2px 6px;">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </div>
        <div class="ws-modal-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Image Url</label>
                <input type="text" class="form-control input-sm">
                <div style="margin-top:6px;">
                    <button type="button" class="btn btn-primary btn-xs">Media...</button>
                </div>
            </div>
            <div class="form-group">
                <label>Alt Text</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Link Url</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Link Target</label>
                <select class="form-control input-sm">
                    <option>Same Window</option>
                </select>
            </div>
            <div class="form-group">
                <label>Lazyload</label>
                <select class="form-control input-sm">
                    <option>Enabled</option>
                </select>
            </div>
            <div class="form-group">
                <label>Fetch Priority</label>
                <select class="form-control input-sm">
                    <option>Auto</option>
                </select>
            </div>
            <div class="form-group">
                <label>CSS Classes</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Style</label>
                <input type="text" class="form-control input-sm">
            </div>
            <div class="form-group">
                <label>Render Logic</label>
                <select class="form-control input-sm">
                    <option>Always Display</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control input-sm">
                    <option>Active</option>
                </select>
            </div>
            <div class="form-group">
                <label>Short Description</label>
                <textarea class="form-control input-sm" rows="3"></textarea>
                <div style="font-size:11px; color:#6b7280; margin-top:4px;">
                    Description for personal use
                </div>
            </div>
        </div>
        <div class="ws-modal-footer">
            <button type="button" class="btn btn-primary btn-sm"
                    style="background:#4f46e5; border-color:#4f46e5; margin-right:4px;">
                Save
            </button>
            <button type="button" id="ws-image-cancel"
                    class="btn btn-default btn-sm">
                Cancel
            </button>
        </div>
    </div>
</div>

<?php
$js = <<<JS
(function(){
    var browserBackdrop = document.getElementById('ws-browser-backdrop');

    var menuBackdrop  = document.getElementById('ws-menu-backdrop');
    var ytBackdrop    = document.getElementById('ws-youtube-backdrop');
    var rssBackdrop   = document.getElementById('ws-rss-backdrop');
    var pageBackdrop  = document.getElementById('ws-page-content-backdrop');
    var slideBackdrop = document.getElementById('ws-slideshow-backdrop');
    var htmlBackdrop  = document.getElementById('ws-html-backdrop');
    var imageBackdrop = document.getElementById('ws-image-backdrop');

    var btnNew          = document.getElementById('ws-open-browser');
    var btnBrowserClose = document.getElementById('ws-browser-close');
    var btnBrowserCreate= document.getElementById('ws-browser-create');
    var widgetSelect    = document.getElementById('ws-widget-select');

    function open(bd){ if(bd) bd.style.display = 'flex'; }
    function close(bd){ if(bd) bd.style.display = 'none'; }

    if (btnNew) btnNew.addEventListener('click', function(){ open(browserBackdrop); });
    if (btnBrowserClose) btnBrowserClose.addEventListener('click', function(){ close(browserBackdrop); });

    if (btnBrowserCreate) btnBrowserCreate.addEventListener('click', function(){
        var val = widgetSelect ? widgetSelect.value : '';
        close(browserBackdrop);
        if (val === 'menu-items')          open(menuBackdrop);
        else if (val === 'youtube-channel-videos') open(ytBackdrop);
        else if (val === 'rss-display')    open(rssBackdrop);
        else if (val === 'page-content-widget') open(pageBackdrop);
        else if (val === 'slideshow')      open(slideBackdrop);
        else if (val === 'html-code-widget') open(htmlBackdrop);
        else if (val === 'image-widget')   open(imageBackdrop);
    });

    // helper: bind close buttons
    function bindClose(id, backdrop){
        var el = document.getElementById(id);
        if (el) el.addEventListener('click', function(){ close(backdrop); });
    }

    bindClose('ws-menu-close', menuBackdrop);
    bindClose('ws-menu-cancel', menuBackdrop);

    bindClose('ws-youtube-close', ytBackdrop);
    bindClose('ws-youtube-cancel', ytBackdrop);

    bindClose('ws-rss-close', rssBackdrop);
    bindClose('ws-rss-cancel', rssBackdrop);

    bindClose('ws-page-content-close', pageBackdrop);
    bindClose('ws-page-content-cancel', pageBackdrop);

    bindClose('ws-slideshow-close', slideBackdrop);
    bindClose('ws-slideshow-cancel', slideBackdrop);

    bindClose('ws-html-close', htmlBackdrop);
    bindClose('ws-html-cancel', htmlBackdrop);

    bindClose('ws-image-close', imageBackdrop);
    bindClose('ws-image-cancel', imageBackdrop);

    // backdrop click to close
    [browserBackdrop, menuBackdrop, ytBackdrop, rssBackdrop,
     pageBackdrop, slideBackdrop, htmlBackdrop, imageBackdrop].forEach(function(bd){
        if (!bd) return;
        bd.addEventListener('click', function(e){
            if (e.target === bd) close(bd);
        });
    });
})();
JS;

$this->registerJs($js);
?>
