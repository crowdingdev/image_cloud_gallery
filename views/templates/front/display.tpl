<div class="image-cloud-gallery-wrapper">

<div class="row" >



{foreach from=$items item=item}

	<div class="col-xs-4 " style="background-image: url('/modules/imagecloudgallery/img/{$item.image}');  background-size: 100%; height: {$item.image_h}px;">
		<div class="text-content">
<h3>{$item.title}</h3>
<p>{$item.description}</p>
</div>	
</div>

{/foreach}

</div>
</div>