
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
 
<style>
  
 

  .dropzone{
    min-height: 150px;
border: 2px dotted rgba(0,0,0,0.2);
background: #fff;
  background-color: rgb(255, 255, 255);
  background-position-x: 0%;
  background-position-y: 0%;
  background-repeat: repeat;
  background-attachment: scroll;
  background-image: none;
  background-size: auto;
  background-origin: padding-box;
  background-clip: border-box;
padding: 20px 20px;
margin-top: 10px;
height: 300px;
box-shadow: 1px 1px 10px rgba(0,0,0,0.1);
display: flex;
align-items: center;
justify-content: center;
  }
</style>

 
 <h3>Upload photo</h3>
 <br>
 
<form action="#" class="dropzone dz-upload" method="post" enctype="multipart/form-data">
  <input type="file" name="file[]" style="display:none;" />
  <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">
 
</form>
 
 