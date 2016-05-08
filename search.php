<!DOCTYPE html>
<html lang="en">
    <?php include 'include/variables.php'; ?>
    <?php include 'include/head.php'; ?>
    <?php include 'include/functions.php'; ?>

    <body style='tab-interval:2pt'>
        <?php
            $searchText = $_POST["searchText"];
            if(isset($_GET["search"])){
                $searchType = $_GET["search"];
            } else {
                $searchType = "none";
            }

            if(isset($_GET["input"])){
                $input = $_GET["input"];
            }
 
            $navPage = $search;
            include("include/nav.php"); 
        ?>

        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="col-sm-3 col-md-2 sidebar-offcanvas" id="sidebar" role="navigation">
                    <ul class="nav nav-sidebar">
                        <?php
                            echo "<li";
                            if($searchType=="lexicon" || $searchType =="none"){
                                echo $active;
                            } 
                            echo "><a href='search.php?search=lexicon&amp;input=none'>";
                            echo "Search ".$language."</a></li>";
                            
                            echo "<li";
                            if($searchType=="english"){
                                echo $active;
                            } 
                            echo "><a href='search.php?search=english&amp;input=none'>";
                            echo "Search ".$indexLanguage."</a></li>";

                            echo "<li";
                            if($searchType=="category"){
                                echo $active;
                            } 
                            echo "><a href='search.php?search=category&amp;input=none'>";
                            echo "Search Categories</a></li>";
                        ?>
                    </ul>            
                </div><!--/col-sm-3 col-md-2 sidebar-offcanvas-->
          
                <div class="col-sm-9 col-md-10 main">
                    <!--toggle sidebar button-->
                    <p class="visible-xs">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><b>&lt;</b>&nbsp;Select Search Type</button>
                    </p>
            
                    <div>
                        <?php
                            // if no search input yet given, go to relevant search box
                            if($input == "none" || $searchType == "none"){
                                $url = "search.php?search=";
                                if($searchType=="lexicon" || $searchType =="none"){
                                    $searchName = $language." lexicon";
                                    $url .= "lexicon";
                                } else if($searchType=="english"){
                                    $searchName = $indexLanguage."-".$language." index";
                                    $url .= $searchType;
                                } else if($searchType=="category"){
                                    $searchName = "categories";
                                    $url .= $searchType;
                                } 

                                echo "<p>Please enter your search term below to search the <strong>".$searchName."</strong>.</p>";
                                echo "<form action=\"".$url."\" METHOD=POST>";
                                echo "<input type=\"text\" class=\"form-control\" id='searchText' name='searchText' placeholder=\"Search...\">";
                                echo "<button type=\"submit\" value=\"Submit\" class=\"btn btn-primary btn-md\">Search&nbsp;<b>&gt;</b></button>";
                                echo "</form>";

                            } else {
                                $found = false;

                                if($searchType == "lexicon"){
                                    echo "<p>The search for <strong>".$searchText."</strong> within ".$language." lexicon headwords yielded the following results:</p><hr>";
                                    $dir = 'lexicon';
                                    foreach (glob("$dir/*") as $file) {

                                        $classname = "lpLexEntryName";
                                        $domdocument = new DomDocument("1.0", "utf-8");
                                        $domdocument->loadHTMLFile($file);
                                        header("Content-Type: text/html; charset=utf-8");
                                        $a = new DOMXPath($domdocument);
                                        $spans = $a->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

                                        for ($i = 0; $i < $spans->length; $i++) {
                                            $headwordNode = $spans->item($i)->firstChild;
                                            $headwordContents = $headwordNode->nodeValue;

                                            if (strpos(strtolower($headwordContents), strtolower($searchText) ) !== false) {
                                                $found = true;
                                                $result[] = $headwordContents;
                                                $headwordParent = $headwordNode->parentNode->parentNode;
                                                $entry = $domdocument->saveHTML($headwordParent);
                                                $text = convert_to($entry, "UTF-8");
                                                $regex = "/([0-9]+)\.htm(#e[0-9]+)/";
                                                $newText = preg_replace($regex,"lexicon.php?letter=$1$2",$text);
                                                echo $newText;
                                            }
                                        }
                                    }
                                } else if($searchType == "english"){
                                    echo "<p>The search for <strong>".$searchText."</strong> within the ".$indexLanguage." finder list yielded the following results:</p><hr>";
                                    $dir = 'index-english';
                                    foreach (glob("$dir/*") as $file) {

                                        $classname = "lpIndex".$indexLanguage;
                                        $domdocument = new DomDocument("1.0", "utf-8");
                                        $domdocument->loadHTMLFile($file);
                                        header("Content-Type: text/html; charset=utf-8");
                                        $a = new DOMXPath($domdocument);
                                        $spans = $a->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

                                        for ($i = 0; $i < $spans->length; $i++) {
                                            $headwordNode = $spans->item($i)->firstChild;
                                            $headwordContents = $headwordNode->nodeValue;

                                            if (strpos(strtolower($headwordContents), strtolower($searchText) ) !== false) {
                                                $found = true;
                                                $result[] = $headwordContents;
                                                $headwordParent = $headwordNode->parentNode->parentNode->parentNode;
                                                $entry = $domdocument->saveHTML($headwordParent);
                                                $text = convert_to($entry, "UTF-8");
                                                $regex = "/javascript:go\('([0-9]+)',(\s|%20)'([0-9]+)'\)/";
                                                $newText = preg_replace($regex,"lexicon.php?letter=$1#e$3",$text);
                                                echo $newText."<br>";
                                            }
                                        }
                                    }
                                } else if($searchType == "category"){
                                    echo "<p>The search for <strong>".$searchText."</strong> within category and sub-category names yielded the following results:</p><hr>";                    

                                    reset($categoryNames);
                                    while (list($key, $val) = each($categoryNames)) {
                                        if (strpos(strtolower($val), strtolower($searchText)) !== false) {
                                            $found = true;
                                            echo "<p style='margin:0cm;margin-top:0.100cm;margin-left:0.200cm'><a href=\"categories.php?category=".$key."\"><span class=\"lpCategory\">".$val."</span></a></p>";
                                        }

                                        // get text for relevant category
                                        $filename = "categories/c".$key.".htm";
                                        
                                        $classname = "lpCategory";
                                        $domdocument = new DomDocument("1.0", "utf-8");
                                        $domdocument->loadHTMLFile($filename);
                                        header("Content-Type: text/html; charset=utf-8");
                                        $a = new DOMXPath($domdocument);
                                        $spans = $a->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");

                                        for ($i = 0; $i < $spans->length; $i++) {

                                            $headwordNode = $spans->item($i)->firstChild;
                                            $headwordContents = $headwordNode->nodeValue;

                                            if (strpos(strtolower($headwordContents), strtolower($searchText) ) !== false) {
                                                // check that parent element is a link, if not discard
                                                if($headwordNode->parentNode->parentNode->nodeName == "a"){

                                                    $found = true;
                                                    $result[] = $headwordContents;
                                                    $headwordParent = $headwordNode->parentNode->parentNode->parentNode;
                                                    $entry = $domdocument->saveHTML($headwordParent);
                                                    $text = convert_to($entry, "UTF-8");
                                                    $regex = "/c([0-9]+)\.htm/";
                                                    $newText = preg_replace($regex,"categories.php?category=$1",$text);
                                                    echo $newText;
                                                }
                                            }
                                        }
                                    }
                                }

                                if(!$found){
                                    echo "<p>The item searched for was not found.</p>";
                                }
                            } 
                        ?>
                    </div>
                </div><!--/row-->
            </div>
        </div><!--/.container-->
        <?php include 'include/script.php'; ?>
    </body>
</html>