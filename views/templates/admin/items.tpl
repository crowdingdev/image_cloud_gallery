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
				{foreach from=$htmlitems.items item=item}
					<li id="item-{$item.id_cloud_gallery_image|escape:'htmlall':'UTF-8'}" class="item well">
						<form method="post" action="{$htmlitems.postAction|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" class="item-form defaultForm  form-horizontal">
							<div class="btn-group pull-right">
								<button class="btn btn-default button-edit">
									<span class="button-edit-edit"><i class="icon-edit"></i> {l s='Edit' mod='themeconfigurator'}</span>
									<span class="button-edit-close hide"><i class="icon-remove"></i> {l s='Close' mod='themeconfigurator'}</span>
								</button>
								<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									<i class="icon-caret-down"></i>
								</button>
								<ul class="dropdown-menu">
									<li>
										<a href="{$htmlitems.postAction|escape:'htmlall':'UTF-8'}&amp;removeItem&amp;item_id={$item.id_cloud_gallery_image|escape:'htmlall':'UTF-8'}" name="removeItem" class="link-item-delete">
											<i class="icon-trash"></i> {l s='Delete item' mod='themeconfigurator'}
										</a>
									</li>
								</ul>
							</div>
							<span class="item-order">{$item.title}</span>
							<br>
							{if $item.image && isset($item.image)}
								<img src="{$module_dir}img/{$item.image}" style="height:100px; rel="#comments_{$item.id_cloud_gallery_image}" class="preview img-thumbnail" />
							{/if}
							<div class="item-container clearfix" style="display:none">
								<input type="hidden" name="item_id" value="{$item.id_cloud_gallery_image|escape:'htmlall':'UTF-8'}" />
								<input type="hidden" name="item_order" value="{$item.item_order|escape:'htmlall':'UTF-8'}" />
								<div class="item-field form-group">
									<div class="col-lg-9 col-lg-offset-3">
										<div class="checkbox">
											<label class="control-label">
												{l s='Enable' mod='themeconfigurator'}
												<input type="checkbox" name="item_active" value="1"{if $item.active == 1} checked="checked"{/if} />
											</label>
										</div>
									</div>
								</div>
								<div class="title item-field form-group">
									<label class="control-label col-lg-3">{l s='Image title' mod='themeconfigurator'}</label>
									<div class="col-lg-7">
										<input type="text" name="item_title" value="{$item.title|escape:'htmlall':'UTF-8'}" />
									</div>
								</div>

				<div class="item-order item-field form-group">
					<label class="control-label col-lg-3">{l s='Item order' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<input type="number" name="item_order" maxlength="4" value="{$item.item_order}" />
					</div>
				</div>


								<div class="image item-field form-group">
									<label class="control-label col-lg-3">{l s='Load your image' mod='themeconfigurator'}</label>
									<div class="col-lg-7">
										<input type="file" name="item_img" />
									</div>
								</div>
								<div class="image_w item-field form-group">
									<label class="control-label col-lg-3">{l s='Image width in columns (max: 12, min: 1)' mod='themeconfigurator'}</label>
									<div class="col-lg-7">
										<div class="input-group fixed-width-lg">
											<input name="item_img_w" type="text" maxlength="4" size="4" value="{$item.image_w|escape:'htmlall':'UTF-8'}"/>
											<span class="input-group-addon">{l s='columns'}</span>
										</div>
									</div>
								</div>
								<div class="image_h item-field form-group">
									<label class="control-label col-lg-3">{l s='Image height' mod='themeconfigurator'}</label>
									<div class="col-lg-7">
										<div class="input-group fixed-width-lg">
											<input name="item_img_h" type="text" maxlength="4" size="4" value="{$item.image_h|escape:'htmlall':'UTF-8'}"/>
											<span class="input-group-addon">{l s='pixels'}</span>
										</div>
									</div>
								</div>
								<div class="url item-field form-group">
									<label class="control-label col-lg-3">{l s='Target link' mod='themeconfigurator'}</label>
									<div class="col-lg-7">
										<input type="text" name="item_url" value="{$item.url|escape:'htmlall':'UTF-8'}" />
									</div>
								</div>
								<div class="target item-field form-group">
									<div class="col-lg-9 col-lg-offset-3">
										<div class="checkbox">
											<label class="control-label">
												{l s='Open link in a new tab/page' mod='themeconfigurator'}
												<input type="checkbox" name="item_target" value="1"{if $item.target == 1} checked="checked"{/if} />
											</label>
										</div>
									</div>
								</div>
								<div class="html item-field form-group">
									<label class="control-label col-lg-3">{l s='Description' mod='themeconfigurator'}</label>
									<div class="col-lg-7">
										<textarea name="item_description" cols="65" rows="12">{$item.description|escape:'htmlall':'UTF-8'}</textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-lg-7 col-lg-offset-3">
										<button type="button" class="btn btn-default button-item-edit-cancel" >
											<i class="icon-remove"></i> {l s='Cancel' mod='themeconfigurator'}
										</button>
										<button type="submit" name="updateItem" class="btn btn-success button-save pull-right" >
											<i class="icon-save"></i> {l s='Save' mod='themeconfigurator'}
										</button>
									</div>
								</div>
							</div>
						</form>
					</li>
				{/foreach}
			</ul>
</div>
