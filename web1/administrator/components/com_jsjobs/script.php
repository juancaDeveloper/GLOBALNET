<?php

/** @Copyright Copyright (C) 2011
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 + Created by:	Ahmad Bilal
 * Company:		Buruj Solutions
 + Contact:		www.burujsolutions.com , ahmad@burujsolutions.com
 * Created on:	Oct 22, 2011
 ^
 + Project:		JS Documentation 
*/
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class com_JSJobsInstallerScript
{

	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{

		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_jsjobs&view=installer&layout=sampledata');
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('JS_JSJOBS_UNINSTALL_TEXT') . '</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) {

		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		jimport('joomla.installer.helper');
		$installer = new JInstaller();
		//$installer->_overwrite = true;

		$ext_module_path = JPATH_ADMINISTRATOR.'/components/com_jsjobs/extensions/modules/';
		
			$extensions = array(
				'mod_hotjsjobs.zip'=>'JS Hot Jobs Module',
				'mod_jsfeaturedcompanies.zip'=>'JS Featured Companies Module',
				'mod_jsfeaturedjobs.zip'=>'JS Featured Jobs Module',
				'mod_jsfeaturedresumes.zip'=>'JS Featured Resumes Module',
				'mod_jsgoldcompanies.zip'=>'JS Gold Companies Module',
				'mod_jsgoldjobs.zip'=>'JS Gold Jobs Module',
				'mod_jsgoldresumes.zip'=>'JS Gold Resumes Module',
				'mod_jsjobcategories.zip'=>'JS Job Categories Module',
				'mod_jsjobscity.zip'=>'JS Jobs BY City Module',
				'mod_jsjobscountry.zip'=>'JS Jobs BY Country Module',
				'mod_jsjobslogin.zip'=>'JS Jobs Login Module',
				'mod_jsjobsonmap.zip'=>'JS Jobs On Map',
				'mod_jsjobspackage.zip'=>'JS Jobs Package',
				'mod_jsjobssearch.zip'=>'Search JS Jobs Module',
				'mod_jsjobsstates.zip'=>'JS Jobs BY State Module',
				'mod_jsjobsstats.zip'=>'JS Jobs Stats Module',
				'mod_jsresumesearch.zip'=>'JS Resume Search Module',
				'mod_jstopresume.zip'=>'JS Top Resume Module',
				'mod_newestjsjobs.zip'=>'Newest JS Jobs Module',
				'mod_newestjsresume.zip'=>'JS Newest Resumes Module',
				'mod_topjsjobs.zip'=>'Top JS Jobs Module'
			 );
             
			echo "<br /><br /><font color='green'><strong>Installing modules</strong></font>";
			 foreach( $extensions as $ext => $extname ){
				  $package = JInstallerHelper::unpack( $ext_module_path.$ext );
				  if( $installer->install( $package['dir'] ) ){
					echo "<br /><font color='green'>$extname successfully installed.</font>";
				  }else{
					echo "<br /><font color='red'>ERROR: Could not install the $extname. Please install manually.</font>";
				  }
				JInstallerHelper::cleanupInstall( $ext_module_path.$ext, $package['dir'] ); 
			}


			echo "<br /><br /><font color='green'><strong>Installing plugins</strong></font>";
			$ext_plugin_path = JPATH_ADMINISTRATOR.'/components/com_jsjobs/extensions/plugins/';
			$extensions = array( 
				'plg_jsfeaturedcompanies.zip'=>'JS Featured Companies Plugin',
				'plg_jsfeaturedjobs.zip'=>'JS Featured Jobs Plugin',
				'plg_jsfeaturedresumes.zip'=>'JS Featured Resumes Plugin',
				'plg_jsgoldcompanies.zip'=>'JS Gold Companies Plugin',
				'plg_jsgoldjobs.zip'=>'JS Gold Jobs Plugin',
				'plg_jsgoldresumes.zip'=>'JS Gold Resumes Plugin',
				'plg_jshotjobs.zip'=>'JS Hot Jobs Plugin',
				'plg_jsjobcategories.zip'=>'JS Job Categories Plugin',
				'plg_jsjobscities.zip'=>'JS Jobs BY City Plugin',
				'plg_jsjobscountries.zip'=>'JS Jobs BY Country Plugin',
				'plg_jsjobsloginredirect.zip'=>'JS Jobs Login Redirect Plugin',
				'plg_jsjobsregister.zip'=>'JS Jobs Register Plugin',
				'plg_jsjobsstates.zip'=>'JS Jobs BY State Plugin',
				'plg_jsnewestjobs.zip'=>'JS Newest Jobs Plugin',
				'plg_jsnewestresume.zip'=>'JS Newest Resumes Plugin',
				'plg_jssearchjobs.zip'=>'JS Search Jobs Plugin',
				'plg_jssearchresumes.zip'=>'JS Search Resumes Plugin',
				'plg_jstopjobs.zip'=>'JS Top Jobs Plugin',
				'plg_jstopresume.zip'=>'JS Top Resumes Plugin'
			 );
				 
			 foreach( $extensions as $ext => $extname ){
				  $package = JInstallerHelper::unpack( $ext_plugin_path.$ext );
				  if( $installer->install( $package['dir'] ) ){
					echo "<br /><font color='green'>$extname successfully installed.</font>";
				  }else{
					echo "<br /><font color='red'>ERROR: Could not install the $extname. Please install manually.</font>";
				  }
				JInstallerHelper::cleanupInstall( $ext_plugin_path.$ext, $package['dir'] ); 
			}
		
	}



}

