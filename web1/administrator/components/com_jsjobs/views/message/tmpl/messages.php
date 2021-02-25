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
$document = JFactory::getDocument();

$status = array(
    '1' => JText::_('Approved'),
    '-1' => JText::_('Rejected'));

JHTML::_('behavior.calendar');
if ($this->config['date_format'] == 'm/d/Y')
    $dash = '/';
else
    $dash = '-';

$dateformat = $this->config['date_format'];
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
?>
<script>
    jQuery(document).ready(function(){
     
        
        jQuery("span#showhidefilter").find('img').click(function(e){
            e.preventDefault();
            var img2 = "<?php echo JURI::root()."administrator/components/com_jsjobs/include/images/filter-up.png";?>";
            var img1 = "<?php echo JURI::root()."administrator/components/com_jsjobs/include/images/filter-down.png";?>";
            if(jQuery('.default-hidden').is(':visible')){
                jQuery(this).attr('src',img1);
            }else{
                jQuery(this).attr('src',img2);
            }
            jQuery(".default-hidden").toggle();            
            var height = jQuery(this).parent().height();
            var imgheight = jQuery(this).height();
            var currenttop = (height-imgheight) / 2;
            jQuery(this).css('top',currenttop);
        });
    });
</script>   
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
    <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Messages'); ?></span></div>          
      <form action="index.php" method="post" name="adminForm" id="adminForm">
          <div id="jsjobs_filter_wrapper_messages">
           
                  <div id="checkallbox-main">
                      <div id="checkallbox">
                        <?php if (JVERSION < '3') { ?> 
                          <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
                         <?php  }else { ?>
                          <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
                        <?php } ?>
                       </div>
                  </div> 
              <div id="jsjobs-filter-main-new">
                  <span><input type="text" name="message_subject" id="message_subject" placeholder="<?php echo JText::_('Subject'); ?>" value="<?php if (isset($this->lists['subject'])) echo $this->lists['subject']; ?>" class="inputbox"  /></span>                   
                  <span><input type="text" name="message_employername" placeholder="<?php echo JText::_('Employer Name'); ?>" id="message_employername" size="15" value="<?php if (isset($this->lists['employername'])) echo $this->lists['employername']; ?>"/></span>
                  <span><input type="text" name="message_company" id="message_company" placeholder="<?php echo JText::_('Company'); ?>" value="<?php if (isset($this->lists['company'])) echo $this->lists['company']; ?>" class="inputbox"  /></span>
                  <span class="default-hidden"><input type="text" name="message_jobseekername" id="message_jobseekername" placeholder="<?php echo JText::_('Job Seeker Name'); ?>" value="<?php if (isset($this->lists['jobseekername'])) echo $this->lists['jobseekername']; ?>" class="inputbox"  /></span>
                  <span class="default-hidden"><input type="text" name="message_jobtitle" id="message_jobtitle" placeholder="<?php echo JText::_('Job Title'); ?>" value="<?php if (isset($this->lists['jobtitle'])) echo $this->lists['jobtitle']; ?>" class="inputbox"  /></span>
                  <span class="default-hidden"><input type="text" name="message_appname" id="message_appname" placeholder="<?php echo JText::_('Resume App Title'); ?>" value="<?php if (isset($this->lists['appname'])) echo $this->lists['appname']; ?>" class="inputbox"  /></span>
                  <span class="default-hidden"><?php echo $this->lists['status']; ?></span>
                  <span class="default-hidden"><?php echo $this->lists['conflict']; ?></span>
                  
                  <span><button class="js-button" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
                  <span><button class="js-button" onclick="document.getElementById('message_subject').value = '';
                     document.getElementById('message_employername').value = '';
                     document.getElementById('message_company').value = '';
                     document.getElementById('message_jobseekername').value = '';
                     document.getElementById('message_jobtitle').value = '';
                     document.getElementById('message_appname').value = '';
                     document.getElementById('message_conflicted').value = '';
                     document.getElementById('message_status').value = '';
                     this.form.submit();"><?php echo JText::_('Reset'); ?></button></span>
                  <span id="showhidefilter"><img src="components/com_jsjobs/include/images/filter-down.png"/></span>
              </div>
      </div>
        <?php if(!empty($this->items)){ ?>      
                <?php
                    jimport('joomla.filter.output');
                    $k = 0;

                    $companydeletetask = 'messageenforcedelete';
                    $deleteimg = 'publish_x.png';
                    $Deletealt = JText::_('Delete');

                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = JHTML::_('grid.id', $i, $row->id);
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&c=message&view=message&layout=message_history&bd=' . $row->jobid . '&rd=' . $row->resumeid . '&sm=3');
                ?>        

                      <div id="jsjobs-message-wrapper" class="js-col-xs-12 js-col-md-12">
                        <div id="message-header" class="js-col-xs-12 js-col-md-12">
                            <div id="message-head-content" class="js-col-xs-12 js-col-md-11">  
                                  <span class="checkbox-mesg" ><?php echo $checked; ?></span>
                                  <span class="js-col-xs-12 js-col-xs-6 message-title mesg-bold" ><span class="subjectlinks"><span class="mesg-title-text"><?php echo JText::_('Subject').' :'; ?></span>&nbsp;</span><a class="linkclass" href="<?php echo $link; ?>" ><?php echo $row->subject; ?></a></span>
                              </div>
                              <div id="mesg-corner" class="js-col-xs-12 js-col-md-1" >
                                  <?php if($row->status==1){?>
                                    <span class="mesg-right-corner"><img src="components/com_jsjobs/include/images/approved-corner.png" alt="app"><span class="listheadrightcorner-green"><?php echo JText::_('Approved'); ?></span></span>
                                    <?php }else{ ?>
                                    <span class="mesg-right-corner"><img src="components/com_jsjobs/include/images/reject-cornor.png" alt="rej"><span class="listheadrightcorner-red"><?php echo JText::_('Rejected'); ?></span></span>
                                 <?php } ?>
                                </span>
                              </div>
                          </div>
                          <div id="message-body" class="js-col-xs-12 js-col-md-12">
                              <span class="js-col-xs-12 js-col-md-12 mesg-color" id="rtitle"><span class="mesg-title-text Resumetitle"><?php echo JText::_('Resume Title').' :'; ?></span>&nbsp; <span class="msgResumetitle"><?php echo $row->application_title; ?></span></span>
                              <span class="js-col-xs-12 js-col-md-4 paddingclass mesg-color"><span class="mesg-title-text Employeename"><?php echo JText::_('Employer Name').' :'; ?></span>&nbsp; <span class="msgEmployeename"><?php echo $row->employername; ?></span></span>
                              <span class="js-col-xs-12 js-col-md-4 paddingclass mesg-color"><span class="mesg-title-text Company"><?php echo JText::_('Company').' :'; ?></span>&nbsp; <span class="msgCompany"><?php echo $row->companyname; ?></span></span>
                              <span class="js-col-xs-12 js-col-md-4 paddingclass mesg-color"><span class="mesg-title-text Jobtitle"><?php echo JText::_('Job Title').' :'; ?></span>&nbsp; <span class="msgJobtitle"><?php echo $row->jobtitle; ?></span></span>
                          </div>
                          <div id="message-footer" class="js-col-xs-12 js-col-md-12">
                              <span class="js-col-xs-12 js-col-md-8 createdfooter mesg-bold" ><?php echo JText::_('Posted').' :'; ?><span class="mesg-color">&nbsp;<?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></span></span>
                              <span class="js-col-xs-12 js-col-md-4 buttons-message">
                                  <a class="js-bottomspan" href="<?php echo $link; ?>"><img src="components/com_jsjobs/include/images/edit-new.png" alt="edit">&nbsp;&nbsp;<?php echo JText::_('Edit');?></a>
                                  <a class="js-bottomspan" href="javascript:void(0);" onclick="return confirmdeletemessage('cb<?php echo $i; ?>', 'message.<?php echo $companydeletetask; ?>');" ><img src="components/com_jsjobs/include/images/forced-delete-new.png" alt="fdel">&nbsp;&nbsp;<?php echo JText::_('Force Delete');?></a>
                              </span> 
                          </div>
                        </div>
                           <?php
                                $k = 1 - $k;
                            }

                            ?>
                      
                     
                 <div id="jsjobs-pagination-wrapper">
                    <?php echo $this->pagination->getLimitBox(); ?>
                    <?php echo $this->pagination->getListFooter(); ?>
                </div>
            <?php }else{ JSJOBSlayout::getNoRecordFound(); } ?>
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="jobid" id="jobid" value="<?php echo $row->jobid; ?>" />
                <input type="hidden" name="resumeid" id="resumeid" value="<?php echo $row->resumeid; ?>" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="c" value="message" />
                <input type="hidden" name="view" value="message" />
                <input type="hidden" name="layout" value="messages" />
            </form>
       
   </div>    
</div>

<div id="jsjobs-footer">
    <table width="100%" style="table-layout:fixed;">
        <tr><td height="15"></td></tr>
        <tr>
            <td style="vertical-align:top;" align="center">
                <a class="img" target="_blank" href="http://www.joomsky.com"><img src="http://www.joomsky.com/logo/jsjobscrlogo.png"></a>
                <br>
                Copyright &copy; 2008 - <?php echo  date('Y') ?> ,
                <span id="themeanchor"> <a class="anchor"target="_blank" href="http://www.burujsolutions.com">Buruj Solutions </a></span>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    function confirmdeletemessage(id, task) {
        if (confirm("<?php echo JText::_('Are You Sure?'); ?>") == true) {
            return listItemTask(id, task);
        } else
            return false;
    }
</script>
