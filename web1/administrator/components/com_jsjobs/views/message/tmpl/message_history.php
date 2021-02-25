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

?>

<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=message&view=message&layout=messages"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Messages'); ?></span></div>

        <div class="admin-massage-history-main">
            <div class="massage-history-uper-area">
                <span class="massage-history-img-area">
                    <?php
                    $common = $this->getJSModel('common');
                    $path = $common->getCompanyLogo($this->summary->companyid, $this->summary->companylogo , $this->config);
                    ?>
                   <img class="myfilelogoimg" src="<?php echo $path;?>"/>
                </span>
                <span class="massage-history-content-area">
                    <span class="massage-history-job-area">
                       <strong><?php echo JText::_('Job'); ?>:</strong> 
                       <?php echo $this->summary->title; ?>
                    </span>
                    <span class="massage-history-jobseeker-area">
                        <strong><?php echo JText::_('Job Seeker'); ?>: </strong>
                        <?php
                            echo $this->summary->first_name;
                            if ($this->summary->middle_name)
                            echo ' ' . $this->summary->middle_name;
                            echo ' ' . $this->summary->last_name;
                        ?>
                    </span>
                    <span class="massage-history-resume-area">
                        <strong><?php echo JText::_('Resume'); ?>: </strong>
                        <?php echo $this->summary->application_title; ?>
                    </span>
                </span>
            </div>
            <div class="massage-history-lower-area">
                <form action="index.php" method="post" name="adminForm" id="adminForm">
                        <?php
                        $trclass = array("row0", "row1");
                        $isodd = 1;
                        ?>
                        <?php
                        $i = 0;


                        $k = 0;
                        for ($i = 0, $n = count($this->messages); $i < $n; $i++) {

                        $isodd = 1 - $isodd;
                        $message = $this->messages[$i];
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&c=message&view=message&layout=formmessage&cid[]=' . $message->id . '&sm=2');
                        ?>
                        <?php
                        $sendby = '';
                        if ($message->sendby == $message->employerid){
                            $sendby = JText::_('Employer Sent');
                            $classsendby = 'employersend';
                        }elseif ($message->sendby == $message->jobseekerid){
                            $sendby = JText::_('Job Seeker Sent');
                            $classsendby = 'jobseekersend';
                        }
                        ?>
                        <div class="<?php echo $trclass[$isodd]; ?>"> </div>
                        <span class="massage-history-edit <?php echo $classsendby; ?>">
                            <span class="massage-history-sent-title">
                                <strong>
                                    <?php echo $sendby; ?>
                                </strong>   
                            </span>
                            <span class="massage-history-achor">  
                                <a class="massage-history-anchor" href="<?php echo $link; ?>"><img src="components/com_jsjobs/include/images/edit-new.png"> <?php echo JText::_('Edit') ?></a>
                            </span>
                        </span>
                        <?php if( ! empty($message->subject)){ ?>
                            <span class="massage-history-subject-area">
                                <span class="massage-history-subject-wrap">

                                    <strong><?php echo JText::_('Subject'); ?>:</strong>   
                                    <?php echo $message->subject; ?>   
                                </span>
                            </span>
                        <?php
                        } ?>
                        <span class="massage-history-createddate-area"> 
                            <span class="massage-history-createddate-wrap">
                                <strong><?php echo JText::_('Created'); ?>:   </strong>

                                <?php $created = JHtml::_('date', $message->created, $this->config['date_format'] . ' H:i:s');
                                echo $created;
                                ?>      
                            </span>
                        </span>
                        <span class="massage-history-massage-area">
                            <span class="massage-history-massage-area-title"><strong><?php echo JText::_('Message'); ?>:</strong></span>
                            <span class="massage-history-massage-area-value"><?php echo $message->message; ?></span>
                        </span>
                        <?php
                        }
                        ?>
                        <?php echo $this->pagination->getListFooter(); ?>   
                    <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
                    <input type="hidden" name="c" value="message" />
                    <input type="hidden" name="view" value="message" />
                    <input type="hidden" name="layout" value="message_history" />
                    <input type="hidden" name="task" value="" />
                    <input type="hidden" name="bd" id="jobid" value="<?php echo $this->bd; ?>" />
                    <input type="hidden" name="rd" id="resumeid" value="<?php echo $this->resumeid; ?>" />
                    <input type="hidden" name="boxchecked" value="0" />
                </form>
            </div>
        </div>
              
<!--  -->
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





