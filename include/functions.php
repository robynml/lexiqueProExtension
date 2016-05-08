<?php
// From http://php.net/manual/de/function.mb-convert-encoding.php
function convert_to ( $source, $target_encoding )
    {
    // detect the character encoding of the incoming file
    $encoding = mb_detect_encoding( $source, "auto" );
       
    // escape all of the question marks so we can remove artifacts from
    // the unicode conversion process
    $target = str_replace( "?", "[question_mark]", $source );
       
    // convert the string to the target encoding
    $target = mb_convert_encoding( $target, $target_encoding, $encoding);
       
    // remove any question marks that have been introduced because of illegal characters
    $target = str_replace( "?", "", $target );
       
    // replace the token string "[question_mark]" with the symbol "?"
    $target = str_replace( "[question_mark]", "?", $target );
   
    return $target;
    }
?>