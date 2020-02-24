<?php
use app\models\Projects;
?>

<div class="project-menu-wrapper">
    <?php foreach (Projects::getMenu() as $section => $items): ?>
        <p class="project-menu-title-section"><?= $section ?></p>
        <?php foreach ($items as $item): ?>
            <a
                <?php if ($item['attributes']): ?>
                    <?php foreach ($item['attributes'] as $key => $value): ?>
                        <?= $key.'="'.$value.'"' ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                class="project-menu-item" href="<?= $item['url'] ?>"><p><?= $item['name'] ?></p>
            </a>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>