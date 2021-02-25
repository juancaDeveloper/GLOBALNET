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
?>
<div id="js_jobs_main_wrapper">
<div id="js_menu_wrapper">
    <?php
    if (sizeof($this->jobseekerlinks) != 0) {
        foreach ($this->jobseekerlinks as $lnk) {
            ?>                     
            <a class="js_menu_link <?php if ($lnk[2] == 'controlpanel') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    if (sizeof($this->employerlinks) != 0) {
        foreach ($this->employerlinks as $lnk) {
            ?>
            <a class="js_menu_link <?php if ($lnk[2] == 'controlpanel') echo 'selected'; ?>" href="<?php echo $lnk[0]; ?>"><?php echo $lnk[1]; ?></a>
            <?php
        }
    }
    ?>
</div>
<?php

if ($this->config['offline'] == '1') {
    $this->jsjobsmessages->getSystemOfflineMsg($this->config);
} else {
    $line_chart_text = JText::_('Statistics');
    $userrole = $this->userrole;
    $config = $this->config;
    $emcontrolpanel = $this->emcontrolpanel;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 1){ // employer
            $allowed = true;
            $line_chart_text = JText::_('Jobs');
        }else
            $allowed = false;
    }else {
        if ($config['visitorview_emp_conrolpanel'] == 1)
            $allowed = true;
        else
            $allowed = false;
    } // user not logined
    if ($allowed == true) {
        ?>
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><?php echo JText::_('My Stuff'); ?></span>
            <div id="jsjobs-emp-cp-wrapper">
                <div class="jsjobs-cp-toprow">
                    <?php
                    $print = checkLinks('myjobs', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet js-mobile">
                            <a class="menu_style color2" href="index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/jobs.png"></span> 
                                <span class="jsjobs-title"><?php echo JText::_('My Jobs'); ?></span>
                            </a>
                        </div>
                    <?php
                    }
                    $print = checkLinks('formjob', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet">
                            <a class="menu_style color1" href="index.php?option=com_jsjobs&c=job&view=job&layout=formjob&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-job.png"></span>
                                <span class="jsjobs-title"><?php echo JText::_('New Job'); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    $print = checkLinks('resumesearch', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet">
                            <a class="menu_style color3" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumebycategory&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/categories.png"></span>
                                <span class="jsjobs-title"><?php echo JText::_('Resume By Category'); ?></span>
                            </a>
                        </div>
                        <?php
                    }
                    $print = checkLinks('resumesearch', $userrole, $config, $emcontrolpanel);
                    if ($print) {
                        ?>
                        <div class="js-col-xs-4 js-col-md-4 js-menu-wrap js-tablet">
                            <a class="menu_style color4" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resumesearch&Itemid=<?php echo $this->Itemid; ?>">
                                <span class="jsjobs-img"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/resme-search.png"></span>
                                <span class="jsjobs-title"><?php echo JText::_('Resume Search'); ?></span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="jsjobs-cp-graph-wrap">
                    <?php 
                    $showjobgraph = checkBlocks('jobs_graph', $userrole, $emcontrolpanel);
                    if($showjobgraph){ ?>
                        <div class="js-col-xs-12 js-col-md-6 js-graph-left">
                            <div class="jsjobs-graph-wrp">
                                <span class="jsjobs-graph-title">
                                    <span class="jsjobs-title">
                                        <?php echo $line_chart_text; ?>
                                    </span>
                                </span>
                                <div id="curve_chart" class="js_emp_chart1">
                                    <div id="no_message" class="linechart"><?php echo JText::_('No data'); ?></div>
                                </div>
                            </div>
                        </div> 
                        <?php
                    } ?>
                    <?php 
                        $showresumegraph = checkBlocks('resume_graph', $userrole, $emcontrolpanel);
                    if($showresumegraph){ ?>
                        <div class="js-col-xs-12 js-col-md-6 js-graph-right">
                            <div class="jsjobs-graph-wrp">
                                <span class="jsjobs-graph-title">
                                    <span class="jsjobs-title">
                                        <?php echo JText::_('Applied Resume'); ?>    
                                    </span>
                                </span>
                                <div id="js_donut_chart" class="js_emp_chart2">
                                    <div id="no_message" class="donut_chart"><?php echo JText::_('No data'); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php 
                    }  ?>
                </div>
                <?php 
                
                $showjobblock = checkBlocks('mystuff_area', $userrole, $emcontrolpanel);
                if($showjobblock){
                ?>
                <div class="jsjobs-cp-adding-section">
                    <span class="js-col-xs-12 js-col-md-12 js-sample-title"><?php echo JText::_('My Stuff'); ?></span>
                    <div class="js-col-xs-12 js-col-md-12 js-adding-btn">
                        <?php
                        $print = checkLinks('mycompanies', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=company&view=company&layout=mycompanies&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/companies.png"> </span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('My Companies'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('formcompany', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=company&view=company&layout=formcompany&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-company.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('New Company'); ?></span>
                                </a>
                            </div>
                        <?php
                        }
                        $print = checkLinks('mydepartment', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=department&view=department&layout=mydepartments&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/department.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('My Departments'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('formdepartment', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=department&view=department&layout=formdepartment&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-departmnet.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('New Department'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('myfolders', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=folder&view=folder&layout=myfolders&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/folder.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('My Folders'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('newfolders', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=folder&view=folder&layout=formfolder&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/add-folder.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('New Folder'); ?></span>
                                </a>
                            </div>
                            <?php
                        }
                        $print = checkLinks('empmessages', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=message&view=message&layout=empmessages&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/messages.png"></span>
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('Messages'); ?></span>
                                </a>
                            </div>
                        <?php }
                        $print = checkLinks('my_resumesearches', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=my_resumesearches&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-new-company-icon"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/save-resume.png"></span> 
                                    <span class="jsjobs-new-company-title"><?php echo JText::_('Resume Save Search'); ?></span>
                                </a>
                            </div>
                        <?php } ?>
                        <?php
                        if (isset($userrole->rolefor) && $userrole->rolefor == 1) {//jobseeker
                            $link = "index.php?option=com_users&view=profile&Itemid=" . $this->Itemid;
                            $text = JText::_('Profile');
                            $icon = "profile.png";
                        } else {
                            $link = "index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=3&Itemid=" . $this->Itemid;
                            $text = JText::_('Register');
                            $icon = "register.png";
                        }
                        $print = checkLinks('empregister', $userrole, $config, $emcontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-employer-icon">
                                <a href="<?php echo $link; ?>">
                                    <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/<?php echo $icon; ?>"></span>
                                    <span class="jsjobs-new-company-title"><?php echo $text; ?></span>
                                </a>
                            </div>
                        <?php
                        }
                    if ($emcontrolpanel['emploginlogout'] == 1) {
						$redirectUrl = JRoute::_('index.php?option=com_jsjobs&c=employer&view=employer&layout=controlpanel&Itemid=' . $this->Itemid ,false);
						if (isset($userrole->rolefor)) {//jobseeker
							$redirect = base64_encode($redirectUrl);
							$link = "index.php?option=com_jsjobs&task=jsjobs.logout&return=".$redirect."&Itemid=" . $this->Itemid;
							$text = JText::_('Logout');
							$icon = "login.png";
						} else {
							$redirectUrl = '&amp;return=' . base64_encode($redirectUrl);
							$link = 'index.php?option=com_users&view=login' . $redirectUrl;
							$text = JText::_('Login');
							$icon = "login.png";
						}                        
                        ?>
                        <div class="js-cp-employer-icon">
                            <a href="<?php echo $link; ?>">
                                <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/<?php echo $icon; ?>"></span>
                                <span class="jsjobs-new-company-title"><?php echo $text; ?></span>
                            </a>
                        </div> 
                    <?php
                    } ?>

                    </div> 
                </div>
                <?php

                }

                ?>

                <div class="jsjobs-jobs-resume-panel">
                <?php
                    $shownewestresume_box = checkBlocks('box_newestresume', $userrole, $emcontrolpanel);
                if($shownewestresume_box){ 
                    ?>
                    <div class="js-col-xs-12 js-col-md-6 js-cp-applied-resume">
                        <div class="js-cp-wrap-resume-jobs">
                            <span class="js-cp-applied-resume-title1"><?php echo JText::_('Newest Resume');?></span>
                            <div class="js-col-xs-12 js-col-md-12 js-cp-resume-wrap">
                                <?php 
                                $resumes = $this->cp_data['newest_resume'];
                                 if(isset($resumes) AND (!empty($resumes))){ 
                                //echo('<pre>'); print_r($resumes); echo "</pre>";
                                foreach ($resumes as $resume) { 
                                    $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                                    $link_viewresume = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd='. $resumealiasid . '&Itemid=' . $this->Itemid;
                                    $imgsrc = JURI::root()."components/com_jsjobs/images/jobseeker.png";
                                    if (isset($resume->photo) && $resume->photo != "") {
                                        if ($this->isjobsharing) {
                                            $imgsrc = $resume->photo;
                                        } else {
                                            $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->appid . '/photo/' . $resume->photo;
                                        }
                                    }
                                    ?>
                                    <div id="jsjsjobs-row_wrapper">
                                        <div class="js-cp-applied-resume">
                                            <a class="img-anchor" href="<?php echo $link_viewresume;?>">
                                            <div class="js-cp-image-area">
                                                <img class="js-cp-imge-user" src="<?php echo $imgsrc;?>">
                                            </div>
                                            </a>
                                            <div class="js-cp-content-area">
                                                <div class="js-cp-company-title">
                                                    <a href="<?php echo $link_viewresume;?>"><?php echo $resume->first_name.' '.$resume->last_name; ?></a>
                                                    <?php
                                                    if($resume->isgoldresume==1 AND $resume->endgolddate > date('Y-m-d')){
                                                        echo '<span class="jsjobs-gold">'.JText::_('Gold').'</span>';
                                                    }
                                                    if($resume->isfeaturedresume==1 AND $resume->endfeaturedate > date('Y-m-d')){
                                                        echo '<span class="jsjobs-featured">'.JText::_('Featured').'</span>';
                                                    }
                                                    ?>
                                                </div>
                                                <div class="js-cp-company-location">
                                                    <?php echo $resume->application_title; ?>
                                                </div>
                                                <div class="js-cp-company-email-address">
                                                    <span class="jsjobs-title"><?php echo JText::_('Experience');?> : </span><span class="jsjobs-value"><?php echo htmlspecialchars($resume->experience_title);?></span>
                                                </div>
                                                <div class="js-cp-company-category">
                                                    <span class="jsjobs-title"><?php echo JText::_('Category');?> : </span><span class="jsjobs-value"><?php echo htmlspecialchars($resume->cat_title); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="js-cp-applied-resume-lower">
                                            <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span><span class="jsjobs-loction"><?php echo htmlspecialchars($resume->location); ?></span>
                                        </div>
                                    </div>
                                    <?php
                                } }else{
                                        $this->jsjobsmessages->getCPNoRecordFound();
                                    }     
                                ?>
                            </div>
                            <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=resume_searchresults&jsfrom=cpbox&Itemid=<?php echo $this->Itemid;?>"><span class="js-cp-applied-resume-show-more2"><?php echo JText::_('Show More'); ?></span></a>
                        </div>
                    </div>
                        <?php
                    }
                    $showappliedresume_box = checkBlocks('box_appliedresume', $userrole, $emcontrolpanel);
                    if($showappliedresume_box){
                        ?>
                        <div class="js-col-xs-12 js-col-md-6 js-cp-applied-resume">
                            <div class="js-cp-wrap-resume-jobs">
                                <span class="js-cp-applied-resume-title2"><?php echo JText::_('Applied Resume');?></span>
                                <div class="js-col-xs-12 js-col-md-12 js-cp-resume-wrap">
                                    <?php
                                     $resumes = $this->cp_data['applied_resume']; 
                                    if(isset($resumes) AND (!empty($resumes))){ 
                                    //echo('<pre>'); print_r($resumes); echo "</pre>";
                                    foreach ($resumes as $resume) { 
                                        $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                                        $link_viewresume = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&rd='. $resumealiasid . '&Itemid=' . $this->Itemid;
                                        $imgsrc = JURI::root()."components/com_jsjobs/images/jobseeker.png";
                                        if (isset($resume->photo) && $resume->photo != "") {
                                            if ($this->isjobsharing) {
                                                $imgsrc = $resume->photo;
                                            } else {
                                                $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->appid . '/photo/' . $resume->photo;
                                            }
                                        }
                                        ?>
                                        <div id="jsjsjobs-row_wrapper">
                                            <div class="js-cp-applied-resume">
                                                <a class="img-anchorr" href="<?php echo $link_viewresume;?>">
                                                <div class="js-cp-image-area">
                                                    <img class="js-cp-imge-user" src="<?php echo $imgsrc; ?>">
                                                </div>
                                            </a>
                                            <div class="js-cp-content-area">
                                                <div class="js-cp-company-title">
                                                   <a href="<?php echo $link_viewresume;?>"> <?php echo $resume->first_name.' '.$resume->last_name; ?></a>
                                                    <?php
                                                    if($resume->isgoldresume==1 AND $resume->endgolddate > date('Y-m-d')){
                                                        echo '<span class="jsjobs-gold">'.JText::_('Gold').'</span>';
                                                    }
                                                    if($resume->isfeaturedresume==1 AND $resume->endfeaturedate > date('Y-m-d')){
                                                        echo '<span class="jsjobs-featured">'.JText::_('Featured').'</span>';
                                                    }
                                                    ?>                                                   
                                                </div>
                                                <div class="js-cp-company-location">
                                                    <?php echo $resume->application_title; echo " (".JText::_('Job').": ".$resume->jobtitle.")"; ?>
                                                </div>
                                                <div class="js-cp-company-email-address">
                                                    <span class="jsjobs-title"><?php echo JText::_('Experience');?> : </span><span class="jsjobs-value"><?php echo htmlspecialchars($resume->experience_title);?></span>
                                                </div>
                                                <div class="js-cp-company-category">
                                                    <span class="jsjobs-title"><?php echo JText::_('Category');?> : </span><span class="jsjobs-value"><?php echo htmlspecialchars($resume->cat_title); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="js-cp-applied-resume-lower">
                                            <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span><span class="jsjobs-loction"><?php echo htmlspecialchars($resume->location); ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    }else{
                                        $this->jsjobsmessages->getCPNoRecordFound();
                                    } 
                                ?>
                            </div>
                            <?php $link_applied = 'index.php?option=com_jsjobs&c=job&view=job&layout=myjobs&Itemid=' . $this->Itemid; ?>
                            <a href="<?php echo $link_applied;?>"><span class="js-cp-applied-resume-show-more1"><?php echo JText::_("Show More")?></span></a>
                        </div>
                    </div>
                    <?php
                } ?>
                </div>

                <?php 
                $showstatsblock = checkBlocks('mystats_area', $userrole, $emcontrolpanel);
                if($showstatsblock){ ?>
                    <div class="js-cp-stats-panel">
                        <span class="js-col-xs-12 js-col-md-12 js-sample-title"><?php echo JText::_('Statistics');?></span>
                        <div class="js-col-xs-12 js-col-md-12 js-adding-btn">
                            <?php
                            $print = checkLinks('my_stats', $userrole, $config, $emcontrolpanel);
                            if ($print) {
                                ?>
                                <div class="js-cp-employer-icon">
                                    <a href="index.php?option=com_jsjobs&c=employer&view=employer&layout=my_stats&Itemid=<?php echo $this->Itemid; ?>">
                                        <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/Stats.png"></span>
                                        <span class="jsjobs-new-company-title"><?php echo JText::_('My Stats'); ?></span>
                                    </a>
                                </div>
                            <?php }
                            ?>
                            <?php
                            if ($config['resume_rss'] == 1) {
                                $print = checkLinks('empresume_rss', $userrole, $config, $emcontrolpanel);
                                if ($print) {
                                    ?>
                                    <div class="js-cp-employer-icon">
                                        <a href="index.php?option=com_jsjobs&c=rss&view=rss&layout=rssresumes&format=rss&Itemid=<?php echo $this->Itemid; ?>">
                                            <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/rss.png"></span>
                                            <span class="jsjobs-new-company-title"><?php echo JText::_('Resume RSS'); ?></span>
                                        </a>
                                    </div>
                                    <?php
                                }
                            }
                            $print = checkLinks('packages', $userrole, $config, $emcontrolpanel);
                            if ($print) {
                                ?>
                                <div class="js-cp-employer-icon">
                                    <a href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=packages&Itemid=<?php echo $this->Itemid; ?>">
                                        <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/package.png"></span>
                                        <span class="jsjobs-new-company-title"><?php echo JText::_('Packages'); ?></span>
                                    </a>
                                </div>
                            <?php
                            }
                            $print = checkLinks('purchasehistory', $userrole, $config, $emcontrolpanel);
                            if ($print) {
                                ?>
                                <div class="js-cp-employer-icon">
                                    <a href="index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout=employerpurchasehistory&Itemid=<?php echo $this->Itemid; ?>">
                                        <span class="jsjobs-new-company-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/log-history.png"></span>
                                        <span class="jsjobs-new-company-title"><?php echo JText::_('Purchase History'); ?></span>
                                    </a>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <?php

        if ($emcontrolpanel['empexpire_package_message'] == 1) {
            $message = '';
            if (!empty($this->packagedetail[0]->packageexpiredays)) {
                $days = $this->packagedetail[0]->packageexpiredays - $this->packagedetail[0]->packageexpireindays;
                if ($days == 1)
                    $days = $days . ' ' . JText::_('Day');
                else
                    $days = $days . ' ' . JText::_('Days');
                $message = "<strong><font color='red'>" . JText::_('Your Package') . ' &quot;' . $this->packagedetail[0]->packagetitle . '&quot; ' . JText::_('Has Expired') . ' ' . $days . ' ' . JText::_('Ago') . ' <a href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=$this->Itemid">' . JText::_('Employer Packages') . "</a></font></strong>";
            }
            if ($message != '') {
                ?>
                <div id="errormessage" class="errormessage">
                    <div id="message"><?php echo $message; ?></div>
                </div>
                <?php
            }
        }
        ?>
        <?php
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view employer control panel', 0);
    }
}
?>
</div>
<?php

function checkBlocks($configname, $userrole, $emcontrolpanel) {
    $print = false;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 1) {
            if ($emcontrolpanel[$configname] == 1)
                $print = true;
        }
    }else {
        $configname = 'vis_'.$configname;
        if ($emcontrolpanel[$configname] == 1)
            $print = true;
    }
    return $print;
}

function checkLinks($name, $userrole, $config, $emcontrolpanel) {
    $print = false;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 1) {
            if ($name == 'empresume_rss') {
                if ($config[$name] == 1)
                    $print = true;
            }elseif ($emcontrolpanel[$name] == 1)
                $print = true;
        }
    }else {
        if ($name == 'empmessages')
            $name = 'vis_emmessages';
        elseif ($name == 'empresume_rss')
            $name = 'vis_resume_rss';
        else
            $name = 'vis_em' . $name;

        if ($config[$name] == 1)
            $print = true;
    }
    return $print;
}
?>





<script type="text/javascript" 
            src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }">
</script>

<script type="text/javascript">
    <?php if($this->cp_data['line_chart']['line_chart_horizontal']['title'] != null){ ?>
            google.setOnLoadCallback(drawChart1);
            jQuery('div#no_message.linechart').show();
    <?php } ?>
    
    function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          <?php
          $line_chart = $this->cp_data['line_chart'];
            echo $line_chart['line_chart_horizontal']['title'].',';
            echo $line_chart['line_chart_horizontal']['data'];
        ?>
        ]);

        var options = {
          title: '<?php echo $line_chart["graph"]["title"];?>'
          ,pointSize: 6
          ,colors:['#1EADD8','#179650','#D98E11','#DB624C','#5F3BBB']
          ,curveType: 'function'
          ,legend: { position: 'bottom' }
          ,focusTarget: 'category'
          ,chartArea: {width:'90%',top:50}
          ,vAxis: { format: '0'}
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
    <?php if(!empty($this->cp_data['pie_chart']['pie_chart_horizontal']['data'])){ ?>
    google.setOnLoadCallback(drawChart2);
    <?php } ?>

    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
            ['<?php echo JText::_("Applied Resume"); ?>', '<?php echo JText::_("Applied resume by experiences"); ?>'],
            <?php
                if(isset($this->cp_data['pie_chart']) && !empty($this->cp_data['pie_chart'])){
                    $pie_chart = $this->cp_data['pie_chart'];
                    echo $pie_chart['pie_chart_horizontal']['data'];
                }
                ?>
                    ]);
        var options = {
            title: "<?php if(isset($this->cp_data['pie_chart']) && !empty($this->cp_data['pie_chart'])) echo $pie_chart["pie_chart_horizontal"]["title"];?>",
            pieHole: 0.4,
            legend: { position: 'bottom' }
        };
        var chart = new google.visualization.PieChart(document.getElementById('js_donut_chart'));
        chart.draw(data, options);
    }
</script>
