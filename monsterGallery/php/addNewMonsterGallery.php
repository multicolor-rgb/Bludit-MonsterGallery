 <?php

	global $security;
	$tokenCSRF = $security->getTokenCSRF();; ?>
 <style>
 	.monsterspan {
 		padding: 5px;
 		background: #fafafa;
 		width: 100%;
 		box-sizing: border-box;
 		margin: 10px 0;
 		align-items: center;
 		display: grid;
 		align-items: center;
 		grid-template-columns: 80px 1fr;
 		gap: 10px;
 		position: relative;
 		padding-top: 30px;
 		background: #ddd;
 	}

 	.monsterspan img {
 		width: 80px;
 		height: 80px;
 		object-fit: cover;
 		display: block;
 		grid-column: 1/2;
 		grid-row: 1/4;
 		border: solid 4px #fff;

 	}

 	.monsterspan input {
 		width: 100%;
 		padding: 5px;
 		box-sizing: border-box;
 		margin: 5px 0;
 		grid-column: 2/3;

 	}

 	.closeThis {
 		position: absolute;
 		top: 0;
 		right: 0;
 		background: red;
 		width: 20px;
 		height: 20px;
 		color: #fff;
 		border: none;
 	}
 </style>

 <h3>MonsterGallery edit</h3>
 <form class="mgForm" method="POST" action="#">
 	<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF; ?>">

 	<input type="text" name="MGtitle" style="width:100%;padding:10px;box-sizing: border-box;" placeholder="title" pattern="[a-zA-Z0-9]+" required <?php if (isset($_GET['edit'])) : ?> value="<?php echo str_replace('--', ' ', $_GET['edit']); ?>" <?php endif; ?>>

 	<small class="text-muted">Put name without special characters and spacebar</small>


 	<input type="hidden" name="check" style="width:100%;padding:10px;box-sizing: border-box;" placeholder="title" <?php if (isset($_GET['edit'])) : ?> value="<?php echo str_replace('--', ' ', $_GET['edit']); ?>" <?php endif; ?>>

 	<div style="width:100%;background: #000;padding:10px; margin-top:10px;box-sizing: border-box; color:#fff;
display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:10px;box-sizing: border-box;">


 		<?php


			if (isset($_GET['edit'])) {


				$data = file_get_contents($storeFolderList . $_GET['edit'] . '.json');

				$dataJson = json_decode($data, false);

				$width = $dataJson->width;
				$height = $dataJson->height;
				$gap = $dataJson->gap;
				$quality = $dataJson->quality;
				$mods = $dataJson->modules;
			};; ?>


 		<div style="grid-column: 1/6;border:solid 1px #333;padding: 10px;background: #222;">
 			<p style="color:#fff; font-size:1rem;margin:0;padding:0;margin-bottom: 10px;">Gallery type</p>
 			<select name="modules" class="modules" style="width:100%;margin-bottom: 10px;box-sizing: border-box;padding: 6px;font-size:13px;">
 				<option value="glightbox">Glightbox</option>
 				<option value="spotlight">Spotlight</option>
 				<option value="simplelightbox">SimpleLightbox</option>
 				<option value="baguettebox">baguetteBox</option>
 				<option value="PhotoSwipe">PhotoSwipe</option>
 			</select>

 			<script>
 				if ('<?php echo @$mods; ?>' !== '') {


 					document.querySelector('.modules').value = '<?php echo @$mods; ?>';

 				};
 			</script>

 		</div>
 		<div style="grid-column:1/2">
 			<p style="margin:0;padding:0;">quality width in px </p>
 			<input type="" name="quality" style="width:100%;padding:5px;box-sizing: border-box;font-size:12px" required placeholder="800" value="<?php echo @$quality ?>" pattern="[0-9]+">
 		</div>

 		<div style="grid-column:2/3">
 			<p style="margin:0;padding:0;">Width thumbnails in px</p>
 			<input type="" name="width" pattern="[0-9]+" style="width:100%;padding:5px;box-sizing: border-box;font-size:12px;" required placeholder="320" value="<?php echo @$width ?>">
 		</div>


 		<div style="grid-column: 3/4;">
 			<p style="margin: 0;padding:0;">height thumbnails in px</p>
 			<input type="" name="height" pattern="[0-9]+" style="width:100%;padding:5px;box-sizing: border-box;font-size:12px;" required placeholder="240" value="<?php echo @$height; ?>">

 		</div>

 		<div style="grid-column: 4/6;">

 			<p style="margin: 0;padding:0;">gap thumbnails in px</p>
 			<input type="" name="gap" pattern="[0-9]+" style="width:100%;padding:5px;box-sizing: border-box;font-size:12px;" placeholder="10" required value="<?php echo @$gap; ?>">
 		</div>


 	</div>



 	<button class="addMG" style="background: #000;color:#fff;padding:0.5rem 1rem;border:none;margin-top:10px;">Add Image</button>

 	<br>

 	<div class="imagelist" id="imagelist" style=" padding:10px;margin:10px 0;">

 		<?php



			if (isset($_GET['edit'])) {

				$ed = str_replace(' ', '--', $_GET['edit']);
				$fils =    $storeFolderList . $ed . '.json';

				if (file_exists($fils)) {

					$filedit = file_get_contents($fils);
					$fileditJson = json_decode($filedit);





					foreach ($fileditJson->images as $key => $value) {


						echo '<span class="monsterspan"> 
<button class="closeThis" onclick="event.preventDefault();
this.parentElement.remove();">X</button>
<img src="' . $value . '">
<input type="text" name="name[]" value="' . @$fileditJson->names[$key] . '" placeholder="title">
<textarea  name="description[]" value="description" placeholder="description" style="width:100%;height:60px;box-sizing:border-box;padding:5px;">
' . @$fileditJson->descriptions[$key] . '
</textarea>

<input type="text" name="image[]" value = "' . @$value . '" >
 </span>';
					};
				}
			};; ?>

 	</div>

 	<input type="submit" name="saveMG" class="saveMG" value="save gallery" style="background: #000;color:#fff;padding:0.5rem 1rem;border:none">




 </form>





 <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>



 <script>
 	document.querySelector('.addMG').addEventListener('click', (e) => {
 		e.preventDefault();
 		window.open('<?php echo DOMAIN . HTML_PATH_ADMIN_ROOT; ?>plugin/monstergallery?&filebrowser', "", "width=1200,height=400");
 	});






 	new Sortable(imagelist, {
 		animation: 150,
 		ghostClass: 'blue-background-class'
 	});
 </script>