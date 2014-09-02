<div class="image-cloud-gallery-wrapper">
	<div class="row">

		{foreach from=$items item=item}

		<div class="col-lg-{$item.image_w} col-xs-12 cloud-item" style="background-image: url('/modules/imagecloudgallery/img/{$item.image}');  background-size: 100%; height: {$item.image_h}px;">
			<div class="text-content">
				<h3>{$item.title}</h3>
				{if isset($item.description) && $item.description}
					<p>{$item.description}</p>
				{/if}
				{if isset($item.url) && $item.url}
					<a href="{$item.url}" target="{if $item.target == 1}blank{/if}">{l s="Read more" mod="imagecloudgallery"}</a>
				{/if}
			</div>
		</div>

		{/foreach}

	</div>
</div>