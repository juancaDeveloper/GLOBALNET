<?php

/**
 * @Copyright Copyright (C) 2009-2010 Ahmad Bilal
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * Company:     Buruj Solutions
 + Contact:     https://www.burujsolutions.com , info@burujsolutions.com
 * Created on:  Nov 22, 2010
 ^
 + Project:     JS Jobs
 ^ 
 */
 
defined('_JEXEC') or die('Restricted access');
$commonpath = "index.php?option=com_jsjobs";
$pathway = $mainframe->getPathway();
if ($config['cur_location'] == 1) {
    switch ($layout) {
        case 'folder_resumes':
            $pathway->addItem(JText::_('My Folders'), $commonpath . '&c=folder&view=folder&layout=myfolders&Itemid=' . $itemid);
            $pathway->addItem(JText::_('My Folders Resumes'), '');
            break;
        case 'formfolder':
            if (isset($result[0])) {
                $pathway->addItem(JText::_('My Folders'), $commonpath . '&c=folder&view=folder&layout=myfolders&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Folders Info'), '');
            } else {
                $pathway->addItem(JText::_('Folders Info'), '');
            }
            break;
        case 'myfolders':
            $pathway->addItem(JText::_('My Folders'), '');
            break;
        case 'viewfolder':
            $pathway->addItem(JText::_('My Folders'), $commonpath . '&c=folder&view=folder&layout=myfolders&Itemid=' . $itemid);
            $pathway->addItem(JText::_('View Folder'), '');
            break;
    }
}
?>
