<?php
/**
 * @version     1.1
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$tlpteam_params = JComponentHelper::getParams('com_tlpteam');
$image_storiage_path = $tlpteam_params->get('image_path','images/tlpteam');
// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_tlpteam/assets/css/tlpteam.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
    if(js('#jform_department option:selected').length == 0){
		js("#jform_department option[value=0]").attr('selected','selected');
	}
	js('input:hidden.skill1').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('skill1hidden')){
			js('#jform_skill1 option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_skill1").trigger("liszt:updated");
	js('input:hidden.skill2').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('skill2hidden')){
			js('#jform_skill2 option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_skill2").trigger("liszt:updated");
	js('input:hidden.skill3').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('skill3hidden')){
			js('#jform_skill3 option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_skill3").trigger("liszt:updated");
	js('input:hidden.skill4').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('skill4hidden')){
			js('#jform_skill4 option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_skill4").trigger("liszt:updated");
	js('input:hidden.skill5').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('skill5hidden')){
			js('#jform_skill5 option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_skill5").trigger("liszt:updated");
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'team.cancel') {
            Joomla.submitform(task, document.getElementById('team-form'));
        }
        else {
            
				js = jQuery.noConflict();
				if(js('#jform_profile_image').val() != ''){
					js('#jform_profile_image_hidden').val(js('#jform_profile_image').val());
				}
            if (task != 'team.cancel' && document.formvalidator.isValid(document.id('team-form'))) {
                
                Joomla.submitform(task, document.getElementById('team-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tlpteam&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="team-form" class="form-validate">

    
<?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
    <div class="form-horizontal">


        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_TLPTEAM_TITLE_TEAM', true)); ?>
        <div class="row-fluid">
            <div class="span9 form-horizontal">
                <fieldset class="adminform">

            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('department'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('department'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('position'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('position'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('email'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('email'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('phoneno'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('phoneno'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('mobileno'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('mobileno'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('personal_website'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('personal_website'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('location'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('location'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('profile_image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('profile_image'); ?></div>
			</div>
			<?php if (!empty($this->item->profile_image)) : ?>
			<div class="control-group">
				<div class="control-label"></div>
				<div class="controls"><img class="img-responsive" src="<?php echo JURI::root().$image_storiage_path.'/s_'.$this->item->profile_image; ?> " alt="<?php echo $this->item->name; ?>" style="width:60px;"/></div>
			</div>
			<?php endif; ?>
				<input type="hidden" name="jform[profile_image]" id="jform_profile_image_hidden" value="<?php echo $this->item->profile_image ?>" />
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('short_bio'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('short_bio'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('detail_bio'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('detail_bio'); ?></div>
			</div>
		<div class="span12">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('facebook'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('facebook'); ?></div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('twitter'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('twitter'); ?></div>
				</div>
			</div>
		</div>
		<div class="span12">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('linkedin'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('linkedin'); ?></div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('google_plus'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('google_plus'); ?></div>
				</div>
			</div>
		</div>
		<div class="span12">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('youtube'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('youtube'); ?></div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('vimeo'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('vimeo'); ?></div>
				</div>
			</div>
		</div>
		<div class="span12">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('instagram'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('instagram'); ?></div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('xing'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('xing'); ?></div>
				</div>
			</div>
		</div>
		<div class="span12">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('joomla'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('joomla'); ?></div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('wordpress'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('wordpress'); ?></div>
				</div>
			</div>
		</div>
		<div class="span12">
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('behance'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('behance'); ?></div>	
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('dribbble'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('dribbble'); ?></div>
				</div>
			</div>
		</div>
			<div class="control-group">
			<div class="span5">
				<div class="control-label"><?php echo $this->form->getLabel('skill1'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('skill1'); ?></div>
			</div>
			<div class="span4">
				<div class="control-label"><?php echo $this->form->getLabel('skill1_no'); ?></div>
				<div class="controls1"><?php echo $this->form->getInput('skill1_no'); ?></div>
			</div>	
			</div>

			<?php
				foreach((array)$this->item->skill1 as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="skill1" name="jform[skill1hidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			
			<div class="control-group">
			<div class="span5">
				<div class="control-label"><?php echo $this->form->getLabel('skill2'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('skill2'); ?></div>
			</div>

			<div class="span4">
				<div class="control-label"><?php echo $this->form->getLabel('skill2_no'); ?></div>
				<div class="controls1"><?php echo $this->form->getInput('skill2_no'); ?></div>
			</div>
			</div>

			<?php
				foreach((array)$this->item->skill2 as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="skill2" name="jform[skill2hidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>			

			<div class="control-group">
			<div class="span5">
				<div class="control-label"><?php echo $this->form->getLabel('skill3'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('skill3'); ?></div>
			</div>
			
			<div class="span4">
				<div class="control-label"><?php echo $this->form->getLabel('skill3_no'); ?></div>
				<div class="controls1"><?php echo $this->form->getInput('skill3_no'); ?></div>
			</div>
			</div>

			<?php
				foreach((array)$this->item->skill3 as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="skill3" name="jform[skill3hidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>
			<div class="control-group">
			<div class="span5">
				<div class="control-label"><?php echo $this->form->getLabel('skill4'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('skill4'); ?></div>
			</div>
			
			<div class="span4">
				<div class="control-label"><?php echo $this->form->getLabel('skill4_no'); ?></div>
				<div class="controls1"><?php echo $this->form->getInput('skill4_no'); ?></div>
			</div>
			</div>
			<?php
				foreach((array)$this->item->skill4 as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="skill4" name="jform[skill4hidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>

			<div class="control-group">
			<div class="span5">
				<div class="control-label"><?php echo $this->form->getLabel('skill5'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('skill5'); ?></div>
			</div>
			
			<div class="span4">
				<div class="control-label"><?php echo $this->form->getLabel('skill5_no'); ?></div>
				<div class="controls1"><?php echo $this->form->getInput('skill5_no'); ?></div>
			</div>
			</div>

			<?php
				foreach((array)$this->item->skill5 as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="skill5" name="jform[skill5hidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>

			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>


                </fieldset>
            </div>

            <div class="span3">
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('language'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('language'); ?></div>
				</div>
				<div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('access'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('access'); ?></div>
				</div>

			</div>

        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>