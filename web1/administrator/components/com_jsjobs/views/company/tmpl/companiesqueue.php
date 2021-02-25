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
JHTML::_('behavior.calendar');
if ($this->config['date_format'] == 'm/d/Y')
    $dash = '/';
else
    $dash = '-';

if (JVERSION < 3) {
    JHtml::_('behavior.mootools');
    $document->addScript('../components/com_jsjobs/js/jquery.js');
} else {
    JHtml::_('behavior.framework');
    JHtml::_('jquery.framework');
}
$dateformat = $this->config['date_format'];
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;

$sort_combo = array(
    '0' => array('value' => 0, 'text' => JText::_('Sort By')),
    '1' => array('value' => 1, 'text' => JText::_('Category')),
    '2' => array('value' => 2, 'text' => JText::_('Created')),
    '3' => array('value' => 3, 'text' => JText::_('Status')),
    '4' => array('value' => 4, 'text' => JText::_('Location')),
    '5' => array('value' => 5, 'text' => JText::_('Company Name')),);
$sort_combo = JHTML::_('select.genericList', $sort_combo, 'js_sortby', 'class="inputbox" onchange="js_Ordering();"'.'', 'value', 'text',$this->js_sortby);
?>

<script type="text/javascript">
    function js_Ordering(){
        var val = jQuery('#js_sortby option:selected').val();
        jQuery('form#adminForm').submit();
    }

    function js_imgSort(){
        var val = jQuery('#js_sortby option:selected').val();
        if(val!=0){
            jQuery('#my_click').val('1');
            jQuery('form#adminForm').submit();
        }
    }

</script>

<script type="text/javascript">  
  function confirmdeletecompany(id, task) {
      if (confirm("<?php echo JText::_('Are You Sure?'); ?>") == true) {
          return listItemTask(id, task);
      } else
          return false;
  }
</script>


