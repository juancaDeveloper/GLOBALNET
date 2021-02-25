<?php
/**
 * @name		Slideshow CK
 * @package		com_slideshowck
 * @copyright	Copyright (C) 2019. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.template-creator.com - https://www.joomlack.fr
 */
 
// No direct access
defined('CK_LOADED') or die;

use Slideshowck\CKController;
use Slideshowck\CKFof;

require_once SLIDESHOWCK_PATH . '/helpers/ckbrowse.php';

class SlideshowckControllerBrowse extends CKController {

	public function getFiles() {
		// security check
		if (! CKFof::checkAjaxToken()) {
			exit();
		}

		$folder = $this->input->get('folder', '', 'string');
		$type = $this->input->get('type', '', 'string');
		$filetypes = CKBrowse::getFileTypes($type);
		$files = CKBrowse::getImagesInFolder(JPATH_SITE . '/' . $folder, implode('|', $filetypes));

		if (empty($files)) {
			echo JText::_('CK_NO_IMAGE_FOUND');
		} else {
			foreach($files as $file) {
				?>
					<div class="ckfoldertreefile" data-type="<?php echo $type ?>" onclick="ckSelectFile(this)" data-path="<?php echo utf8_encode($folder) ?>" data-filename="<?php echo utf8_encode($file) ?>">
						<img src="<?php echo JUri::root(true) . '/' . utf8_encode($folder) . '/' . utf8_encode($file) ?>" title="<?php echo utf8_encode($file); ?>" loading="lazy">
						<div class="ckimagetitle"><?php echo utf8_encode($file); ?></div>
					</div>
				<?php
			}
		}
		exit;
	}
}
