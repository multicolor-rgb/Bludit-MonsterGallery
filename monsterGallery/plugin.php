<?php
class monsterGallery extends Plugin
{



    public function pageBegin()
    {

        global $page;

        $newcontent = preg_replace_callback(
            '/\\[% mg=(.*) %\\]/i',
            "mgShow",
            $page->content()
        );


        global $page;
        $page->setField('content', $newcontent);
    }



    public function adminView()
    {



        global $security;
        $tokenCSRF = $security->getTokenCSRF();
        if (isset($_GET['credits'])) {
            // Token for send forms in Bludit

            include($this->phpPath() . 'php/credits.php');
        };


        if (isset($_GET['monsterGalleryList'])) {
            // Token for send forms in Bludit

            include($this->phpPath() . 'php/settings.php');
        };


        if (isset($_GET['addMonsterGallery'])) {
            // Token for send forms in Bludit

            include($this->phpPath() . 'php/addNewMonsterGallery.php');
        }


        if (isset($_GET['filebrowser'])) {

            include($this->phpPath() . 'php/imagebrowser.php');
        }


        if (isset($_GET['uploader'])) {

            include($this->phpPath() . 'php/uploader.php');
        }
    }

    public function adminSidebar()
    {
        $pluginName = Text::lowercase(__CLASS__);
        $url = HTML_PATH_ADMIN_ROOT . 'plugin/' . $pluginName;
        $html = '<a id="current-version" class="nav-link" href="' . $url . '?monsterGalleryList=true">🐙 Monster Gallery Settings</a>';
        return $html;
    }



    public function siteHead()
    {

        function MGthumb($values, $width)
        {



            $file = file_get_contents($values);

            $folder = PATH_PLUGINS . "monsterGallery/monsterGalleryThumb/";


            $extension =  pathinfo($values, PATHINFO_EXTENSION);

            $base = pathinfo($values, PATHINFO_BASENAME);

            $finalfile = $folder . $width . "-" . $base;

            if (file_exists($finalfile)) {
            } else {

                $origPic = imagecreatefromstring($file);

                $width_orig = imagesx($origPic);
                $height_orig = imagesy($origPic);

                $height = $height_orig  * 1.77;


                $ratio_orig = $width_orig / $height_orig;

                if ($width / $height > $ratio_orig) {
                    $width = $height * $ratio_orig;
                } else {
                    $height = $width / $ratio_orig;
                }


                $thumbnail = @imagecreatetruecolor($width, $height);

                @imagecopyresampled($thumbnail, $origPic, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);


                if ($extension == 'jpeg' || $extension == 'jpg') {
                    imagejpeg($thumbnail, $finalfile);
                } elseif ($extension == 'png') {
                    imagepng($thumbnail, $finalfile);
                } elseif ($extension == 'webp') {
                    imagewebp($thumbnail, $finalfile);
                } elseif ($extension == 'gif') {
                    imagegif($thumbnail, $finalfile);
                } elseif ($extension == 'bmp') {
                    imagebmp($thumbnail, $finalfile);
                } else {
                    imagejpeg($thumbnail, $finalfile);
                }


                imagedestroy($origPic);
                imagedestroy($thumbnail);
            };


            return str_replace(PATH_PLUGINS, DOMAIN . '/bl-plugins/', $finalfile);
        };



        function mgShow($matches)
        {

            if (file_exists(PATH_PLUGINS . 'monsterGallery/monsterGalleryList/' . $matches[1] . '.json')) {

                $modules = array();
                $name = $matches[1];
                $data = file_get_contents(PATH_PLUGINS . 'monsterGallery/monsterGalleryList/' . $name . '.json');
                $dataJson = json_decode($data, false);
                $width = $dataJson->width;
                $height = $dataJson->height;
                $gap = $dataJson->gap;
                $quality = $dataJson->quality;


                if ($dataJson->modules == 'glightbox') {

                    include(PATH_PLUGINS . 'monsterGallery/modules/glightbox.php');
                };

                if ($dataJson->modules == 'PhotoSwipe') {
                    include(PATH_PLUGINS . 'monsterGallery/modules/photoswipe.php');
                };


                if ($dataJson->modules == 'spotlight') {
                    include(PATH_PLUGINS . 'monsterGallery/modules/spotlight.php');
                };

                if ($dataJson->modules == 'simplelightbox') {
                    include(PATH_PLUGINS . 'monsterGallery/modules/simplelightbox.php');
                };

                if ($dataJson->modules == 'baguettebox') {
                    include(PATH_PLUGINS . 'monsterGallery/modules/baguettebox.php');
                };

                return $gal;

                global $modules;
            }
        };
    }


