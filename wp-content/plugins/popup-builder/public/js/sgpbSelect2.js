jQuery.fn.sgpbselect2=jQuery.fn.select2;function SGPBSelect2()
{this.init();}
SGPBSelect2.prototype.init=function()
{if(!jQuery('.js-sg-select2').length){return;}
this.hideProOptions();jQuery('select.js-sg-select2').each(function(){var type=jQuery(this).attr('data-select-type');var className=jQuery(this).attr('data-select-class');var options={width:'100%'};if(type=='ajax'){options=jQuery.extend(options,{minimumInputLength:1,ajax:{url:SGPB_JS_PARAMS.url,dataType:'json',delay:250,type:"POST",data:function(params){var searchKey=jQuery(this).attr('data-value-param');return{action:'select2_search_data',nonce_ajax:SGPB_JS_PARAMS.nonce,searchTerm:params.term,searchKey:searchKey};},processResults:function(data){return{results:jQuery.map(data.items,function(item){return{text:item.text,id:item.id}})};}}});}
jQuery(this).sgpbselect2(options);});};SGPBSelect2.prototype.hideProOptions=function()
{if(typeof SGPB_JS_PACKAGES=='undefined'){return;}
if(SGPB_JS_PACKAGES.packages['current']<SGPB_JS_PACKAGES.packages['platinum']){var disabledOptions=SGPB_JS_PACKAGES.proEvents;if(SGPB_JS_PACKAGES.packages['current']<SGPB_JS_PACKAGES.packages['silver']){for(var option in disabledOptions){var disabledOption=disabledOptions[option];jQuery('.sgpb-selectbox-settings option').each(function(){if(jQuery(this).val()==disabledOption){jQuery(this).attr('disabled','disabled');}});}}
if(SGPB_JS_PACKAGES.extensions['geo-targeting']){return;}
var disabledOptions=['groups_countries'];jQuery('.sgpb-selectbox-settings optgroup option').each(function(){for(var option in disabledOptions){var disabledOption=disabledOptions[option];if(jQuery(this).val()==disabledOption){jQuery(this).attr('disabled','disabled');}}});}};jQuery(document).ready(function(){var sgpbSelect2=new SGPBSelect2();});