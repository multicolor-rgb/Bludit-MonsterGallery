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

        $storeFolder = PATH_CONTENT . 'monsterGallery/';
        $storeFolderImages = $storeFolder . 'monsterGalleryImages/';
        $storeFolderThumb = $storeFolder . 'monsterGalleryThumb/';
        $storeFolderList = $storeFolder . 'monsterGalleryList/';


        $HTMLstoreFolder = HTML_PATH_CONTENT . 'monsterGallery/';
        $HTMLstoreFolderImages = $HTMLstoreFolder . 'monsterGalleryImages/';
        $HTMLstoreFolderThumb = $HTMLstoreFolder . 'monsterGalleryThumb/';
        $HTMLstoreFolderList = $HTMLstoreFolder . 'monsterGalleryList/';

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


        if (isset($_GET['migrateGallery'])) {
            // Token for send forms in Bludit

            include($this->phpPath() . 'php/migrate.php');
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


            $storeFolder = PATH_CONTENT . 'monsterGallery/';
            $storeFolderImages = $storeFolder . 'monsterGalleryImages/';
            $storeFolderThumb = $storeFolder . 'monsterGalleryThumb/';
            $storeFolderList = $storeFolder . 'monsterGalleryList/';

            $HTMLstoreFolder = HTML_PATH_CONTENT . 'monsterGallery/';
            $HTMLstoreFolderImages = $HTMLstoreFolder . 'monsterGalleryImages/';
            $HTMLstoreFolderThumb = $HTMLstoreFolder . 'monsterGalleryThumb/';
            $HTMLstoreFolderList = $HTMLstoreFolder . 'monsterGalleryList/';


            $file = file_get_contents($values);

            $folder = $storeFolderThumb;


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


            return str_replace($storeFolderThumb,  $HTMLstoreFolderThumb, $finalfile);
        };



        function mgShow($matches)
        {

            $storeFolder = PATH_CONTENT . 'monsterGallery/';
            $storeFolderImages = $storeFolder . 'monsterGalleryImages/';
            $storeFolderThumb = $storeFolder . 'monsterGalleryThumb/';
            $storeFolderList = $storeFolder . 'monsterGalleryList/';

            $HTMLstoreFolder = HTML_PATH_CONTENT . 'monsterGallery/';
            $HTMLstoreFolderImages = $HTMLstoreFolder . 'monsterGalleryImages/';
            $HTMLstoreFolderThumb = $HTMLstoreFolder . 'monsterGalleryThumb/';
            $HTMLstoreFolderList = $HTMLstoreFolder . 'monsterGalleryList/';

            if (file_exists($storeFolderList . $matches[1] . '.json')) {

                $modules = array();
                $name = $matches[1];
                $data = file_get_contents($storeFolderList . $name . '.json');
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


        $storeFolder = PATH_CONTENT . 'monsterGallery/';
        $storeFolderImages = $storeFolder . 'monsterGalleryImages/';
        $storeFolderThumb = $storeFolder . 'monsterGalleryThumb/';
        $storeFolderList = $storeFolder . 'monsterGalleryList/';


        $HTMLstoreFolder = HTML_PATH_CONTENT . 'monsterGallery/';
        $HTMLstoreFolderImages = $HTMLstoreFolder . 'monsterGalleryImages/';
        $HTMLstoreFolderThumb = $HTMLstoreFolder . 'monsterGalleryThumb/';
        $HTMLstoreFolderList = $HTMLstoreFolder . 'monsterGalleryList/';

        if (file_exists($storeFolder) == null) {

            mkdir($storeFolder, 0755);
        };

        if (file_exists($storeFolderImages) == null) {
            mkdir($storeFolderImages, 0755);
        };

        if (file_exists($storeFolderThumb) == null) {
            mkdir($storeFolderThumb, 0755);
        };

        if (file_exists($storeFolderList) == null) {
            mkdir($storeFolderList, 0755);
        };

        file_put_contents($storeFolderImages . '.htaccess', 'Allow from all');
        file_put_contents($storeFolderThumb . '.htaccess', 'Allow from all');
        file_put_contents($storeFolderList . '.htaccess', 'Deny from all');


        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name'];
            $targetPath =  $storeFolderImages;

            $names = $_FILES['file']['name'];
            $noSpaceName = str_replace(' ', '-', pathinfo($_FILES['file']['name'])['filename']);
            $newName = preg_replace('/[^0-9a-z\-]+/', '', $noSpaceName);

            $targetFile =  $targetPath . $newName . '.' . pathinfo($_FILES['file']['name'])['extension'];
            move_uploaded_file($tempFile, $targetFile);
        };




        if (isset($_POST['saveMG'])) {

            $file = $storeFolderList . str_replace(' ', '--', $_POST['MGtitle']) . '.json';


            $values = array();
            $descriptions = array();
            $texts = array();

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

                rename($storeFolderList . $_POST['check'] . '.json', $storeFolderList . $_POST['MGtitle'] . '.json');
            }


            echo "<script type='text/javascript'>
    window.location.href = '" . HTML_PATH_ADMIN_ROOT . "plugin/monstergallery?&addMonsterGallery&edit=" . $_POST['MGtitle'] . "';
    </script>";
        };



        if (isset($_GET['clearCache'])) {


            $imager = glob($storeFolderThumb . '*', GLOB_BRACE);

            foreach ($imager as $img) {
                unlink($img);
            };
        };



        if (isset($_GET['delete'])) {

            unlink($storeFolderList . $_GET['delete'] . '.json');


            global $SITEURL;

            echo "<script type='text/javascript'>
                window.location.href = '" . HTML_PATH_ADMIN_ROOT . "plugin/monstergallery?monsterGalleryList=true';
                </script>";
        };


        if (isset($_GET['moveData'])) {
            foreach (glob($this->PhpPath() . 'monsterGalleryImages/*') as $file) {
                $path = $this->PhpPath() . 'monsterGalleryImages/';
                $pureFile = pathinfo($file)['basename'];
                rename($path . $pureFile, $storeFolderImages . $pureFile);
            };

            unlink($this->PhpPath() . 'monsterGalleryImages/.htaccess');
            rmdir($this->PhpPath() . 'monsterGalleryImages/');


            foreach (glob($this->PhpPath() . 'monsterGalleryThumb/*') as $file) {
                $path = $this->PhpPath() . 'monsterGalleryThumb/';
                $pureFile = pathinfo($file)['basename'];
                rename($path . $pureFile, $storeFolderThumb . $pureFile);
            };

            unlink($this->PhpPath() . 'monsterGalleryThumb/.htaccess');
            rmdir($this->PhpPath() . 'monsterGalleryThumb/');

            foreach (glob($this->PhpPath() . 'monsterGalleryList/*') as $file) {
                $path = $this->PhpPath() . 'monsterGalleryList/';
                $pureFile = pathinfo($file)['basename'];
                rename($path . $pureFile, $storeFolderList . $pureFile);


                foreach (glob($storeFolderList . '*.json') as $file) {

                    $fileContent = file_get_contents($file);

                    $newContent = str_replace('bl-plugins', 'bl-content', $fileContent);

                    file_put_contents($file, $newContent);
                }
            };

            unlink($this->PhpPath() . 'monsterGalleryList/.htaccess');
            rmdir($this->PhpPath() . 'monsterGalleryList/');

            echo '<div class="alert alert-success" role="alert">
            Done!
            </div>';


            echo "<script type='text/javascript'>
            
            setTimeout(()=>{

                window.location.href = '" . HTML_PATH_ADMIN_ROOT . "plugin/monstergallery?monsterGalleryList=true';

            },2000);

                </script>";
        };
    }
}
