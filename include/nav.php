<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
                echo "<a class=\"navbar-brand\" href=\"".$homepage."\">";
                echo $language." Dictionary</a>";
            ?>
        </div><!--/navbar-header-->

        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if(!isset($navPage)){
                        $navPage = "";
                    }
                    $class = " class=\"active\"";

                    for ($x = 0; $x <= sizeof($pages); $x++) {
                        echo "<li";
                        if($navPage == $pages[$x]){
                            echo $class;    
                        }
                        echo "><a href=\"".$pages[$x]."\">".$names[$x]."</a></li>";
                    } 
                ?>
            </ul>
        </div><!--/navbar-collapse collapse-->
    </div><!--/container-fluid"-->
</nav>
