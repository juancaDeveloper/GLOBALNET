<?php
/**
 * @package   JS Easy Social Icons
 * @copyright 2016 Open Source Training, LLC. All rights reserved.
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

defined('_JEXEC') or die('Direct access to files is not permitted.');

?>

<div id="easy-social-icons">

    <?php if ($before !== '') : ?>
    <div class="jssocialicons-before"><?php echo $before; ?></div>
    <?php endif; ?>

    <div class="jssocialicons-icons">
        <ul class="jssocialicons <?php echo "jssocialicons-" . $orientation?>">
        <?php foreach ($sites as $site => $url) : ?>
            <li><a class='<?php echo "iconset-" . $iconset . " si-size-" . $iconsize . " si-" . $site ; ?>' href="<?php echo $url?>" target="<?php echo $target; ?>"></a></li>
        <?php endforeach; ?>
        </ul>
    </div>

    <?php if ($after !== '') : ?>
    <div class="jssocialicons-after"><?php echo $after; ?></div>
    <?php endif; ?>

</div>
