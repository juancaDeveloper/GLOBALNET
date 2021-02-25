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

jimport('joomla.application.component.controller');

class JSJobsControllerJobshortlist extends JSController {

    function __construct() {
        parent::__construct();
    }

    function jobaddtoshortlist() {
        $jobid = JRequest::getVar('jobid');
        if (!is_numeric($jobid)) {
            return false;
        }
        //COOKIES
        $shortlistarray = array();
        if (isset($_COOKIE['jsjobshortlistid'])){
            $shortlistarray = $_COOKIE['jsjobshortlistid'];
        }
        $src = JRequest::getVar('jobsrcid');
        $jobshortlist_model = $this->getmodel('jobshortlist');
        $shortlistdata = $jobshortlist_model->checkJobShortlist($jobid, $shortlistarray);
        if ($shortlistdata)
            $comments = $shortlistdata->comments;
        else
            $comments = "";
        if ($shortlistdata)
            $slid = $shortlistdata->id;
        else
            $slid = 0;
        $option = 'com_jsjobs';
        $return_value = "<div class='shortlist_box'>\n";
        $return_value .= "<div class='jsjobs_shortlist_box'>\n";
        $return_value .= "<label for='sendername' class='js-col-sm-6 contact_info_margin'><b>" . JText::_('Comments') . "</b></label>\n";
        $return_value .= "<div class='js-col-lg-12 js-col-md-12 '>\n";
        $return_value .= "<textarea name='comments' class='textarea_shortlist' id='comments_" . $jobid . "'>" . $comments . "</textarea>\n";
        $return_value .= "</div>\n</div\n>";
        $return_value .= "<div class='jsjobs_stars_wrapper'>\n";
        $return_value .= "<div class='jsjobs-starst-slist'>\n";
        $return_value .= "<label for='sendername' class='contact_info_margin'><b>" . JText::_('Rate') . "</b></label>\n";
        
        $percent = 0;
        if ($shortlistdata)
            $percent = $shortlistdata->rate * 20;
        else
            $percent = 0;
        $stars = '';
        $stars = '-small';
        $return_value .="
                        <div class=\"jsjobs-container" . $stars . "\">
                            <ul class=\"jsjobs-stars" . $stars . "\">
                                <li id=\"rating_" . $jobid . "\" class=\"current-rating\" style=\"width:" . (int) $percent . "%;\"></li>
                                <li><a anchor=\"anchor\" href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $jobid . "',1);\" title=\"" . JTEXT::_('Very Poor') . "\" class=\"one-star\">1</a></li>
                                <li><a anchor=\"anchor\" href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $jobid . "',2);\" title=\"" . JTEXT::_('Poor') . "\" class=\"two-stars\">2</a></li>
                                <li><a anchor=\"anchor\" href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $jobid . "',3);\" title=\"" . JTEXT::_('Regular') . "\" class=\"three-stars\">3</a></li>
                                <li><a anchor=\"anchor\" href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $jobid . "',4);\" title=\"" . JTEXT::_('Good') . "\" class=\"four-stars\">4</a></li>
                                <li><a anchor=\"anchor\" href=\"javascript:void(null)\" onclick=\"javascript:setrating('rating_" . $jobid . "',5);\" title=\"" . JTEXT::_('Very Good') . "\" class=\"five-stars\">5</a></li>
                            </ul>
                        </div>
                        ";
        $return_value .= "</div>\n";
        $return_value .= "</div>\n";
        $return_value .= "</div>    \n";
        $return_value .= "<div id='js_shortlist_main_wrapper'>";
        $return_value .= "</div>";
        $return_value .= "<div id='jsjobs-shortlist_btn_margin'><input type='button' rel=\"button\" class=\"js_job_shortlist_button\"class='button' onclick=\"javascript:saveJobShortlist($jobid, '$src', $slid);\" value='" . JText::_('Save') . "'/>";
        $return_value .= " <input type='button' rel=\"button\" id=\"jsjobs_button\" class='button js_job_shortlist_button' onclick=\"javascript:jobshortlistclose();\" value='" . JText::_('Close') . "'></div>\n";
        $return_value .= "</div>\n";


        echo $return_value;
        JFactory::getApplication()->close();
    }

