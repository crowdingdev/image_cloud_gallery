<?php
if (!defined('_PS_VERSION_')){
  exit;
  }


class ImageCloudGallery extends Module
{
	protected $max_image_size = 1048576;
	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function __construct()
	{
		$this->name = 'imagecloudgallery';
		$this->tab = 'advertising_marketing';
		$this->version = '1.0';
		$this->author = 'Linus Lundevall @prettypegs.com';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6');
		$this->bootstrap = true;

		$this->module_path = _PS_MODULE_DIR_.$this->name.'/';
		$this->uploads_path = _PS_MODULE_DIR_.$this->name.'/img/';
		$this->admin_tpl_path = _PS_MODULE_DIR_.$this->name.'/views/templates/admin/';
		$this->hooks_tpl_path = _PS_MODULE_DIR_.$this->name.'/views/templates/hooks/';

		parent::__construct();

		$this->displayName = $this->l('Image Cloud Gallery');
		$this->description = $this->l('Create cloud of images as a gallery.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall? We are not friends anymore...');

		if (!Configuration::get('IMAGECLOUDGALLERY_NAME'))
		{
			$this->warning = $this->l('No name provided');
		}

	}

	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function install()
	{
		if (Shop::isFeatureActive()){
    	Shop::setContext(Shop::CONTEXT_ALL);
    }

  	return parent::install() &&
  	$this->installDB() &&
    $this->registerHook('leftColumn') &&
    $this->registerHook('header') &&
    $this->registerHook('displayBackOfficeHeader') &&
    Configuration::updateValue('IMAGECLOUDGALLERY_NAME', 'my friend');
	}

	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function uninstall()
	{
		if (!parent::uninstall())
			return false;
		return true;
	}

	/**
	* This controls the configuration page for this module.
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function getContent()
	{
		$output = null;


		if (Tools::isSubmit('submit'.$this->name))
		{
			$image_cloud_gallery = strval(Tools::getValue('IMAGECLOUDGALLERY_NAME'));
			if (!$image_cloud_gallery
				|| empty($image_cloud_gallery)
				|| !Validate::isGenericName($image_cloud_gallery)) {
				$output .= $this->displayError($this->l('Invalid Configuration value'));
			}
			else
			{
				Configuration::updateValue('IMAGECLOUDGALLERY_NAME', $image_cloud_gallery);
				$output .= $this->displayConfirmation($this->l('Settings updated'));
			}
		}

		if (Tools::isSubmit('newItem'))
			$this->addItem();
		elseif (Tools::isSubmit('updateItem'))
			$this->updateItem();
		elseif (Tools::isSubmit('removeItem'))
			$this->removeItem();

		$output .= $this->renderThemeConfiguratorForm();
		return $output.$this->displayForm();
	}

	/**
	* This displays the form in the backoffice configuration page for this module.
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function displayForm()
	{
    // Get default language
		$default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

    // Init Fields form array
		// $fields_form[0]['form'] = array(
		// 	'legend' => array(
		// 		'title' => $this->l('Settings'),
		// 		),
		// 	'input' => array(
		// 		array(
		// 			'type' => 'text',
		// 			'label' => $this->l('Configuration value'),
		// 			'name' => 'IMAGECLOUDGALLERY_NAME',
		// 			'size' => 20,
		// 			'required' => true
		// 			)
		// 		),
		// 	'submit' => array(
		// 		'title' => $this->l('Save'),
		// 		'class' => 'button'
		// 		)
		// 	);

		$helper = new HelperForm();

    // Module, token and currentIndex
		$helper->module = $this;
		$helper->name_controller = $this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

    // Language
		$helper->default_form_language = $default_lang;
		$helper->allow_employee_form_lang = $default_lang;

    // Title and toolbar
		$helper->title = $this->displayName;
    $helper->show_toolbar = true;        // false -> remove toolbar
    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
    $helper->submit_action = 'submit'.$this->name;
    $helper->toolbar_btn = array(
    	'save' =>
    	array(
    		'desc' => $this->l('Save'),
    		'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
    		'&token='.Tools::getAdminTokenLite('AdminModules'),
    		),
    	'back' => array(
    		'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
    		'desc' => $this->l('Back to list')
    		)
    	);

    // Load current value
    $helper->fields_value['IMAGECLOUDGALLERY_NAME'] = Configuration::get('IMAGECLOUDGALLERY_NAME');

    //return $helper->generateForm($fields_form);
  }

  public function hookDisplayBackOfficeHeader()
	{
		if (Tools::getValue('configure') != $this->name)
			return;

		$this->context->controller->addCSS($this->_path.'css/admin.css');
		$this->context->controller->addJquery();
		$this->context->controller->addJS($this->_path.'js/admin.js');
	}


	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function hookDisplayLeftColumn($params)
	{
		$this->context->smarty->assign(
			array(
				'imagecloudgallery' => Configuration::get('IMAGECLOUDGALLERY_NAME'),
				'my_module_link' => $this->context->link->getModuleLink('imagecloudgallery', 'display')
				)
			);
		return $this->display(__FILE__, 'imagecloudgallery.tpl');
	}

	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function hookDisplayRightColumn($params)
	{
		return $this->hookDisplayLeftColumn($params);
	}

	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS($this->_path.'css/imagecloudgallery.css', 'all');
	}

	/**
	* Creates the tables in database for this module.
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	private function installDB()
	{
		return (
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'cloud_gallery_image_lang`') &&
			Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."cloud_gallery_image_lang` (
			  `id_cloud_gallery_image` int(255) unsigned NOT NULL AUTO_INCREMENT,
			  `id_lang` int(11) NOT NULL,
			  `image` VARCHAR(100),
			  `image_w` VARCHAR(10),
				`image_h` VARCHAR(10),
				`number_of_column int(10) DEFAULT 4,
				`title` text NOT NULL,
				`url` TEXT,
				`target` tinyint(1) unsigned NOT NULL DEFAULT '0',
				`active` tinyint(1) unsigned NOT NULL DEFAULT '1',
			  `description` text NOT NULL,
			  `item_order` int(10) unsigned NOT NULL COMMENT 'Normaly they are sorted by date. But also listens to this value. (greater == first).' ,
			  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date when this that was created.',
			  PRIMARY KEY (`id_cloud_gallery_image`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;"));

	}

	/**
	* This is suppose to set up the admin page
	* @author Linus Lundevall <developer@prettypegs.com>
	*/