    public function siteBodyEnd()
    {
        global $modules;
    }



    public function adminController()
    {


 

    
            $ds   = DIRECTORY_SEPARATOR;

            $storeFolder = PATH_PLUGINS . 'monsterGallery/monsterGalleryImages/';

            if (!empty($_FILES)){


        
                $tempFile = $_FILES['file']['tmp_name'];
                $targetPath =    $storeFolder;

                $names = $_FILES['file']['name'];
                $noSpaceName = str_replace(' ','-',pathinfo($_FILES['file']['name'])['filename']);
                $newName = preg_replace('/[^0-9a-z\-]+/', '', $noSpaceName);

                $targetFile =  $targetPath .$newName.'.'.pathinfo($_FILES['file']['name'])['extension'];
                move_uploaded_file($tempFile, $targetFile);
            };
        



        if (isset($_POST['saveMG'])) {

            $file = $this->phpPath() . 'monsterGalleryList/' . str_replace(' ', '--', $_POST['MGtitle']) . '.json';

            $folderExist = file_exists($this->phpPath() . 'monsterGalleryList/') || mkdir($this->phpPath() . 'monsterGalleryList/');

            $values = array();
            $descriptions = array();
            $texts = array();


            if ($folderExist) {

                foreach ($_POST['image'] as $key => $value) {
                    array_push($values, $value);
                };


                foreach ($_POST['name'] as $key => $value) {
                    array_push($texts, $value);
                };



                foreach ($_POST['description'] as $key => $value) {
                    array_push($descriptions, $value);
                };



                $myObj = new stdClass();
                $myObj->names = $texts;
                $myObj->images = $values;
                $myObj->descriptions = $descriptions;
                $myObj->width = @$_POST['width'];
                $myObj->height = @$_POST['height'];
                $myObj->gap = @$_POST['gap'];
                $myObj->quality = @$_POST['quality'];
                $myObj->modules = @$_POST['modules'];

                $myJSON = json_encode($myObj);



                file_put_contents($file, $myJSON);


                if (isset($_GET['edit']) && $_POST['MGtitle'] !== $_POST['check'] && $_POST['check'] !== null) {

                    rename($this->phpPath() . 'monsterGalleryList/' . $_POST['check'] . '.json', $this->phpPath() . 'monsterGalleryList/' . $_POST['MGtitle'] . '.json');
                }



                echo "<script type='text/javascript'>
    window.location.href = '" . HTML_PATH_ADMIN_ROOT . "plugin/monstergallery?&addMonsterGallery&edit=" . $_POST['MGtitle'] . "';
    </script>";
            };
        };



        if (isset($_GET['clearCache'])) {

            function mbCleanThumb()
            {

                $imager = glob(PATH_PLUGINS . 'monsterGallery/monsterGalleryThumb/*', GLOB_BRACE);

                foreach ($imager as $img) {

                    unlink($img);
                };
            };

            mbCleanThumb();
        };



        if (isset($_GET['delete'])) {

            unlink($this->phpPath() . 'monsterGalleryList/' . $_GET['delete'] . '.json');


            global $SITEURL;

            echo "<script type='text/javascript'>
                window.location.href = '" . HTML_PATH_ADMIN_ROOT . "plugin/monstergallery?monsterGalleryList=true';
                </script>";
        };
    }
}
