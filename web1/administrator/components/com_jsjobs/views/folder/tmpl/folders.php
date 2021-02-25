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

JFactory::getDocument()->addScript(JURI::root().'administrator/components/com_jsjobs/include/js/responsivetable.js');

$status = array(
    '1' => JText::_('Approved'),
    '-1' => JText::_('Rejected'));
?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Folders'); ?></span></div>
       <form action="index.php" method="post" name="adminForm" id="adminForm">
             <div id="jsjobs_filter_wrapper">
                        <span class="jsjobs-filter"><input type="text" name="searchname" placeholder="<?php echo JText::_('Name'); ?>" id="searchname" size="15" value="<?php if (isset($this->lists['searchname'])) echo $this->lists['searchname']; ?>"  /></span>
                        <span class="jsjobs-filter"><input type="text" name="searchempname" placeholder="<?php echo JText::_('Company Name'); ?>" id="searchempname" size="15" value="<?php if (isset($this->lists['searchempname'])) echo $this->lists['searchempname']; ?>"/></span>
                        <span class="jsjobs-filter"><?php echo $this->lists['searchstatus']; ?></span>
                        <span class="jsjobs-filter"><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
                        <span class="jsjobs-filter"><button class="js-button" onclick="document.getElementById('searchname').value = '';
                                document.getElementById('searchempname').value = '';
                                document.getElementById('searchstatus').value = '';
                                this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
                </div>
            <?php if(!empty($this->items)){ ?>
                <table class="adminlist" border="0" id="js-table">
                    <thead>
                        <tr>
                            <th width="20">
                                <?php if (JVERSION < '3') { ?> 
                                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                                <?php } else { ?>
                                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
                                <?php } ?>
                            </th>
                            <th class="title"><?php echo JText::_('Name'); ?></th>
                            <th class="title"><?php echo JText::_('Company'); ?></th>
                            <th class="center"><?php echo JText::_('Status'); ?></th>
                            <th class="center"><?php echo JText::_('Resume'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    jimport('joomla.filter.output');
                    $k = 0;


                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=folder.edit&cid[]=' . $row->id);
                        ?>
                        <tr valign="top" class="<?php echo "row$k"; ?>">
                            <td width="5%">
                                <?php echo $checked; ?>
                            </td>
                            <td width="10%" class="title">
                                <a href="<?php echo $link; ?>">
                                    <?php echo $row->name; ?></a>
                            </td>
                            <td class="title">
                                <?php echo $row->companyname; ?>
                            </td>
                            <td class="center">
                                <strong><?php
                                    if ($row->status == 1) {
                                        echo '<font color="green">' . JText::_('Approved') . '</font>';
                                    } else {
                                        echo '<font color="red">' . JText::_('Rejected') . '</font>';
                                    }
                                    ?></strong>
                            </td>
                            <?php
                                $noofresume = !empty($row->nor) ? $row->nor : 0;
                            ?>
                            <td class="center" >
                                    <?php $link = 'index.php?option=com_jsjobs&c=jsjobs&c=folderresume&view=folderresume&layout=folder_resumes&fd=' . $row->id; ?>
                                <a class="pageLink" href="<?php echo $link ?>"><?php echo JText::_('Resume');
                                echo ' (' . $noofresume . ')';
                                ?></a>
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
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="c" value="folder" />
                <input type="hidden" name="view" value="folder" />
                <input type="hidden" name="layout" value="folders" />
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



