<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 *
 * @var dektrium\user\Module $module
 */
?>

<?php if ($module->enableFlashMessages): ?>
<div class="row">
	<div class="col-xs-12">
            <?php foreach (Yii::$app->session->getAllFlashes() as $type => $message): ?>
                <?php if (in_array($type, ['success', 'danger', 'warning', 'info'])): ?>
                    <div class="alert alert-<?= $type ?>">
                        <?= $message?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
</div>
<?php endif ?>
