<?php
/** @var yii\web\View $this */
/** @var app\models\EpaperCategory[] $categories */

$this->title = 'Main Homepage';
?>
<div class="site-index">
    <div class="container mt-4">
        <div class="row justify-content-center">
            
            <?php if (!empty($categories)): ?>
                <!-- SINGLE CONTAINER WITH 3 CARDS IN ONE ROW -->
                <div class="col-12">
                    <div class="d-flex justify-content-center flex-wrap">
                        <?php 
                        $counter = 0;
                        foreach ($categories as $category): 
                        ?>
                            <!-- SMALL CARDS - 3 in one row -->
                            <div class="epaper-small-card-container">
                                <a href="<?= Yii::$app->urlManager->createUrl(['epaper/view', 'id' => $category->id]) ?>"
                                   class="epaper-link-small">
                                    <div class="epaper-card-small text-center">

                                        <!-- IMAGE - 300x300 size -->
                                        <div class="epaper-image-square">
                                            <div class="epaper-thumb-square" 
                                                 style="background-image: url('<?= $category->image ? Yii::getAlias('@web') . '/' . $category->image : 'https://via.placeholder.com/300x300/ffffff/1a365d?text=Epaper' ?>');">
                                            </div>
                                        </div>

                                        <!-- META - TITLE INSIDE BOX -->
                                        <div class="epaper-meta-small">
                                            <div class="epaper-title-box">
                                                <h6 class="epaper-title-small"><?= htmlspecialchars($category->name) ?></h6>
                                            </div>
                                            <div class="epaper-info-center">
                                                <div class="epaper-date-small"><?= date('d M Y') ?></div>
                                                <div class="epaper-source-small">SADA E HUSSAINI</div>
                                            </div>
                                        </div>

                                    </div>
                                </a>
                            </div>
                            
                            <?php 
                            $counter++;
                            if ($counter >= 3) break; // Show only 3 cards
                            ?>
                            
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No categories found.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
.site-index {
    background: #f3f5f7;
    min-height: 100vh;
    padding: 40px 0;
}

/* MAIN CONTAINER FOR 3 CARDS IN ONE ROW */
.d-flex.justify-content-center.flex-wrap {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px; /* Space between cards */
}

/* INDIVIDUAL CARD CONTAINER */
.epaper-small-card-container {
    width: 300px; /* Fixed width for each card */
    margin: 0 10px;
}

.epaper-link-small {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

/* SMALL CARD STYLING */
.epaper-card-small {
    background: #fff;
    border-radius: 8px;
    border: 1px solid #e1e5e9;
    padding: 10px;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
    width: 100%;
    height: 420px; /* Fixed height */
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
}

.epaper-card-small:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: #c8d6e5;
}

/* IMAGE SQUARE - 300x300 */
.epaper-image-square {
    width: 280px;
    height: 280px;
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 6px;
    padding: 10px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.epaper-thumb-square {
    width: 260px; /* 280 - padding */
    height: 260px; /* 280 - padding */
    border-radius: 4px;
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    background-color: #fff;
}

/* TITLE BOX - TITLE INSIDE BORDERED BOX */
.epaper-title-box {
    background: #fff;
    border: 1px solid #eaeaea;
    border-radius: 4px;
    padding: 8px 5px;
    margin-bottom: 12px;
    min-height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* INFO CENTER - FOR DATE AND SOURCE */
.epaper-info-center {
    text-align: center;
    width: 100%;
}

/* META FOR SMALL CARDS */
.epaper-meta-small {
    padding: 0 5px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1;
}

.epaper-title-small {
    font-weight: 700;
    font-size: 0.95rem;
    color: #1a365d;
    line-height: 1.3;
    margin: 0;
    padding: 0;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.epaper-date-small,
.epaper-source-small {
    color: #555;
    font-size: 0.8rem;
    text-transform: uppercase;
    margin-bottom: 3px;
    letter-spacing: 0.5px;
    text-align: center;
    width: 100%;
}

.epaper-source-small {
    color: #2c5282;
    font-weight: 600;
    font-size: 0.85rem;
    margin-top: 5px;
}

/* RESPONSIVE ADJUSTMENTS */

/* For 3 cards in one row */
@media (min-width: 1200px) {
    .epaper-small-card-container {
        width: 300px;
    }
}

/* For 2 cards in one row on tablet */
@media (max-width: 1199.98px) and (min-width: 768px) {
    .epaper-small-card-container {
        width: 280px;
    }
    .epaper-image-square {
        width: 260px;
        height: 260px;
    }
    .epaper-thumb-square {
        width: 240px;
        height: 240px;
    }
    .epaper-title-box {
        min-height: 45px;
    }
    .epaper-title-small {
        font-size: 0.9rem;
    }
}

/* For 1 card in one row on mobile */
@media (max-width: 767.98px) {
    .d-flex.justify-content-center.flex-wrap {
        flex-direction: column;
        align-items: center;
    }
    .epaper-small-card-container {
        width: 320px;
        margin: 0 0 20px 0;
    }
    .epaper-image-square {
        width: 300px;
        height: 300px;
    }
    .epaper-thumb-square {
        width: 280px;
        height: 280px;
    }
    .epaper-card-small {
        height: 440px;
    }
}

/* Small Mobile */
@media (max-width: 575.98px) {
    .epaper-small-card-container {
        width: 300px;
    }
    .epaper-card-small {
        height: 420px;
        padding: 12px;
    }
    .epaper-image-square {
        width: 280px;
        height: 280px;
        padding: 8px;
    }
    .epaper-thumb-square {
        width: 264px;
        height: 264px;
    }
    .epaper-title-box {
        padding: 6px 4px;
        min-height: 45px;
    }
    .epaper-title-small {
        font-size: 0.9rem;
    }
}
</style>
