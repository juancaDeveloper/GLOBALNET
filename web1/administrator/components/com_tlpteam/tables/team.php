<?php
/**
 * @version     1.1
 * @package     com_tlpteam
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// No direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * team Table class
 */
class TlpteamTableteam extends JTable
{

	/**
	 * Constructor
	 *
	 * @param JDatabase A database connector object
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__tlpteam_team', 'id', $db);
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param    array        Named array
	 *
	 * @return    null|string    null is operation was satisfactory, otherwise returns an error
	 * @see        JTable:bind
	 * @since      1.5
	 */
	public function bind($array, $ignore = '')
	{

			$app = JFactory::getApplication();
	    	$input = $app ->input;
	    	$tlpteam_params = JComponentHelper::getParams('com_tlpteam');

				//Support for file field: profile_image
				$input = JFactory::getApplication()->input;
				$files = $input->files->get('jform');
				if(!empty($files['profile_image'])){
					jimport('joomla.filesystem.file');
					$file = $files['profile_image'];

					//Check if the server found any error.
					$fileError = $file['error'];
					$message = '';
					if($fileError > 0 && $fileError != 4) {
						switch ($fileError) {
							case 1:
								$message = JText::_( 'File size exceeds allowed by the server');
								break;
							case 2:
								$message = JText::_( 'File size exceeds allowed by the html form');
								break;
							case 3:
								$message = JText::_( 'Partial upload error');
								break;
						}
						if($message != '') {
							JError::raiseWarning(500, $message);
							return false;
						}
					}
					else if($fileError == 4){
						if(isset($array['profile_image_hidden'])){
							$array['profile_image'] = $array['profile_image_hidden'];
						}
					}
					else{		
				    	$image_small_width = $tlpteam_params->get('smallimage_width','200');
				    	$image_small_height = $tlpteam_params->get('smallimage_height','200');
						$image_medium_width = $tlpteam_params->get('mediumimage_width','400');
						$image_medium_height = $tlpteam_params->get('mediumimage_height','500');
						$image_large_width = $tlpteam_params->get('largeimage_width','600');
						$image_large_height = $tlpteam_params->get('largeimage_height','700');
				   		$image_storiage_path = $tlpteam_params->get('image_path','images/tlpteam');
						$image_storiage_folder = JPATH_ROOT.'/'. $image_storiage_path.'/';
						

						$folder = $image_storiage_folder;
						if(!file_exists($folder)){
							mkdir($folder, 0777, true);
						}
						// jimport('joomla.filter.output');
						// if ($array['id'] == 0)
						// 	{
						// 		$db = JFactory::getDbo();
						// 		$query = $db->getQuery(true);

						// 		$query->select($db->quoteName('id'))
						// 		->from($db->quoteName('#__tlpteam_team'))
						// 		->order($db->quoteName('id') . ' DESC');

						// 		$db->setQuery($query);
						// 		$result = $db->loadResult();
						// 		$result1=$result+1;
						// 		$img_name='team_'.$result1;
						// 	}else{
						// 		$img_name='team_'.$array['id'];
						// 	}
						// Replace any special characters in the filename
						jimport('joomla.filesystem.file');
						$filename = JFile::stripExt($file['name']);
						$extension = JFile::getExt($file['name']);
						$filename = preg_replace("/[^A-Za-z0-9]/i", "-", $filename);
						$image_name = $filename .'-'.time(). '.' . $extension;		


						//$image_name = $img_name.".jpg";
						$image_small = 's_'.$image_name;
						$image_medium = 'm_'.$image_name;
						$image_large = 'l_'.$image_name;
										
						// $image_name = $img_name.".jpg";
						// $image_small = 's_'.$image_name;
						// $image_medium = 'm_'.$image_name;
						// $image_large = 'l_'.$image_name;
					
						self::createImage($file['tmp_name'],$image_small,$image_medium,$image_large,$image_small_width, $image_small_height, $image_medium_width, $image_medium_height, $image_large_width, $image_large_height, '', $image_storiage_folder, $file['name']);

						$array['profile_image'] = $image_name;

					}
				}

		//Support for multiple or not foreign key field: skill1
			if(!empty($array['skill1'])){
				if(is_array($array['skill1'])){
					$array['skill1'] = implode(',',$array['skill1']);
				}
				else if(strrpos($array['skill1'], ',') != false){
					$array['skill1'] = explode(',',$array['skill1']);
				}
			}
			else {
				$array['skill1'] = '';
			}

		//Support for multiple or not foreign key field: skill2
			if(!empty($array['skill2'])){
				if(is_array($array['skill2'])){
					$array['skill2'] = implode(',',$array['skill2']);
				}
				else if(strrpos($array['skill2'], ',') != false){
					$array['skill2'] = explode(',',$array['skill2']);
				}
			}
			else {
				$array['skill2'] = '';
			}

		//Support for multiple or not foreign key field: skill3
			if(!empty($array['skill3'])){
				if(is_array($array['skill3'])){
					$array['skill3'] = implode(',',$array['skill3']);
				}
				else if(strrpos($array['skill3'], ',') != false){
					$array['skill3'] = explode(',',$array['skill3']);
				}
			}
			else {
				$array['skill3'] = '';
			}

		//Support for multiple or not foreign key field: skill4
			if(!empty($array['skill4'])){
				if(is_array($array['skill4'])){
					$array['skill4'] = implode(',',$array['skill4']);
				}
				else if(strrpos($array['skill4'], ',') != false){
					$array['skill4'] = explode(',',$array['skill4']);
				}
			}
			else {
				$array['skill4'] = '';
			}

		//Support for multiple or not foreign key field: skill5
			if(!empty($array['skill5'])){
				if(is_array($array['skill5'])){
					$array['skill5'] = implode(',',$array['skill5']);
				}
				else if(strrpos($array['skill5'], ',') != false){
					$array['skill5'] = explode(',',$array['skill5']);
				}
			}
			else {
				$array['skill5'] = '';
			}
		$input = JFactory::getApplication()->input;
		$task = $input->getString('task', '');
		if(($task == 'save' || $task == 'apply') && (!JFactory::getUser()->authorise('core.edit.state','com_tlpteam') && $array['state'] == 1)){
			$array['state'] = 0;
		}
		if($array['id'] == 0){
			$array['created_by'] = JFactory::getUser()->id;
		}

		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}
		if (!JFactory::getUser()->authorise('core.admin', 'com_tlpteam.team.' . $array['id']))
		{
			$actions         = JFactory::getACL()->getActions('com_tlpteam', 'team');
			$default_actions = JFactory::getACL()->getAssetRules('com_tlpteam.team.' . $array['id'])->getData();
			$array_jaccess   = array();
			foreach ($actions as $action)
			{
				$array_jaccess[$action->name] = $default_actions[$action->name];
			}
			$array['rules'] = $this->JAccessRulestoArray($array_jaccess);
		}
		//Bind the rules for ACL where supported.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$this->setRules($array['rules']);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * This function convert an array of JAccessRule objects into an rules array.
	 *
	 * @param type $jaccessrules an arrao of JAccessRule objects.
	 */
	private function JAccessRulestoArray($jaccessrules)
	{
		$rules = array();
		foreach ($jaccessrules as $action => $jaccess)
		{
			$actions = array();
			foreach ($jaccess->getData() as $group => $allow)
			{
				$actions[$group] = ((bool) $allow);
			}
			$rules[$action] = $actions;
		}

		return $rules;
	}

