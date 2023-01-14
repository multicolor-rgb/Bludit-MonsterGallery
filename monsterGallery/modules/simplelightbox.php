<?php 

global $SITEURL;

$gal = '
<link rel="stylesheet" href="'.DOMAIN.'/bl-plugins/monsterGallery/modules/simplelightbox/simple-lightbox.min.css">

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


$gal .= '<div class="monsterGallery-grid gallery">';

foreach ($dataJson->images as $key => $value) {

global $SITEURL;

$forthumb = str_replace(DOMAIN.'bl-plugins/monsterGallery/monsterGalleryImages/',PATH_PLUGINS.'/monsterGallery/monsterGalleryImages/',$value);

$gal .=  '<a href="'.$value.'"  data-title="'.$dataJson->names[$key].'"
 data-description="'.$dataJson->descriptions[$key].'" data-zoomable="true"><img src="'.MGthumb($forthumb,$quality).'" style="width:'.$width.'px;height:'.$height.'px;object-fit:cover;"></a>';

}

 $gal .= '</div>';


 $gal .= '
<script src="'.DOMAIN.'/bl-plugins/monsterGallery/modules/simplelightbox/simple-lightbox.min.js"></script>


 <script>
 let gallery = new SimpleLightbox(".gallery a");
 gallery.on("show.simplelihtbox", function (e) {
 
 e.captions = true;
 e.captionSelector = "a";
 e.captionType = "data-title";
 });
 
 </script>

 
 ';



global $modules;

$modules = 'simplelightbox';


 ;?>