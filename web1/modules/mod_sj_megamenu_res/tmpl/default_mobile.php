<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$id = '';

if (($tagId = $params->get('tag_id', '')))
{
	$id = ' id="' . $tagId . '"';
}

// The menu class is deprecated. Use nav instead
?>
<?php if ($params->get('mobilemenutype', 'default') === 'push') {?>
<div class="sj-level">
<?php }?>
<ul class="nav menu<?php echo $class_sfx; ?>"<?php echo $id; ?>>
<?php foreach ($list as $i => &$item)
{
	$class = 'item-' . $item->id;

	if ($item->id == $default_id)
	{
		$class .= ' default';
	}


	if (($item->id == $active_id) || ($item->type == 'alias' && $item->params->get('aliasoptions') == $active_id))
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator')
	{
		$class .= ' divider';
	}

	if ($item->deeper)
	{
		$class .= ' deeper';
	}

	if ($item->parent)
	{
		$class .= ' parent';
	}

	echo '<li class="' . $class . '">';

	switch ($item->type) :
		case 'separator':
		case 'component':
		case 'heading':
		case 'url':
			require JModuleHelper::getLayoutPath('mod_sj_megamenu_res', 'default_mobile_' . $item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_sj_megamenu_res', 'default_mobile_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper)
	{
		if ($params->get('mobilemenutype', 'default') === 'push')
			echo '<div class="sj-level"><h2>'.$item->title.'</h2><a class="sj-back" href="#">back</a><ul class="nav-child unstyled small">';
		else
			echo '<ul class="nav-child unstyled small">';
	}
	// The next item is shallower.
	elseif ($item->shallower)
	{
		echo '</li>';
		if ($params->get('mobilemenutype', 'default') === 'dropdown')
			echo str_repeat('</ul><span class="touch-button"><i class="navicon">▼</i></span></li>', $item->level_diff);
		elseif ($params->get('mobilemenutype', 'default') === 'push')
			echo str_repeat('</ul></div></li>', $item->level_diff);
		else
			echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else
	{
		echo '</li>';
	}
}
?></ul>
<?php if ($params->get('mobilemenutype', 'default') === 'push') {?>
</div>
<?php }?>