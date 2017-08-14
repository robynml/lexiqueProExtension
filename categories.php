<!DOCTYPE html>
<html lang="en">
    <!-- This file presents the category data, with main categories listed to the left of in the page sidebar.-->
    <?php include 'include/variables.php'; ?>
    <?php include 'include/head.php'; ?>
    <?php include 'include/functions.php'; ?>

    <body style='tab-interval:2pt'>
        <?php
            $originalCategory = $_GET["category"];
            $category = $_GET["category"];
            $navPage=$categories;
            include("include/nav.php"); 
        ?>

        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
             
                    <ul class="nav nav-sidebar">
                        <?php
                            reset($categoryNames);
                            $keys = array_keys($categoryNames);
                            $values = array_values($categoryNames);

                            // set to 1st category if none chosen
                            if(!isset($category) || $category == 0){
                                $category = $keys[0];
                            }

                            for ($i = 0; $i <= sizeof($categoryNames); $i++) {
                                echo "<li";
                                if($category >= $keys[$i] && $category < $keys[$i + 1]){
                                    echo $active;
                                } 
                                echo "><a href=\"categories.php?category=".$keys[$i]."\">".$values[$i]."</a></li>";
                            }
                          ?>
                    </ul>            
                </div><!--/col-sm-3 col-md-2 sidebar-offcanvas-->
          
                <div class="col-sm-9 col-md-10 main">

                    <!--toggle sidebar button-->
                    <p class="visible-xs">
                      <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><b>&lt;</b>&nbsp;Select Category</button>
                    </p>

                    <div>
                        <?php
                            // get text for relevant category
                            $filename = "categories/c";
                            $filename .= $category.".htm";

                            $text = convert_to(file_get_contents($filename), "UTF-8");

                            $regexAudioPic = "/\.\.\/images/";
                            $newAudioPicText = preg_replace($regexAudioPic,"images",$text);

                            $regexAudio = "/\<a href\=\"\.\.\/audio\/([\s\S]*)\.mp3[\s\S]*\>/U";
                            $replaceAudio = "<audio id=\"$1\" src=\"audio/$1.mp3\"></audio><a href=\"#\" onclick=\"document.getElementById('$1').play()\">";
                            $newAudioText = preg_replace($regexAudio,$replaceAudio,$newAudioPicText);

                            // transform links to type from 
                            // src="../pictures/bitter-tomato.jpg"
                            // to
                            // src="pictures/bitter-tomato.jpg"
                            $regexPic = "/\.\.\/pictures/";
                            $newPicText = preg_replace($regexPic,"pictures",$newAudioText);

                            // transform links to type from 
                            // href="c001.htm"
                            // to
                            // href="categories.php?category=001"
                            $regex = "/c([0-9]+)\.htm/";
                            $newText = preg_replace($regex,"categories.php?category=$1",$newPicText);

                            // href="../lexicon/22.htm#e3129"
                            $regex2 = "/\.\.\/lexicon\/([0-9]+)\.htm(#e[0-9]+)/";
                            $newText2 = preg_replace($regex2,"lexicon.php?letter=$1$2",$newText);

                            echo $newText2;
                        ?> 
                    </div>
                </div><!--/col-sm-9 col-md-10 main-->
            </div><!--/row row-offcanvas row-offcanvas-left-->
        </div><!--/container-fluid-->
        <?php include 'include/script.php'; ?>
    </body>
</html>
