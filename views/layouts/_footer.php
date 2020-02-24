<?php
/** @var \yii\web\View $this */
?>
<footer >
    <div id="footerHalf-left" >
        <div class="footerHalf">
            <?php if (isset($this->blocks['control_buttons_page'])): ?>
                <?= $this->blocks['control_buttons_page'] ?>
            <?php endif; ?>
            <div class="footer-text">
                <p>Интерактивная карта зарубежных проектов «РЖД»</p>
            </div>
        </div>
    </div>
</footer>