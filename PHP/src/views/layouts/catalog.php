<?php
use app\widgets\TreeWidget; ?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h2>Каталог</h2>
                <div class="category-products">
                    <?= TreeWidget::widget(); ?>
                </div>
            </div>

            <div class="col-sm-9">
                <?= $content ?>
            </div>
        </div>
    </div>
</section>
<?php $this->endContent(); ?>