	/**
	 * Overloaded check function
	 */
	public function check()
	{

		jimport('joomla.filter.output');
		
		// Check for existing name
		$query = $this->_db->getQuery(true)
			->select($this->_db->quoteName('id'))
			->from($this->_db->quoteName('#__tlpteam_team'))
			->where($this->_db->quoteName('name') . ' = ' . $this->_db->quote($this->name));
			
		$this->_db->setQuery($query);

		$xid = (int) $this->_db->loadResult();
		if ($xid && $xid != (int) $this->id)
		{
			//$this->setError(JText::_('Menu Name Already exist'));
			$this->alias = $this->name.$this->id;
			//return true;
		}
		
		if (empty($this->alias))
		{
		   $this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);


		//If there is an ordering column and this is a new row then get the next ordering value
		if (property_exists($this, 'ordering') && $this->id == 0)
		{
			$this->ordering = self::getNextOrder();
		}

		return parent::check();
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param    mixed    An optional array of primary key values to update.  If not
	 *                    set the instance property value is used.
	 * @param    integer  The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param    integer  The user id of the user performing the operation.
	 *
	 * @return    boolean    True on success.
	 * @since    1.0.4
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		// Initialise variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			// Nothing to set publishing state on, return false.
			else
			{
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));

				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where = $k . '=' . implode(' OR ' . $k . '=', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time'))
		{
			$checkin = '';
		}
		else
		{
			$checkin = ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// Update the publishing state for rows with the given primary keys.
		$this->_db->setQuery(
			'UPDATE `' . $this->_tbl . '`' .
			' SET `state` = ' . (int) $state .
			' WHERE (' . $where . ')' .
			$checkin
		);
		$this->_db->execute();

		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows()))
		{
			// Checkin each row.
			foreach ($pks as $pk)
			{
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks))
		{
			$this->state = $state;
		}