    function jobshortlistsave() {
        $jobid = JRequest::getVar('jobid');
        if (!is_numeric($jobid)) {
            return false;
        }
        $user = JFactory::getUser();
        if (!$user->guest) {
            $data['uid'] = $user->id;
        }
        $comments = JRequest::getVar('comments');
        $slid = JRequest::getVar('slid');
        $rate = JRequest::getVar('rate');
        if ($slid !== '' && $slid !== 0)
            $data['id'] = $slid;
        else
            $data['id'] = $slid;
        $data['jobid'] = $jobid;
        $data['comments'] = $comments;
        $data['rate'] = $rate;
        $data['created'] = date('Y-m-d H:i:s');
        $data['status'] = 1;

        $jobshortlist_model = $this->getmodel('jobshortlist');
        $return = $jobshortlist_model->storeJobShortList($data);

        if ($return == 1) {
            $return_value = "<div class=\"js-col-lg-12 js-col-md-12 js-null-padding\">\n";
            $return_value .= "<div id=\"added_shortlist\">\n";
            $return_value .= "<span style=\"text-indent:10px;\"><b>" . JText::_('Job successfully mark as shortlisted') . "</b></span>\n";

            $return_value .= "</div>\n";
            $return_value .= "</div>\n";
            echo $return_value;
        } elseif ($return == 3) {
            $return_value = "<div class=\"js-col-lg-12 js-col-md-12 js-null-padding\">\n";
            $return_value .= "<div class=\"added_shortlist\">\n";
            $return_value .= "<span><b>" . JText::_('Your job shortlist limit is exceeded') . "</b></span>\n";
            $return_value .= "</div>\n";
            $return_value .= "</div>\n";
            echo $return_value;
        } elseif ($return == 4) {
            $return_value = "<div class=\"js-col-lg-12 js-col-md-12 js-null-padding\">\n";
            $return_value .= "<div id=\"added_shortlist\">\n";
            $return_value .= "<span><b>" . JText::_('Job already mark shortlisted') . "</b></span>\n";
            $return_value .= "</div>\n";
            $return_value .= "</div>\n";
            echo $return_value;
        } else {
            $return_value = "<div class=\"js-col-lg-12 js-col-md-12 js-null-padding\">\n";
            $return_value .= "<div class=\"added_shortlist\">\n";
            $return_value .= "<span><b>" . JText::_('Error in marking job as shortlist') . "</b></span>\n";
            $return_value .= "</div>\n";
            $return_value .= "</div>\n";
            echo $return_value;
        }
        JFactory::getApplication()->close();
    }

    function deletejobshortlist() {
        JRequest::checkToken('get') OR jexit('Invalid Token');
        $id = JRequest::getVar('id');
        $return_value = $this->getmodel('jobshortlist')->removeJobShortlist($id);
        if ($return_value == 1) {
            JSJOBSActionMessages::setMessage(DELETED, 'shortlistedjob','message');
        } else {
            JSJOBSActionMessages::setMessage(DELETE_ERROR, 'shortlistedjob','error');
        }
        $Itemid = JRequest::getVar('Itemid');
        $link = "index.php?option=com_jsjobs&c=jobshortlist&view=jobshortlist&layout=list_jobshortlist&Itemid=" . $Itemid;

        $this->setRedirect(JRoute::_($link , false));
    }

    function display($cachable = false, $urlparams = false) { // correct employer controller display function manually.
        $document = JFactory::getDocument();
        $viewName = JRequest::getVar('view', 'default');
        $layoutName = JRequest::getVar('layout', 'default');
        $viewType = $document->getType();
        $view = $this->getView($viewName, $viewType);
        $view->setLayout($layoutName);
        $view->display();
    }

}

?>
