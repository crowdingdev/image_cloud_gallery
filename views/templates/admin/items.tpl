{*
	* 2007-2014 PrestaShop
	*
	* NOTICE OF LICENSE
	*
	* This source file is subject to the Academic Free License (AFL 3.0)
	* that is bundled with this package in the file LICENSE.txt.
	* It is also available through the world-wide-web at this URL:
	* http://opensource.org/licenses/afl-3.0.php
	* If you did not receive a copy of the license and are unable to
	* obtain it through the world-wide-web, please send an email
	* to license@prestashop.com so we can send you a copy immediately.
	*
	* DISCLAIMER
	*
	* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
	* versions in the future. If you wish to customize PrestaShop for your
	* needs please refer to http://www.prestashop.com for more information.
	*
	*  @author PrestaShop SA <contact@prestashop.com>
	*  @copyright  2007-2014 PrestaShop SA
	*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
	*  International Registered Trademark & Property of PrestaShop SA
	*}


	<div id="" class="tab-pane">

		<ul id="items" class="list-unstyled">
			{foreach from=$htmlItems.items item=item}
			<li id="item-{$item.id_prettypegs_attribute_preferences|escape:'htmlall':'UTF-8'}" class="item well">
				<form method="post" action="{$htmlItems.postAction|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" class="item-form defaultForm  form-horizontal">

					<div class="btn-group pull-right">
						<button class="btn btn-default button-edit">
							<span class="button-edit-edit"><i class="icon-edit"></i> {l s='Edit' mod='prettypegsattributepreferences'}</span>
							<span class="button-edit-close hide"><i class="icon-remove"></i> {l s='Close' mod='prettypegsattributepreferences'}</span>
						</button>
						<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<i class="icon-caret-down"></i>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="{$htmlItems.postAction|escape:'htmlall':'UTF-8'}&amp;removeItem&amp;item_id={$item.id_prettypegs_attribute_preferences|escape:'htmlall':'UTF-8'}" name="removeItem" class="link-item-delete">
									<i class="icon-trash"></i> {l s='Delete item' mod='prettypegsattributepreferences'}
								</a>
							</li>
						</ul>
					</div>

					<p><strong>ID: </strong>{$item.id_prettypegs_attribute_preferences}<p>

						<p><strong>Description: </strong>{$item.description}<p>

						<div class="item-container clearfix" style="display:none">

							<input type="hidden" name="item_id" value="{$item.id_prettypegs_attribute_preferences|escape:'htmlall':'UTF-8'}" />
							<div class="hook item-field form-group">
								<label class="control-label col-lg-3">{l s='Attribute' mod='prettypegsattributepreferences'}</label>
								<div class="col-lg-7">
									<select class="form-control fixed-width-lg" name="id_attribute" >

										

										{foreach from=$attributes item=attribute}
											<option value="{$attribute.id_attribute}" {if $attribute.id_attribute == $item.id_attribute}selected{/if}>{$attribute.name}</option>
										{/foreach}

									</select>
								</div>
							</div>

							<div class="hook item-field form-group">
								<label class="control-label col-lg-3">{l s='Product' mod='prettypegsattributepreferences'}</label>
								<div class="col-lg-7">
									<select class="form-control fixed-width-lg" name="id_product" >

										{foreach from=$products item=product}
											<option value="{$product.id_product}" {if $product.id_product == $item.id_product}selected{/if} >{$product.name}</option>  
										{/foreach}

									</select>
								</div>
							</div>

							<div class="hook item-field form-group">
								<label class="control-label col-lg-3">{l s='Category' mod='prettypegsattributepreferences'}</label>
								<div class="col-lg-7">
									<select class="form-control fixed-width-lg" name="id_category" >

										{foreach from=$categories item=category}
											<option value="{$category.id_category}" {if $category.id_category == $item.id_category}selected{/if}>{$category.name}</option>
										{/foreach}

									</select>
								</div>
							</div>

							<div class="html item-field form-group">
								<label class="control-label col-lg-3">{l s='Description' mod='prettypegsattributepreferences'}</label>
								<div class="col-lg-7">
									<!--This is used in conjuction with the translations for this module-->
									<input type="text" name="description" value="{$item.description|escape:'htmlall':'UTF-8'}">
								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-7 col-lg-offset-3">
									<button type="button" class="btn btn-default button-item-edit-cancel" >
										<i class="icon-remove"></i> {l s='Cancel' mod='prettypegsattributepreferences'}
									</button>
									<button type="submit" name="updateItem" class="btn btn-success button-save pull-right" >
										<i class="icon-save"></i> {l s='Save' mod='prettypegsattributepreferences'}
									</button>
								</div>
							</div>
						</div>

				</form>

			</li>

			{/foreach}
		</ul>
	</div>
