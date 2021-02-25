<?php
/**
 * @package BW Social Share
 * @copyright (C) 2016 www.woehrlin-websolutions.de
 * @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$document 					= JFactory::getDocument();
$app						= JFactory::getApplication();
$moduleclass_sfx			= htmlspecialchars($params->get('moduleclass_sfx'));
$session                    = JFactory::getSession();

/**
 * if parameter is not set
 * first check if a respective open graph parameter is available,
 * if not get the document meta data.
 *
 * accepted key for the open graph array:
 * og:title, og:description, og:url, og:image
 */
$open_graph = $session->get('open_graph', null);
$og_title = null;
$og_description = null;
$og_url = null;
$og_img = null;

if ($open_graph != null) {
    $open_graph;
    $og_title = (array_key_exists('og:title', $open_graph) && strlen(trim($open_graph['og:title'])) > 0) ? $open_graph['og:title'] : null;
	$og_description = array_key_exists('og:description', $open_graph) && strlen(trim($open_graph['og:description'])) > 0 ? $open_graph['og:description'] : null;
    $og_url = array_key_exists('og:url', $open_graph) && strlen(trim($open_graph['og:url'])) > 0 ? $open_graph['og:url'] : null;
    $og_img = array_key_exists('og:image', $open_graph) && strlen(trim($open_graph['og:image'])) > 0 ? $open_graph['og:image'] : null;

}

$title                      = strlen(trim($params->get('social_title'))) > 0 ? $params->get('social_title') : ($og_title != null ? $og_title : $document->getTitle());
$description                = strlen(trim($params->get('social_description'))) > 0 ? $params->get('social_description') : ($og_description != null ? $og_description : $document->getDescription());
$author                     = strlen(trim($params->get('social_author'))) > 0 ? $params->get('social_author') : $_SERVER['SERVER_NAME'];
$path                       = strlen(trim($params->get('social_path'))) > 0 ? $params->get('social_path') : ($og_url != null ? $og_url : JURI::current());
$img                        = strlen(trim($params->get('social_img'))) > 0 ? $params->get('social_img') : ($og_img != null ? $og_img : '');

$box_title                  = $params->get('box_title');

$jversion = new JVersion();
if ($jversion->isCompatible('3.0.0')) {
    JHtml::_('jquery.framework');
} else {
    $document->addScript(JURI::root(true) . '/media/mod_bw_social_share/js/jquery.js');
}

$document->addStyleSheet(JURI::root(true) . '/modules/mod_bw_social_share/css/mod_bw_social_share.css');
$document->addStyleSheet(JURI::root(true) . '/modules/mod_bw_social_share/css/rrssb.css');
$document->addScript(JURI::root(true) . '/modules/mod_bw_social_share/js/rrssb.js');
$document->addScript(JURI::root(true) . '/modules/mod_bw_social_share/js/mod_bw_social_share.js');


#echo $params->get('layout', 'default');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_bw_social_share', $params->get('layout', 'default'));
