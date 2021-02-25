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
if (isset($this->result) && $this->result != false) {
    header("Content-Type: application/xml; charset=utf-8", true);
    $results = $this->result;
    $jobs = $results[0];
    $link = JURI::root();
    $listconfig = $results[1];

    echo '<rss version="2.0">';
    echo '<channel>';
    echo '<title>' . $this->config['rss_job_title'] . '</title>';
    echo '<link>' . $link . '</link>';
    echo '<ttl>' . $this->config['rss_job_ttl'] . '</ttl>';
    echo '<description>' . $this->config['rss_job_description'] . '</description>';
    if ($this->config['rss_job_copyright'] != '') {
        echo '<copyright>' . $this->config['rss_job_copyright'] . '</copyright>';
    }
    if ($this->config['rss_job_webmaster'] != '') {
        echo '<webmaster>' . $this->config['rss_job_webmaster'] . '</webmaster>';
    }
    if ($this->config['rss_job_editor'] != '') {
        echo '<editor>' . $this->config['rss_job_editor'] . '</editor>';
    }
    foreach ($jobs AS $job) {
        $link = JURI::root();
        if (!empty($job->title)) {
            $item = '<item><title>';
            $item .= htmlspecialchars($job->title) . '</title>';
            $description = '';
            if ($listconfig['lj_company'] == 1){
                if ($this->config['rss_job_image'] == 1)
                    if ($job->logofilename != '' AND ! empty($job->logofilename)) {
                        $datadirectory = $this->getJSModel('configurations')->getConfigValue('data_directory');
                        $imagelink = $link . $datadirectory.'/data/employer/comp_' . $job->companyid . '/logo/' . $job->logofilename;
//                        $item .= '<image><url>' . htmlspecialchars($imagelink) . '</url>';
//                        $item .= '<title>' . $job->logofilename . '</title>';
//                        $item .= '<link>' . htmlspecialchars($itemlink) . '</link>';
//                        $item .= '</image>';
                        $description .= '<br/><img vspace="1" hspace="10" align="left" width="100px" src="'.htmlspecialchars($imagelink).'"/>';
                    }
                $description .= JText::_('Company') . ':- ' . $job->comp_title . '<br/>';
            }
            if ($listconfig['lj_category'] == 1)
                $description .= JText::_('Category') . ':- ' . JText::_($job->cat_title) . '<br/>';
            if ($listconfig['lj_jobtype'] == 1)
                $description .= JText::_('Job Type') . ':- ' . JText::_($job->jobtype) . '<br/>';
            if ($listconfig['lj_jobstatus'] == 1)
                $description .= JText::_('Job Status') . ':- ' . JText::_($job->jobstatus) . '<br/>';
            if ($listconfig['lj_noofjobs'] == 1)
                $description .= JText::_('Number Of Jobs') . ':- ' . $job->noofjobs . '<br/>';
            if (!empty($job->jobsalaryfrom) && !empty($job->jobsalaryto))
                if ($listconfig['lj_salary'] == 1){
                    $localconfig = $this->getJSModel('configurations')->getConfigValue('currency_align');
                    $description .= JText::_('Salary Range') . ':- ' . $this->getJSModel('common')->getSalaryRangeView($job->currency,$job->jobsalaryfrom,$job->jobsalaryto,$job->salarytype,$localconfig);
                }
            $item .= '<description><![CDATA[' . $description . ']]></description>';
            $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($job->jobaliasid);
            $itemlink = $link . 'index.php?option=com_jsjobs&c=job&view=job&layout=view_job&nav=15&bd=' . $jobaliasid . '&Itemid=' . $this->Itemid;
            if ($this->config['rss_job_categories'] == 1)
                $item .= '<category>' . $job->cat_title . '</category>';
            $item .= '<link>' . htmlspecialchars($itemlink) . '</link></item>';
            echo $item;
        }
    }
    echo '</channel>';
    echo '</rss>';
}
?>
