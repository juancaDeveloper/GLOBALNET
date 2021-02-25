<?php
/**
 * @package		customfieldsforall
 * @copyright	Copyright (C)2014-2018 breakdesigns.net . All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access');

use Joomla\Utilities\ArrayHelper;

require_once __DIR__.DIRECTORY_SEPARATOR.'bootstrap.php';

/**
 * Plugin's main class
 * @author sakis
 *
 */
class plgVmCustomCustomfieldsforall extends vmCustomPlugin
{
    /**
     *
     * @var array
     */
	public $custom_ids_to_product = [];

	/**
	 *
	 * @var boolean;
	 */
    public $product_associations_deleted = false;

    /**
     *
     * @var int
     */
    public $tmp_custom_id = 0;

    /**
     *
     * @var array
     */
    public $displayed_customfields = [];

    /**
     *
     * @var string
     */
    protected $_product_paramName = '';

    /**
     *
     * @var CustomFieldsForAllLanguageHandler
     */
    protected $languageHandler;

	/**
	 * Constructor class of the custom field
	 *
	 * @param unknown_type $subject
	 * @param array $config
	 */
	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);

		$this->_tablepkey = 'id';
		$this->tableFields = array();
		$this->_tablename = '#__virtuemart_product_custom_plg_customsforall';
		$languageFactory = new CustomFieldsForAllLanguageHandlerFactory();
		$this->languageHandler = $languageFactory->get();

		$varsToPush = array(
			'display_type'=> array('button', 'string'),
			'data_type'=> array('', 'string'),
			'is_required'=> array('0', 'int'),
			'is_price_variant'=> array('0', 'int'),
			'display_price'=> array('0', 'string')
		);

		if(!defined('VM_VERSION'))define('VM_VERSION', '3.0');
		$this->setConfigParameterable ('customfield_params', $varsToPush);
		$this->_product_paramName = 'customfield_params';
	}

	/**
	 * Declares the Parameters of a plugin
	 * @param $data
	 * @return bool
	 */
	function plgVmDeclarePluginParamsCustomVM3(&$data)
	{
		return $this->declarePluginParams('custom', $data);
	}

	/**
	 *
	 * @param unknown $psType
	 * @param string $name
	 * @param int $id
	 * @param unknown $xParams
	 * @param array $varsToPush
	 * @return boolean
	 */
	function plgVmGetTablePluginParams($psType, $name, $id, &$xParams, &$varsToPush)
	{
		return $this->getTablePluginParams($psType, $name, $id, $xParams, $varsToPush);
	}

	/**
	 *
	 * @return multitype:
	 */
	public function getVmPluginCreateTableSQL()
	{
		return array();
	}

	/**
	 * (non-PHPdoc)
	 * @see vmPlugin::getTableSQLFields()
	 */
	function getTableSQLFields()
	{
		return array();
	}

	/**
	 * Exec when a cf is created/updated (stored) - Customfield view
	 *
	 * @param string $psType
	 * @param array  $data All the data of that cf
	 */
	function plgVmOnStoreInstallPluginTable($psType, $data)
	{
	    //install additional language tables
	    try {
	       $this->languageHandler->createLanguageTables();
	    }
	    catch(Exception $e) {
	        throw $e;
	    }

		$virtuemart_custom_id = $data['virtuemart_custom_id'];
        $customfield = Customfield::getInstance($virtuemart_custom_id);
        $db_value_ids = $customfield->getCustomValues($field = 'customsforall_value_id');
        $current_values = $data['cf_val'];
        $used_ids = Customfield::getField($current_values, $field = 'customsforall_value_id');

        // update the values
        $toBeDeleted = array_diff($db_value_ids, $used_ids);

        // check for duplicates
        $customfield->store($current_values);
        $customfield->delete($toBeDeleted);

		//update extension site with the download id
        $upadteHelper = new CustomFieldsForAllUpdate();
        $upadteHelper->refreshUpdateSite();
	}

	/**
	 *
	 * @param unknown $selectList
	 * @param unknown $searchCustomValues
	 * @param int $virtuemart_custom_id
	 * @return boolean
	 */
	public function plgVmSelectSearchableCustom(&$selectList, &$searchCustomValues, $virtuemart_custom_id)
	{
		return true;
	}


	/*
	 * Comment this because it destroys the VM products module
	 * Re-implement it when the VM search work correctly with the custom plugins

	 public function plgVmAddToSearch(&$where,&$PluginJoinTables,$custom_id)
	 {
		$jinput=JFactory::getApplication()->input;
		$keyword=trim($jinput->get('keyword','','string'));

		if(!empty($keyword)){
		$db=JFactory::getDbo();
		$query= $db->getQuery(true);
		$keyword =  '"%' .str_replace(array(' ','-'),'%',$db->escape( $keyword, true )). '%"';
		$query->select('customsforall_value_id');
		$query->from('#__virtuemart_custom_plg_customsforall_values');
		$query->where('customsforall_value_name LIKE '.$keyword);
		$db->setQuery($query);
		$customsforall_value_ids=$db->loadColumn();
		if(!empty($customsforall_value_ids)){
		$where[]='customsforall_value_id IN('.implode(',', $customsforall_value_ids).')';
		$PluginJoinTables[]='customsforall';
		return true;
		}
		}
		return false;
		}*/

	/**
	 * Displays the custom field in the product view of the backend
	 *
	 * @param 	object $field - The custom field
	 * @param 	int $product_id
	 * @param 	int $row - The a/a of that field within the product
	 * @param 	string $retValue - The html that regards the custom fields of that product
	 * @since	1.0
	 */
	function plgVmOnProductEdit($field, $product_id, &$row,&$retValue)
	{
		if ($field->custom_element != $this->_name) return '';
		$this->setDisplayOnProductForm($field, $product_id, $row,$retValue, $field_name='');
	}

	/**
	 * Displays the custom field in the product view of the backend
	 *
	 * @param 	JDatabaseObject $field - The custom field
	 * @param 	int 			$product_id
	 * @param 	int 			$row - The a/a of that field within the product
	 * @param 	string 			$retValue - The html that regards the custom fields of that product
	 * @param	string			$field_prefix - The prefix that will be used in the input fields. All the variables with that prefix will be then returned to the save function
	 * @since	1.0
	 */
	function plgVmOnStockableDisplayBE($field, $product_id, &$row,&$retValue, $field_prefix)
	{
		if (empty($field) || $field->custom_element != $this->_name) return '';
		$this->setDisplayOnProductForm($field, $product_id, $row, $retValue, $field_prefix, $force_multiple=false);
	}

	/**
	 * Creates the backend output of the plugin inside the product
	 *
	 * @param 	object 	$field - The custom field
	 * @param 	int 	$product_id
	 * @param 	int 	$row - The a/a of that field within the product
	 * @param 	string 	$retValue - The html that regards the custom fields of that product
	 * @param 	string 	$field_prefix -The prefix that will be used in the input fields
	 *
	 * @since	3.0
	 */
	private function setDisplayOnProductForm($field, $product_id, &$row,&$retValue, $field_prefix, $force_multiple=null)
	{
		$product_value_ids=array();
		$customfield=Customfield::getInstance($field->virtuemart_custom_id);
		$custom_params=$customfield->getCustomfieldParams($field->virtuemart_custom_id);
		$datatype=$custom_params['data_type'];
		$virtuemart_custom_id=$field->virtuemart_custom_id;
		$virtuemart_customfield_id=isset($field->virtuemart_customfield_id)?$field->virtuemart_customfield_id:0;

		$values_obj_list=$customfield->getCustomValues();
		if(!empty($virtuemart_customfield_id))$product_value_ids=$customfield->getProductCustomValues($product_id,'p_cf.customsforall_value_id AS customsforall_value_id',$virtuemart_customfield_id);
		$filterInput=CustomfieldsForAllFilter::getInstance(); //filter

		//load scripts and styles
		$customfield->loadStylesScripts();

		$option_style='';
		$selected='';
		$multiple='';
		if(!$custom_params['is_price_variant'] && (!isset($force_multiple) || $force_multiple==true))$multiple='multiple';
		$html='';

		//Non color types
		if(!empty($values_obj_list)){
			if($datatype!='color_hex'){

				$wrapper_id='customsforall_'.$row.'_'.$virtuemart_custom_id;

				//add buttons toolbar
				if(count($values_obj_list)>1 && !empty($multiple)){
					$html.='
					<div class="cf4all_values_toolbar" style="min-height:3em;">
						<button class="btn" type="button" onclick="jQuery(\'#'.$wrapper_id.' option\').attr(\'selected\',\'selected\'); jQuery(\'#'.$wrapper_id.'\').trigger(\'liszt:updated\');">'.JText::_('JGLOBAL_SELECTION_ALL').'</button>
						<button class="btn" type="button" onclick="jQuery(\'#'.$wrapper_id.' option\').removeAttr(\'selected\'); jQuery(\'#'.$wrapper_id.'\').trigger(\'liszt:updated\');">'.JText::_('JGLOBAL_SELECTION_NONE').'</button>
					<div class="clr"></div>
					</div>
					<div class="clr"></div>';
				}

				$html.='<select class="cfield-chosen-select" id="customsforall_'.$row.'_'.$virtuemart_custom_id.'" name="'.$this->_product_paramName.'['.$row.']'.$field_prefix.'[customfieldsforall][value][]" '.$multiple.'>';
				if(empty($multiple))$html.='<option value="">'.JText::_('PLG_CUSTOMSFORALL_SELECT_AN_OPTION').'</option>';
				foreach($values_obj_list as $v){
					if(in_array($v->customsforall_value_id, $product_value_ids))$selected='selected="selected"';

					$html.='<option value="'.$v->customsforall_value_id.'" '.$selected.' style="'.$option_style.'">'.$this->languageHandler->__($v).'</option>';
					$selected='';
				}
				$html.='</select>';
			}

			//color buttons
			else{
				if(!empty($multiple))$type='checkbox';
				else $type='radio';
				$wrapper_id='cffall_color_btn_set'.$row;

				//add buttons toolbar
				if(count($values_obj_list)>1 && !empty($multiple)){
					$html.='
					<div class="cf4all_values_toolbar" style="min-height:3em;">
						<button class="btn" type="button" onclick="jQuery(\'#'.$wrapper_id.' input\').attr(\'checked\',\'checked\');">'.JText::_('JGLOBAL_SELECTION_ALL').'</button>
						<button class="btn" type="button" onclick="jQuery(\'#'.$wrapper_id.' input\').removeAttr(\'checked\');">'.JText::_('JGLOBAL_SELECTION_NONE').'</button>
					</div>
					<div class="clr"></div>';

				}

				$html.='<div class="cffall_btns_wrapper" id="'.$wrapper_id.'" style="max-height:200px; overflow-y:scroll;">';
				foreach($values_obj_list as $v){
					//styling
					$title='';
					$tooltip='';
					$class='';

					//the value displayed as label within the button

					$label_html='';
					$custom_value_name_multi=explode('|', $v->customsforall_value_name);
					$count_multi_values=count($custom_value_name_multi);
					$width=100/$count_multi_values;
					$customsforall_value_label='';
					if($count_multi_values==1)$customsforall_value_label=$custom_value_name_multi[0];

					//multi-colors
					foreach($custom_value_name_multi as $custom_value_name){
						$color=$filterInput->checkNFormatColor($custom_value_name);
						if(empty($color))continue;
						$ishex=false;
						if(strpos($color, '#')!==false)$ishex=true;
						$label_style='color:#ffffff; text-shadow:-1px 1px #444444; background:'.$color.'; width:'.$width.'%;';
						$label_html.='<div class="cf4all_inner_value" style="'.$label_style.'">'.$customsforall_value_label.'</div>';
					}

					$el_id='cffall_color_bn'.$v->customsforall_value_id.'_'.$row;
					//check selected
					if(in_array($v->customsforall_value_id, $product_value_ids)){
						$selected='checked="checked"';
						//$option_style.='border:2px solid #000000';
					}

					if(!empty($v->customsforall_value_label))$tooltip= $this->languageHandler->__($v, $lang = '', $group = 'label').' ';
					else $tooltip='';

					if(!empty($tooltip)){
						//JHTML::_('behavior.tooltip');//load the tooltips script
						$title=' data-tip="'.$tooltip.'"';
						$class.=' cf4allTip';
					}

					$html.='
					<input '.$selected.' type="'.$type.'" id="'.$el_id.'" name="'.$this->_product_paramName.'['.$row.']'.$field_prefix.'[customfieldsforall][value][]" value="'.$v->customsforall_value_id.'"/>
					<label for="'.$el_id.'" '.$title.' class="'.$class.'">'.$label_html.'</label>';
					$selected='';
				}
				$html.='<div style="clear:both"></div>';
				$html.='</div>';
				$html.=' <script>
				jQuery(function($){

				  $(".cf4allTip").hover(function() {
				  	var label=$(this).attr("data-tip");
						$( this ).append( $("<span style=\"display:block; position:absolute; margin-top:30px; background:#ffffff; border:1px solid #ccc; padding:5px; color:black;\">"+label+"</span>" ) );
					},
					function() {
						$( this ).find( "span:last" ).remove();
					});

					//insert only once
					if(typeof(cf_rule_inserted)=="undefined"){
						var stylesheet = document.styleSheets[0];
						var selector=new Array();
						var rule=new Array();

						selector[0] = \'.cffall_btns_wrapper input[type="radio"]:checked+label,.cffall_btns_wrapper input[type="checkbox"]:checked+label\';
						rule[0] = \'{border: 2px solid #555555 !important; box-shadow: 0 0 4px rgba(10, 10, 10, 0.8);} \'

						selector[1]=\'.cffall_btns_wrapper label\';
						rule[1]=\'{display:block; float:left; width:56px; border-radius:2px; border:1px solid #ccc; overflow:hidden;} \';

						selector[2]=\'.cffall_btns_wrapper .cf4all_inner_value\';
						rule[2]=\'{height:1em; float:left; padding:6px 0px; text-align:center; } \';

						selector[3]=\'.cffall_btns_wrapper input[type=radio],.cffall_btns_wrapper input[type=checkbox]\';
						rule[3]=\'{display: none; } \';

						selector[4]=\'.cffall_btns_wrapper\';
						rule[4]=\'{clear:both; padding:10px 0px;} \';

						if (stylesheet.insertRule) {
							for(var i=0; i<selector.length; i++){
						    	stylesheet.insertRule(selector[i] + rule[i], stylesheet.cssRules.length);
						    }
						} else if (stylesheet.addRule) {
							for(var i=0; i<selector.length; i++){
						    	stylesheet.addRule(selector[i], rule[i], -1);
						    }
						}
						cf_rule_inserted=true;
					}
				});
				</script>';
			}
		}

		//create also new values using the existing JElement
		if(!class_exists('RenderFields'))require(JPATH_PLUGINS.DIRECTORY_SEPARATOR.'vmcustom'.DIRECTORY_SEPARATOR.'customfieldsforall'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR.'renderFields.php');
		$renderFields=new RenderFields;
		$custom_params['single_entry']=empty($multiple)?true:false;
		$addValues_el=$renderFields->fetchCustomvalues($name=$this->_product_paramName.'['.$row.']'.$field_prefix.'[customfieldsforall][newvalues]',$virtuemart_custom_id,$value='',$row,$custom_params);
		$html.=$addValues_el;
		$html.='<input type="hidden" name="'.$this->_product_paramName.'['.$row.']'.$field_prefix.'[customfieldsforall][virtuemart_custom_id]" value="'.$virtuemart_custom_id.'"/>';
		$html.='<input type="hidden" name="'.$this->_product_paramName.'['.$row.']'.$field_prefix.'[customfieldsforall][row]" value="'.$row.'"/>';
		$retValue .=$html;
		return true ;
	}

	/**
	 * trigered when a product is cloned
	 * This function is inconsistent as it tries to guess the next product_id and virtuemart_customfield_id
	 * In case of multi-user environment will may fail due to concurrent insertions of products and custom fields
	 *
	 * @param object $product
	 * @since	1.4.0
	 */
	function plgVmCloneProduct($product)
	{
        $product_id=$product->originId;

		if(empty($product->customfields)){
			if(!empty($product_id))$customfields=$this->getProductCustomFields($product_id);
		}
		else $customfields=$product->customfields;

		//get the next customfield_id - autoincrement
		$db=JFactory::getDbo();
		$query="SHOW TABLE STATUS LIKE '".$db->getPrefix()."virtuemart_product_customfields'";
		$db->setQuery($query);
		try {
			$db->execute();
			$tableStatus=$db->loadObject();
			$last_virtuemart_customfield_id=$tableStatus->Auto_increment;
			if(empty($last_virtuemart_customfield_id))return;
		}
		catch(RuntimeException $e) {
			JLog::add(sprintf('CF4All Error cloning Product : ERROR: %s',$e->getMessage()));
			vmdebug('CF4All Error cloning Product : ERROR: %s',$e->getMessage());
		}
		
        $new_entry=(int)$last_virtuemart_customfield_id-count($customfields);
        $new_product_id_entry=$product->virtuemart_product_id;

		for($i=0; $i<count($customfields); $i++){
			$cf=$customfields[$i];

			if($cf->custom_element=='customfieldsforall'){
				//insert it to the our tables
				$custom_id=$cf->virtuemart_custom_id;
				$customfield=Customfield::getInstance($custom_id);
				//if we could not get the original product id
				if(empty($product_id))$product_id=$customfield->getProductFromCustomfield_id($cf->virtuemart_customfield_id);
				$product_assigned_id=$customfield->getProductCustomValues($product_id,'p_cf.customsforall_value_id',$customfield_id=$cf->virtuemart_customfield_id);
				$customfield->storeProductValues($product_assigned_id, $new_product_id_entry,$new_entry);
			}
			$new_entry++;
		}
	}

	/**
	 *
	 * Get the custom fields of a product
	 * @param 	int 	$product_id
	 *
	 * @return	Array	the custom fields
	 * @since	2.1.2
	 */
	function getProductCustomFields($product_id)
	{
		$db=JFactory::getDbo();
		$q=$db->getQuery(true);
		$q->select('*')->from('#__virtuemart_product_customfields')->where('virtuemart_product_id='.(int)$product_id);
		$q->leftJoin('#__virtuemart_customs AS customs ON #__virtuemart_product_customfields.virtuemart_custom_id=customs.virtuemart_custom_id');
		$db->setQuery($q);
		$results=$db->loadObjectList();
		return $results;
	}

	/**
	 * Store the custom fields for a specific product
	 *
	 * @param array $data
	 * @param array $plugin_param
	 */
	function plgVmOnStoreProduct($data, $plugin_param)
    {
        $plugin_name = key($plugin_param);
        if ($plugin_name != $this->_name) {
            return;
        }
        $is_customforall = false;

        if (isset($plugin_param[$plugin_name]['virtuemart_custom_id'])) {
            $custom_id = $plugin_param[$plugin_name]['virtuemart_custom_id'];
        }
        else {
            $custom_id = 0;
        }

        $product_id = (int) $data['virtuemart_product_id'];
        $customfield = Customfield::getInstance($custom_id);
        $isCustomSetInProduct = $customfield->isCustomSetInProduct($product_id);

        // if there are records to be stored
        if ($isCustomSetInProduct) {
            if ($plugin_name == 'customfieldsforall') {
                $is_customforall = true;
                $row = $plugin_param['customfieldsforall']['row'];
            }

            // check if its the 1st with that id. We run this only to the 1st of its type
            if ($is_customforall && $customfield->isFirstCustomOfType($row, $data)) {
                $jinput = JFactory::getApplication()->input;
                $custom_plugins = $jinput->get($this->_product_paramName, array(), 'array');
                $this->storeAllCustomsforall($data, $custom_plugins);
            }
        } else
            if ($this->product_associations_deleted == false) {
                if (customfield::deleteAllProductAssociations($product_id)) {
                    vmdebug('Cf4All All product associations deleted', $product_id);
                    $this->product_associations_deleted = true;
                }
            }
        return $this->OnStoreProduct($data, $plugin_param);
    }

	/**
	 * Triggered by the stockableCustomfields plugin on saving a product
	 *
	 * @param 	object $data
	 * @param 	object $custom_plugin
	 *
	 * @since	3.0
	 */
	public function plgVmOnStockableSave($data, $custom_plugin)
	{
		vmdebug('DATA',$custom_plugin);
		$custom_plugins=array($custom_plugin);
		$new_data=array('field'=>array($data),'virtuemart_product_id'=>$data['virtuemart_product_id']);

		$result=$this->storeAllCustomsforall($new_data, $custom_plugins, $single_assignment=true);
		return $result;
	}

	/**
	 * Store all the values for all the custom fields
	 * This function should run only once for each product
	 *
	 * @param 	array 	$data - contains the data for the current product
	 * @param	array	$custom_plugins - contains the data we set in the plugin's inputs
	 * @param	mixed	$single_assignment - indicates only 1 value/product should be stored for 1 custom field
	 * @since	1.0
	 */
	protected function storeAllCustomsforall($data, $custom_plugins, $single_assignment=null)
	{
		$product_id=$data['virtuemart_product_id'];
		static $all_values=array();
		$position=array();//indicates the position of that record in the products custom fields

		foreach($custom_plugins as $key=>$plg){
			$custom_id=$data['field'][$key]['virtuemart_custom_id'];
			$customfield=Customfield::getInstance($custom_id);
			$custom_params=$customfield->getCustomfieldParams($custom_id);
			if(!isset($position[$custom_id]))$position[$custom_id]=0;

			//check if its the correct plugin type and the correct custom id
			//maybe the user is using more than 1 customforall plugins for that product
			if(isset($plg['customfieldsforall'])){
				$this->custom_ids_to_product[]=$custom_id;
				$customfield_id=$data['field'][$key]['virtuemart_customfield_id'];

				//new record without customfield id
				if(empty($customfield_id)){
					//get it
					$customfield_id=$customfield->getVmProductCustomfieldId($product_id,$position[$custom_id]);
				}
				$position[$custom_id]++;

				$myplugin=$plg['customfieldsforall'];
				$selected_ids=$myplugin['value'];
				if(empty($selected_ids))$selected_ids=array();
				$new_values=$myplugin['newvalues'];
				if(empty($new_values))$new_values=array();

				$existing_ids=array();
				$new_stored_ids=array();
				$product_assigned_ids=array();

				$stored_ids=array();
				if(!empty($new_values)){

					//the ids of the values which already exist in the db although the user has tried to re-insert them
					$existing_ids=$customfield->findExistingUnsetDuplicates($new_values);

					//the ids of the new inserted values
					if(!empty($new_values))$new_stored_ids=$customfield->store($new_values,$set_ordering=false);
				}

				/*
				 * in case of price variant only 1 assignment should be done.
				 * This will be always the last one. So the last new value if exist
				 */
				if($custom_params['is_price_variant'] || (isset($single_assignment) && $single_assignment==true)) {
					if($existing_ids)$product_assigned_ids=$existing_ids;
					else if($new_stored_ids)$product_assigned_ids=$new_stored_ids;
					else $product_assigned_ids=$selected_ids;
				}else{

					/*
					 * Non price variants
					 * the assignment should contain the existing selected, the values added (accidentaly) which already exist and the new inserted values
					 */
					$product_assigned_ids=array_merge($selected_ids, $existing_ids, $new_stored_ids);
					$product_assigned_ids=array_unique($product_assigned_ids);

				}

				vmdebug('CF4All product association ids for product id:'.$product_id.' and custom_id '.$custom_id.': ', implode(',',$product_assigned_ids));
				//vmdebug('CF4All customfield_id for custom_id '.$custom_id.' and position '.$position[$custom_id].': ',$customfield_id);
				$customfield->storeProductValues($product_assigned_ids, $product_id, $customfield_id);
				$all_values=array_merge($all_values, $product_assigned_ids);
			}
		}

		$custom_ids_lookup = [];
		if(isset($single_assignment) && $single_assignment==true) {
            $custom_ids_lookup = $this->custom_ids_to_product;
		}

		//delete the values which are other than the supplied ($all_values)
		$result=Customfield::deleteProductValues($product_id, $all_values, $custom_ids_lookup);

		//delete completely the custom field associations for the custom fields which have been deleted and they are other than those used here
		if(!$single_assignment) {
		    $result=Customfield::deleteAllProductAssociations($product_id, $this->custom_ids_to_product);
		}
		return $result;
	}

	/**
	 * Override this function as we do not want VM to store the plug-in data
	 * @see vmCustomPlugin::storePluginInternalDataProduct()
	 */
	protected function storePluginInternalDataProduct (&$values, $primaryKey = 0, $product_id = 0)
	{
		return true;
	}

	/**
	 * Display of the Cart Variant Custom fields - VM3
	 *
	 * @param object $field
	 * @param int $idx
	 * @param object $group
	 */
	function plgVmOnDisplayProductVariantFEVM3($field,&$idx,&$group)
	{
		vmdebug('Cf4All All display variants',$group);
	}

	/**
	 * Sets the output/html
	 * Also sets an array of objects containing the customfields objects
	 * Each object should have these fields: id, value, virtuemart_custom_id,virtuemart_product_id,
	 * id: The unique id of the value (virtuemart_customfield_id if no 3rd party tables used)
	 * value: The value (e.g. Red)
	 * virtuemart_custom_id: The virtuemart_custom_id of the custom
	 * virtuemart_product_id: The virtuemart_product_id of the product where the custom field is assigned
	 *
	 * @param	VirtueMartModelProduct	$current_product	The current product
	 * @param	JDatabaseObject			$custom_obj			The custom field. An object containing the data of the custom
	 * @param 	array 					$product_ids		All the product ids which are derived by this custom for that parent product
	 * @param	string					$output				The html output returned from the plugin
	 *
	 * @return	boolean
	 * @since	3.0
	 */
	function plgVmOnStockableDisplayFE($current_product, $custom_obj, $product_ids, &$customfields, &$output)
	{
	    if ($custom_obj->custom_element != $this->_name) return '';
		$customfields=array();
		$custom_id=$custom_obj->virtuemart_custom_id;
		$customfield=Customfield::getInstance($custom_id);
		$vmCompatibility=VmCompatibilityCF::getInstance();
		ArrayHelper::toInteger($product_ids);

        //get the custom values related with a set of products (derived products)
		$customfields=$customfield->getProductCustomValues(
		    $product_ids,'
			cf.customsforall_value_id,
			cf.customsforall_value_id AS id,
			cf.customsforall_value_name,
			cf.customsforall_value_name AS value,
			p_cf.virtuemart_product_id AS virtuemart_product_id,
			"'.$custom_id.'" AS virtuemart_custom_id,
			cf.customsforall_value_label,
			cf_p.virtuemart_customfield_id,
			'.$vmCompatibility->getColumnName('custom_price').' AS custom_price',
		    $customfield_id=0,
		    $order='FIELD(cf_p.virtuemart_product_id,'.implode(',', $product_ids).') ASC'
		    );

		if(empty($customfields))return false;
		$customfields_for_display=$customfield->array_unique($customfields, 'id');
		//display generation
		$custom_params=$customfield->getCustomfieldParams($custom_id);
		$custom_obj->virtuemart_customfield_id=end($customfields)->virtuemart_customfield_id;
		$custom_obj->calculate_price=true;
		$custom_obj->custom_params=$custom_params;
		$custom_obj->values=$customfields_for_display;
		if(empty($custom_obj->pb_group_id))$custom_obj->pb_group_id='';
		$layout=$custom_params['display_type'];
		if(empty($layout))$layout='select';
		//cart input
		$viewdata=$custom_obj;
		$viewdata->virtuemart_product_id=$current_product->virtuemart_product_id;

		//cannot use multi-select layout
		switch ($layout){
			case 'checkbox':
				$layout='radio';
				break;
			case 'button_multi':
				$layout='button';
				break;
			case 'color_multi':
				$layout='color';
				break;
		}
		$output = $this->renderByLayout($layout,$viewdata);
		return true;
	}

	/**
	 * Display of the Cart Variant/Non cart variants Custom fields - VM3
	 *
	 * @param object $field
	 * @param int $idx
	 * @param object $group
	 */
	function plgVmOnDisplayProductFEVM3(&$product,&$group)
	{
		if ($group->custom_element != $this->_name) return '';
		$html='';
		$custom_id=$group->virtuemart_custom_id;
		$this->displayed_customfields[]=$custom_id;
		$calculate_price=false;
		$customfield=Customfield::getInstance($custom_id);
		$custom_params=$customfield->getCustomfieldParams($custom_id);
		if($custom_params['is_price_variant'] && !empty($custom_params['display_price'])){
			$calculate_price=true;
		}

		if(empty($group->pb_group_id))$group->pb_group_id='';
		$group->calculate_price=$calculate_price;
		$group->custom_params=$custom_params;
		$group->values=$customfield->getProductCustomValues($group->virtuemart_product_id);

		//when there the same custom exists multiple times in a product, then it is probably a price variant and should be loaded only once.
		if(!empty($group->values) && end($group->values)->customfield_id!=$group->virtuemart_customfield_id)return;

		$layout=$custom_params['display_type'];
		if(empty($layout))$layout='select';

		//cart input
		$viewdata=$group;
		$viewdata->virtuemart_product_id=$product->virtuemart_product_id;

		if($group->is_input)$html = $this->renderByLayout($layout,$viewdata);

		//non cart input
		else{
			if(!empty($group->values)){
				$document=JFactory::getDocument();
				$document->addStyleSheet( JURI::root(true).'/plugins/vmcustom/customfieldsforall/assets/css/customsforall_fe.css');
				$html='<div class="cf4all_customvalues_wrapper">';
				$counter=count($group->values);
				$i=0;

				foreach ($group->values as $v){
					$html.=Customfield::displayCustomValue($v,$layout); //generate the html of that custom field
					if($i<$counter-1 && $layout!='color')$html.='<span class="cf4all_comma">, </span>'; //add a comma
					$i++;
				}
				$html.='</div>';
			}
		}
		$group->display = $html;
		return true;
	}

	/**
	 * Calculates the price of a product applying specific/selected custom field values - VM3
	 * Same as plgVmCalculateCustomVariant (VM2)
	 *
	 * @param object $product The product object
	 * @param object $productCustomsPrice the customfield object
	 * @param unknown_type $selected
	 * @param float $modificatorSum  The modificator that affects the price
	 */
	public function plgVmPrepareCartProduct(&$product, &$customfield,$selected,&$modificatorSum)
	{
		if ($customfield->custom_element !==$this->_name) return ;

		$total_custom_price=0;
		foreach ($selected as $key=>$value){
			if(strpos($key,'customsforall_option')!==false){
				$selected_option=$value;
				$custom_value=Customfield::getCustomValue(0,0,$selected_option);
				//print_r($custom_value); echo '<br/>';
				if(!empty($custom_value->custom_price)){
					//echo '##',(float)$custom_value->custom_price;
					$total_custom_price+=(float)$custom_value->custom_price;
				}
			}
		}
		$modificatorSum+=$total_custom_price;

		return true;
	}

	/**
	 *
	 * Prints the fields in a static way - non selectable
	 *
	 * @param 	object $productCustom
	 * @param 	array $values
	 * @param 	string $html
	 * @param 	bool $inline_css
	 * @param 	bool $display_color_label
	 *
	 * @since	2.0
	 * @author	Sakis Terz
	 */
	function printStaticFields($productCustom,$values,&$html,$inline_css=false,$display_color_label=true)
	{
		$document=JFactory::getDocument();
		$document->addStyleSheet( JURI::root(true).'/plugins/vmcustom/customfieldsforall/assets/css/customsforall_fe.css');
		$separator= '';
		$innerHtml='';

		$custom_id=$productCustom->virtuemart_custom_id;
		$customfield=Customfield::getInstance($custom_id);
		$custom_params=$customfield->getCustomfieldParams($custom_id);
		$display_type=$custom_params['display_type'];

		if(!empty($values)){
			foreach($values as $key=>$selval){
				if(strpos($key, 'customsforall_option')!==false){
					$customOption=Customfield::getCustomValue($custom_value_id=0, $product_id=0,$value_product_id=$selval);
					vmdebug('Cf4All $values',$customOption);
					$innerHtml .=$separator.Customfield::displayCustomValue($customOption,$display_type,$class='cf4all_color_btn_small',$inline_css,$display_color_label);
					$separator= ',';
				}
			}
		}

		if(!empty($innerHtml)){
			$html  .='<span class="product-field-wrapper">';
			$html  .='<span class="product-field-label">'.JText::_($productCustom->custom_title).': </span>';
			$html .=$innerHtml;
			$html .= '</span>';
		}
		return true;
	}

	/**
	 * function triggered on display cart - VM3
	 *
	 * @param 	$product
	 * @param 	$productCustom
	 * @param 	$html
	 *
	 * @author	Sakis Terz
	 * @return 	bool|string
	 */
	function plgVmOnViewCartVM3(&$product, &$productCustom, &$html,$inline_css=false,$display_color_label=true)
	{
		if (empty($productCustom->custom_element) or $productCustom->custom_element != $this->_name) return false;
		//vmdebug('val',$product->customProductData);
		if(!empty($product->customProductData[$productCustom->virtuemart_custom_id][$productCustom->virtuemart_customfield_id]))$values=$product->customProductData[$productCustom->virtuemart_custom_id][$productCustom->virtuemart_customfield_id];
		else return;
		$this->printStaticFields($productCustom,$values,$html,$inline_css,$display_color_label);

		return true;
	}

	/**
	 * function triggered by the stockable custom fields plug-in on display cart - VM3
	 *
	 * @param 	$product
	 * @param 	$productCustom
	 * @param 	$html
	 *
	 * @author	Sakis Terz
	 * @return 	bool|string
	 */
	public function plgVmOnStockableDisplayCart(&$product, &$productCustom, &$html)
	{
		if (empty($productCustom->custom_element) or $productCustom->custom_element != $this->_name) return false;
		$customfield=Customfield::getInstance($productCustom->virtuemart_custom_id);
		$values=$customfield->getProductCustomValues($product->virtuemart_product_id,'p_cf.id');
		//the printStaticFields requires that the values use that key (customsforall_option)
		$new_values=array('customsforall_option'=>reset($values));
		$return=$this->printStaticFields($productCustom,$new_values,$html);
		return $return;
	}

	function plgVmSetOnTablePluginParamsCustom($name, $id, &$table)
	{
		return $this->setOnTablePluginParams($name, $id, $table);
	}

	function plgVmOnDeleteProduct($virtuemart_product_id, $ok)
	{
		$return=Customfield::deleteProductValues($virtuemart_product_id);
		return $return;
	}

	function plgVmDeclarePluginParamsCustom($psType,$name,$id, &$data)
	{
		return $this->declarePluginParams($psType, $name, $id, $data);
	}

	function plgVmOnDisplayEdit($virtuemart_custom_id,&$customPlugin)
	{
		return $this->onDisplayEditBECustom($virtuemart_custom_id,$customPlugin);
	}

	function plgVmOnCloneProduct($data,$plugin_param)
	{ // not work! need to edit VM2 core
		return $this->OnStoreProduct($data,$plugin_param);
	}

	public function plgVmDisplayInOrderCustom(&$html,$item, $param,$productCustom, $row ,$view='FE')
	{
		$this->plgVmDisplayInOrderCustom($html,$item, $param,$productCustom, $row ,$view);
	}

	/**
	 *
	 * vendor order display BE- VM3
	 */
	function plgVmDisplayInOrderBEVM3( &$product, &$productCustom, &$html)
	{
		$this->plgVmOnViewCartVM3($product,$productCustom,$html,$inline_css=true);
	}

	/**
	 *
	 * shopper order display FE - VM3
	 * Also used for the invoice creation
	 */
	function plgVmDisplayInOrderFEVM3( &$product, &$productCustom, &$html)
	{
		$this->plgVmOnViewCartVM3($product,$productCustom,$html,$inline_css=true,$display_color_label=true);
	}

	/**
	 * Hook for generating custom filters from the plugin
	 *
	 * @param	string   $PluginJoinTable        the table where the plugin stores the connection between custom_value and product id
	 * @param	int      $virtuemart_custom_id	 the id of the custom field
	 * @param	string   $data_type              the datatype of the custom_value (string,int,float)
	 */
	public function onGenerateCustomfilters($name,$virtuemart_custom_id,&$data_type)
	{
		if(empty($name) || empty($virtuemart_custom_id) || $name!=$this->_name)return; //exec only for this plugin
		$customfield=Customfield::getInstance($virtuemart_custom_id);
		$custom_params=$customfield->getCustomfieldParams($virtuemart_custom_id);

		if($custom_params['display_type']=='color' && $custom_params['data_type']!='color_hex'){
			$data_type='color_name'; //use of color names
		}
		else $data_type=$custom_params['data_type'];
		if(empty($data_type))$data_type='string';
		return true;
	}

	/**
	 * Hook for filtering from plugins
	 *
	 * The filtering can work either if the custom_values and the product_ids are in the same table
	 * Or if the custom_values use their own table and the custom_values->product_ids connection is happening in another table using the custom_value_ids
	 * In both cases there should be a field named virtuemart_custom_id in the custom_values table, that indicates (is key) the VM custom_id for these records
	 *
	 * @param string $name the plugin name as stored in the custom_element field of the virtuemart_customs table
	 * @param int	 $virtuemart_custom_id as stored in the virtuemart_customs table
	 * @param string $product_customvalues_table the name of the table where the custom_value->product relationship is saved-- Table alias: cfp
	 * @param string $customvalues_table the name of the table where the custom_values are saved 							-- Table alias: cf
	 * @param string $filter_by_field the column by which the filtering will be done. If 2 tables indicates the custom_value id in both of the above tables
	 * @param string $customvalue_value_field the field name where the custom value is stored in the table $customvalues_table
	 * @param string $filter_data_type the datatype of the field which will be used for filtering (string|int|float|boolean)
	 * @param string $sort_by	The field by which the values/options will be sorted. name and id cane be applied to all
	 *
	 * @return boolean
	 */
	public function onFilteringCustomfilters(
	    $name,
	    $virtuemart_custom_id,
	    &$product_customvalues_table,
	    &$customvalues_table,
	    &$filter_by_field,
	    &$customvalue_value_field,
	    &$filter_data_type, &$sort_by='name')
	{
	    //exec only for this plugin
		if(empty($name) || empty($virtuemart_custom_id) || $name!=$this->_name){
		    return false;
		}

		$product_customvalues_table='#__virtuemart_product_custom_plg_customsforall';
		$filter_by_field='customsforall_value_id';
		$filter_data_type='int';
		$customvalue_value_field='customsforall_value_name';
		$sort_by='cf.ordering';

		//can be the same as above if the custom_values and the product ids are in the same table (as happens in built in custom fields)
		$customvalues_table='#__virtuemart_custom_plg_customsforall_values';
		$languages = $this->languageHandler->getLanguages();
		$customfield=Customfield::getInstance($virtuemart_custom_id);
		$custom_params=$customfield->getCustomfieldParams($virtuemart_custom_id);

		//enable multi-lingual
		if(
		    $this->languageHandler->getDefaultLangTag() != $this->languageHandler->getAppLanguageCode() &&
		    count($languages)>1
		    && in_array($custom_params['data_type'], ['string', 'color_hex'])) {
		    $langTable = $customvalues_table.'_' . $languages[$this->languageHandler->getAppLanguageCode()]->db_code;
		    $customvalues_table = '
		        (SELECT tbl1.customsforall_value_name, tbl1.customsforall_value_label, tbl1.customsforall_value_id, tbl2.virtuemart_custom_id, tbl2.ordering
		        FROM `'.$langTable.'` AS tbl1
		        LEFT JOIN '. $customvalues_table .' AS tbl2 ON tbl1.'.$filter_by_field.'= tbl2.'.$filter_by_field.')';
		}

		return true;
	}

	/**
	 * Hook for the stockableCustomfields plugin
	 * Returns the name of that plugin, so that custom fields from that can be used as stockables
	 *
	 * @return	string
	 * @since	3.0
	 */
	public function onDetectStockables()
	{
		return $this->_name;
	}
}
