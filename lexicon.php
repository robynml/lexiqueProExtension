<!DOCTYPE html>
<html lang="en">
    <?php include 'include/variables.php'; ?>
    <?php include 'include/head.php'; ?>
    <?php include 'include/functions.php'; ?>

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
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><b>&lt;</b>&nbsp;Select Letter</button>
                    </p>
        
                    <div>
                        <!--dictionary entry paragraphs-->
                        <?php
                            // get text for relevant letter

                            $filename = "lexicon/";
                            if($y < 10){ $filename .= "0"; }
                            $filename .= $y.".htm";

                            $text = convert_to(file_get_contents($filename), "UTF-8");

                            $regex0 = "/\.\.\//";
                            $newText0 = preg_replace($regex0,"",$text);

                            $regexAudio = "/\<a href\=\"audio\/([\s\S]*)\.mp3[\s\S]*\>/U";
                            $replaceAudio = "<audio preload=\"none\" id=\"$1\" src=\"audio/$1.mp3\"></audio><a href=\"#\" onclick=\"document.getElementById('$1').play(); return false\">";
                            $newAudioText = preg_replace($regexAudio,$replaceAudio,$newText0);

                            // transform links to type from 
                            // href="09.htm#e1668"
                            // to
                            // href="lexicon.php?letter=1#e25"
                            $regex1 = "/([0-9]+)\.htm(#e[0-9]+)/";
                            $newText1 = preg_replace($regex1,"lexicon.php?letter=$1$2",$newAudioText);

                            // add extra span to push text down so that selected word is immediately visible
                            $regex2 = "/<p class=\"lpLexEntryPara\">/";
                            $newText2 = preg_replace($regex2,"<p class=\"lpLexEntryPara\"><span class=\"lpLexEntryNameNew\"></span>",$newText1);

                            // use this section to get valid HTML, but may be slower
                            // $domdocument = new DomDocument("1.0", "utf-8");
                            // $domdocument->preserveWhiteSpace = false;
                            // $domdocument->loadXML($newText2);

                            // $body = $domdocument->getElementsByTagName('html') 
                            //         ->item(0)
                            //         ->getElementsByTagName('body')
                            //         ->item(0);
                            
                            // if($body->hasChildNodes()){
                            //     $children = $body->childNodes;
                            //     foreach($children as $child) {
                            //         $entry = $domdocument->saveHTML($child);
                            //         $paragraphText = convert_to($entry, "UTF-8");
                            //         echo $paragraphText;
                            //     }
                            // }
                            echo $newText2;
                        ?> 
                    </div>
                </div><!--/col-sm-9 col-md-10 main-->
            </div>
        </div><!--/.container-->
        <?php include 'include/script.php'; ?>
    </body>
</html>
