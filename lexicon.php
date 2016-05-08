<!DOCTYPE html>
<html lang="en">
    <?php include 'include/variables.php'; ?>
    <?php include 'include/head.php'; ?>

	<body style='tab-interval:2pt'>
        <?php
            $arrlength = count($lettersLexicon);

            if(isset($_GET["letter"])){
                $letter = ltrim($_GET["letter"],'0');
            }
        ?>

        <?php 
          $navPage = $lexicon;
          include("include/nav.php"); 
        ?>

        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
             
                    <ul class="nav nav-sidebar">
                        <?php
                        $x;
                        $y;

                        // set to A if no letter chosen
                        if(!isset($letter) || $letter == 0){
                            $letter = 1;
                        }

                        // get all the letters in the alphabet for the side menu
                        for($x = 1; $x < $arrlength; $x++) {
                            echo "<li";
                            if($lettersLexicon[$letter-1] == $lettersLexicon[$x-1]){
                                // active
                                $y = $x;
                                echo $active;
                            } 
                            echo "><a href=\"lexicon.php?letter=".$x."\">".$lettersLexicon[$x-1]."</a></li>";
                        }
                        ?>
                    </ul>            
                </div><!--/col-sm-3 col-md-2 sidebar-offcanvas-->
          
                <div class="col-sm-9 col-md-10 main">
                    <!--toggle sidebar button-->
                    <p class="visible-xs">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="glyphicon glyphicon-chevron-left"></i>&nbsp;Select Letter</button>
                    </p>
        
                    <div>
                        <?php
                            // get text for relevant letter

                            $filename = "lexicon/";
                            if($y < 10){ $filename .= "0"; }
                            $filename .= $y.".htm";

                            $text = mb_convert_encoding(file_get_contents($filename), "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));

                            // transform links to type from 
                            // src="../pictures/bitter-tomato.jpg"
                            // to
                            // src="pictures/bitter-tomato.jpg"
                            $regexPic = "/\.\.\/pictures/";
                            $newPicText = preg_replace($regexPic,"pictures",$text);

                            // transform links to type from 
                            // href="09.htm#e1668"
                            // to
                            // href="lexicon.php?letter=1#e25"
                            $regex = "/([0-9]+)\.htm(#e[0-9]+)/";
                            $newText = preg_replace($regex,"lexicon.php?letter=$1$2",$newPicText);

                            // add extra span to push text down so that selected word is immediately visible
                            $regexNew = "/<p class=\"lpLexEntryPara\">/";
                            $newNewText = preg_replace($regexNew,"<p class=\"lpLexEntryPara\"><span class=\"lpLexEntryNameNew\"></span>",$newText);

                            echo $newNewText;
                        ?> 
                    </div>
                </div><!--/col-sm-9 col-md-10 main-->
            </div>
        </div><!--/.container-->
        <?php include 'include/script.php'; ?>
    </body>
</html>