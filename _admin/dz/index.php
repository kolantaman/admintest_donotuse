<!DOCTYPE html>
<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.js"></script>
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.css">
  <style>
    *
      {
      box-sizing: border-box;
      }

    #dropzone {
      border: 2px dashed #ccc;
      background-color: #F0F0F0;
      background-image: url("images.png");
      background-repeat: no-repeat;
      background-position: center center;
      margin: 2rem;
      border-radius: 10px;
      //width: 100%;
      min-height: 300px;
      text-align: center;
      //padding: 90% auto auto auto;
      padding-top: 250px;
    }

    .dz-default
     {
     //outline: 1px solid red;
     font-weight: bold;
     vertical-align: bottom;
     }

  </style>
</head>
<body>
  <?php
  $subfolder = $_GET["sb"];
  ?>
  <div id="dropzone" class="dropzone"></div>
  <script>
    // Initialize Dropzone.js
    Dropzone.options.dropzone = {
      // Define the URL where images will be uploaded
      url: "upload-handler.php?subfolder=<?php echo $subfolder ?>",
      maxFiles: 1200, // Maximum number of files that can be uploaded
      acceptedFiles: "image/*", // Only accept images
      addRemoveLinks: true, // Add remove links for each file
      dictDefaultMessage: "Bilder in dieses Feld ziehen, oder klicken f&uuml;r Auswahl",
      init: function() {
        // Attach event handlers to the Dropzone object
        this.on("success", function(file, response) {
          console.log("File uploaded successfully: ", file);
        });
        this.on("error", function(file, errorMessage) {
          console.error("File upload failed: ", errorMessage);
        });
      }
    };
  </script>
<center><p><a onClick="self.close();">Nach Upload, Fenster schlie&szlig;en</a></p></center>
</body>
</html>

