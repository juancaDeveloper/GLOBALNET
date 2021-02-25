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

jimport('joomla.application.component.view');

class JSJobsViewRss extends JSView {

    /**
     * Displays a generic page
     * (for when there are no actions or selected registers)
     *
     * @param string $template  Optional name of the template to use
     */
    function display($tpl = NULL) {
        require_once(JPATH_COMPONENT . '/views/common.php');
        if ($layout == 'rssjobs') {
            $document->setTitle(JText::_('Subscribe For Jobs Feeds'));
            $result = $this->getJSModel('job')->getRssJobs($uid);
            $this->assignRef('result', $result);
        } elseif ($layout == 'rssresumes') {
            $document->setTitle(JText::_('Subscribe For Resumes Feeds'));
            $result = $this->getJSModel('resume')->getRssResumes();
            $this->assignRef('result', $result);
        }
        $config = $this->getJSModel('configurations')->getConfigByFor('rss');
        $this->assignRef('config', $config);
        $Itemid = JRequest::getVar('Itemid');
        $this->assignRef('Itemid', $Itemid);
        $this->assignRef('isjobsharing', $_client_auth_key);

        parent::display();
        $mainframe->close();
    }

}

?>
