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
$document = JFactory::getDocument();
if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'job') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php
if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    if (isset($this->job)) {//job summary table 
        //check which field is enabled or not
        require_once 'jobapply.php';
        $fieldarray = array();
        foreach ($this->fieldsordering as $field) {
            $fieldarray[$field->field] = $field->published;
        }
        $section_array = array();
        //requirement section
        if (
                (isset($fieldarray['heighesteducation']) && $fieldarray['heighesteducation'] == 1) ||
                (isset($fieldarray['experience']) && $fieldarray['experience'] == 1) ||
                (isset($fieldarray['workpermit']) && $fieldarray['workpermit'] == 1) ||
                (isset($fieldarray['requiredtravel']) && $fieldarray['requiredtravel'] == 1)
        )
            $section_array['requirement'] = 1;
        else
            $section_array['requirement'] = 0;
        ?>
        <div id="js_main_wrapper">
            <span class="js_controlpanel_section_title">
                <?php
                echo JText::_('Job Information');
                $days = $this->config['newdays'];
                $isnew = date("Y-m-d H:i:s", strtotime("-$days days"));
                if (isset($this->job)) {
                    if ($this->job->created > $isnew)
                        echo '<div class="js_job_new"><canvas class="newjob" width="20" height="20"></canvas>' . JText::_('New').'!' . '</div>';
                }
                ?>

            </span>
            <span class="js_job_title">
                <?php
                if (isset($this->job))
                    echo $this->job->title;
                ?>
            </span>
            <span class="js_controlpanel_section_title"><?php echo JText::_('Company Information'); ?></span>
            <div class="js_job_company_logo">
                <?php
                $common = $this->getJSModel('common');
                $logourl = $common->getCompanyLogo($this->job->companyid, $this->job->companylogo , $this->config);
                ?>
                <img class="js_job_company_logo" src="<?php echo $logourl; ?>" />
            </div>
            <div class="js_job_company_data">
                <?php if ($this->listjobconfig['lj_company'] == '1') { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Company'); ?></span>
                        <span class="js_job_data_value">
                            <?php
                            if (isset($_GET['cat']))
                                $jobcat = $_GET['cat'];
                            else
                                $jobcat = null;
                            (isset($navcompany) && $navcompany == 41) ? $navlink = "&nav=41" : $navlink = "";
                            $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($this->job->companyaliasid);
                            $link = 'index.php?option=com_jsjobs&c=company&view=company&layout=view_company' . $navlink . '&cd=' . $companyaliasid . '&cat=' . $this->job->jobcategory . '&Itemid=' . $this->Itemid;
                            ?>
                            <a class="js_job_company_anchor" href="<?php echo $link; ?>">
                                <?php echo $this->job->companyname; ?>
                            </a>
                        </span>
                    </div>
                <?php } ?>
                <?php if ($this->config['comp_show_url'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Website'); ?></span>
                        <span class="js_job_data_value">
                            <a class="js_job_company_anchor" href="<?php echo $this->job->companywebsite; ?>">
                                <?php echo $this->job->companywebsite; ?>
                            </a>
                        </span>
                    </div>
                <?php } ?>
                <?php if ($this->config['comp_name'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Contact Name'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->companycontactname; ?></span>
                    </div>
                <?php } ?>
                <?php if ($this->config['comp_email_address'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Contact Email'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->companycontactemail; ?></span>
                    </div>
                <?php } ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('Since'); ?></span>
                    <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->companysince, $this->config['date_format']); ?></span>
                </div>
            </div>
            <span class="js_controlpanel_section_title"><?php echo JText::_('Job Information'); ?></span>
            <?php if ($this->listjobconfig['lj_jobtype'] == '1') { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('Job Type'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->jobtypetitle; ?></span>
                </div>
            <?php } ?>
            <?php if (isset($fieldarray['duration']) && $fieldarray['duration'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('Duration'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->duration; ?></span>
                </div>
            <?php } ?>
            <?php if (isset($fieldarray['jobsalaryrange']) && $fieldarray['jobsalaryrange'] == 1) { ?>
                <?php if ($this->job->hidesalaryrange != 1) { // show salary ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Salary Range'); ?></span>
                        <span class="js_job_data_value">
                            <?php
                            $salary = $this->getJSModel('common')->getSalaryRangeView($this->job->symbol,$this->job->salaryfrom,$this->job->salaryto,$this->job->salarytype,$this->config['currency_align']);
                            echo $salary;
                            ?>
                        </span>
                    </div>
                <?php } ?>
            <?php } ?>
            <?php if (isset($fieldarray['department']) && $fieldarray['department'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_(' Department'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->departmentname; ?></span>
                </div>
            <?php } ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('Category'); ?></span>
                <span class="js_job_data_value"><?php echo $this->job->cat_title; ?></span>
            </div>
            <?php if (isset($fieldarray['subcategory']) && $fieldarray['subcategory'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('Sub Category'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->subcategory; ?></span>
                </div>
            <?php } ?>
            <?php if (isset($fieldarray['jobshift']) && $fieldarray['jobshift'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('Shift'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->shifttitle; ?></span>
                </div>
            <?php } ?>
            <?php
            foreach ($this->fieldsordering AS $field) {
                if ($field->published == 1 && is_numeric($field->field)) {
                    if ($this->isjobsharing != "") {
                        if (is_array($this->userfields)) {
                            for ($k = 0; $k < 15; $k++) {
                                $field_title = 'fieldtitle_' . $k;
                                $field_value = 'fieldvalue_' . $k;
                                echo '<div class="js_job_data_wrapper">
                                                    <span class="js_job_data_title">' . $this->userfields[$field_title] . '</span>
                                                    <span class="js_job_data_value">' . $this->userfields[$field_value] . '</span>
                                                </div>';
                            }
                        }
                    } else {
                        foreach ($this->userfields as $ufield) {
                            if ($ufield[0]->published == 1 && $ufield[0]->id == $field->field) {
                                $userfield = $ufield[0];
                                $i++;
                                echo '<div class="js_job_data_wrapper">
                                                    <span class="js_job_data_title">' . $userfield->title . '</span>
                                                    <span class="js_job_data_value">';
                                if ($userfield->type == "checkbox") {
                                    if (isset($ufield[1])) {
                                        $fvalue = $ufield[1]->data;
                                        $userdataid = $ufield[1]->id;
                                    } else {
                                        $fvalue = "";
                                        $userdataid = "";
                                    }
                                    if ($fvalue == '1')
                                        $fvalue = "True";
                                    else
                                        $fvalue = "false";
                                }elseif ($userfield->type == "select") {
                                    if (isset($ufield[2])) {
                                        $fvalue = $ufield[2]->fieldtitle;
                                        $userdataid = $ufield[2]->id;
                                    } else {
                                        $fvalue = "";
                                        $userdataid = "";
                                    }
                                } else {
                                    if (isset($ufield[1])) {
                                        $fvalue = $ufield[1]->data;
                                        $userdataid = $ufield[1]->id;
                                    } else {
                                        $fvalue = "";
                                        $userdataid = "";
                                    }
                                }
                                echo $fvalue . '</span>
                                                </div>';
                            }
                        }
                    }
                }
            }
            ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('Posted'); ?></span>
                <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->created, $this->config['date_format']); ?></span>
            </div>
            <?php if ($section_array['requirement'] == 1) { ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('Requirements'); ?></span>
                <?php
                if ($this->job->iseducationminimax == 1) {
                    if ($this->job->educationminimax == 1)
                        $title = JText::_('Minimum Education');
                    else
                        $title = JText::_('Maximum Education');
                    $educationtitle = $this->job->educationtitle;
                }else {
                    $title = JText::_('Education');
                    $educationtitle = $this->job->mineducationtitle . ' - ' . $this->job->maxeducationtitle;
                }
                ?>
                <?php if (isset($fieldarray['heighesteducation']) && $fieldarray['heighesteducation'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo $title; ?></span>
                        <span class="js_job_data_value"><?php echo $educationtitle; ?></span>
                    </div>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Degree Title'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->degreetitle; ?></span>
                    </div>
                <?php } ?>
                <?php
                if ($this->job->isexperienceminimax == 1) {
                    if ($this->job->experienceminimax == 1)
                        $title = JText::_('Minimum Experience');
                    else
                        $title = JText::_('Maximum Experience');
                    $experiencetitle = $this->job->experiencetitle;
                }else {
                    $title = JText::_('Experience');
                    $experiencetitle = $this->job->minexperiencetitle . ' - ' . $this->job->maxexperiencetitle;
                }
                if ($this->job->experiencetext)
                    $experiencetitle .= ' (' . $this->job->experiencetext . ')';
                ?>
                <?php if (isset($fieldarray['experience']) && $fieldarray['experience'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo $title; ?></span>
                        <span class="js_job_data_value"><?php echo $experiencetitle; ?></span>
                    </div>
                <?php } ?>
                <?php if (isset($fieldarray['workpermit']) && $fieldarray['workpermit'] == 1) { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Work Permit'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->workpermitcountry; ?></span>
                    </div>
                <?php } ?>
                <?php
                if (isset($fieldarray['requiredtravel']) && $fieldarray['requiredtravel'] == 1) {
                    switch ($this->job->requiredtravel) {
                        case 1: $requiredtraveltitle = JText::_('Not Required');
                            break;
                        case 2: $requiredtraveltitle = "25%";
                            break;
                        case 3: $requiredtraveltitle = "50%";
                            break;
                        case 4: $requiredtraveltitle = "75%";
                            break;
                        case 5: $requiredtraveltitle = "100%";
                            break;
                    }
                    ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Required Travel'); ?></span>
                        <span class="js_job_data_value"><?php echo $requiredtraveltitle; ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
            <span class="js_controlpanel_section_title"><?php echo JText::_('Job Status'); ?></span>
            <?php if (isset($fieldarray['jobstatus']) && $fieldarray['jobstatus'] == 1) { ?>
                <?php if ($this->listjobconfig['lj_jobstatus'] == '1') { ?>
                    <div class="js_job_data_wrapper">
                        <span class="js_job_data_title"><?php echo JText::_('Job Status'); ?></span>
                        <span class="js_job_data_value"><?php echo $this->job->jobstatustitle; ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('Start Publishing'); ?></span>
                <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->startpublishing, $this->config['date_format']); ?></span>
            </div>
            <?php if (isset($fieldarray['noofjobs']) && $fieldarray['noofjobs'] == 1) { ?>
                <div class="js_job_data_wrapper">
                    <span class="js_job_data_title"><?php echo JText::_('Number Of Jobs'); ?></span>
                    <span class="js_job_data_value"><?php echo $this->job->noofjobs; ?></span>
                </div>
            <?php } ?>
            <div class="js_job_data_wrapper">
                <span class="js_job_data_title"><?php echo JText::_('Stop Publishing'); ?></span>
                <span class="js_job_data_value"><?php echo JHtml::_('date', $this->job->stoppublishing, $this->config['date_format']); ?></span>
            </div>
            <span class="js_controlpanel_section_title"><?php echo JText::_('Location'); ?></span>            
            <?php if ($this->listjobconfig['lj_city'] == '1') { ?>
                <div class="js_job_full_width_data">
                    <?php if ($this->job->multicity != '') echo $this->job->multicity; ?>
                </div>
            <?php } ?>
            <?php if (isset($fieldarray['map']) && $fieldarray['map'] == 1) { ?>
                <div class="js_job_full_width_data">
                    <div id="map"><div id="map_container"></div></div>
                    <input type="hidden" id="longitude" name="longitude" value="<?php if (isset($this->job)) echo $this->job->longitude; ?>"/>
                    <input type="hidden" id="latitude" name="latitude" value="<?php if (isset($this->job)) echo $this->job->latitude; ?>"/>
                </div>
            <?php } ?>
            <?php if (isset($fieldarray['video']) && $fieldarray['video'] == 1) { ?>
                <?php if ($this->job->video) { ?>
                    <span class="js_controlpanel_section_title"><?php echo JText::_('Video'); ?></span>
                    <div class="js_job_full_width_data">
                        <iframe title="YouTube video player" width="480" height="390" 
                                src="http://www.youtube.com/embed/<?php echo $this->job->video; ?>" frameborder="0" allowfullscreen>
                        </iframe>
                    </div>
                <?php } ?>
            <?php } ?>
            <span class="js_controlpanel_section_title"><?php echo JText::_('Description'); ?></span>
            <div class="js_job_full_width_data"><?php echo $this->job->description; ?></div>
            <?php if (isset($fieldarray['agreement']) && $fieldarray['agreement'] == 1) { ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('Agreement'); ?></span>
                <div class="js_job_full_width_data"><?php echo $this->job->agreement; ?></div>
            <?php } ?>
            <?php if (isset($fieldarray['qualifications']) && $fieldarray['qualifications'] == 1) { ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('Qualifications'); ?></span>
                <div class="js_job_full_width_data"><?php echo $this->job->qualifications; ?></div>
            <?php } ?>
            <?php if (isset($fieldarray['prefferdskills']) && $fieldarray['prefferdskills'] == 1) { ?>
                <span class="js_controlpanel_section_title"><?php echo JText::_('Preferred Skills'); ?></span>
                <div class="js_job_full_width_data"><?php echo $this->job->prefferdskills; ?></div>
            <?php } ?>
            <div class="js_job_apply_button">
                <?php $link = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=job_apply&bd=' . $this->job->jobaliasid . '&Itemid=' . $this->Itemid; ?>
                <a class="js_job_button" data-jobapply="jobapply" data-jobid="<?php echo $this->job->jobaliasid; ?>" href="#" ><strong><?php echo JText::_('Apply Now'); ?></strong></a>		   
            </div>
            <div class="js_job_share_pannel">
                <?php if ($this->socailsharing['jobseeker_share_google_share'] == 1) { ?>
                    <a class="js_job_share_link" href="#" onclick="window.open('https://m.google.com/app/plus/x/?v=compose&content=' + location.href, 'gplusshare', 'width=450,height=300,left=' + (screen.availWidth / 2 - 225) + ',top=' + (screen.availHeight / 2 - 150) + '');
                            return false;"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_google.png"; ?>" alt="Share on Google+" /></a>
                   <?php
                   }
                   if ($this->socailsharing['jobseeker_share_friendfeed_share'] == 1) {
                       ?>
                    <a class="js_job_share_link" target="_blank" href="http://www.friendfeed.com/share?title=<?php echo $document->title; ?> - <?php echo JURI::current(); ?>" title="Share to FriendFeed"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_ff.png"; ?>" alt="Friend Feed" /></a>
                <?php
                }
                if ($this->socailsharing['jobseeker_share_blog_share'] == 1) {
                    ?>
                    <a class="js_job_share_link" href="#" onclick="window.open('http://www.blogger.com/blog_this.pyra?t&u=' + location.href + '&n=' + document.title, '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');
                            return false" title="BlogThis!"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_blog.png"; ?>" alt="Share on Blog" /></a>
                   <?php
                   }
                   if ($this->socailsharing['jobseeker_share_linkedin_share'] == 1) {
                       ?>
                    <a class="js_job_share_link" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo JURI::current(); ?>&title=<?php echo $document->title; ?>" title="Share to Linkedin"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_linkedin.png"; ?>" alt="Linkedid" /></a>
                <?php
                }
                if ($this->socailsharing['jobseeker_share_myspace_share'] == 1) {
                    ?>
                    <a class="js_job_share_link" target="_blank" href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php echo JURI::current(); ?>&t=<?php echo $document->title; ?>" title="Share to MySpace"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_myspace.png"; ?>" alt="MySpace" /></a>
                   <?php
                   }
                   if ($this->socailsharing['jobseeker_share_twiiter_share'] == 1) {
                       ?>
                    <a class="js_job_share_link" href="#" onclick="window.open('http://twitter.com/share?text=<?php echo $document->title; ?>&url=<?php echo JURI::current(); ?>', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');
                            return false" title="Share to Twitter"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_twitter.png"; ?>" alt="Twitter" /></a>
                <?php
                }
                if ($this->socailsharing['jobseeker_share_yahoo_share'] == 1) {
                    ?>
                    <a class="js_job_share_link" target="_blank" href="http://bookmarks.yahoo.com/toolbar/savebm?u=<?php echo JURI::current(); ?>&t=<?php echo $document->title; ?>" title="Save to Yahoo! Bookmarks"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_yahoo.png"; ?>" alt="Yahoo" /></a>
                   <?php
                   }
                   if ($this->socailsharing['jobseeker_share_digg_share'] == 1) {
                       ?>
                    <a class="js_job_share_link" href="#" onclick="window.open('http://digg.com/submit?url=' + location.href);
                            return false" title="Share to Digg" ><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_digg.png"; ?>" alt="Share on Digg" /></a>
                <?php
                }
                if ($this->socailsharing['jobseeker_share_fb_share'] == 1) {
                    ?>
                    <a class="js_job_share_link" href="#" onclick="window.open('<?php echo $protocol; ?>www.facebook.com/sharer.php?u=' + location.href + '&t=' + document.title, '_blank', 'scrollbars=0, resizable=1, menubar=0, left=200, top=200, width=550, height=440, toolbar=0, status=0');
                            return false"><img src="<?php echo JURI::root() . "components/com_jsjobs/themes/images/share_fb.png"; ?>" alt="Share on facebook" /></a>
        <?php } ?>
            </div>
            <div class="js_job_share_pannel" >
        <?php if ($this->socailsharing['jobseeker_share_fb_like'] == 1) { ?>
                    <div id="share_content">
                        <div id="fb-root"></div>
                        <script>
                            // Load the SDK Asynchronously
                            (function (d) {
                                var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                                if (d.getElementById(id)) {
                                    return;
                                }
                                js = d.createElement('script');
                                js.id = id;
                                js.async = true;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                ref.parentNode.insertBefore(js, ref);
                            }(document));
                        </script>
                        <div class="fb-like"></div>
                    </div>
            <?php
            }
            if ($this->socailsharing['jobseeker_share_google_like'] == 1) {
                ?>
                    <div id="share_content">
                        <script src="https://apis.google.com/js/plusone.js"></script>
                        <g:plus action="share" href="<?php echo JURI::current(); ?>"></g:plus>
                    </div>
            <?php } ?>
            </div>	
        <?php if ($this->socailsharing['jobseeker_share_fb_comments'] == 1) { ?>				
                <div id="js_job_fb_commentparent">
                    <span id="js_job_fb_commentheading"><?php echo JText::_('Facebook Comments'); ?></span>
                    <div id="jsjobs_fbcomment">
                        <iframe id="jobseeker_fb_comments" src="" scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:100%; height:400px;" allowTransparency="true"></iframe>
                        <script>//window.onload = function() {}</script>
                    </div>
                </div>
                    <?php } ?>
        </div>
    <?php } else {
            $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
        }
}//ol
?>
 </div>

<style type="text/css">
    div#map_container{ width:100%; height:350px; }
</style>
<script type="text/javascript" src="<?php echo $protocol; ?>maps.googleapis.com/maps/api/js?key=<?php echo $this->config['google_map_api_key']; ?>"></script>
<script type="text/javascript">
                window.onload = loadMap();
                function loadMap() {
                    var latedit = [];
                    var longedit = [];

                    var longitude = jQuery('#longitude').val();
                    var latitude = jQuery('#latitude').val();
                    if (typeof (longitude) != "undefined" && typeof (latitude) != "undefined") {
                        latedit = latitude.split(",");
                        longedit = longitude.split(",");
                        if (latedit != '' && longedit != '') {
                            for (var i = 0; i < latedit.length; i++) {
                                var latlng = new google.maps.LatLng(latedit[i], longedit[i]);
                                zoom = 4;
                                var myOptions = {
                                    zoom: zoom,
                                    center: latlng,
                                    scrollwheel: false,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };
                                if (i == 0)
                                    var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
                                /*var lastmarker = new google.maps.Marker({
                                 postiion:latlng,
                                 map:map,
                                 });*/
                                var marker = new google.maps.Marker({
                                    position: latlng,
                                    zoom: zoom,
                                    map: map,
                                    visible: true,
                                });
                                marker.setMap(map);
                            }
                        }

                    }

                }
                window.onload = function () {

                    if (document.getElementById('jobseeker_fb_comments') != null) {
                        var myFrame = document.getElementById('jobseeker_fb_comments');
                        if (myFrame != null)
                            myFrame.src = '<?php echo $protocol; ?>www.facebook.com/plugins/comments.php?href=' + location.href;
                    }
                    if (document.getElementById('employer_fb_comments') != null) {
                        var myFrame = document.getElementById('employer_fb_comments');
                        if (myFrame != null)
                            myFrame.src = '<?php echo $protocol; ?>www.facebook.com/plugins/comments.php?href=' + location.href;
                    }
                }
</script>
<?php
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
?>