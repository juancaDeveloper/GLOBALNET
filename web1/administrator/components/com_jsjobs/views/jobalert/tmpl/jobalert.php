<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     http://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */

defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();
JFactory::getDocument()->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/responsivetable.js');
$status = array(
    '1' => JText::_('Approved'),
    '-1' => JText::_('Rejected'),
    '0' => JText::_('Pending Approval'),
    );
?>
<script language=Javascript>
    function confirmdeletejobalert(id, task) {
        if (confirm("<?php echo JText::_('Are You Sure?'); ?>") == true) {
            return listItemTask(id, task);
        } else
            return false;
    }
</script>


<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
       <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Job Alert'); ?></span></div>
       <form action="index.php" method="post" name="adminForm" id="adminForm">
           <div id="jsjobs_filter_wrapper">           
               <span class="jsjobs-filter"><input type="text" name="searchname" id="searchname" size="15" placeholder="<?php echo JText::_('Name'); ?>" value="<?php if (isset($this->lists['searchname'])) echo $this->lists['searchname']; ?>" class="text_area" onchange="document.adminForm.submit();" /></span>
               <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
               <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('searchname').value = '';this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
           </div>
            <?php if(!empty($this->items)){ ?>
          <table class="adminlist" id="js-table" border="0">
                    <thead>
                        <tr>
                            <th width="20">
                                <?php if (JVERSION < '3') { ?> 
                                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                                <?php } else { ?>
                                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
                                <?php } ?>
                            </th>
                            <th width="20%" class="title bold" ><?php echo JText::_('Name'); ?></th>
                            <th class="bold center" ><?php echo JText::_('Contact Email'); ?></th>
                            <th width="20%" class="title bold" ><?php echo JText::_('Job Category'); ?></th>
                            <th width="20%" class="title bold" ><?php echo JText::_('Subcategory'); ?></th>
                            <th class="bold center" ><?php echo JText::_('Status'); ?></th>
                            <th class="bold center" > <?php echo JText::_('Created'); ?></th>
                            <th class="bold" width="17"><?php echo JText::_('Unsubscribe'); ?></th>
                        </tr>
                    </thead><tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;

                    $jobalertdeletetask = 'unsubscribeJobAlertSetting';
                    $deleteimg = 'cross.png';
                    $Deletealt = JText::_('Delete');


                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=jobalert.editjobalert&cid[]=' . $row->id);
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td>
                                <?php echo $checked; ?>
                            </td>
                            <td class="title">
                                <a class="overflow_td" href="<?php echo $link; ?>">
                                    <?php echo $row->name; ?></a>
                            </td>
                            <td class="center">
                                <?php
                                echo $row->contactemail;
                                ?>
                            </td>
                            <td class="title">
                                <div class="overflow_td">
                                <?php echo $row->cat_title; ?>
                                </div>
                            </td>
                            <td class="title">
                                <div class="overflow_td">
                                <?php echo $row->title; ?>
                                </div>
                            </td>
                            <td class="center">
                                <?php
                                if ($row->status == 1)
                                    echo "<font color='green'>" . $status[$row->status] . "</font>";
                                else
                                    echo "<font color='red'>" . $status[$row->status] . "</font>";
                                ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?>
                            </td>
                            <td class="center">
                                <a href="javascript:void(0);" onclick=" return confirmdeletejobalert('cb<?php echo $i; ?>', 'jobalert.<?php echo $jobalertdeletetask; ?>');">
                                    <img src="components/com_jsjobs/include/images/<?php echo $deleteimg; ?>" width="16" height="16" border="0" alt="<?php echo $deletealt; ?>" /></a>
                            </td>
                        </tr>
                        <?php
                        $k = 1 - $k;
                    }
                    ?>
                    </tbody>
                </table>
                <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
<?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="c" value="jobalert" />
                <input type="hidden" name="view" value="jobalert" />
                <input type="hidden" name="layout" value="jobalert" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
            </form>
 
    </div>    
</div>
<div id="jsjobs-footer">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>
