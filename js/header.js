$(function(){

	// Get the category id for the last anchor tag in the breadcrumb
	var categoryUrl = $('.breadcrumb a').last().attr('href')
	if (!categoryUrl){
		return;
	}
	var categoryId =  parseInt(categoryUrl.substring( categoryUrl.lastIndexOf("/")+1, categoryUrl.lastIndexOf("-")),10);

	for (var i in attributePreference){

		if (parseInt(attributePreference[i].id_category) === categoryId){

			// var el = $('.attribute_list input[value="'+attributePreference[i].id_attribute+'"]');
			// el.attr('name');
			//$('.attribute_list input[name="'+el.attr('name')+'"]').attr('disabled',true);

			$('.attribute_list input[value="'+attributePreference[i].id_attribute+'"]').attr('checked', true);

		}
	}

});


