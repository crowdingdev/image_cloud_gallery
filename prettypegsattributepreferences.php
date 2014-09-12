<?php
if (!defined('_PS_VERSION_')){
  exit;
  }

require_once(_PS_MODULE_DIR_.'prettypegsattributepreferences/classes/DBQueryHelperClass.php');

class PrettypegsAttributePreferences extends Module
{
	protected $max_image_size = 1048576;

	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function __construct()
	{
		$this->name = 'prettypegsattributepreferences';
		$this->tab = 'font_office_features';
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

		$this->displayName = $this->l('Prettypegs Attribute Preferences');
		$this->description = $this->l('This module makes it possible to select what attributes a product fits depending on the category is in the breadcrumb.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall? We are not friends anymore...');

		// if (!Configuration::get('IMAGECLOUDGALLERY_NAME'))
		// {
		// 	$this->warning = $this->l('No name provided');
		// }

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
    $this->registerHook('header') &&
    $this->registerHook('displayBackOfficeHeader');
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
		{
			$this->addItem();
		}
		elseif (Tools::isSubmit('updateItem'))
		{
			$this->updateItem();
		}
		elseif (Tools::isSubmit('removeItem'))
		{
			$this->removeItem();
		}

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
    //$helper->fields_value['IMAGECLOUDGALLERY_NAME'] = Configuration::get('IMAGECLOUDGALLERY_NAME');

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
	public function hookDisplayHeader()
	{

		$attributePreference = DBQueryHelperClass::getAllEnabledPrettypegsAttributePreference();
		$this->context->smarty->assign(array('attributePreference' => $attributePreference));
		$this->context->controller->addJS($this->_path.'js/header.js');
		//$this->context->controller->addCSS($this->_path.'css/prettypegsattributepreferences.css', 'all');

		return $this->display(__FILE__, 'views/templates/hook/header.tpl');
	}

	/**
	* Creates the tables in database for this module.
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	private function installDB()
	{
		return (
			Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'prettypegs_attribute_preferences`') &&
			Db::getInstance()->Execute("
			CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."prettypegs_attribute_preferences` (
			  `id_prettypegs_attribute_preferences` int(255) unsigned NOT NULL AUTO_INCREMENT,
			  `id_product` int(11) NOT NULL,
			  `id_category` int(11) NOT NULL,
			  `id_attribute` int(11) NOT NULL,
				`enabled` tinyint(1) unsigned NOT NULL DEFAULT '1',
			  `description` text NOT NULL,
			  `importance` int(10) unsigned NOT NULL ,
			  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Date when this that was created.',
			  PRIMARY KEY (`id_prettypegs_attribute_preferences`),
			   KEY `select` (`id_product`,`id_category`,`id_attribute`)
			) ENGINE="._MYSQL_ENGINE_." DEFAULT CHARSET=utf8;"));

	}

	/**
	* This is suppose to set up the admin page
	* @author Linus Lundevall <developer@prettypegs.com>
	*/

	protected function renderThemeConfiguratorForm()
	{
		$id_shop = (int)$this->context->shop->id;
	//		$items = array();

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

		require_once(_PS_MODULE_DIR_.'prettypegsattributepreferences/classes/DBQueryHelperClass.php');

		$attributes = DBQueryHelperClass::getAllAttributes();
		$products = DBQueryHelperClass::getAllProducts();
		$categories = DBQueryHelperClass::getAllCategories();
		$items = DBQueryHelperClass::getAllPrettypegsAttributePreference();

		//$this->context->smarty->assign(array('items' => $items));
  	$this->context->smarty->assign(array('attributes' => $attributes));
		$this->context->smarty->assign(array('products' => $products));
		$this->context->smarty->assign(array('categories' => $categories));



		$this->context->smarty->assign('htmlItems', array('items' => $items,
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
		require_once(_PS_MODULE_DIR_.'prettypegsattributepreferences/classes/DBQueryHelperClass.php');

		$id_item = Tools::getValue('item_id');
		$id_product = Tools::getValue('id_product');
		$id_category = Tools::getValue('id_category');
		$id_attribute = Tools::getValue('id_attribute');
		$description = Tools::getValue('description');

		$result = DBQueryHelperClass::updatePrettypegsAttributePreference($id_item, $id_attribute, $id_category, $id_product, $description);

		if(!$result){
			$this->context->smarty->assign('error', $this->l('An error occurred while saving data.'));
			return false;
		}
		else{
			$this->context->smarty->assign('confirmation', $this->l('Successfully updated.'));
			return true;
		}
	}

	/**
	* Used for adding new images to the cloud gallery.
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	protected function addItem()
	{

		require_once(_PS_MODULE_DIR_.'prettypegsattributepreferences/classes/DBQueryHelperClass.php');

		$attributes = DBQueryHelperClass::getAllAttributes();

		$id_product = Tools::getValue('id_product');
		$id_category = Tools::getValue('id_category');
		$id_attribute = Tools::getValue('id_attribute');
		$description = Tools::getValue('description');

		$insertResult = DBQueryHelperClass::insertPrettypegsAttributePreference($id_attribute, $id_category, $id_product, $description);

		if (!$insertResult){
			$this->context->smarty->assign('error', $this->l('An error occurred while saving data.'));
			return false;
		}
		else{
			$this->context->smarty->assign('confirmation', $this->l('New preference successfully added.'));
			return true;
		}
	}


	protected function removeItem()
	{
		$id_item = (int)Tools::getValue('item_id');

		Db::getInstance()->delete(_DB_PREFIX_.'prettypegs_attribute_preferences', 'id_prettypegs_attribute_preferences = '.(int)$id_item);

		if (Db::getInstance()->Affected_Rows() == 1)
		{
			Tools::redirectAdmin('index.php?tab=AdminModules&configure='.$this->name.'&conf=6&token='.Tools::getAdminTokenLite('AdminModules'));
		}
		else
			$this->context->smarty->assign('error', $this->l('Can\'t delete the slide.'));
	}

}