	protected function renderThemeConfiguratorForm()
	{
		$id_shop = (int)$this->context->shop->id;
		$items = array();

		$this->context->smarty->assign('htmlcontent', array(
			'admin_tpl_path' => $this->admin_tpl_path,
			'hooks_tpl_path' => $this->hooks_tpl_path,

			'info' => array(
				'module' => $this->name,
				'name' => $this->displayName,
				'version' => $this->version,
				'psVersion' => _PS_VERSION_,
				'context' => (Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') == 0) ? 1 : ($this->context->shop->getTotalShops() != 1) ? $this->context->shop->getContext() : 1
				)
			));

		$items = Db::getInstance()->ExecuteS('
			SELECT * FROM `'._DB_PREFIX_.'cloud_gallery_image_lang`
			ORDER BY created_at ASC'
			);
			//AND id_lang = '.(int)$language['id_lang'].'
			//WHERE id_shop = '.(int)$id_shop.'
			//AND hook = \''.pSQL($hook).'\'

		$this->context->smarty->assign('htmlitems', array(
			'items' => $items,
			'postAction' => 
			'index.php?tab=AdminModules&configure='.$this->name
			.'&token='.Tools::getAdminTokenLite('AdminModules')
			.'&tab_module=other&module_name='.$this->name.'',
			'id_shop' => $id_shop
			));

		return $this->display(__FILE__, 'views/templates/admin/admin.tpl');
	}


	/**
	* Saves an item in admin panel
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	protected function updateItem()
	{
		$id_item = (int)Tools::getValue('item_id');
		$title = Tools::getValue('item_title');
		$description= Tools::getValue('item_description');

		if (!Validate::isCleanHtml($title, (int)Configuration::get('PS_ALLOW_HTML_IFRAME')) || !Validate::isCleanHtml($description, (int)Configuration::get('PS_ALLOW_HTML_IFRAME')))
		{
			$this->context->smarty->assign('error', $this->l('Invalid content'));
			return false;
		}

		$new_image = '';
		$image_w = (is_numeric(Tools::getValue('item_img_w'))) ? (int)Tools::getValue('item_img_w') : '';
		$image_h = (is_numeric(Tools::getValue('item_img_h'))) ? (int)Tools::getValue('item_img_h') : '';

		if (!empty($_FILES['item_img']['name']))
		{
			if ($old_image = Db::getInstance()->getValue('SELECT image FROM `'._DB_PREFIX_.'cloud_gallery_image_lang` WHERE id_cloud_gallery_image = '.(int)$id_item))
				if (file_exists(dirname(__FILE__).'/img/'.$old_image))
					@unlink(dirname(__FILE__).'/img/'.$old_image);

			if (!$image = $this->uploadImage($_FILES['item_img'], '',''))
				return false;

			$new_image = 'image = \''.pSQL($image).'\',';
		}

		if (!Db::getInstance()->execute('
			UPDATE `'._DB_PREFIX_.'cloud_gallery_image_lang` SET 
					title = \''.pSQL($title).'\',
					url = \''.pSQL(Tools::getValue('item_url')).'\',
					target = '.(int)Tools::getValue('item_target').',
					'.$new_image.'
					image_w = '.(int)$image_w.',
					image_h = '.(int)$image_h.',
					item_order ='. (int)Tools::getValue('item_order').',
					active = '.(int)Tools::getValue('item_active').',
					description = \''.pSQL($description, true).'\'
			WHERE id_cloud_gallery_image = '.(int)Tools::getValue('item_id')
		))
		{
			if ($image = Db::getInstance()->getValue('SELECT image FROM `'._DB_PREFIX_.'cloud_gallery_image_lang` WHERE id_cloud_gallery_image = '.(int)Tools::getValue('item_id')))
				$this->deleteImage($image);

			$this->context->smarty->assign('error', $this->l('An error occurred while saving data.'));

			return false;
		}

		$this->context->smarty->assign('confirmation', $this->l('Successfully updated.'));

		return true;
	}


	/**
	* Used in updateItem and newItem
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	protected function uploadImage($image, $image_w = '', $image_h = '')
	{
		$res = false;
		if (is_array($image) && (ImageManager::validateUpload($image, $this->max_image_size) === false) && ($tmp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS')) && move_uploaded_file($image['tmp_name'], $tmp_name))
		{
			$salt = sha1(microtime());
			$pathinfo = pathinfo($image['name']);
			$img_name = $salt.'_'.Tools::str2url($pathinfo['filename']).'.'.$pathinfo['extension'];

			if (ImageManager::resize($tmp_name, dirname(__FILE__).'/img/'.$img_name, $image_w, $image_h))
				$res = true;
		}

		if (!$res)
		{
			$this->context->smarty->assign('error', $this->l('An error occurred during the image upload.'));
			return false;
		}

		return $img_name;
	}

	/**
	* Used for adding new images to the cloud gallery.
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	protected function addItem()
	{
		$title = Tools::getValue('item_title');
		$description = Tools::getValue('item_description');

		if (!Validate::isCleanHtml($title, (int)Configuration::get('PS_ALLOW_HTML_IFRAME'))
			|| !Validate::isCleanHtml($description, (int)Configuration::get('PS_ALLOW_HTML_IFRAME')))
		{
			$this->context->smarty->assign('error', $this->l('Invalid content'));
			return false;
		}

		if (!$current_order = (int)Db::getInstance()->getValue('
			SELECT item_order + 1
			FROM `'._DB_PREFIX_.'cloud_gallery_image_lang` 
				ORDER BY item_order DESC'
		))
			$current_order = 1;

		$image_w =  '';
		$image_h = '';

		if (!empty($_FILES['item_img']['name']))
		{
			if (!$image = $this->uploadImage($_FILES['item_img'], $image_w, $image_h))
				return false;
		}
		else
		{
			$image = '';
			$image_w = '';
			$image_h = '';
		}

		if (!Db::getInstance()->Execute('
			INSERT INTO `'._DB_PREFIX_.'cloud_gallery_image_lang` (
					 `item_order`, `title`, `url`, `target`, `image`, `image_w`, `image_h`, `description`, `active`
			) VALUES (
					'. (int)Tools::getValue('item_order') .',
					\''.pSQL($title).'\',
					\''.pSQL(Tools::getValue('item_url')) .'\',
					\''.(int)Tools::getValue('item_target').'\',
					\''.pSQL($image).'\',
					\''.pSQL($image_w).'\',
					\''.pSQL($image_h).'\',
					\''.pSQL($description, true).'\',
					1)'
		))
		{
			if (!Tools::isEmpty($image))
				$this->deleteImage($image);

			$this->context->smarty->assign('error', $this->l('An error occurred while saving data.'));
			return false;
		}

		$this->context->smarty->assign('confirmation', $this->l('New item successfully added.'));
		return true;
	}
	
	protected function deleteImage($image)
	{
		$file_name = $this->uploads_path.$image;

		if (realpath(dirname($file_name)) != realpath($this->uploads_path))
			Tools::dieOrLog(sprintf('Could not find upload directory'));

		if ($image != '' && is_file($file_name) && !strpos($file_name, 'banner-img') && !strpos($file_name, 'bg-theme') && !strpos($file_name, 'footer-bg'))
			unlink($file_name);
	}


	protected function removeItem()
	{
		$id_item = (int)Tools::getValue('item_id');

		if ($image = Db::getInstance()->getValue('SELECT image FROM `'._DB_PREFIX_.'cloud_gallery_image_lang` WHERE id_cloud_gallery_image = '.(int)$id_item))
			$this->deleteImage($image);

		Db::getInstance()->delete(_DB_PREFIX_.'cloud_gallery_image_lang', 'id_cloud_gallery_image = '.(int)$id_item);

		if (Db::getInstance()->Affected_Rows() == 1)
		{
			Db::getInstance()->execute('
				UPDATE `'._DB_PREFIX_.'cloud_gallery_image_lang` 
				SET item_order = item_order-1 
				WHERE (item_order > '.(int)Tools::getValue('item_order').')'
			);
			Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&conf=6&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else
			$this->context->smarty->assign('error', $this->l('Can\'t delete the slide.'));
	}



}