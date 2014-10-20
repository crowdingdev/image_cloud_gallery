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
		<button type="button" class="btn btn-default btn-lg button-new-item"><i class="icon-plus-sign"></i> {l s='Add item' mod='prettypegsattributepreferences'}</button>
	</div>
	<div class="item-container" style="display:none;">
		<form method="post" action="{$htmlItems.postAction|escape:'htmlall':'UTF-8'}" enctype="multipart/form-data" class="item-form defaultForm  form-horizontal">
			<div class="well">

				<div class="hook item-field form-group">
					<label class="control-label col-lg-3">{l s='Attribute' mod='prettypegsattributepreferences'}</label>
					<div class="col-lg-7">
						<select class="form-control fixed-width-lg" name="id_attribute" default="home">

							{foreach from=$attributes item=attribute}
								<option value="{$attribute.id_attribute}">{$attribute.name}</option>  
							{/foreach}

						</select>
					</div>
				</div>


				<div class="hook item-field form-group">
					<label class="control-label col-lg-3">{l s='Product' mod='prettypegsattributepreferences'}</label>
					<div class="col-lg-7">
						<select class="form-control fixed-width-lg" name="id_product" default="home">

							{foreach from=$products item=product}
								<option value="{$product.id_product}">{$product.name}</option>  
							{/foreach}

						</select>
					</div>
				</div>



				<div class="hook item-field form-group">
					<label class="control-label col-lg-3">{l s='Category' mod='prettypegsattributepreferences'}</label>
					<div class="col-lg-7">
						<select class="form-control fixed-width-lg" name="id_category" default="home">

							{foreach from=$categories item=category}
								<option value="{$category.id_category}">{$category.name}</option>  
							{/foreach}

						</select>
					</div>
				</div>

				<div class="html item-field form-group">
					<label class="control-label col-lg-3">{l s='Description' mod='prettypegsattributepreferences'}</label>
					<div class="col-lg-7">
						<input type="text" name="description" >
					</div>
				</div>


				<div class="form-group">
					<div class="col-lg-7 col-lg-offset-3">
						<button type="button" class="btn btn-default button-new-item-cancel"><i class="icon-remove"></i> {l s='Cancel' mod='prettypegsattributepreferences'}</button>
						<button type="submit" name="newItem" class="btn btn-success button-save pull-right"><i class="icon-save"></i> {l s='Save' mod='prettypegsattributepreferences'}</button>
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
