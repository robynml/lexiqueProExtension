<!DOCTYPE html>
<html lang="en">
    <?php include 'include/variables.php'; ?>
    <?php include 'include/head.php'; ?>
    <?php include 'include/functions.php'; ?>

    <body style='tab-interval:2pt'>
        <?php
            $arrlength = count($lettersIndex);
            $letter = ltrim($_GET["letter"],'0');
            $navPage = $finder;
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
                                if($lettersIndex[$letter-1] == $lettersIndex[$x-1]){
                                    // active
                                    $y = $x;
                                    echo $active;
                                } 
                                echo "><a href=\"index-english.php?letter=".$x."\">".$lettersIndex[$x-1]."</a></li>";
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
                        <?php
                            // get text for relevant letter
                            $filename = "index-english/";
                            if($y < 10){ $filename .= "0"; } 
                            $filename .= $y.".htm";

                            $text = convert_to(file_get_contents($filename), "UTF-8");

                            $regex0 = "/\.\.\//";
                            $newText0 = preg_replace($regex0,"",$text);

                            // transform links to type from 
                            // href="javascript:go('06', '1226')"
                            // to
                            // href="lexicon.php?letter=1#e25"
                            $regex1 = "/javascript:go\('([0-9]+)',\s'([0-9]+)'\)/";
                            $newText1 = preg_replace($regex1,"lexicon.php?letter=$1#e$2",$newText0);

                            echo $newText1;
                        ?> 
                    </div>
            
            
                </div><!--/col-sm-9 col-md-10 main-->
            </div><!--/row row-offcanvas row-offcanvas-left-->
        </div><!--/container-fluid-->
        <?php include 'include/script.php'; ?>
    </body>
</html>
