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

?>
<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['corechart']}]}"></script>
<script type="text/javascript">
    google.setOnLoadCallback(drawStackChartHorizontal);
    function drawStackChartHorizontal() {
      var data = google.visualization.arrayToDataTable([
        <?php
            echo $this->jobs_cp_data['stack_chart_horizontal']['title'].',';
            echo $this->jobs_cp_data['stack_chart_horizontal']['data'];
        ?>
      ]);

      var view = new google.visualization.DataView(data);

      var options = {
          curveType: 'function',
        height:300,
        legend: { position: 'top', maxLines: 3 },
        pointSize: 4,
        isStacked: true,
        focusTarget: 'category',
        chartArea: {width:'90%',top:50}
      };
      var chart = new google.visualization.LineChart(document.getElementById("stack_chart_horizontal"));
      chart.draw(view, options);
    }
</script>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
       <div class="dashboard">
            <span class="heading-dashboard"><?php echo JText::_('Dashboard'); ?></span>
            <span class="dashboard-icon">
                <?php
                $url = 'http://www.joomsky.com/appsys/latestversion.php?prod=joomla-jobs';
                $pvalue = "dt=".date('Y-m-d');
                if (in_array('curl', get_loaded_extensions())) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 8);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $pvalue);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
                    $curl_errno = curl_errno($ch);
                    $curl_error = curl_error($ch);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    if ($result == str_replace('.', '', $this->config['version'])) {
                        $image = "components/com_jsjobs/include/images/up-dated.png";
                        $lang = JText::_('Your system is up to date');
                        $class="green";
                    } elseif ($result) {
                        $image = "components/com_jsjobs/include/images/new-version.png";
                        $lang = JText::_('New version is available');
                        $class="orange";
                    } else {
                        $image = "components/com_jsjobs/include/images/connection-error.png";
                        $lang = JText::_('Unable connect to server');
                        $class="red";
                    }
                } else {
                    $image = "components/com_jsjobs/include/images/connection-error.png";
                    $lang = JText::_('Unable connect to server');
                }
                ?>
            <span class="download <?php echo $class; ?>">
                <img src="<?php echo $image; ?>" />
                <span><?php echo $lang; ?></span>
            </span>
            </span>
        </div>
        <div id="jsjobs-admin-wrapper">
            <div class="count1">
                <div class="box">
                    <img class="job" src="components/com_jsjobs/include/images/icon/job.png">
                    <div class="text">
                        <div class="bold-text"><?php echo $this->jobs_cp_data['jobs']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Jobs'); ?></div>   
                    </div>
                </div>
                <div class="box">
                    <img class="company" src="components/com_jsjobs/include/images/icon/companies.png">
                    <div class="text">
                        <div class="bold-text"><?php echo $this->jobs_cp_data['companies']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Companies'); ?></div>   
                    </div>
                </div>
                <div class="box">
                    <img class="resume" src="components/com_jsjobs/include/images/icon/reume.png">
                    <div class="text">
                        <div class="bold-text"><?php echo $this->jobs_cp_data['resumes']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Resumes'); ?></div>
                    </div>
                </div>
                <div class="box">
                    <img class="activejobs" src="components/com_jsjobs/include/images/icon/active-jobs.png">
                    <div class="text">
                        <div class="bold-text"><?php echo $this->jobs_cp_data['activejobs']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Active Jobs'); ?></div>    
                    </div>               
                </div>
                <div class="box1">
                    <img class="appliedresume" src="components/com_jsjobs/include/images/icon/job-applied.png">
                    <div class="text">
                        <div class="bold-text"><?php echo $this->jobs_cp_data['appliedjobs']; ?></div>
                        <div class="nonbold-text"><?php echo JText::_('Applied Resumes'); ?></div>
                    </div>    
                </div>
            </div>
            <div class="newestjobs">
                <span class="header">
                    <img src="components/com_jsjobs/include/images/newesticon.png">
                    <span><?php echo JText::_('Statistics'); ?>&nbsp;(<?php echo JHtml::_('date', $this->jobs_cp_data['fromdate'], $this->config['date_format']); ?>&nbsp;-&nbsp;<?php echo JHtml::_('date', $this->jobs_cp_data['curdate'], $this->config['date_format']); ?>)&nbsp;</span>
                </span>
                <div id="js-jobscp-main-bg_white">
                    <div class="performance-graph" id="stack_chart_horizontal"></div>
                    <div class="count2">
                        <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                            <div class="box">
                                <img class="newjobs" src="components/com_jsjobs/include/images/icon/jobs.png">
                                <div class="text">
                                    <div class="bold-text"><?php echo $this->jobs_cp_data['totalnewjobs']; ?></div>
                                    <div class="nonbold-text"><?php echo JText::_('New Jobs'); ?></div>   
                                </div>
                            </div>
                        </div>
                        <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                            <div class="box">
                                <img class="newresume" src="components/com_jsjobs/include/images/icon/resume-2.png">
                                <div class="text">
                                    <div class="bold-text"><?php echo $this->jobs_cp_data['totalnewresume']; ?></div>
                                    <div class="nonbold-text"><?php echo JText::_('New Resume'); ?></div>   
                                </div>
                            </div>
                        </div>
                        <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                            <div class="box">
                                <img class="jobapplied" src="components/com_jsjobs/include/images/icon/job-applied-2.png">
                                <div class="text">
                                    <div class="bold-text"><?php echo $this->jobs_cp_data['totalnewjobapply']; ?></div>
                                    <div class="nonbold-text"><?php echo JText::_('Job Applied'); ?></div>   
                                </div>
                            </div>
                        </div>
                        <div class="js-col-md-3 js-col-lg-3 js-col-xs-12 jsjobs- box-outer">
                            <div class="box">
                                <img class="newcompanies" src="components/com_jsjobs/include/images/icon/new-companies.png">
                                <div class="text">
                                    <div class="bold-text"><?php echo $this->jobs_cp_data['totalnewcompanies']; ?></div>
                                    <div class="nonbold-text"><?php echo JText::_('New Companies'); ?></div>   
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
            <div class="main-heading">
                <span class="text"><?php echo JText::_('Admin'); ?></span>
                <?php /*
                  <span class="showmore">
                  <a class="img" href=""><img src="components/com_jsjobs/include/images/Menu-icon.png">Show More</a>
                  </span>
                 */ ?>
            </div>
            <div class="categories-jobs">
                <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs" class="box">
                    <img class="jobs" src="components/com_jsjobs/include/images/icon/job.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Jobs'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=job&view=job&layout=jobqueue" class="box">
                    <img class="approval-queue" src="components/com_jsjobs/include/images/icon/approval-queue.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Approval Queue'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=2" class="box">
                    <img class="Fields" src="components/com_jsjobs/include/images/icon/fields2.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Fields'); ?></div>   
                    </div>
                </a>

                <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=reports" class="box">
                    <img class="jsjobstats" src="components/com_jsjobs/include/images/icon/report.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Reports'); ?></div>   
                    </div>
                </a>

                <a href="index.php?option=com_jsjobs&c=employerpackages&view=employerpackages&layout=employerpackages" class="box">
                    <img class="information" src="components/com_jsjobs/include/images/icon/employer-package.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Employer Packages'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=jobseekerpackages&view=jobseekerpackages&layout=jobseekerpackages" class="box">
                    <img class="jsjobstats" src="components/com_jsjobs/include/images/icon/jobseeker-package.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Job Seeker Packages'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=message&view=message&layout=messages" class="box">
                    <img class="messages" src="components/com_jsjobs/include/images/icon/message.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Messages'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=category&view=category&layout=categories" class="box">
                    <img class="categories" src="components/com_jsjobs/include/images/icon/category.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Categories'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=info" class="box">
                    <img class="information" src="components/com_jsjobs/include/images/icon/information.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Information'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=translation" class="box">
                    <img class="information" src="components/com_jsjobs/include/images/icon/language.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Translation'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=premiumplugin&view=premiumplugin&layout=premiumplugins" class="box">
                    <img class="heighesteducation" src="components/com_jsjobs/include/images/icon/premium_plugins.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Premium Plugins'); ?></div>   
                    </div>
                </a>
            </div>
        <a id="jsjobs-joomla-freeprobanner" target="_blank" href="https://www.joomsky.com/products/jobi-template.html">
            <img class="banner" src="components/com_jsjobs/include/images/jobi-banner.png">
        </a>
           <div class="main-heading">
                <span class="text"><?php echo JText::_('Configuration'); ?></span>
            </div>
            <div class="categories-configuration">
                <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurations" class="box">
                    <img class="general" src="components/com_jsjobs/include/images/icon/cofigration.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('General'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsjobseeker" class="box">
                    <img class="jobseeker" src="components/com_jsjobs/include/images/icon/jobseeker-2e.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Job Seeker'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=configurationsemployer" class="box">
                    <img class="employer" src="components/com_jsjobs/include/images/icon/jobseeker.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Employer'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=paymentmethodconfiguration&view=paymentmethodconfiguration&layout=paymentmethodconfig" class="box">
                    <img class="payment-method" src="components/com_jsjobs/include/images/icon/paymentt.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Payment Methods'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=configuration&view=configuration&layout=themes" class="box">
                    <img class="themes" src="components/com_jsjobs/include/images/icon/theme.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Themes'); ?></div>   
                    </div>
                </a>
            </div>
 
            <div class="newestjobs">
                <span class="header">
                    <img src="components/com_jsjobs/include/images/newesticon.png">
                    <span><?php echo JText::_('Newest Jobs'); ?></span>
                </span>
                <table id="js-table" class="newestjobtable">
                    <thead>
                        <tr>
                            <th class="colunm-heading"><?php echo JText::_('Job Title'); ?></th>
                            <th class="colunm-heading"><?php echo JText::_('Company'); ?></th>
                            <th class="colunm-heading"><?php echo JText::_('Location'); ?></th>
                            <th class="colunm-heading"><?php echo JText::_('Status'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->jobs_cp_data['latestjobs'] AS $tj) { ?>

                            <tr>
                                <td width="30%" class="job-title elipsises"><div class="js-elip"> <a href="index.php?option=com_jsjobs&task=job.edit&cid[]=<?php echo $tj->id; ?>"><?php echo $tj->title; ?></a></div></td>
                                <td width="20%" class="description elipsises"><div class="js-elip"> <?php echo $tj->name; ?></div></td>
                                <?php
                                $startDate = $tj->startpublishing;
                                $stopDate = $tj->stoppublishing;
                                $currentDate = date("Y-m-d H:i:s");
                                if( ($startDate <= $currentDate) AND ($stopDate >= $currentDate) ){
                                    $status = JText::_('Published');
                                    $class = "published";
                                }elseif ($startDate >= $currentDate) {
                                    $status = JText::_('Unpublished');
                                    $class = "unpublished";
                                }elseif ($stopDate <= $currentDate) {
                                    $status = JText::_('Expired');
                                    $class = "expired";
                                }

                               ?>
                                <td width="40%" class="description elipsises"><div class="js-elip"> <?php echo $this->getJSModel('city')->getLocationDataForView($tj->city); ?></div></td>
                                <td width="10%"class="status"><span class="<?php echo $class; ?>"><?php echo $status; ?></span></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="main-heading">
                <span class="text"><?php echo JText::_('Companies'); ?></span>
            </div>
            <div class="categories-companies">
                <a href="index.php?option=com_jsjobs&c=company&view=company&layout=companies" class="box">
                    <img class="companies" src="components/com_jsjobs/include/images/icon/companies-1.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Company'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=company&view=company&layout=companiesqueue" class="box">
                    <img class="approval-queue" src="components/com_jsjobs/include/images/icon/aproval-queue.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Approval Queue'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=1" class="box">
                    <img class="Fields" src="components/com_jsjobs/include/images/icon/fields.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Fields'); ?></div>   
                    </div>
                </a>
            </div>
        <div class="main-heading">
            <span class="text"><?php echo JText::_('Resume'); ?></span>          
        </div>
        <div class="categories-resume">
            <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps" class="box">
                <img class="resume" src="components/com_jsjobs/include/images/icon/reume.png">
                <div class="text">
                    <div class="nonbold-text"><?php echo JText::_('Resume'); ?></div>   
                </div>
            </a>
            <a href="index.php?option=com_jsjobs&c=resume&view=resume&layout=appqueue" class="box">
                <img class="approval-queue" src="components/com_jsjobs/include/images/icon/approval-queue.png">
                <div class="text">
                    <div class="nonbold-text"><?php echo JText::_('Approval Queue'); ?></div>   
                </div>
            </a>
            <a href="index.php?option=com_jsjobs&c=fieldordering&view=fieldordering&layout=fieldsordering&ff=3" class="box">
                <img class="Fields" src="components/com_jsjobs/include/images/icon/fields.png">
                <div class="text">
                    <div class="nonbold-text"><?php echo JText::_('Fields'); ?></div>   
                </div>
            </a>
            
        </div>
            <div class="extra-activities">
                <div class="js-col-md-6 js-col-lg-6 js-col-xs-12 companies">
                    <div class="header-left">
                        <span class="img img_left"><img src="components/com_jsjobs/include/images/previous.png"></span>
                        <span class="text"><?php echo JText::_('Most Viewed Companies'); ?></span>
                        <span class="img img_right"><img src="components/com_jsjobs/include/images/next.png"></span>
                    </div>
                    <div class="show-items">
                        <?php 
                        if (isset($this->jobs_cp_data['mostviewcompanioes']) && !empty($this->jobs_cp_data['mostviewcompanioes'])) {
                           $common = $this->getJSModel('common');
                           foreach ($this->jobs_cp_data['mostviewcompanioes'] AS $company) {
                                $comp_link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=company.edit&cid[]=' . $company->id);

                                $path = $common->getCompanyLogo($company->id, $company->logofilename , $this->config);
                                ?>                
                                <div class="job-wrapper">
                                    <div class="img"><a href="<?php echo $comp_link; ?>"><img src="<?php echo $path; ?>"></a></div>
                                    <div class="detail">
                                        <a class="title overflow_text" href="<?php echo $comp_link; ?>"><?php echo $company->name; ?></a>
                                        <?php if($company->isgoldcompany == 1){ ?>
                                        <span class="gold"><?php echo JText::_('Gold')?></span>
                                        <?php } ?>
                                        <?php if($company->isfeaturedcompany == 1){ ?>
                                        <span class="featured"><?php echo JText::_('Featured')?></span>
                                        <?php } ?>
                                        <div class="created"><?php echo JText::_('Posted On') . ':&nbsp' .JHtml::_('date', $company->created, $this->config['date_format']); ?></div>
                                        <a href="<?php echo $company->url;?>" target="_blank" class="url"><?php echo $company->url; ?></a>
                                        <div class="info">
                                            <span class="text"><?php echo JText::_('Category');?></span>
                                            <span class="get-text"><?php echo JText::_($company->cat_title); ?></span>
                                        </div>
                                        <div class="info">
                                            <span class="text"><?php echo JText::_('Location');?></span>
                                            <span class="get-text"><?php echo $this->getJSModel('city')->getLocationDataForView($company->city); ?></span>
                                        </div>
                                        <span class="views">
                                            <div><?php if(!is_numeric($company->hits)) echo "0";else echo $company->hits; ?></div>
                                            <div class="text"><?php echo JText::_("Views");?></div>
                                        </span>
                                    </div>      
                                </div>
                                <?php
                            }
                        } else {
                            echo JSJOBSlayout::getNoRecordFound();
                        }
                        ?>
                    </div>                  
                    <a class="footer" href="index.php?option=<?php echo $this->option;?>&c=company&view=company&layout=companies&js_sortby=6&sortby=desc"><?php echo JText::_('Show More'); ?></a>
                </div>
                <div class="js-col-md-6 js-col-lg-6 js-col-xs-12 jobs">
                    <div class="header-left">
                        <span class="img img_left"><img src="components/com_jsjobs/include/images/previous.png"></span>
                        <span class="text"><?php echo JText::_('Most Viewed Jobs'); ?></span>
                        <span class="img img_right"><img src="components/com_jsjobs/include/images/next.png"></span>
                    </div>
                    <div class="show-items">
                    <?php
                    if (isset($this->jobs_cp_data['mostviewjobs']) && !empty($this->jobs_cp_data['mostviewjobs'])) {
                        $common = $common->getJSModel('common');
                        foreach ($this->jobs_cp_data['mostviewjobs'] AS $job) {
                            $path = $common->getCompanyLogo($job->companyid, $job->logofilename , $this->config);

                            $job_link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=job.edit&cid[]=' . $job->id);
                            ?>
                            <div class="job-wrapper">
                                <div class="img"><a href="<?php echo $job_link; ?>"><img src="<?php echo $path; ?>"></a></div>
                               <div class="detail">
                                    <a class="title overflow_text" href="<?php echo $job_link; ?>"><?php echo $job->title; ?></a>
                                    <?php if($job->isgoldjob == 1){ ?>
                                    <span class="gold"><?php echo JText::_('Gold')?></span>
                                    <?php } ?>
                                    <?php if($job->isfeaturedjob == 1){ ?>
                                    <span class="featured"><?php echo JText::_('Featured')?></span>
                                    <?php } ?>
                                    <div class="created"><?php echo JText::_('Posted On') . ':&nbsp' . JHtml::_('date', $job->created, $this->config['date_format']);?></div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Category');?></span>
                                        <span class="get-text"><?php echo JText::_($job->cat_title); ?></span>
                                    </div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Location');?></span>
                                        <span class="get-text"><?php echo $this->getJSModel('city')->getLocationDataForView($job->city); ?></span>
                                    </div>
                                    <span class="views">
                                        <div><?php if(!is_numeric($job->hits)) echo "0"; else echo $job->hits;?></div>
                                        <div class="text"><?php echo JText::_("Views");?></div>
                                    </span>
                                </div>      
                            </div>
                            <?php
                        }
                    } else {
                        echo JSJOBSlayout::getNoRecordFound();
                    }
                    ?>
                </div>                  
                <a class="footer" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs&js_sortby=8&sortby=desc"><?php echo JText::_('Show More'); ?></a>
            </div>
            <div class="js-col-md-6 js-col-lg-6 js-col-xs-12 resume">
                <div class="header-left">
                    <span class="img img_left"><img src="components/com_jsjobs/include/images/previous.png"></span>
                    <span class="text"><?php echo JText::_('Most Viewed Resume'); ?></span>
                    <span class="img img_right"><img src="components/com_jsjobs/include/images/next.png"></span>
                </div>
                <div class="show-items">
                    <?php 
                    if (isset($this->jobs_cp_data['mostviewresumes']) && !empty($this->jobs_cp_data['mostviewresumes'])) {
                        foreach ($this->jobs_cp_data['mostviewresumes'] AS $resume) {
                            if($resume->photo==""){
                              $path = "components/com_jsjobs/include/images/Users.png";
                            }else{
                              $path = "../".$this->config['data_directory']."/data/jobseeker/resume_".$resume->id."/photo/".$resume->photo;
                            }


                            $resume_link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=resume.edit&cid[]=' . $resume->id);
                            ?>                
                            <div class="job-wrapper">
                                <div class="img"><a href="<?php echo $resume_link; ?>"><img src="<?php echo $path; ?>"></a></div>
                                <div class="detail">
                                    <a class="title overflow_text" href="<?php echo $resume_link; ?>"><?php echo $resume->application_title; ?></a>
                                    <?php if($resume->isgoldresume == 1){ ?>
                                    <span class="gold"><?php echo JText::_('Gold')?></span>
                                    <?php } ?>
                                    <?php if($resume->isfeaturedresume == 1){ ?>
                                    <span class="featured"><?php echo JText::_('Featured')?></span>
                                    <?php } ?>
                                    <div class="created"><?php echo JText::_('Posted On') . ':&nbsp' . JHtml::_('date', $resume->created, $this->config['date_format']); ?></div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Category');?></span>
                                        <span class="get-text"><?php echo JText::_($resume->cat_title); ?></span>
                                    </div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Highest Education');?></span>
                                        <span class="get-text"><?php echo JText::_($resume->heighestfinisheducation); ?></span>
                                    </div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Location');?></span>
                                        <span class="get-text"><?php echo $this->getJSModel('city')->getLocationDataForView($resume->city); ?></span>
                                    </div>
                                    <span class="views">
                                        <div><?php if(!is_numeric($resume->hits)) echo "0"; else echo $resume->hits;?></div>
                                        <div class="text"><?php echo JText::_("Views");?></div>
                                    </span>
                                </div>      
                            </div>
                            <?php
                        }
                    } else {
                        echo JSJOBSlayout::getNoRecordFound();
                    }
                    ?>
                </div>                  
                <a class="footer" href="index.php?option=com_jsjobs&c=resume&view=resume&layout=empapps&js_sortby=8&sortby=desc"><?php echo JText::_('Show More'); ?></a>
            </div>
            <div class="js-col-md-6 js-col-lg-6 js-col-xs-12 appliedjobs">
                <div class="header-left">
                    <span class="img img_left"><img src="components/com_jsjobs/include/images/previous.png"></span>
                    <span class="text"><?php echo JText::_('Most Applied Jobs'); ?></span>
                    <span class="img img_right"><img src="components/com_jsjobs/include/images/next.png"></span>
                </div>
                <div class="show-items">
                    <?php
                    if (isset($this->jobs_cp_data['mostappliedjobs']) && !empty($this->jobs_cp_data['mostappliedjobs'])) {
                        $common = $common->getJSModel('common');
                        foreach ($this->jobs_cp_data['mostappliedjobs'] AS $appliedjob) {
                            $path = $common->getCompanyLogo($appliedjob->companyid, $appliedjob->logofilename , $this->config);
                           
                            $job_link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=job.edit&cid[]=' . $appliedjob->id);
                            ?>                
                            <div class="job-wrapper">
                                <div class="img"><a href="<?php echo $job_link; ?>"><img src="<?php echo $path; ?>"></a></div>
                                <div class="detail">
                                    <a class="title overflow_text" href="<?php echo $job_link; ?>"><?php echo $appliedjob->title; ?></a>
                                    <?php if($appliedjob->isgoldjob == 1){ ?>
                                    <span class="gold"><?php echo JText::_('Gold')?></span>
                                    <?php } ?>
                                   <?php if($appliedjob->isfeaturedjob == 1){ ?>
                                    <span class="featured"><?php echo JText::_('Featured')?></span>
                                   <?php } ?>
                                    <div class="created"><?php echo JText::_('Posted On') . ':&nbsp' .JHtml::_('date', $appliedjob->created, $this->config['date_format']); ?></div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Category');?></span>
                                        <span class="get-text"><?php echo JText::_($appliedjob->cat_title); ?></span>
                                    </div>
                                    <div class="info">
                                        <span class="text"><?php echo JText::_('Location');?></span>
                                        <span class="get-text"><?php echo $this->getJSModel('city')->getLocationDataForView($appliedjob->city); ?></span>
                                    </div>
                                    <span class="views">
                                        <div><?php if(!is_numeric($appliedjob->totalapplied)) echo "0"; else echo $appliedjob->totalapplied;?></div>
                                        <div class="text"><?php echo JText::_('Applied');?></div>
                                    </span>
                                </div>      
                            </div>
                        <?php
                        }
                    } else {
                       echo JSJOBSlayout::getNoRecordFound();
                    }
                    ?>
                </div>                  
                <a class="footer" style="min-height:38px;" href="index.php?option=com_jsjobs&c=job&view=job&layout=jobs&js_sortby=8&sortby=desc"><?php echo JText::_('Show More'); ?></a>
            </div>
        </div>
             <div class="main-heading">
                <span class="text"><?php echo JText::_('Misc'); ?></span>
                <?php /*
                  <span class="showmore">
                  <a class="img" href=""><img src="components/com_jsjobs/include/images/Menu-icon.png"><?php echo JText::_('Show More','js-jobs'); ?></a>
                  </span>
                */ ?>
            </div>
            <div class="categories-admin">
                <a href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=stepone" class="box">
                    <img class="jsjobstats" src="components/com_jsjobs/include/images/icon/report.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Update'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=shift&view=shift&layout=shifts" class="box">
                    <img class="shifts" src="components/com_jsjobs/include/images/icon/shift.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Shift'); ?></div>
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=highesteducation&view=highesteducation&layout=highesteducations" class="box">
                    <img class="heighesteducation" src="components/com_jsjobs/include/images/icon/higest-edu.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Education'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=careerlevel&view=careerlevel&layout=careerlevels" class="box">
                    <img class="careerlavel" src="components/com_jsjobs/include/images/icon/career-level.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Career Level'); ?></div>
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=experience&view=experience&layout=experience" class="box">
                    <img class="experince" src="components/com_jsjobs/include/images/icon/experience.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Experience'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=department&view=department&layout=departments" class="box">
                    <img class="department" src="components/com_jsjobs/include/images/icon/department.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Departments'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=folder&view=folder&layout=folders" class="box">
                    <img class="folders" src="components/com_jsjobs/include/images/icon/folder.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Folders'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=salaryrange&view=salaryrange&layout=salaryrange" class="box">
                    <img class="salaryrange" src="components/com_jsjobs/include/images/icon/salary-range.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Salary Range'); ?></div>   
                    </div>
                </a>
               <a href="index.php?option=com_jsjobs&c=userrole&view=userrole&layout=users" class="box">
                    <img class="salaryrange" src="components/com_jsjobs/include/images/icon/users.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Users'); ?></div>   
                    </div>
                </a>
                <a href="index.php?option=com_jsjobs&c=emailtemplate&view=emailtemplate&layout=emailtemplate&tf=ew-cm" class="box">
                    <img class="salaryrange" src="components/com_jsjobs/include/images/icon/email-temp.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Email Templates'); ?></div>   
                    </div>
                </a>
             </div>
             <div class="main-heading">
                <span class="text"><?php echo JText::_('Support'); ?></span>
            </div>
            <div class="categories-admin">
                <a href="http://www.joomsky.com/appsys/documentations/joomla-jobs" target="_blank" class="box">
                    <img class="shifts" src="components/com_jsjobs/include/images/icon/doc.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Documentation'); ?></div>
                    </div>
                </a>
                <a href="http://www.joomsky.com/appsys/forum/joomla-jobs"  target="_blank" class="box">
                    <img class="jsjobstats" src="components/com_jsjobs/include/images/icon/form.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Forum'); ?></div>   
                    </div>
                </a>
                <?php /*
                <a href="http://www.joomsky.com/appsys/support/joomla-jobs" target="_blank"class="box">
                    <img class="heighesteducation" src="components/com_jsjobs/include/images/icon/support.png">
                    <div class="text">
                        <div class="nonbold-text"><?php echo JText::_('Support'); ?></div>   
                    </div>
                </a>
                */ ?>
                
             </div>
            <a class="jsjobs-joomla-ratingbanner" href="http://extensions.joomla.org/extensions/extension/ads-a-affiliates/jobs-a-recruitment/js-jobs" target="_blank">
                <img class="heighesteducation" src="components/com_jsjobs/include/images/review-banner.png">
            </a>
        <?php /*<div class="review">
            <div class="upper">
                <div class="imgs">
                    <img class="reviewpic" src="components/com_jsjobs/include/images/review.png">
                    <img class="reviewpic2" src="components/com_jsjobs/include/images/corner-1.png">
                </div>
                <div class="text">
                    <div class="simple-text">
                        <span class="nobold"><?php echo JText::_('If You Use'); ?></span>
                        <span class="bold"><?php echo JText::_('JS Jobs,'); ?></span>
                        <span class="nobold"><?php echo JText::_('Please Write Appreciate Review As'); ?></span>
                    </div>
                    <a href="http://extensions.joomla.org/extensions/extension/ads-a-affiliates/jobs-a-recruitment/js-jobs" target="_blank"><?php echo JText::_('Joomla Extension Directory'); ?><img src="components/com_jsjobs/include/images/arrow2.png"></a>
                </div>
                <div class="right">
                    <img src="components/com_jsjobs/include/images/star.png">
                </div>
            </div>
            <div class="lower">

            </div>
        </div> */ ?>
    </div>
    </div>
</div>  
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('div.resume').animate({left: '-100%'});
        jQuery('div.companies span.img img').click(function (e) {
            jQuery('div.companies').animate({left: '-100%'});
            jQuery('div.resume').animate({left: '0%'});
        });
        jQuery('div.resume span.img img').click(function (e) {
            jQuery('div.resume').animate({left: '-100%'});
            jQuery('div.companies').animate({left: '0%'});
        });
        jQuery('div.jobs').animate({right: '-100%'});
        jQuery('div.jobs span.img img').click(function (e) {
            jQuery('div.jobs').animate({right: '-100%'});
            jQuery('div.appliedjobs').animate({right: '0%'});
        });
        jQuery('div.appliedjobs span.img img').click(function (e) {
            jQuery('div.appliedjobs').animate({right: '-100%'});
            jQuery('div.jobs').animate({right: '0%'});
        });
        jQuery("span.dashboard-icon").find('span.download').hover(function(){
            jQuery(this).find('span').toggle("slide");
        },function(){
            jQuery(this).find('span').toggle("slide");
        });
    });
</script>
