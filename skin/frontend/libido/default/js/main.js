jQuery.fn.hasAttr = function(name) {  
	var attr = jQuery(this).attr(name);
	return (typeof attr !== 'undefined' && attr !== false);
};

jQuery(document).ready(function(){
	jQuery('.watermak').focus(function(){
		if(jQuery(this).hasAttr('value') && !jQuery(this).hasAttr('watermak')){
			jQuery(this).attr('watermak',this.value);
			jQuery(this).val('');
		}
	}).blur(function(){
		if(jQuery(this).hasAttr('value') && jQuery(this).hasAttr('watermak') && jQuery(this).val()==''){
			jQuery(this).val(jQuery(this).attr('watermak'));
			jQuery(this).removeAttr('watermak');
		}
	});
});