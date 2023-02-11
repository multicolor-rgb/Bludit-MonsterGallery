 

 
<?php 

global $security;
$tokenCSRF = $security->getTokenCSRF();

;?>
<h3>Migrate MonsterGallery</h3>

 <form action="#" method="post" class="migrateMe text-dark bg-light border p-3">
 <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">

<label for="">Old Url</label>
 <input type="text" name="oldurl"  class="form-control" placeholder="https://youroldadress.com/">
 <label for="">New Url</label>
 <input type="text" name="newurl" class="form-control"  placeholder="https://yournewadress.com/">
 <input type="submit" name="submit" class="btn btn-dark mt-2" value="Change gallery url">
 </form>



<?php 


if(isset($_POST['submit'])){
	foreach(glob($this->phpPath() .'monsterGalleryList/*.json')as $file){

		$fileContent = file_get_contents($file);
	
	 
		$oldurl = str_replace('/','\/',$_POST['oldurl']);
		$newurl = str_replace('/','\/',$_POST['newurl']);
	
 
		$newContent = str_replace([$oldurl, $oldurl.'/'],[$newurl, $newurl.'/'],$fileContent);
	
		file_put_contents($file,$newContent);
	
	}

	echo '<div class="alert alert-primary">done!</div>';
		
}
 


;?>