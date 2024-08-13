<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>


<style>



</style>


<h3>Upload photo</h3>
<br>

<form action="#" class="border p-2" method="post" enctype="multipart/form-data">

  <!-- Input for file upload -->
  <input type="file" name="file[]" class="dropzone dz-upload  " id="fileInput" style="display:none;" multiple />

  <!-- Input for folder name -->
  <input type="text" name="folder" class="form-control" style="text-transform: lowercase;" oninput="this.value = this.value.toLowerCase();" placeholder="Folder name (empty is root)" />

  <!-- Hidden CSRF token -->
  <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF; ?>">

  <!-- Button to trigger file selection -->
  <button type="button" class="btn-primary d-block w-100 mt-2 btn" onclick="document.getElementById('fileInput').click();">Select Files (many files, with ctrl)</button>

  <!-- Submit button to upload files -->
  <button type="submit" class="btn-primary mt-3 btn">Upload</button>

</form>