<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <form action="index.php" method="post" name="adminForm" id="adminForm">   
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs&c=jsjobs&view=jsjobs&layout=controlpanel"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a><span id="heading-text"><?php echo JText::_('Companies Approval Queue'); ?></span>
            <span id="sorting-wrapper">
            <span id="sorting-bar1">
                <?php echo $sort_combo ?>
            </span>
            <span id="sortimage">
                <?php if ($this->sort == 'asc') {$img = "components/com_jsjobs/include/images/up.png"; }else{$img = "components/com_jsjobs/include/images/down.png"; } ?>
                <a href="javascript: void(0);"onclick="js_imgSort();"><img src="<?php echo $img ?>"></a>
            </span>
            </span>

        </div>
            <div id="jsjobs_filter_wrapper_new">
        <div id="checkallbox-main">
            <div id="checkallbox">
                <?php if (JVERSION < '3') { ?> 
                    <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);highlightAll();" />
                <?php } else { ?>
                    <input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);highlightAll();" />
                 <?php } ?>
            </div>
        </div>    
        <div id="jsjobs-filter-main-new">
            <span class="jsjobs-filter-new"><input type="text" name="companyname" placeholder="<?php echo JText::_('Company Name'); ?>" id="companyname" value="<?php if (isset($this->lists['companyname'])) echo $this->lists['companyname']; ?>"  /></span>
            <span class="jsjobs-filter-new"><?php echo $this->lists['jobcategory']; ?></span>
            <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists["datefrom"], 'datefrom', 'datefrom', $js_dateformat, array('placeholder' => JText::_('Date From'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
            <span class="jsjobs-filter-new"><span class="default-hidden"><?php echo JHTML::_('calendar', $this->lists["dateto"], 'dateto', 'dateto', $js_dateformat, array('placeholder' => JText::_('Date To'),'class' => 'inputbox validate-since', 'size' => '10', 'maxlength' => '19')); ?></span></span>
            <span class="jsjobs-filter-new"><?php echo $this->lists['isgfcombo']; ?></span>
            <span class="jsjobs-filter-new"><button class="js-button" id="js-search" onclick="this.form.submit();"><?php echo JText::_('Search'); ?></button></span>
            <span class="jsjobs-filter-new"><button class="js-button" name="reset" id="js-reset" ><?php echo JText::_('Reset'); ?></button></span>
            <span id="showhidefilter"><img src="components/com_jsjobs/include/images/filter-down.png"/></span>
           </div>    
        </div>
        <?php if(!empty($this->items)){
                    jimport('joomla.filter.output');
                    $k = 0;
                    $approvetask = 'companyapprove';
                    $companydeletetask = 'companyenforcedelete';
                    $approveimg = 'tick.png';
                    $rejecttask = 'companyreject';
                    $rejectimg = 'publish_x.png';
                    $Approvealt = JText::_('Approve');
                    $Rejectalt = JText::_('Reject');
                    $common = $this->getJSModel('common');
                    for ($i = 0, $n = count($this->items); $i < $n; $i++) {
                        $row = $this->items[$i];
                        $checked = '<input type="checkbox" onclick="single_highlight('.$row->id.');" id="cb'.$i.'" name="cid[]" value="'.$row->id.'" />';
                        $link = JFilterOutput::ampReplace('index.php?option=' . $this->option . '&task=company.edit&cid[]=' . $row->id.'&callfrom=companiesqueue');
                        ?>

                <div id="js-jobs-comp-listwrapper"  class="jsjobs-check-container select_<?php echo $row->id;?>">
                    <div id="jsjobs-top-comp-left">
                        <?php 
                        $path = $common->getCompanyLogo($row->id, $row->logofilename , $this->config);
                        ?>

                       <a class="jsjobs-leftimg" href="<?php echo $link; ?>" ><img class="myfilelogoimg" src="<?php echo $path;?>"/></a>   
                    </div>
                    <div id="jsjobs-top-comp-right">
                        <div id="jsjobslist-comp-header" class="jsjobsqueuereletive">
                          <div id="innerheaderlefti">
                             <span class="datablockhead-left"><span class="notbold color-blue font-mysize"><a href="<?php echo $link; ?>"><?php echo $row->name; ?></a></span>
                                <?php if($row->isgoldcompany==1 AND date('Y-m-d',strtotime($row->endgolddate)) > date('Y-m-d')){?>
                                  <span class="goldnew" data-id="<?php echo $row->id; ?>"><span class="jsjobs-goldstatus"><?php echo JText::_('Gold'); ?></span><span class="goldnew-onhover" id="gold<?php echo $row->id; ?>" style="display:none"><?php echo JText::_("Expiry Date").': '.JHTML::_('date',strtotime($row->endgolddate),$this->config['date_format']); ?><img src="components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                                <?php } ?>
                                <?php if($row->isfeaturedcompany==1 AND date('Y-m-d',strtotime($row->endfeatureddate)) > date('Y-m-d')){?>
                                  <span class="featurednew"><span class="jsjobs-faturedstatus"><?php echo JText::_('Featured'); ?></span><span class="featurednew-onhover" style="display:none"><?php echo JText::_("Expirey Date").': '.JHTML::_('date',strtotime($row->endfeatureddate),$this->config['date_format']); ?><img src="components/com_jsjobs/include/images/bottom-tool-tip.png" alt="downhover-part"></span></span>
                                <?php } ?>
                             </span>
                          </div>
                          <span id="js-queues-statuses"><?php
                              $class_color = '';
                              $arr = array();
                              if($row->isgoldcompany==0){ ?>
                                <img class="q-image" src="components/com_jsjobs/include/images/q-gold.png"><span class="q-gold forapproval"><?php echo JText::_('Gold'); ?></span><?php
                                $class_color = 'q-gold';
                                $arr['gold'] = 1;
                              }
                              if($row->isfeaturedcompany==0){ 
                                if($class_color==''){
                                  echo '<img class="q-image" src="components/com_jsjobs/include/images/q-feature.png">';
                                }
                                ?>
                                <span class="q-feature forapproval"><?php echo JText::_('Featured'); ?></span><?php 
                                $class_color = 'q-feature';
                                $arr['feature'] = 1;
                              }
                              if($row->status==0){
                                if($class_color==''){
                                  echo '<img class="q-image" src="components/com_jsjobs/include/images/q-comp.png">';
                                }?>
                                <span class="q-self forapproval"><?php echo JText::_('Company'); ?></span><?php
                                $class_color = 'q-self';
                                  $arr['self'] = 1;
                                } ?>
                                <span class="<?php echo $class_color; ?> waiting-text"><?php echo JText::_('Waiting for approval'); ?></span>
                            </span>                          
                        </div>
                          <div id="jsjobslist-comp-body">
                          <span class="datablock" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('jobcategory', 1 )); ?> :</span><span class="notbold color"><?php echo JText::_($row->cat_title); ?></span></span>
                          <span class="datablock" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('url', 1 )); ?> :</span><a class="notbold" href="<?php echo $row->url; ?>"><?php echo $row->url; ?></a></span>
                          <span class="datablock location" ><span class="title"><?php echo JText::_($this->getJSModel('fieldordering')->getFieldTitleByFieldAndFieldfor('city', 1 )); ?> :</span><span class="notbold color"><?php echo $row->location; ?></span></span>
                          </div>
                    </div>
                    <div id="jsjobs-bottom-comp">
                        <div id="bottomleftnew">
                            <span class="bottomcheckbox ss_<?php echo $row->id;?>"><?php echo $checked; ?></span>
                            <span class="js-created"><b><?php echo JText::_('Created'); ?></b>:&nbsp;<span class="color"><?php echo JHtml::_('date', $row->created, $this->config['date_format']); ?></span></span>
                        </div>
                        <div id="bottomrightnew"> <?php
                          $total = count($arr);
                          if($total==3){
                            $objid = 4; //for all
                          }elseif($total!=1){
                            if(isset($arr['self']) && isset($arr['gold'])){
                              $objid = 1; // for comp&gold
                            }elseif(isset($arr['self']) && isset($arr['feature'])){
                              $objid = 2; //for comp&feature
                            }else{
                              $objid = 3; //for gold&feature
                            }
                          }
                          if($total==1){
                            if(isset($arr['self'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=company&task=companyapprove&id='.$row->id.'"><img src="components/com_jsjobs/include/images/hired-new.png">  '.JText::_('Approve').'</a>';
                            }elseif(isset($arr['gold'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=company&task=goldcompanyapprove&id='.$row->id.'"><img src="components/com_jsjobs/include/images/hired-new.png">  '.JText::_('Approve').'</a>';
                            }elseif(isset($arr['feature'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=company&task=featuredcompanyapprove&id='.$row->id.'"><img src="components/com_jsjobs/include/images/hired-new.png">  '.JText::_('Approve').'</a>';
                            }
                          }else{ ?>
                            <div class="js-bottomspan jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover="approveActionPopup('<?php echo $row->id; ?>');"><img src="components/com_jsjobs/include/images/hired-new.png">&nbsp;&nbsp;<?php echo JText::_('Approve');?>
                              <div id="jsjobs-queue-actionsbtn" class="jobsqueueapprove_<?php echo $row->id;?>">
                                <?php
                                  if(isset($arr['self'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=company&task=companyapprove&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/company.png">'.JText::_("Company Approve").'</a>';
                                  }
                                  if(isset($arr['gold'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=company&task=goldcompanyapprove&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/addgold.png">'.JText::_("Gold Approve").'</a>';
                                  }
                                  if(isset($arr['feature'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=company&task=featuredcompanyapprove&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/addfeatured.png">'.JText::_("Feature Approve").'</a>';
                                  }
                                  echo '<a id="jsjobs-act-row-all" class="jsjobs-act-row-all" href="index.php?option=com_jsjobs&c=company&task=allapprove&alltype='.$objid.'&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/select-all.png">'.JText::_("All Approve").'</a>';
                                ?>
                              </div>
                            </div>
                          <?php
                          } // End approve
                          if($total==1){
                            if(isset($arr['self'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=company&task=companyreject&id='.$row->id.'"><img src="components/com_jsjobs/include/images/reject-s.png">  '.JText::_('Reject').'</a>';
                            }elseif(isset($arr['gold'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=company&task=goldcompanyreject&id='.$row->id.'"><img src="components/com_jsjobs/include/images/reject-s.png">  '.JText::_('Reject').'</a>';
                            }elseif(isset($arr['feature'])){
                              echo '<a class="js-bottomspan" href="index.php?option=com_jsjobs&c=company&task=featuredcompanyreject&id='.$row->id.'"><img src="components/com_jsjobs/include/images/reject-s.png">  '.JText::_('Reject').'</a>';
                            }
                          }else{ ?>
                            <div class="js-bottomspan jobsqueue-approvalqueue" onmouseout="hideThis(this);" onmouseover="rejectActionPopup('<?php echo $row->id; ?>');"><img src="components/com_jsjobs/include/images/reject-s.png">&nbsp;&nbsp;<?php echo JText::_('Reject');?>
                              <div id="jsjobs-queue-actionsbtn" class="jobsqueuereject_<?php echo $row->id;?>">
                                <?php
                                  if(isset($arr['self'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=company&task=companyreject&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/company.png">'.JText::_("Company Reject").'</a>';
                                  }
                                  if(isset($arr['gold'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=company&task=goldcompanyreject&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/addgold.png">'.JText::_("Gold Reject").'</a>';
                                  }
                                  if(isset($arr['feature'])){
                                    echo '<a id="jsjobs-act-row" class="jsjobs-act-row" href="index.php?option=com_jsjobs&c=company&task=featuredcompanyreject&id='.$row->id.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/addfeatured.png">'.JText::_("Feature Reject").'</a>';
                                  }
                                  echo '<a id="jsjobs-act-row-all" class="jsjobs-act-row-all" href="index.php?option=com_jsjobs&c=company&task=allreject&id='.$objid.'"><img class="jobs-action-image" src="components/com_jsjobs/include/images/select-all.png">'.JText::_("All Reject").'</a>';
                                ?>
                              </div>
                            </div>
                          <?php
                          }//End Reject ?>
                          <a class="js-bottomspan" href="javascript:void(0);" onclick="return confirmdeletecompany('cb<?php echo $i; ?>', 'company.remove');"><img src="components/com_jsjobs/include/images/delete-icon-new.png" alt="del">&nbsp;&nbsp;<?php echo JText::_('Delete');?></a>
                          <a class="js-bottomspan" href="javascript:void(0);" onclick="return confirmdeletecompany('cb<?php echo $i; ?>', 'company.<?php echo $companydeletetask; ?>');"><img src="components/com_jsjobs/include/images/forced-delete-new.png">&nbsp;&nbsp;<?php echo JText::_('Force Delete');?></a>
                        </div>
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
                <input type="hidden" name="c" value="company" />
                <input type="hidden" name="view" value="company" />
                <input type="hidden" name="callfrom" value="companiesqueue" />
                <input type="hidden" name="layout" value="companiesqueue" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="sortby" value="<?php echo $this->sort;?>"/>
                <input type="hidden" id="my_click" name="my_click" value=""/>
                <?php echo JHTML::_('form.token'); ?>
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

        jQuery('#js-reset').click(function(e){
            jQuery('#companyname').val('');
            jQuery('#jobcategory').prop('selectedIndex', 0);
            jQuery('#dateto').val('');
            jQuery('#datefrom').val('');
            jQuery('#isgfcombo').prop('selectedIndex', 0);
            //this.form.submit();
        });
    });

    function approveActionPopup(id){
      var cname = '.jobsqueueapprove_'+id;
      jQuery(cname).show();
      jQuery(cname).mouseout(function(){
        jQuery(cname).hide();
      });
    }

    function rejectActionPopup(id){
      var cname = '.jobsqueuereject_'+id;
      jQuery(cname).show();
      jQuery(cname).mouseout(function(){
        jQuery(cname).hide();
      });
    }

    function hideThis(obj){
      jQuery(obj).find('div#jsjobs-queue-actionsbtn').hide();
    }

    function single_highlight(id){
      if (jQuery("div.select_"+id+" span input:checked").length > 0){
        showBorder(id);
      }else{
        hideBorder(id);
      }
    }

    function showBorder(id){
      jQuery("div.select_"+id).addClass('ck_blue');
      jQuery("span.ss_"+id).addClass('ck_blue');
    }

    function hideBorder(id){
      jQuery("div.select_"+id).removeClass('ck_blue');
      jQuery("span.ss_"+id).removeClass('ck_blue');
    }

    function highlightAll(){
      if (jQuery("span.bottomcheckbox input").is(':checked') == false){
        jQuery("div.jsjobs-check-container").removeClass('ck_blue');
        jQuery("span.bottomcheckbox").removeClass('ck_blue');
      }
      if (jQuery("span.bottomcheckbox input").is(':checked') == true){
        jQuery("div.jsjobs-check-container").addClass('ck_blue');
        jQuery("span.bottomcheckbox").addClass('ck_blue');
      }
    }
</script>
