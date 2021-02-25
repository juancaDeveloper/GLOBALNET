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
        case 'empmessages':
            $pathway->addItem(JText::_('Messages'), '');
            break;
        case 'send_message':
            if ($nav == 30) { // job_appliedapplications
                $pathway->addItem(JText::_('My Jobs'), $commonpath . '&c=job&view=job&layout=myjobs&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Job Applied Resume'), $commonpath . '&c=jobapply&view=jobapply&layout=job_appliedapplications&bd=' . $jobaliasid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Send Message'), '');
            } elseif ($nav == 12) { // job_job messages
                $pathway->addItem(JText::_('Messages'), $commonpath . '&c=message&view=message&layout=empmessages&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Job Messages'), $commonpath . '&c=message&view=message&layout=job_messages&bd==' . $jobaliasid . '&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Send Message'), '');
            } elseif ($nav == 11) { // js messages
                $pathway->addItem(JText::_('Messages'), $commonpath . '&c=message&view=message&layout=jsmessages&Itemid=' . $itemid);
                $pathway->addItem(JText::_('Send Message'), '');
            } else {
                $pathway->addItem(JText::_('Send Message'), '');
            }
            break;
        case 'job_messages':
            $pathway->addItem(JText::_('Messages'), $commonpath . '&c=message&view=message&layout=empmessages&Itemid=' . $itemid);
            $pathway->addItem(JText::_('Job Messages'), '');
            break;
        case 'jsmessages':
            $pathway->addItem(JText::_('Messages'), '');
            break;
    }
}
?>
