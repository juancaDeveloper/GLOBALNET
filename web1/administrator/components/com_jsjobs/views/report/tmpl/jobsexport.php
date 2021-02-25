<?php
//	echo '<pre>';print_r($this->lists);exit;

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
jimport('joomla.html.pane');

$document = JFactory::getDocument();
$document->addStyleSheet('../components/com_jsjobs/css/token-input-jsjobs.css');
$document->addScript('../components/com_jsjobs/js/jquery.tokeninput.js');

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
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;

?>
<div id="jsjobs-wrapper">
    <div id="jsjobs-menu">
        <?php include_once('components/com_jsjobs/views/menu.php'); ?>
    </div>    
    <div id="jsjobs-content">
        <div id="jsjobs-heading"><a id="backimage" href="index.php?option=com_jsjobs"><img src="components/com_jsjobs/include/images/back-icon.png" alt="<?php echo JText::_('Back');?>" ></a>
        	<span id="heading-text"><?php echo JText::_('Export Jobs'); ?></span>
        </div>
        <form action="index.php" method="POST" name="adminForm" id="adminForm">
            <div class="js-form-area js-jobs-from-export">
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Company'); ?>:</label>
                    <div class="jsjobs-value"> <?php echo $this->lists['companies'];?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Job Type'); ?>:</label>
                    <div class="jsjobs-value"> <?php echo $this->lists['jobtype'];?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Job Category'); ?>:</label>
                    <div class="jsjobs-value"> <?php echo $this->lists['jobcategory'];?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Job Subcategory'); ?>:</label>
                    <div class="jsjobs-value"><?php echo $this->lists['subcategory']; ?> </div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Career Level'); ?>:</label>
                    <div class="jsjobs-value"> <?php echo $this->lists['careerlevel'];?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Job Status'); ?>:</label>
                    <div class="jsjobs-value"><?php echo $this->lists['jobstatus']; ?> </div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Shift'); ?>:</label>
                    <div class="jsjobs-value"> <?php echo $this->lists['shift'];?></div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Gender'); ?>:</label>
                    <div class="jsjobs-value"><?php echo $this->lists['gender']; ?> </div>
                </div>
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Workpermit'); ?>:</label>
                    <div class="jsjobs-value"><?php echo $this->lists['workpermit']; ?> </div>
                </div>
                
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Job Location'); ?>:</label>
                    <div class="jsjobs-value">
                		<input class="inputbox" type="text" name="city" id="city" size="40" value="" /> 
                		<input class="inputbox" type="hidden" name="citynames" id="citynames" value="" /> 
            		</div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Status'); ?>:</label>
                    <div class="jsjobs-value">
                		<?php echo $this->lists['status']; ?> 
            		</div>
                </div>

                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Job Gold Featured'); ?>:</label>
                    <div class="jsjobs-value">
                		<?php echo $this->lists['isgfcombo']; ?> 
            		</div>
                </div>
                
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('Start Date'); ?>:</label>
                    <div class="jsjobs-value">
                		<?php 
                		$fromdate = JHtml::_('date', strtotime(date('Y-m-d')." -30 days"), 'Y-m-d');
						$fromdatevalue = JHtml::_('date', $fromdate, $this->config['date_format'],true, true);
                		echo JHTML::_('calendar', $fromdatevalue, 'fromdate', 'job_fromdate', $js_dateformat, array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19'));
                		 ?> 
            		</div>
                </div>
                
                <div class="js-form-wrapper">
                    <label class="jsjobs-title" for="title"><?php echo JText::_('End Date'); ?>:</label>
                    <div class="jsjobs-value">
                		<?php 
                		$todate = JHtml::_('date', strtotime(date('Y-m-d')), 'Y-m-d');
                		$todatevalue = JHtml::_('date', $todate, $this->config['date_format'],true, true);
                		echo JHTML::_('calendar', $todatevalue, 'todate', 'job_todate', $js_dateformat, array('class' => 'inputbox', 'size' => '10', 'maxlength' => '19'));
                		?> 
            		</div>
                </div>


                <input type="hidden" name="check" value="" />
                <input type="hidden" name="task" value="report.exportjobsdata" />
                <input type="hidden" name="option" value="<?php echo $this->option; ?>" />
            </div>
            <div class="js-buttons-area">
                <input type="submit" class="js-btn-save" name="submit_app" value="<?php echo JText::_('Export Data'); ?>" />
            </div>
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
            jQuery("#city").tokenInput("<?php echo JURI::root()."index.php?option=com_jsjobs&c=cities&task=getaddressdatabycityname";?>", {
                theme: "jsjobs",
                preventDuplicates: true,
                hintText: "<?php echo JText::_('Type In A Search'); ?>",
                noResultsText: "<?php echo JText::_('No Results'); ?>",
                searchingText: "<?php echo JText::_('Searching...');?>",
                onAdd: function(item) {
                    if (item.id > 0) {
                    	// code to add city names as comma seprated values to hidden field
                    	var current_name = item.name;
                        var citynames = jQuery('input#citynames').val();
                        if(citynames != ''){
                        	current_name = " : "+current_name;
                        }
                        citynames = citynames + current_name;
                        jQuery('input#citynames').val(citynames);
                    }
                }
            });

    jQuery('#adminForm').submit(function() {
    	jQuery(this).find('select.inputbox').each(function() {
		    var combo_name  = jQuery(this).attr("name");
		    var combo_value  = jQuery(this).find('option:selected').text();
			jQuery('#adminForm').append('<input type="hidden" name="'+combo_name+'_text" id="'+combo_name+'_text" value="'+combo_value+'" />');
		})
	});
});
    function getdepartments(src, val){
        jQuery("#"+src).html("Loading ...");
        jQuery.post("index.php?option=com_jsjobs&task=department.listdepartments",{val:val},function(data){
            if(data){
                var parentdiv = jQuery('label[for="'+src+'"]').parent();
                jQuery(parentdiv).find('div.jsjobs-value').html(data); //retuen value
            }
        });
    }

    function fj_getsubcategories(src, val){
        jQuery.post("index.php?option=com_jsjobs&task=subcategory.listsubcategories",{val:val},function(data){
            if(data){
                var parentdiv = jQuery('label[for="'+src+'"]').parent();
                jQuery(parentdiv).find('div.jsjobs-value').html(data); //retuen value
            }
        });
    }

</script>

<div id="jsjobsfooter">
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