		$this->setError('');

		return true;
	}

	/**
	 * Define a namespaced asset name for inclusion in the #__assets table
	 * @return string The asset name
	 *
	 * @see JTable::_getAssetName
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_tlpteam.team.' . (int) $this->$k;
	}

	/**
	 * Returns the parent asset's id. If you have a tree structure, retrieve the parent's id using the external key field
	 *
	 * @see JTable::_getAssetParentId
	 */
	protected function _getAssetParentId(JTable $table = null, $id = null)
	{
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();
		// The item has the component as asset-parent
		$assetParent->loadByName('com_tlpteam');
		// Return the found asset-parent-id
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}

	public function delete($pk = null)
	{
		$this->load($pk);
		$result = parent::delete($pk);
		if ($result)
		{

			
	jimport('joomla.filesystem.file');
	$result = JFile::delete(JPATH_ADMINISTRATOR . '/components/com_tlpteam/images/photos/' . $this->profile_image);
		}

		return $result;
	}

	/*
    * Create Thumbnail
    */
    
    public  function createImage($src_file,$small_name,$medium_name,$large_name,
                                        $max_width_s,
                                        $max_height_s,
                                        $max_width_m,
                                        $max_height_m,
                                        $max_width_l,
                                        $max_height_l,
                                        $tag,
                                        $path,
                                        $orig_name)
            {
                ini_set('memory_limit', '200M');
                
                echo $src_file = urldecode($src_file);
                //exit;
                
                    $orig_name = strtolower($orig_name);
                    $findme  = '.jpg';
                    $pos = strpos($orig_name, $findme);
                    if ($pos === false)
                    {
                        $findme  = '.jpeg';
                        $pos = strpos($orig_name, $findme);
                        if ($pos === false)
                        {
                            $findme  = '.gif';
                            $pos = strpos($orig_name, $findme);
                            if ($pos === false)
                            {
                                $findme  = '.png';
                                $pos = strpos($orig_name, $findme);
                                if ($pos === false)
                                {
                                    return;
                                }
                                else
                                {
                                    $type = "png";
                                }
                            }
                            else
                            {
                                $type = "gif";
                            }
                        }
                        else
                        {
                            $type = "jpeg";
                        }
                    }
                    else
                    {
                        $type = "jpeg";
                    }
                //}
                
                $max_small_h = $max_height_s;
                $max_small_w = $max_width_s;
                $max_medium_h = $max_height_m;
                $max_medium_w = $max_width_m;
                $max_large_h = $max_height_l;
                $max_large_w = $max_width_l;
                
                if ( file_exists( "$path/$small_name")) {
                    unlink( "$path/$small_name");
                }
                
                if ( file_exists( "$path/$medium_name")) {
                    unlink( "$path/$medium_name");
                }
                
                if ( file_exists( "$path/$large_name")) {
                    unlink( "$path/$large_name");
                }
                
                $read = 'imagecreatefrom' . $type; 
                $write = 'image' . $type; 
                
                $src_img = $read($src_file);
                
                // height/width
                $imginfo = getimagesize($src_file);
                $src_w = $imginfo[0];
                $src_h = $imginfo[1];
                
                $zoom_h = $max_small_h / $src_h;
                $zoom_w = $max_small_w / $src_w;
                $zoom   = min($zoom_h, $zoom_w);
                $dst_small_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
                $dst_small_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
                
                $zoom_h = $max_medium_h / $src_h;
                $zoom_w = $max_medium_w / $src_w;
                $zoom   = min($zoom_h, $zoom_w);
                $dst_medium_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
                $dst_medium_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
                
                $zoom_h = $max_large_h / $src_h;
                $zoom_w = $max_large_w / $src_w;
                $zoom   = min($zoom_h, $zoom_w);
                $dst_large_h  = $zoom<1 ? round($src_h*$zoom) : $src_h;
                $dst_large_w  = $zoom<1 ? round($src_w*$zoom) : $src_w;
                
                
                $dst_s_img = imagecreatetruecolor($dst_small_w,$dst_small_h);
                $white = imagecolorallocate($dst_s_img,255,255,255);
                imagefill($dst_s_img,0,0,$white);
                imagecopyresampled($dst_s_img,$src_img, 0,0,0,0, $dst_small_w,$dst_small_h,$src_w,$src_h);
                $textcolor = imagecolorallocate($dst_s_img, 255, 255, 255);
                if (isset($tag))
                    imagestring($dst_s_img, 2, 2, 2, "$tag", $textcolor);
                if($type == 'jpeg'){
                    $desc_img = $write($dst_s_img,"$path/$small_name", 75);
                }else{
                    $desc_img = $write($dst_s_img,"$path/$small_name", 2);
                }
                
                
                $dst_m_img = imagecreatetruecolor($dst_medium_w,$dst_medium_h);
                $white = imagecolorallocate($dst_m_img,255,255,255);
                imagefill($dst_m_img,0,0,$white);
                imagecopyresampled($dst_m_img,$src_img, 0,0,0,0, $dst_medium_w,$dst_medium_h,$src_w,$src_h);
                $textcolor = imagecolorallocate($dst_m_img, 255, 255, 255);
                if (isset($tag))
                    imagestring($dst_m_img, 2, 2, 2, "$tag", $textcolor);
                if($type == 'jpeg'){
                    $desc_img = $write($dst_m_img,"$path/$medium_name", 75);
                }else{
                    $desc_img = $write($dst_m_img,"$path/$medium_name", 2);
                }
                
                $dst_l_img = imagecreatetruecolor($dst_large_w,$dst_large_h);
                $white = imagecolorallocate($dst_l_img,255,255,255);
                imagefill($dst_l_img,0,0,$white);
                imagecopyresampled($dst_l_img,$src_img, 0,0,0,0, $dst_large_w,$dst_large_h,$src_w,$src_h);

                $textcolor = imagecolorallocate($dst_l_img, 255, 255, 255);
                if (isset($tag))
                    imagestring($dst_l_img, 2, 2, 2, "$tag", $textcolor);
                if($type == 'jpeg'){
                    $desc_img = $write($dst_l_img,"$path/$large_name", 75);
                }else{
                    $desc_img = $write($dst_l_img,"$path/$large_name", 2);
                }
                
                
            
            }       

}
