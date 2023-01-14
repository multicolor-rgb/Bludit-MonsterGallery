<?php 

global $SITEURL;

$gal = '
<link rel="stylesheet" href="'.DOMAIN.'/bl-plugins/monsterGallery/modules/baguettebox/baguetteBox.min.css">
<style>

.monsterGallery-grid{
	display:flex;
	flex-direction:row;
	flex-wrap:wrap;'

.($gap=='' ? '':'gap:'.$gap.'px').

	'
}

@media(max-width:768px){

	.monsterGallery{
		width:95%;
		margin:0 auto;
		display:flex;
		flex-wrap:wrap;
		flex-direction:column;
	}


.monsterGallery-grid a{
	margin:0;
	padding:0;
}

.monsterGallery-grid img{
	max-width:100% !important;}}
</style>
';


$gal .= '<div class="monsterGallery-grid galleryx">';

foreach ($dataJson->images as $key => $value) {

global $SITEURL;

$forthumb = str_replace(DOMAIN.'bl-plugins/monsterGallery/monsterGalleryImages/',PATH_PLUGINS.'/monsterGallery/monsterGalleryImages/',$value);

$gal .=  '<a href="'.$value.'"      data-caption="<h4>'.$dataJson->names[$key].'</h4> '.$dataJson->descriptions[$key].'">
<img alt="'.$dataJson->names[$key].' '.$dataJson->descriptions[$key].'" src="'.MGthumb($forthumb,$quality).'" style="width:'.$width.'px;height:'.$height.'px;object-fit:cover;"></a>';

}

 $gal .= '</div>';


$gal .= '<script async  src="'.DOMAIN.'/bl-plugins/monsterGallery/modules/baguettebox/baguetteBox.min.js"></script>';

$gal .= '<script>
 
 window.addEventListener("load", function() {
   baguetteBox.run(".galleryx",(element)=>{
			   return element.getElementsByTagName("img")[0].alt;
	   });
 });
 
 
 </script>';



global $modules;

$modules = 'baguettebox';


 ;?>