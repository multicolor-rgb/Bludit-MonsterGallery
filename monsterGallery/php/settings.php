<style>
.galitem{
	width: 100%;
	display: grid;
	grid-template-columns: 1fr 1fr 130px;
	padding: 10px;
	border: solid 1px #ddd;
	background: #fafafa;
	box-sizing: border-box;
	margin: 2px 0;
	align-items: center;
}

.galitem a{
	background: #000;
	color:#fff !important;
	display: flex;
	align-items: center;
	justify-content: center;
	color:#fff;
	padding:0.5rem 1rem;
	text-decoration: none !important;
}

.galitem p{
	margin:0 !important;
	padding: 0 !important;
}
</style>

<h3>MonsterGallery list</h3>
<br>

<a href="<?php echo DOMAIN_ADMIN;?>plugin/monstergallery?&uploader"
style="padding:0.5rem 1rem;background: #000;color:#fff;text-decoration: none;"
	>UPLOAD IMAGES</a>


<a href="<?php echo DOMAIN_ADMIN;?>plugin/monstergallery?&addMonsterGallery"
style="padding:0.5rem 1rem;background: #000;color:#fff;text-decoration: none;"
	>ADD</a>

	<a href="<?php echo DOMAIN_ADMIN;?>plugin/monstergallery?&monsterGalleryList&clearCache"
style="padding:0.5rem 1rem;background: #000;color:#fff;text-decoration: none;background: red;"
	>CLEAR THUMBNAILS CACHE</a>

	<a href="<?php echo DOMAIN_ADMIN;?>plugin/monstergallery?&credits"
style="padding:0.5rem 1rem;background: #000;color:#fff;text-decoration: none;"
	>CREDITS</a>




<ul style="margin:0;padding: 0;display: block;margin-top: 30px;">

<li class="galitem" style="font-weight: bold;">
<p>name</p>
<p>shortcode for tinyMCE</p>
<p>edit or delete</p>
</li>

<?php 

foreach(glob($this->phpPath().'monsterGalleryList/*.json') as $file){
global $SITEURL;
$name = pathinfo($file)['filename'];

echo '
<li class="galitem">

<p>'.str_replace('--',' ',$name).'</p>

<p style="opacity:0.7">[% mg='.$name.' %] </p>


<div style="display:flex;gap:10px;">
<a href="'.HTML_PATH_ADMIN_ROOT.'plugin/monstergallery?&addMonsterGallery&edit='.$name.'">
Edit
</a>
<a  style="background:red;" href="'.HTML_PATH_ADMIN_ROOT.'plugin/monstergallery?monsterGalleryList=true&delete='.$name.'">
Delete
</a>
</div>

</li>
';


};

?>

</ul>


<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" style="box-sizing:border-box;display:grid; width:100%;grid-template-columns:1fr auto; padding:10px;background:#fafafa;border:solid 1px #ddd;margin-top:20px;">
			<p style="margin:0;padding:0;"> If you like use my plugin! Buy me ☕ </p>
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" border="0">
			<img alt="" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" border="0">
		</form>

 