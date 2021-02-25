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
$link = "index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&Itemid=" . $this->Itemid;
$document = JFactory::getDocument();
$document->addScript('components/com_jsjobs/js/canvas_script.js');
$document->addStyleSheet('components/com_jsjobs/css/status_graph.css');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.myresume-complete-status').each(function(){
            var per = jQuery( this ).attr('data-per');
            jQuery(this).find('.js-mr-rp').attr('data-progress', per);
        });
    });
</script>
<script type="text/javascript">
    function confirmdeleteresume() {
        return confirm("<?php echo JText::_('Are you sure to delete the resume').'!'; ?>");
    }
</script>
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
    ?>
    <div id="jsjobs-main-wrapper">
    <?php
    if ($this->myresume_allowed == VALIDATE) { ?>
        <span class="jsjobs-main-page-title"><span class="jsjobs-title-componet"><?php echo JText::_('My Resume'); ?></span>
            <span class="jsjobs-add-resume-btn"><a class="jsjobs-resume-a" href="index.php?option=com_jsjobs&view=resume&layout=formresume&Itemid=<?php echo $this->Itemid; ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/add-icon.png"><span class="jsjobs-add-resume-btn"><?php echo JText::_('Add Resume'); ?></span></a></span>
        </span>
        <?php 

        $fieldsordering = JSModel::getJSModel('fieldsordering')->getFieldsOrderingByFieldFor(3);
        $_field = array();
        foreach($fieldsordering AS $field){
            if($field->showonlisting == 1){
                $_field[$field->field] = $field->fieldtitle;
            }
        }
        if ($this->resumes) {
            if ($this->sortlinks['sortorder'] == 'ASC')
                $img = JURI::root()."components/com_jsjobs/images/sort0.png";
            else
                $img = JURI::root()."components/com_jsjobs/images/sort1.png";
            ?>
                <form action="index.php" method="post" name="adminForm">
                    <div id="sortbylinks">
                      <ul>
                        <?php if (isset($_field['application_title'])) { ?>
                            <li><a class="<?php if ($this->sortlinks['sorton'] == 'application_title') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['application_title']; ?>"><?php if ($this->sortlinks['sorton'] == 'application_title') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Title'); ?></a></li>
                        <?php } ?>
                        <?php if (isset($_field['jobtype'])) { ?>
                           <li><a class="<?php if ($this->sortlinks['sorton'] == 'jobtype') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['jobtype']; ?>"><?php if ($this->sortlinks['sorton'] == 'jobtype') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Job Type'); ?></a></li>
                        <?php } ?>
                        <?php if (isset($_field['salary'])) { ?>
                            <li><a class="<?php if ($this->sortlinks['sorton'] == 'salaryrange') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['salaryrange']; ?>"><?php if ($this->sortlinks['sorton'] == 'salaryrange') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Salary Range'); ?></a></li>
                        <?php } ?>
                        <li><a  class="<?php if ($this->sortlinks['sorton'] == 'created') echo 'selected' ?>" href="<?php echo $link; ?>&sortby=<?php echo $this->sortlinks['created']; ?>"><?php if ($this->sortlinks['sorton'] == 'created') { ?> <img src="<?php echo $img ?>"> <?php } ?><?php echo JText::_('Posted'); ?></a></li>
                        </ul>
                    </div>
                    <?php
                    $isnew = date("Y-m-d H:i:s", strtotime("-" . $this->config['newdays'] . " days")); ?>
                    <div id="js-jobs-resumelisting-wrapper">  <?php
                        foreach ($this->resumes as $resume) {
                            $status_array = $this->getJSModel('resume')->getResumePercentage($resume->id);
                            $percentage = $status_array['percentage'];
                            unset($status_array['percentage']);
                            $resumealiasid = $this->getJSModel('common')->removeSpecialCharacter($resume->resumealiasid);
                            $link_viewresume = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=view_resume&nav=1&rd=' . $resumealiasid . '&Itemid=' . $this->Itemid;
                            $link_edit = 'index.php?option=com_jsjobs&c=resume&view=resume&layout=formresume&nav=29&rd=' . $resumealiasid . '&Itemid=' . $this->Itemid; 
                            
                            $update_date = JHtml::_('date', $resume->last_modified, $this->config['date_format']) ;
                             ?>
                            
                            <div class="js-resume-list">
                                <div class="jsjobs-img-area">
                                    <div id="js-drag-image-to-top">
                                    <?php if (isset($_field['photo'])) { ?>
                                        <a  class="logo_a" href="<?php echo $link_viewresume;?>">
                                            <?php
                                            if ($resume->photo != '') {
                                                    $imgsrc = JURI::root().$this->config['data_directory'] . "/data/jobseeker/resume_" . $resume->id . "/photo/" . $resume->photo;
                                                } else {
                                                    $imgsrc = JURI::root()."components/com_jsjobs/images/Users.png";
                                                }
                                            ?>
                                            <img class="logo_img" src="<?php echo $imgsrc; ?>" />
                                        </a>
                                    <?php } ?>
                                        <div class="js-myresume-last-modified">
                                            <div class="js-lst-modified"><?php echo JText::_('Updated'); ?></div>
                                            <div class="js-lst-modified"> <?php echo $update_date; ?></div>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="js-topresume-area">
                                    <div class="jsjobs-applyname">
                                       <span class="jsjobs-titleresume">
                                            <a  class="jsjobs-anchor_resume" href="<?php echo $link_viewresume;?>">
                                            <?php if (isset($_field['first_name'])) { ?>
                                                <?php echo htmlspecialchars($resume->first_name); ?>
                                            <?php } ?>
                                            <?php if (isset($_field['last_name'])) { ?>
                                                <?php echo ' ' . htmlspecialchars($resume->last_name); ?>
                                            <?php } ?>
                                            </a>
                                            <?php 
                                            $showgold = true;
                                            $showfeatured = true;
                                            if($resume->isgold==1 AND $resume->endgolddate > date('Y-m-d')){ 
                                                $showgold = false;
                                                ?>
                                                 <span class="goldnew" data-id="<?php echo $resume->id; ?>"><span class="jsjobs-goldstatus"><?php echo JText::_('Gold'); ?></span><span class="goldnew-onhover" id="gold<?php echo $resume->id; ?>" style="display:none"><?php echo JText::_("Expiry Date").': '.$resume->endgolddate; ?><img src="administrator/components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                                            <?php
                                            }elseif($resume->isgold == 0){ 
                                                $showgold = false; ?>
                                                <span class="goldnew" data-id="<?php echo $resume->id; ?>"><span class="jsjobs-goldstatus"><?php echo JText::_('Waiting...'); ?></span></span>
                                            <?php
                                            }
                                            if($resume->isfeatured==1 AND $resume->endfeaturedate > date('Y-m-d')){ 
                                                $showfeatured = false;
                                                ?>
                                                <span class="featurednew"><span class="jsjobs-faturedstatus"><?php echo JText::_('Featured'); ?></span><span class="featurednew-onhover" style="display:none"><?php echo JText::_("Expiry Date").": ".$resume->endfeaturedate; ?><img src="administrator/components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                                            <?php
                                            }elseif($resume->isfeatured == 0){ 
                                                $showfeatured = false; ?>
                                                <span class="featurednew"><span class="jsjobs-faturedstatus"><?php echo JText::_('Waiting...'); ?></span></span>
                                            <?php
                                            }
                                            ?>
                                        </span>
                                        <div class="jsjobs-fulltime-wrapper">
                                            <span class="jsjobs-date-created">
                                                <?php
                                                echo  JText::_('Created');?>: 
                                                <?php echo JHtml::_('date', $resume->created, $this->config['date_format']) ; ?>
                                            </span>
                                            <?php if (isset($_field['jobtype'])) { ?>
                                                <span class="jsjobs-fulltime-btn">
                                                    <?php echo htmlspecialchars(JText::_($resume->jobtypetitle)); ?>
                                                </span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (isset($_field['application_title'])) { ?>
                                        <div class="jsjobs-application-title">
                                            (<?php echo $resume->application_title; ?>)
                                        </div>
                                    <?php } ?>
                                </div>
                                
                                            <div class="jsjobs-resume-data-area">
                                                <div id="myresume-fields-area">
                                                    <?php if (isset($_field['job_category'])) { ?>
                                                            <span class="js-myresume-field-wrapper">
                                                                <span class="js-myresume-field-title"><?php echo JText::_($_field['job_category']) . ": "; ?></span>
                                                                <span class="js-myresume-field-value"><?php echo JText::_($resume->cat_title); ?></span>
                                                            </span>
                                                        <?php } ?>
                                                    <?php if (isset($_field['salary'])) { ?>
                                                        <span class="js-myresume-field-wrapper">
                                                         <span class="js-myresume-field-title"><?php echo JText::_($_field['salary']) . ": "; ?></span>
                                                         <span class="js-myresume-field-value">
                                                            <?php
                                                                $salary = $this->getJSModel('common')->getSalaryRangeView($resume->symbol,$resume->rangestart,$resume->rangeend,JText::_($resume->salarytype),$this->config['currency_align']);
                                                                echo htmlspecialchars($salary);
                                                                ?>
                                                            </span>
                                                          </span>
                                                    <?php } ?>
                                                    <?php if (isset($_field['heighestfinisheducation'])) { ?>
                                                        <span class="js-myresume-field-wrapper">
                                                        <span class="js-myresume-field-title"><?php echo JText::_($_field['heighestfinisheducation']) ?>: </span>
                                                        <span class="js-myresume-field-value">
                                                            <?php echo htmlspecialchars($resume->educationtitle); ?>
                                                        </span>
                                                        </span>
                                                    <?php } ?>
                                                     <?php if (isset($_field['total_experience'])) { ?>
                                                            <span class="js-myresume-field-wrapper">
                                                            <span class="js-myresume-field-title"><?php echo JText::_($_field['total_experience']) . ": "; ?></span>
                                                            <span class="js-myresume-field-value">
                                                                <?php
                                                                if (empty($resume->exptitle))
                                                                    echo $resume->total_experience;
                                                                else
                                                                    echo JText::_($resume->exptitle);
                                                                ?>
                                                            </span>
                                                    </span>
                                                <?php }
                                                    $customfieldobj = getCustomFieldClass();
                                                    $customfields = $customfieldobj->userFieldsData( 3 , 1 , 1);
                                                    foreach ($customfields as $field) {
                                                        echo  $customfieldobj->showCustomFields($field, 9 ,$resume , 1);
                                                    }
                                                 ?>
                                                 </div>

                                                 <div class="myresume-complete-status" data-per="<?php echo $percentage; ?>">
                                                    <div class="complete-status-wrapper">
                                                        <div class="myresume-title"><?php echo JText::_('Your Profile Status'); ?></div> 
                                                        <div class="myresume-graph">
                                                            <div class="mygraph">
                                                                <div class="js-mr-rp" data-progress="0"> <div class="circle"> <div class="mask full"> <div class="fill"></div> </div> <div class="mask half"> <div class="fill"></div> <div class="fill fix"></div> </div> <div class="shadow"></div> </div> <div class="inset"> <div class="percentage"> <div class="numbers"><span>-</span><span>0%</span><span>1%</span><span>2%</span><span>3%</span><span>4%</span><span>5%</span><span>6%</span><span>7%</span><span>8%</span><span>9%</span><span>10%</span><span>11%</span><span>12%</span><span>13%</span><span>14%</span><span>15%</span><span>16%</span><span>17%</span><span>18%</span><span>19%</span><span>20%</span><span>21%</span><span>22%</span><span>23%</span><span>24%</span><span>25%</span><span>26%</span><span>27%</span><span>28%</span><span>29%</span><span>30%</span><span>31%</span><span>32%</span><span>33%</span><span>34%</span><span>35%</span><span>36%</span><span>37%</span><span>38%</span><span>39%</span><span>40%</span><span>41%</span><span>42%</span><span>43%</span><span>44%</span><span>45%</span><span>46%</span><span>47%</span><span>48%</span><span>49%</span><span>50%</span><span>51%</span><span>52%</span><span>53%</span><span>54%</span><span>55%</span><span>56%</span><span>57%</span><span>58%</span><span>59%</span><span>60%</span><span>61%</span><span>62%</span><span>63%</span><span>64%</span><span>65%</span><span>66%</span><span>67%</span><span>68%</span><span>69%</span><span>70%</span><span>71%</span><span>72%</span><span>73%</span><span>74%</span><span>75%</span><span>76%</span><span>77%</span><span>78%</span><span>79%</span><span>80%</span><span>81%</span><span>82%</span><span>83%</span><span>84%</span><span>85%</span><span>86%</span><span>87%</span><span>88%</span><span>89%</span><span>90%</span><span>91%</span><span>92%</span><span>93%</span><span>94%</span><span>95%</span><span>96%</span><span>97%</span><span>98%</span><span>99%</span><span>100%</span></div></div></div></div>
                                                            </div>
                                                            <?php if($percentage != 100){ ?>
                                                                <div class="mytext"><?php echo JText::_('Complete Your Profile'); ?></div>
                                                            <?php } ?>

                                                        </div> 
                                                        
                                                        <?php if($percentage != 100){ ?>
                                                            <div class="myresume-info">
                                                                <?php
                                                                foreach ($status_array as $arr) {
                                                                    if($arr['status'] == 0){
                                                                        $link = $link_edit.'#jsresume_sectionid'.$arr['id'];
                                                                        $html = '<a class="js_myanchor" href="'.$link.'">+ '.JText::_('Add').' '.JText::_(ucfirst($arr['name'])).'</a>';
                                                                        echo $html;
                                                                    }
                                                                }
                                                                ?>
                                                            </div> 
                                                        <?php } ?>
                                                        
                                                    </div>
                                                 </div>
                                            </div>
                                        <div class="jsjobs-myresume-buttons">
                                            <span class="jsjobs-resume-loction">
                                            <span><img src="<?php echo JURI::root();?>components/com_jsjobs/images/location.png"></span>
                                                <?php echo $resume->location; ?>
                                            </span>
                                            <span class="jsjobs-myresumebtn">
                                                <?php
                                                if ($resume->status == 0) { ?>
                                                    <font id="jsjobs-status-btn"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Waiting for approval');?></font>
                                                <?php
                                                } elseif ($resume->status == -1) { ?>
                                                    <font id="jsjobs-status-btn-rejected"><canvas class="canvas_color_bg" width="20" height="20"></canvas><?php echo JText::_('Rejected');?></font>
                                                <?php
                                                } elseif ($resume->status == 1) {
                                                    ?>
                                                    <a class="jsjobs-myresumes-btn" href="<?php echo $link_edit; ?>" title="<?php echo JText::_('Edit'); ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/edit.png" /></a>
                                                    <a class="jsjobs-myresumes-btn" href="<?php echo $link_viewresume; ?>" title="<?php echo JText::_('View'); ?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/view.png" /></a>
                                                    <?php
                                                    if($this->resumeconfig['show_fe_goldresume_button'] == 1){
                                                        if($showgold){
                                                            $link_gold = 'index.php?option=com_jsjobs&task=resume.addtogoldresumes&rd=' . $resume->resumealiasid . '&Itemid=' . $this->Itemid;
                                                            ?>
                                                            <a class="goldfeature jsjobs-myresumes-btn" href="<?php echo $link_gold;?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/add-gold.png" title="<?php echo JText::_('Gold Resume'); ?>"/><span class="jsjobs-gold"><?php echo JText::_('Gold');?></span></a>
                                                            <?php
                                                        }
                                                    }
                                                    if($this->resumeconfig['show_fe_featuredresume_button'] == 1){
                                                        if($showfeatured){
                                                            $link_feature = 'index.php?option=com_jsjobs&task=resume.addtofeaturedresumes&rd=' . $resume->resumealiasid . '&Itemid=' . $this->Itemid; ?>
                                                            <a class="goldfeature jsjobs-myresumes-btn" href="<?php echo $link_feature;?>"><img  src="<?php echo JURI::root();?>components/com_jsjobs/images/add-featured.png" title="<?php echo JText::_('Featured Resume'); ?>"/><span class="jsjobs-featured"><?php echo JText::_('Featured');?></span></a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php $link_delete = 'index.php?option=com_jsjobs&task=resume.deleteresume&rd=' . $resume->resumealiasid . '&Itemid=' . $this->Itemid.'&'.JSession::getFormToken().'=1'; ?>
                                                        <a class="jsjobs-myresumes-btn" href="<?php echo $link_delete; ?>" onclick=" return confirmdeleteresume();" class="icon" title="<?php echo JText::_('Delete'); ?>"><img src="<?php echo JURI::root();?>components/com_jsjobs/images/force-delete.png" /></a>
                                                        <?php if( $this->getJSModel(VIRTUEMARTJSJOBS)->{VIRTUEMARTJSJOBSFUN}("UGF0dFlJam9tc29jaWFsS1ducDhi") && $this->getJSModel('configurations')->getConfigValue('jomsocial_allowpostresume') == 1 ){ ?>
                                                        <a class="jsjobs-myresumes-btn jsjobs-jomsocial-icon" title="<?php echo JText::_("Post on JomSocial"); ?>" href="index.php?option=com_jsjobs&task=resume.postresumeonjomsocial&id=<?php echo $resume->id; ?>&Itemid=<?php echo $this->Itemid; ?>&<?php echo JSession::getFormToken(); ?>=1';">
                                                            <img src="<?php echo JURI::root();?>components/com_jsjobs/images/social-share.png">
                                                        </a>
                                                        <?php } ?>
                                                <?php } ?>
                                            </span>
                                        </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="task" value="deleteresume" />
                    <input type="hidden" name="c" value="resume" />
                    <input type="hidden" id="id" name="id" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                </form>
            <form action="<?php echo JRoute::_('index.php?option=com_jsjobs&c=resume&view=resume&layout=myresumes&sortby='.$this->sortlinks['sorton']. strtolower($this->sortlinks['sortorder']) .'&Itemid=' . $this->Itemid ,false); ?>" method="post">
                <div id="jsjobs_jobs_pagination_wrapper">
                    <div class="jsjobs-resultscounter">
                        <?php echo $this->pagination->getResultsCounter(); ?>
                    </div>
                    <div class="jsjobs-plinks">
                        <?php echo $this->pagination->getPagesLinks(); ?>
                    </div>
                    <div class="jsjobs-lbox">
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                </div>
            </form> 
        <?php } else { // no result found in this category 
                $this->jsjobsmessages->getAccessDeniedMsg('Could not find any matching results', 'Could not find any matching results', 0);
            }
    } else {
        switch ($this->myresume_allowed) {
            case EMPLOYER_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('Employer not allowed', 'Employer is not allowed in job seeker private area', 0);
                break;
            case USER_ROLE_NOT_SELECTED:
                $link = "index.php?option=com_jsjobs&c=common&view=common&layout=new_injsjobs&Itemid=".$this->Itemid;
                $vartext = JText::_('You do not select your role').','.JText::_('Please select your role');
                $this->jsjobsmessages->getUserNotSelectedMsg('You do not select your role',$vartext, $link);
                break;
            case VISITOR_NOT_ALLOWED_JOBSEEKER_PRIVATE_AREA:
                $this->jsjobsmessages->getAccessDeniedMsg('You are not logged in', 'Please login to access private area', 1);
                break;
        }
    } ?>
            </div>
    <?php
}//ol
?>  
</div>

<script type="text/javascript" language="javascript">
    jQuery(document).ready(function(){
        jQuery(".goldnew").hover(function(){
            jQuery(this).find(".goldnew-onhover").show();
        },function() {
            jQuery(this).find('span.goldnew-onhover').fadeOut("slow");
        });    
        jQuery(".featurednew").hover(function(){            
            jQuery(this).find("span.featurednew-onhover").show();
        },function() {
            jQuery(this).find('.featurednew-onhover').fadeOut("slow");
        });
    });
</script>
