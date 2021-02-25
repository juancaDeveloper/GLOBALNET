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
    $suggested_jobs_text = JText::_('Newest Jobs');
    $userrole = $this->userrole;
    $config = $this->config;
    $jscontrolpanel = $this->jscontrolpanel;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor != '') {
            if ($userrole->rolefor == 2){ // job seeker
                $allowed = true;
                $suggested_jobs_text = JText::_('Suggested Jobs');
            }elseif ($userrole->rolefor == 1) { // employer
                if ($config['employerview_js_controlpanel'] == 1)
                    $allowed = true;
                else
                    $allowed = false;
            }
        }else {
            $allowed = true;
        }
    } else{
        if($config['visitorview_js_controlpanel'] == 1)
            $allowed = true; // user not logined
        else
            $allowed = false;
    }
    if ($allowed == true) {
        $message = '';
        if ($jscontrolpanel['jsexpire_package_message'] == 1) {
            if (!empty($this->packagedetail[0]->packageexpiredays)) {
                $days = $this->packagedetail[0]->packageexpiredays - $this->packagedetail[0]->packageexpireindays;
                if ($days == 1)
                    $days = $days . ' ' . JText::_('Day');
                else
                    $days = $days . ' ' . JText::_('Days');
                $message = "<strong><font color='red'>" . JText::_('Your Package') . ' &quot;' . $this->packagedetail[0]->packagetitle . '&quot; ' . JText::_('Has Expired') . ' ' . $days . ' ' . JText::_('Ago') . " <a href='index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=$this->Itemid'>" . JText::_('Job Seeker Packages') . "</a></font></strong>";
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
        <div id="jsjobs-main-wrapper">
            <span class="jsjobs-main-page-title"><?php echo JText::_('My Stuff'); ?></span>
             <div id="jsjobs-emp-cp-wrapper">
              <div class="jsjobs-cp-toprow-job-seeker">
               <?php
            $print = checkLinks('listnewestjobs', $userrole, $config, $jscontrolpanel);
            if ($print) {
                ?>
                <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color3" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs&Itemid=<?php echo $this->Itemid; ?>">
                        <img class="jsjobs-img-job-seeker" src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/jobs.png"> 
                        <span class="jsjobs-title-job-seeker"><?php echo JText::_('Newest Jobs'); ?></span>
                    </a>
                </div>
                <?php
            }
           $print = checkLinks('myappliedjobs', $userrole, $config, $jscontrolpanel);
           if ($print) {
                  ?>
                 <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color1" href="index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=<?php echo $this->Itemid; ?>">
                        <span class="jsjobs-img-job-seeker"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/applied-jobs.png"></span>
                        <span class="jsjobs-title-job-seeker"><?php echo JText::_('My Applied Job'); ?></span>
                    </a> 
                 </div>
                  <?php
           }
            $print = checkLinks('myresumes', $userrole, $config, $jscontrolpanel);
            if ($print) {
                ?>
                <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color2" href="index.php?option=com_jsjobs&c=jobapply&view=resume&layout=myresumes&Itemid=<?php echo $this->Itemid; ?>">
                        <img class="jsjobs-img-job-seeker" src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/add-resume.png"> 
                        <span class="jsjobs-title"><?php echo JText::_('My Resume'); ?></span>
                    </a>
                </div>
                 <?php
            }
            $print = checkLinks('jobsearch', $userrole, $config, $jscontrolpanel);
            if ($print) {
                ?>
                <div class="js-col-xs-12 js-col-md-4 js-menu-wrap-job-seeker">
                    <a class="menu_style-job-seeker color4" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobsearch&Itemid=<?php echo $this->Itemid; ?>">
                        <img class="jsjobs-img-job-seeker" src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/search-job.png"> 
                        <span class="jsjobs-title-job-seeker"><?php echo JText::_('Search Job'); ?></span>
                    </a>
                </div>
                <?php
             }
                ?>
              </div>
              <?php 
              $showjobsgraph = checkBlocks('jsactivejobs_graph', $userrole, $config, $jscontrolpanel);
              if($showjobsgraph) { 
                ?>
                <div class="jsjobs-jobseeker-cp-wrapper">
                   <div class="js-col-xs-12 js-col-md-12 js-cp-graph-area">
                      <span class="js-cp-graph-title"><?php echo JText::_('Active Jobs');?></span>
                      <div class="jsjobs-cp-graph-area">
                          <div id="curve_chart" class="js_jobseeker_chart"></div>
                      </div>
                   </div>
                </div>
                <?php
              } ?>
            <?php

                $showjobblock = checkBlocks('jsmystuff_area', $userrole, $config, $jscontrolpanel);
              if($showjobblock){ ?>
                <div class="jsjobs-cp-jobseeker-categories">
                 <div class="js-col-xs-12 js-col-md-12 jsjobs-cp-jobseeker-categories-btn">
                    <span class="js-cp-graph-title"><?php echo JText::_('Jobs');?></span>
                    <div class="js-col-xs-12 js-col-md-12 jsjobs-cp-jobseeker-category-btn">
                       <?php
                          $print = checkLinks('jobcat', $userrole, $config, $jscontrolpanel);
                          if ($print) {
                         ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=category&view=category&layout=jobcat&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/job-category.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job By Category'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                         $print = checkLinks('listjobbytype', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=job&view=job&layout=listjobtypes&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/job-type.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job By Types'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                         $print = checkLinks('listjobshortlist', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobshortlist&view=jobshortlist&layout=list_jobshortlist&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/short-listed-job.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Short Listed Jobs'); ?></span>
                          </a> 
                       </div>
                        <?php
                      }

                        $print = checkLinks('formresume', $userrole, $config, $jscontrolpanel);
                        if ($print) {
                            ?>
                           <div class="js-cp-jobseeker-icon">
                                <a class="menu_style-job-seeker color1" href="index.php?option=com_jsjobs&view=resume&layout=formresume&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/resume.png"></span>
                                    <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Add Resume'); ?></span>
                                </a>
                            </div>
                            <?php }
                         $print = checkLinks('listallcompanies', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?> 
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=company&view=company&layout=listallcompanies&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/companies.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('All Companies'); ?></span>
                          </a> 
                       </div> 
                        <?php
                         }
                          $print = checkLinks('jsmessages', $userrole, $config, $jscontrolpanel);
                          if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=message&view=message&layout=jsmessages&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/messages.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Messages'); ?></span>
                          </a> 
                       </div>
                       <?php
                         }
                         $print = checkLinks('my_jobsearches', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?> 
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobsearch&view=jobsearch&layout=my_jobsearches&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/search-job.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job Save Search'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                         $print = checkLinks('jobalertsetting', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?> 
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobalert&view=jobalert&layout=jobalertsetting&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/job-alert.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job Alert'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                          $print = checkLinks('mycoverletters', $userrole, $config, $jscontrolpanel);
                                               if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                                              <a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=mycoverletters&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/cover-letter.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('My Cover Letter'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                          $print = checkLinks('formcoverletter', $userrole, $config, $jscontrolpanel);
                          if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=coverletter&view=coverletter&layout=formcoverletter&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/add-coverletter.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Add Cover Letter'); ?></span>
                          </a> 
                       </div>
                       <?php
                        }
                         if (isset($userrole->rolefor) && $userrole->rolefor == 2) {//jobseeker
                           $link = "index.php?option=com_users&view=profile&Itemid=" . $this->Itemid;
                           $text = JText::_('Profile');
                           $icon = "profile.png";
                          } else {
                           $link = "index.php?option=com_jsjobs&c=common&view=common&layout=userregister&userrole=2&Itemid=" . $this->Itemid;
                           $text = JText::_('Register');
                           $icon = "register.png";
                         }
                         $print = checkLinks('jsregister', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                          ?> 
                         <div class="js-cp-jobseeker-icon">
                            <a href="<?php echo $link; ?>">
                                <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/<?php echo $icon; ?>"></span>
                                <span class="jsjobs-cp-jobseeker-title"><?php echo $text; ?></span>
                            </a> 
                         </div>
                        <?php
                          }
                         if ($jscontrolpanel['jobsloginlogout'] == 1) {
							$redirectUrl = JRoute::_('index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=controlpanel&Itemid=' . $this->Itemid ,false);
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
                         <div class="js-cp-jobseeker-icon">
                            <a href="<?php echo $link; ?>">
                                <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/<?php echo $icon; ?>"></span>
                                <span class="jsjobs-cp-jobseeker-title"><?php echo $text; ?></span>
                            </a> 
                         </div>
                       <?php } ?> 
                    </div>
                 </div>
              </div>
              <?php
              } ?>
              <div class="jsjobs-cp-jobseeker-suggested-applied-panel">
              <?php
                $showsuggestd_box = checkBlocks('jsnewestjobs_box', $userrole, $config, $jscontrolpanel);
              if($showsuggestd_box){ ?>
                <div class="js-col-xs-12 js-col-md-6 js-cp-suggested-jobs">
                     <div class="js-cp-resume-jobs">
                         <span class="js-cp-sugest-jobs-title"><?php echo $suggested_jobs_text;?></span>
                         <div class="js-col-xs-12 js-col-md-12 js-suggestedjobs-area">
                            <?php 
                            $suggested_jobs = $this->cp_data['suggested_jobs'];
                            $common = JSModel::getJSModel('common');
                            if(isset($suggested_jobs) AND (!empty($suggested_jobs))){
                              foreach ($suggested_jobs as $jobs) {
                                  $companyaliasid = JSModel::getJSModel('common')->removeSpecialCharacter($jobs->companyid);
                                  $link_viewcomp = "index.php?option=com_jsjobs&c=company&view=company&layout=view_company&nav=31&cd=" . $companyaliasid . "&Itemid=" . $this->Itemid;
                                  $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($jobs->jobaliasid);
                                  $link_viewjob = "index.php?option=com_jsjobs&c=job&view=job&layout=view_job&bd=".$jobaliasid."&Itemid=".$this->Itemid;
                                  $imgsrc = $common->getCompanyLogo($jobs->companyid, $jobs->logofilename , $this->config);
                                  
                                ?>
                                <div class="js-cp-jobs-sugest">
                                   <div class="js-cp-image-area">
                                    <a href="<?php echo $link_viewcomp;?>">
                                      <img class="js-cp-imge-user" src="<?php echo $imgsrc;?>">
                                    </a>
                                    </div>
                                   <div class="js-cp-content-area">
                                   <div class="js-cp-company-title">
                                   <a href="<?php echo $link_viewjob;?>">
                                     <?php echo $jobs->jobtitle;?>
                                   </a>
                                    <?php
                                    if($jobs->isgoldjob==1){
                                        echo '<span class="jsjobs-gold">'.JText::_('Gold').'</span>';
                                    }
                                    if($jobs->isfeaturedjob==1){
                                        echo '<span class="jsjobs-featured">'.JText::_('Featured').'</span>';
                                    }
                                    ?>

                                     </div>
                                   <div class="js-cp-company-location">
                                    <?php echo $jobs->location;?></div>
                                  </div>
                                </div>                              

                              <?php
                              }
                            }else{
                               $this->jsjobsmessages->getCPNoRecordFound();
                            }
                            ?>
                         </div>
                         <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs<?php echo $this->cp_data['suggested_jobs_criteria']; ?>&Itemid=<?php echo $this->Itemid; ?>"><span class="js-cp-sugest-jobs-show-more"><?php echo JText::_('Show More');?></span></a>
                     </div>
                  </div>
                  <?php
                  }
                  $showapplied_box = checkBlocks('jsappliedresume_box', $userrole, $config, $jscontrolpanel);

                  if($showapplied_box){  ?>
                    <div class="js-col-xs-12 js-col-md-6 js-cp-applied-resume">
                     <div class="js-cp-resume-jobs">
                         <span class="js-cp-applied-resume-title"><?php echo JText::_('Applied Resume');?></span>
                         <div class="js-col-xs-12 js-col-md-12 js-appliedresume-area">
                             <?php

                              $applied_resume = $this->cp_data['applied_resume'];

                              if(isset($applied_resume) AND (!empty($applied_resume))){ 
                                foreach ($applied_resume as $resume) {
                                  $jobaliasid = $this->getJSModel('common')->removeSpecialCharacter($resume->jobaliasid);
                                  $link_viewjob = "index.php?option=com_jsjobs&c=job&view=job&layout=view_job&bd=".$jobaliasid."&Itemid=".$this->Itemid;
                                  
                                  $imgsrc = JURI::root()."components/com_jsjobs/images/jobseeker.png";
                                  if (isset($resume->photo) && $resume->photo != "") {
                                      if ($this->isjobsharing) {
                                          $imgsrc = $resume->photo;
                                      } else {
                                          $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->appid . '/photo/' . $resume->photo;
                                      }
                                  }
                                  ?>
                                 <div id="jsjobs-appliedresume-seeker">
                                   <div class="jsjobs-cp-resume-applied">
                                       <div class="js-cp-image-area">
                                        <a href="">
                                          <img class="js-cp-imge-user" src="<?php echo $imgsrc;?>">
                                        </a>
                                       </div>
                                       <div class="js-cp-content-area">
                                           <div class="js-cp-company-title">
                                           <a href="<?php echo $link_viewjob;?>">
                                              <?php echo $resume->jobtitle; ?>
                                           </a>
                                            <?php
                                            if($resume->isgoldjob==1){
                                                echo '<span class="jsjobs-gold">'.JText::_('Gold').'</span>';
                                            }
                                            if($resume->isfeaturedjob==1){
                                                echo '<span class="jsjobs-featured">'.JText::_('Featured').'</span>';
                                            }
                                            ?>

                                           </div>
                                           <div class="js-cp-company-location">
                                              <?php echo $resume->application_title; ?>
                                           </div>
                                           <div class="js-cp-company-email">
                                             <span class="jsjobs-title"><?php echo JText::_('Email Address');?> : </span><span class="jsjobs-value"><?php echo $resume->email_address; ?></span>
                                           </div>
                                           <div class="js-cp-company-catagory">
                                             <span class="jsjobs-title"><?php echo JText::_('Category');?> :</span><span class="jsjobs-value"><?php echo JText::_($resume->cat_title); ?></span>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="jsjobs-cp-resume-applied-lower">
                                      <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span><span class="jsjobs-location"><?php echo $resume->location; ?></span>
                                      <span class="js-cp-pending">

                                      
                                          <?php 
                                          if ($this->config['show_applied_resume_status'] == 1) { 
                                              if ($resume->action_status == 4) { ?>
                                                  <img src="<?php echo JURI::root();?>components/com_jsjobs/images/pending-corner.png"> <span class="js-cp-jobs-wating"><?php echo JText::_('Rejected'); ?></span>
                                              <?php } elseif ($resume->action_status == 3) { ?>
                                                 <img src="<?php echo JURI::root();?>components/com_jsjobs/images/pending-corner.png">  <span class="js-cp-jobs-wating"><?php echo JText::_('Hired'); ?></span>
                                              <?php } elseif ($resume->action_status == 5) { ?>
                                                  <img src="<?php echo JURI::root();?>components/com_jsjobs/images/pending-corner.png"> <span class="js-cp-jobs-wating"><?php echo JText::_('Shortlist'); ?></span>
                                              <?php } elseif ($resume->action_status == 2) { ?>
                                                 <img src="<?php echo JURI::root();?>components/com_jsjobs/images/pending-corner.png">  <span class="js-cp-jobs-wating"><?php echo JText::_('Spam');  ?></span>
                                                  <?php
                                              }
                                          } ?>

                                      
                                      </span>
                                   </div>
                                  </div>
                                <?php
                                }

                              }else{
                                $this->jsjobsmessages->getCPNoRecordFound();
                              }?>
                         </div>
                         <?php $link_applied = 'index.php?option=com_jsjobs&c=jobapply&view=jobapply&layout=myappliedjobs&Itemid=' . $this->Itemid; ?>
                         <a href="<?php echo $link_applied;?>"><span class="js-cp-applied-resume-show-more"><?php echo JText::_('Show More');?></span></a>
                     </div>
                  </div>         
                  <?php
                }
                ?>
              </div>
            <?php 

              $showstatsblock = checkBlocks('jsmystats_area', $userrole, $config, $jscontrolpanel);
            if($showstatsblock){ ?>
                <div class="jsjobs-cp-jobseeker-stats">
                   <span class="js-col-xs-12 js-col-md-12 js-sample-title"><?php echo JText::_('Statistics');?></span>
                  <div class="js-col-xs-12 js-col-md-12 js-cp-jobseeker-stats">
                       <?php
                         $print = checkLinks('jsmy_stats', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                         ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobseeker&view=jobseeker&layout=my_stats&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/reports.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('My Stats'); ?></span>
                          </a> 
                       </div>
                        <?php
                         }
                         if ($config['job_rss'] == 1) {
                         $print = checkLinks('jsjob_rss', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?>
                       <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=rss&view=rss&layout=rssjobs&format=rss&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/rss.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Job RSS'); ?></span>
                          </a> 
                       </div>
                       <?php } }
                         $print = checkLinks('jspackages', $userrole, $config, $jscontrolpanel);
                         if ($print) {
                        ?>
                      <div class="js-cp-jobseeker-icon">
                          <a href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=packages&Itemid=<?php echo $this->Itemid; ?>">
                              <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/jobseeker/package.png"></span>
                              <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Packages'); ?></span>
                          </a> 
                       </div>
                       <?php
                         }
                        $print = checkLinks('jspurchasehistory', $userrole, $config, $jscontrolpanel);
                        if ($print) {
                            ?>
                            <div class="js-cp-jobseeker-icon">
                                <a href="index.php?option=com_jsjobs&c=purchasehistory&view=purchasehistory&layout=jobseekerpurchasehistory&Itemid=<?php echo $this->Itemid; ?>">
                                    <span class="jsjobs-cp-img-icon"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/controlpanel/employer/log-history.png"></span>
                                    <span class="jsjobs-cp-jobseeker-title"><?php echo JText::_('Purchase History'); ?></span>
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
    } else { // not allowed job posting 
        $this->jsjobsmessages->getAccessDeniedMsg('You are not allowed', 'You are not allowed to view Job Seeker control panel', 0);
    }
}//ol
?>
</div>
 
<?php

function checkBlocks($configname, $userrole, $config, $jscontrolpanel) {
    $print = false;
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 2) {
            if ($jscontrolpanel[$configname] == 1)
                $print = true;
        }elseif ($userrole->rolefor == 1) {
            if ($config['employerview_js_controlpanel'] == 1){
              $visname = 'vis_'.$configname;
                if ($jscontrolpanel[$visname] == 1){
                  $print = true;
                }
            }
        }
    }else {
        $configname = 'vis_'.$configname;
        if ($jscontrolpanel[$configname] == 1)
            $print = true;
    }
    return $print;  
}

function checkLinks($name, $userrole, $config, $jscontrolpanel) {
    $print = false;
    switch ($name) {
        case 'jspackages': $visname = 'vis_jspackages';
            break;
        case 'jspurchasehistory': $visname = 'vis_jspurchasehistory';
            break;
        case 'jsmy_stats': $visname = 'vis_jsmy_stats';
            break;
        case 'jsmessages': $visname = 'vis_jsmessages';
            break;
        case 'jsjob_rss': $visname = 'vis_job_rss';
            break;
        case 'jsregister': $visname = 'vis_jsregister';
            break;

        default:$visname = 'vis_js' . $name;
            break;
    }
    if (isset($userrole->rolefor)) {
        if ($userrole->rolefor == 2) {
            if ($name == 'jsjob_rss') {
                if ($config[$name] == 1)
                    $print = true;
            }elseif ($jscontrolpanel[$name] == 1)
                $print = true;
        }elseif ($userrole->rolefor == 1) {
            if ($config['employerview_js_controlpanel'] == 1)
                if ($config[$visname] == 1)
                    $print = true;
        }
    }else {
        if ($config[$visname] == 1)
            $print = true;
    }
    return $print;
}
?>
<script type="text/javascript" language="javascript">
    function setwidth() {
        var totalwidth = document.getElementById("cp_icon_row").offsetWidth;
        var width = totalwidth - 317;
        width = (width / 3) / 3;
        document.getElementById("cp_icon_row").style.marginLeft = width + "px";
        var totalicons = document.getElementsByName("cp_icon").length;
        for (var i = 0; i < totalicons; i++)
        {
            document.getElementsByName("cp_icon")[i].style.marginLeft = width + "px";
            document.getElementsByName("cp_icon")[i].style.marginRight = width + "px";
        }
    }
    //setwidth();
    function setwidthheadline() {
        var totalwidth = document.getElementById("tp_heading").offsetWidth;
        var textwidth = document.getElementById("tp_headingtext").offsetWidth;
        var width = totalwidth - textwidth;
        width = width / 2;
        document.getElementById("left_image").style.width = width + "px";
        document.getElementById("right_image").style.width = width + "px";
    }
    //setwidthheadline();
</script>


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
      google.setOnLoadCallback(drawChart);

    function drawChart() {
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
</script>
