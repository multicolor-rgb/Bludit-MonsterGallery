<?php 

global $SITEURL;

$gal = '

<link rel="stylesheet" href="'.DOMAIN.'/bl-plugins/monsterGallery/modules/photoswipe/photoswipe.css">

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


$gal .= '<div class="monsterGallery-grid" id="gallery--with-custom-caption">';

foreach ($dataJson->images as $key => $value) {

global $SITEURL;

$forthumb = str_replace(DOMAIN.'bl-plugins/monsterGallery/monsterGalleryImages/',PATH_PLUGINS.'/monsterGallery/monsterGalleryImages/',$value);
$gal .=  '<a href="'.$value.'" class="pswp-gallery__item" >
<img src="'.MGthumb($forthumb,$quality).'" style="width:'.$width.'px;height:'.$height.'px;object-fit:cover;"
alt="'.$dataJson->names[$key].' '.$dataJson->descriptions[$key].'"
></a>';

}

 $gal .= '</div>';

 $gal .= '<script type="module" src="'.DOMAIN.'/bl-plugins/monsterGallery/modules/photoswipe/photoSwipeModule.js"></script>';



global $modules;

$modules = 'PhotoSwipe';


 ;?>