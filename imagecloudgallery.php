<?php
if (!defined('_PS_VERSION_')){
  exit;
  }


class ImageCloudGallery extends Module
{

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

		parent::__construct();

		$this->displayName = $this->l('Image Cloud Gallery');
		$this->description = $this->l('Create cloud of images as a gallery.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall? We are not friends anymore...');

		if (!Configuration::get('IMAGECLOUDGALLERY'))
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
    $this->registerHook('leftColumn') &&
    $this->registerHook('header') &&
    Configuration::updateValue('IMAGECLOUDGALLERY', 'my friend');
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
			$image_cloud_gallery = strval(Tools::getValue('IMAGECLOUDGALLERY'));
			if (!$image_cloud_gallery
				|| empty($image_cloud_gallery)
				|| !Validate::isGenericName($image_cloud_gallery))
				$output .= $this->displayError($this->l('Invalid Configuration value'));
			else
			{
				Configuration::updateValue('IMAGECLOUDGALLERY', $image_cloud_gallery);
				$output .= $this->displayConfirmation($this->l('Settings updated'));
			}
		}
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
		$fields_form[0]['form'] = array(
			'legend' => array(
				'title' => $this->l('Settings'),
				),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Configuration value'),
					'name' => 'IMAGECLOUDGALLERY',
					'size' => 20,
					'required' => true
					)
				),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
				)
			);

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
    $helper->fields_value['IMAGECLOUDGALLERY'] = Configuration::get('IMAGECLOUDGALLERY');

    return $helper->generateForm($fields_form);
  }


	/**
	* @author Linus Lundevall <developer@prettypegs.com>
	*/
	public function hookDisplayLeftColumn($params)
	{
		$this->context->smarty->assign(
			array(
				'imagecloudgallery' => Configuration::get('IMAGECLOUDGALLERY'),
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

}