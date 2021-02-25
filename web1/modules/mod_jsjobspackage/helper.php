<?php
class modJSPackageHelper{
	public static function getData($params, $module = array()){
	    $result = array();
	    $result['jsjobs_display_style'] = 1;
	    if(!empty($module) && isset($module->jsjobs_display_style) && $module->jsjobs_display_style != ''){
	        $result['jsjobs_display_style'] = $module->jsjobs_display_style;
	    }
		
		$numberofpackage = $params->get('numberofpackage');
		$packagefor = $params->get('packagefor');
		$db = JFactory::getDbo();
		if (!is_numeric($numberofpackage)) {
			$numberofpackage = 3;
		}
		if ($packagefor == 1) {

			$query = "SELECT package.*,currency.symbol 
						FROM `#__js_job_employerpackages` AS package 
						JOIN `#__js_job_currencies` AS currency ON currency.id = package.currencyid
						WHERE package.status = 1 LIMIT $numberofpackage
						";
			$db->setQuery($query);
			$packages = $db->loadObjectList();
		}else{
			$query = "SELECT package.*,currency.symbol 
						FROM `#__js_job_jobseekerpackages` AS package 
						JOIN `#__js_job_currencies` AS currency ON currency.id = package.currencyid
						WHERE package.status = 1 LIMIT $numberofpackage
						";
			$db->setQuery($query);
			$packages = $db->loadObjectList();
		}
		if ($packagefor == 3) {
			$employerlimit = ceil($numberofpackage/2);
			$query = "SELECT package.*,currency.symbol 
						FROM `#__js_job_employerpackages` AS package 
						JOIN `#__js_job_currencies` AS currency ON currency.id = package.currencyid
						WHERE package.status = 1 LIMIT $employerlimit
						";
			$db->setQuery($query);
			$emppackages = $db->loadObjectList();
			$jobseekerlimit = floor($numberofpackage/2);
			$query = "SELECT package.*,currency.symbol 
						FROM `#__js_job_jobseekerpackages` AS package 
						JOIN `#__js_job_currencies` AS currency ON currency.id = package.currencyid
						WHERE package.status = 1 LIMIT $jobseekerlimit
						";
		
			$db->setQuery($query);
			$jobseekerpackages = $db->loadObjectList();
			$packages = array_merge($emppackages,$jobseekerpackages);
        }

            $result['packages'] = $packages;
			$result['packagefor'] = $packagefor;
			$result['title'] = $params->get('title','JS Jobs Packages');
			$result['description'] = $params->get('description','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et.');

			return $result;
	}
}
?>
