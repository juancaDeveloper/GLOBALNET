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
    $link = JURI::root();
    $results = $this->result;

    echo '<rss version="2.0">';
    echo '<channel>';
    echo '<title>' . $this->config['rss_resume_title'] . '</title>';
    echo '<link>' . $link . '</link>';
    echo '<ttl>' . $this->config['rss_resume_ttl'] . '</ttl>';
    echo '<description>' . $this->config['rss_resume_description'] . '</description>';
    if ($this->config['rss_resume_copyright'] != '') {
        echo '<copyright>' . $this->config['rss_resume_copyright'] . '</copyright>';
    }
    if ($this->config['rss_resume_webmaster'] != '') {
        echo '<webmaster>' . $this->config['rss_resume_webmaster'] . '</webmaster>';
    }
    if ($this->config['rss_resume_editor'] != '') {
        echo '<editor>' . $this->config['rss_resume_editor'] . '</editor>';
    }
    foreach ($results AS $result) {
        if (!empty($result->application_title)) {
            $item = '<item><title>';
            $item .= htmlspecialchars($result->application_title) . '</title>';
            
            $genderText = '';
            if($result->gender == 1){
                $genderText = JText::_('Male');
            }elseif ($result->gender == 1) {
                $genderText = JText::_('Female');
            }elseif ($result->gender == 3) {
                $genderText = JText::_('Does not matter');
            }
            
            $gender = $genderText;
            
            $description = '';
            if ($this->config['rss_resume_image'] == 1) {
                if ($result->photo != '') {
                    $imagelink = $link . 'jsjobsdata/data/jobseeker/resume_' . $result->id . '/photo/' . $result->photo;
//                    $item .= '<image><url>' . htmlspecialchars($imagelink) . '</url>
//                                <title>Picture</title>
//                                <link>' . $link . '</link></image>';
                        $description = '<br/><img vspace="1" hspace="10" align="left" width="100px" src="'.htmlspecialchars($imagelink).'"/>';
                }
            }
            $description .= 'First Name:- ' . $result->first_name . '<br/>Last Name:- ' . $result->last_name . '<br/>Gender:- ' . $gender . '<br/>Highest Education:- ' . JText::_($result->education) . '<br/>Total Experience:- ' . $result->total_experience . '<br/>Email Address:- ' . $result->email_address;
            $item .= '<description><![CDATA[' . $description . ']]></description>';
            if ($this->config['rss_resume_categories'] == 1)
                $item .= '<category>' . JText::_($result->cat_title) . '</category>';
            if ($this->config['rss_resume_file'] == 1) {
                if (!empty($result->filename)) {
                    foreach($result->filename AS $file){
                        $filelink = $link . 'jsjobsdata/data/jobseeker/resume_' . $result->id . '/resume/' . $file->filename;
                        $item .= '<enclosure url="' . $filelink . '" length="' . $file->filesize . '" type="docs/' . $file->filetype . '"/>';
                    }
                }
                $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($result->resumealiasid);
                $itemlink = $link . 'index.php?option=com_jsjobs&amp;c=resume&amp;view=resume&amp;layout=view_resume&amp;nav=6&amp;rd=' . $resumealiasid;
                $item .= '<link>' . htmlspecialchars($itemlink) . '</link>';
            }
            $item .= '</item>';
            echo $item;
        }
    }
    echo '</channel>';
    echo '</rss>';
}
?>
