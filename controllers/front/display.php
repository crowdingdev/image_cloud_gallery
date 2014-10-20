<?php
class ImageCloudGallerydisplayModuleFrontController extends ModuleFrontController
{
  public function initContent()
  {

    parent::initContent();
			$items = array();

		// Selects all rows where active(enabled) == 1(true)
    $items = Db::getInstance()->ExecuteS('SELECT * FROM `ps_cloud_gallery_image_lang` WHERE `active`= 1 ORDER BY item_order ASC, created_at ASC');

  	$this->context->smarty->assign( array( 'items' => $items ) );
		$this->context->controller->addCSS(__DIR__.'/../../css/imagecloudgallery.css');
    $this->setTemplate( 'display.tpl' );
  }
}