 <style>
   .sidebar {
     display: none !important;
   }

   .container {
     max-width: unset !important;
     width: 100% !important;
   }

   .col-lg-10 {
     all: unset;
     width: 95% !important;
   }
 </style>


<select class="col-md-12 form-control m-2" onchange="changeFolder(this)">
   <option value="root">Root</option>
   <?php
    $count = 0;
    if (isset($_GET['folder'])) {
      if ($_GET['folder'] == 'root') {
        $storeFolderImages =  $storeFolderImages;
        $HTMLstoreFolderImages =  $HTMLstoreFolderImages;
      }
      $storeFolderImages = $storeFolderImages . $_GET['folder'] . '/';
      $HTMLstoreFolderImages = $HTMLstoreFolderImages . $_GET['folder'] . '/';
    }

    foreach (glob($storeFolder . 'monsterGalleryImages/' . '*', GLOB_ONLYDIR) as $folder) {
      if (is_dir($folder)) {
        $folderName = basename($folder);
        echo '<option value="' . $folderName . '" style="width:100%;padding:10px;">' . $folderName . '</option>';
        $count++;
      }
    }
    ?>
 </select>

 <div class="col-md-12 d-flex justify-content-between align-items-center bg-light border p-2 m-0 ml-2">
<h4 class="m-0"><?php echo @$_GET['folder'];?></h4> <button class="addall  btn btn-primary">Add All</button>


  </div>
 <?php

  $count = 0;
  foreach (glob($storeFolderImages . '*') as $img) {

    if (is_file($img)) {
      $base = pathinfo($img)['basename'];

      echo '<a href="' . $base . '" class="photo" onclick="event.preventDefault();submitLink(' . $count . ')"><img src="' . $base . '" style="width:100px;height:100px;object-fit:cover;margin:10px;"></a>';
      $count++;
    };
  }; ?>



 

 <script>
   document.querySelectorAll('.photo').forEach(x => {

     x.setAttribute('href', window.location.origin + '<?php echo $HTMLstoreFolderImages; ?>' + x.getAttribute('href'))
     x.querySelector('img').setAttribute('src', window.location.origin + '<?php echo $HTMLstoreFolderImages; ?>' + x.querySelector('img').getAttribute('src'));

   })



   function changeFolder(select) {
     const folderName = select.value;
     window.location.href = DOMAIN_ADMIN + `plugin/monstergallery?&filebrowser&folder=${folderName}`;
};



   function submitLink(e) {


     let linker = document.querySelectorAll('.photo img')[e].getAttribute('src');
     console.log(linker);
     let linkerNew = linker;


     window.opener.document.querySelector('.imagelist').insertAdjacentHTML('afterbegin', `
<span class="monsterspan"> 
<button class="closeThis" onclick="event.preventDefault();
this.parentElement.remove();">X</button>
<img src="${linkerNew}">
<input type="text" name="name[]" placeholder="title">
<textarea  name="description[]" value="description" placeholder="description" style="width:100%;height:60px;box-sizing:border-box;padding:5px;">
</textarea>
<input type="text" name="image[]" value = "${linkerNew}" >
</span>


  `);

     window.close();
   }


   document.querySelector('.addall').addEventListener('click', () => {

     document.querySelectorAll('.photo').forEach(x => {
       let linker = x.getAttribute('href');
       console.log(linker);
       let linkerNew = linker;

       window.opener.document.querySelector('.imagelist').insertAdjacentHTML('afterbegin', `
<span class="monsterspan"> 
<button class="closeThis" onclick="event.preventDefault();
this.parentElement.remove();">X</button>
<img src="${linkerNew}">
<input type="text" name="name[]" placeholder="title">
<textarea  name="description[]" value="description" placeholder="description" style="width:100%;height:60px;box-sizing:border-box;padding:5px;">
</textarea>
<input type="text" name="image[]" value = "${linkerNew}" >
</span>


  `);
     });


     window.close();

   });
 </script>



 </div>
 </div>
 </div>
 </body>

 </html>