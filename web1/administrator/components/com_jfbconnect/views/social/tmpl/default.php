<?php
/**
 * @package         JFBConnect
 * @copyright (c)   2009-2020 by SourceCoast - All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @version         Release v8.4.4
 * @build-date      2020/07/24
 */

if (!(defined('_JEXEC') || defined('ABSPATH'))) {     die('Restricted access'); };
jimport('joomla.filesystem.folder');
JHTML::_('behavior.tooltip');
$model = $this->model;
$k2IsInstalled = JFBConnectUtilities::isJoomlaComponentEnabled('com_k2');

$provider = $this->filter_provider;
$task = JRequest::getVar('task', '', 'post');
if(!empty($task)) { $provider = '';}
?>
<script type="text/javascript">
    function toggleHide(rowId, styleType)
    {
        document.getElementById(rowId).style.display = styleType;
    }
</script>

<div class="sourcecoast">
    <form method="post" id="adminForm" name="adminForm">
        <div class="row-fluid">
            <ul class="nav nav-tabs">
                <li <?php echo $provider ? '' : 'class="active"';?>><a href="#social_content_comment" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_CONTENT_COMMENTS'); ?></a></li>
                <li><a href="#social_content_like" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_CONTENT_LIKE'); ?></a></li>
                <li><a href="#social_content_quote" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_CONTENT_QUOTE'); ?></a></li>
                <?php
                if ($k2IsInstalled)
                {
                    echo '<li><a href="#social_content_k2_comment" data-toggle="tab">' . JText::_('COM_JFBCONNECT_SOCIAL_MENU_CONTENT_K2_COMMENTS') . '</a></li>';
                    echo '<li><a href="#social_content_k2_like" data-toggle="tab">' . JText::_('COM_JFBCONNECT_SOCIAL_MENU_CONTENT_K2_LIKE') . '</a></li>';
                    echo '<li><a href="#social_content_k2_quote" data-toggle="tab">' . JText::_('COM_JFBCONNECT_SOCIAL_MENU_CONTENT_K2_QUOTE') . '</a></li>';
                }
                ?>
                <li><a href="#social_notifications" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_NOTIFICATIONS'); ?></a></li>
                <li><a href="#social_messenger" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_MESSENGER'); ?></a></li>
                <li><a href="#social_misc" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_MISC'); ?></a></li>
                <li <?php echo $provider ? 'class="active"' : '';?>><a href="#social_examples" data-toggle="tab"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_MENU_EXAMPLES'); ?></a></li>
            </ul>
        </div>
        <div class="tab-content">
            <?php echo $this->loadTemplate('comments');?>
            <?php echo $this->loadTemplate('like');?>
            <?php echo $this->loadTemplate('quote');?>
            <?php
            if ($k2IsInstalled)
            {
                ?>
                <?php echo $this->loadTemplate('k2comments');?>
                <?php echo $this->loadTemplate('k2like');?>
                <?php echo $this->loadTemplate('k2quote');?>
                <?php
            }
            echo $this->loadTemplate('notifications');
            echo $this->loadTemplate('messenger');
            ?>
            <div class="tab-pane" id="social_misc">
                <div class="config_row">
                    <div class="config_setting header"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_SOCIAL_SETTING'); ?></div>
                    <div class="config_option header"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_OPTIONS'); ?></div>
                    <div style="clear:both"></div>
                </div>
                <div class="config_row">
                    <div class="config_setting hasTip"
                         title="<?php echo JText::_('COM_JFBCONNECT_SOCIAL_TAG_ADMIN_KEY_DESC'); ?>"><?php echo JText::_('COM_JFBCONNECT_SOCIAL_TAG_ADMIN_KEY_LABEL'); ?></div>
                    <div class="config_option">
                        <input type="text" name="social_tag_admin_key" value="<?php echo $model->getSetting('social_tag_admin_key') ?>" size="20">
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
            <div class="tab-pane <?php echo $provider ? 'active' : '';?>" id="social_examples">
                <?php $this->setLayout('examples'); ?>
                <?php echo $this->loadTemplate(); ?>
            </div>
        </div>
        <input type="hidden" name="option" value="com_jfbconnect" />
        <input type="hidden" name="controller" value="social" />
        <input type="hidden" name="cid[]" value="0" />
        <input type="hidden" name="task" value="" />
        <?php echo JHTML::_('form.token'); ?>

    </form>
</div>
<script type="text/javascript">
    function showHideSettings(settingsId, selectors)
    {
        var hide = true;
        jfbcJQuery.each(selectors, function (i, selector)
            {
                if (jfbcJQuery("select[name=" + selector + "]").val() != "0")
                    hide = false;
            }
        );
        if (hide)
            jfbcJQuery("#" + settingsId).css("display", "none");
        else
            jfbcJQuery("#" + settingsId).css("display", "block");
    }
    ;

    var selectNames = {
        'social_comment_article_settings': ['social_comment_article_view'],
        'social_comment_blog_settings': ['social_comment_frontpage_view', 'social_comment_category_view'],
        'social_like_article_settings': ['social_like_article_view'],
        'social_like_blog_settings': ['social_like_frontpage_view', 'social_like_category_view'],
        'social_k2_comment_item_settings': ['social_k2_comment_item_view'],
        'social_k2_comment_blog_settings': ['social_k2_comment_category_view', 'social_k2_comment_tag_view', 'social_k2_comment_userpage_view', 'social_k2_comment_latest_view'],
        'social_k2_like_item_settings': ['social_k2_like_item_view'],
        'social_k2_like_blog_settings': ['social_k2_like_category_view', 'social_k2_like_tag_view', 'social_k2_like_userpage_view', 'social_k2_like_latest_view']
    };

    jfbcJQuery(document).ready(function ()
    {
        jfbcJQuery.each(selectNames, function (settingsId, selectors)
        {
            jfbcJQuery.each(selectors, function (i, selector)
            {
                showHideSettings(settingsId, selectors);
                jfbcJQuery("select[name=" + selector + "]").change(function ()
                {
                    showHideSettings(settingsId, selectors);
                });
            });
        });
    });

</script>