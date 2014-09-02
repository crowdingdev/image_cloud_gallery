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

<div class="new-item">
	<div class="form-group">
		<button type="button" class="btn btn-default btn-lg button-new-item"><i class="icon-plus-sign"></i> {l s='Add item' mod='themeconfigurator'}</button>
	</div>
	<div class="item-container" style="display:none;">
		<form method="post" action="{$htmlitems.postAction|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" class="item-form defaultForm  form-horizontal">
			<div class="well">
				<div class="title item-field form-group">
					<label class="control-label col-lg-3 ">{l s='Title' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<input class="form-control" type="text" name="item_title"/>
					</div>
				</div>



				<div class="item-order item-field form-group">
					<label class="control-label col-lg-3">{l s='Item order' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<input type="number" maxlength="4" name="item_order" />
					</div>
				</div>



				<div class="image item-field form-group">
					<label class="control-label col-lg-3">{l s='Image' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<input type="file" name="item_img" />
					</div>
				</div>
				<div class="image_w item-field form-group">

					<label class="control-label col-lg-3">{l s='Image width in columns (max: 12, min: 1)' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<div class="input-group fixed-width-lg">
							<span class="input-group-addon">{l s='columns'}</span>
							<input name="item_img_w" type="text" maxlength="4"/>
						</div>
					</div>
				</div>
				<div class="image_h item-field form-group">
					<label class="control-label col-lg-3">{l s='Image height' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<div class="input-group fixed-width-lg">
							<span class="input-group-addon">{l s='px'}</span>
							<input name="item_img_h" type="text" maxlength="4"/>
						</div>
					</div>
				</div>
				<div class="url item-field form-group">
					<label class="control-label col-lg-3">{l s='URL' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<input type="text" name="item_url" placeholder="http://" />
					</div>
				</div>
				<div class="target item-field form-group">
					<div class="col-lg-9 col-lg-offset-3">
						<div class="checkbox">
							<label class="control-label">
								{l s='Target blank' mod='themeconfigurator'}
								<input type="checkbox" name="item_target" value="1" />
							</label>
						</div>
					</div>
				</div>
				<div class="html item-field form-group">
					<label class="control-label col-lg-3">{l s='HTML' mod='themeconfigurator'}</label>
					<div class="col-lg-7">
						<textarea name="item_description" cols="65" rows="12"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-7 col-lg-offset-3">
						<button type="button" class="btn btn-default button-new-item-cancel"><i class="icon-remove"></i> {l s='Cancel' mod='themeconfigurator'}</button>
						<button type="submit" name="newItem" class="btn btn-success button-save pull-right"><i class="icon-save"></i> {l s='Save' mod='themeconfigurator'}</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	function setLanguage(language_id, language_code) {
		$('#lang-id').val(language_id);
		$('#selected-language').html(language_code);
	}
</script>
