#!/bin/bash

######################################################
# Get English alphabet letters used in the index files
######################################################

COUNTER=0
for file in index-english/*
do
	letter=$(perl -nle 'print $& if m{lpTitlePara">.}' $file)
	if [ "$letter" ];then
        char="${letter: 13}"
        charNew=${char%????}
        charNew2=$(echo $charNew | perl -pe 's/(\S+)/\u\L$1/g')
		array[COUNTER]=$charNew2
	fi
	let COUNTER++
done

length=${#array[@]}

lettersString=""
for ((i=0; i<$length; i++))
do
	lettersString+="\"${array[$i]}\""
	if (($i < $length - 1)); then
		lettersString+=","
	fi
done

sed -i '' 's/$lettersIndex = array();/$lettersIndex = array('$lettersString');/' include/variables.php

######################################################
# Get Mawng alphabet letters used in the lexicon files
######################################################

COUNTER2=0
for file2 in lexicon/*
do
	letter2=$(perl -nle 'print $& if m{lpTitlePara">.* }' $file2)
	if [ "$letter2" ];then
		char2="${letter2: 13}"
        char3=${char2%?????}
        char4=$(echo $char3 | perl -pe 's/(\S+)/\u\L$1/g')
		array2[COUNTER2]=$char4
	fi
	let COUNTER2++
done

length2=${#array2[@]}

lettersString2=""
for ((i=0; i<$length2; i++))
do
	lettersString2+="\"${array2[$i]}\""
	if (($i < $length2 - 1)); then
		lettersString2+=","
	fi
done

sed -i '' 's/$lettersLexicon = array();/$lettersLexicon = array('$lettersString2');/' include/variables.php

################
# Get categories
################

COUNTER3=0
for file3 in categories/*
do
	subcat=$(perl -nle 'print $& if m{Sub-categories:}' $file3)
	if [ "$subcat" ];then
		# get category name
		letter3=$(perl -nle 'print $& if m{lpTitlePara">.*<}' $file3)
		cat2="${letter3: 13}"
        cat3=${cat2%?}
        # echo $cat3
		array3[COUNTER3]=$cat3
		
		# get number from file name, e.g. 131 from categories/c131.htm
		file3new="${file3: 12}"
		file3new2=${file3new%????}

		file3new3=$(echo $file3new2 | perl -pe 's/ /\\ /g')

		# echo $file3new2
		array4[COUNTER3]=$file3new3
		let COUNTER3++
	fi
done

length3=${#array3[@]}

categoryString=""
for ((i=0; i<$length3; i++))
do
	# categoryString+="\"${array4[$i]}\"=>"
	categoryString+="\"${array4[$i]}\" => \"${array3[$i]}\""
	if (($i < $length3 - 1)); then
		categoryString+=", "
	fi
done

categoryStringNew=$(printf %q "$categoryString") # escape special charaters
sed -i '' "s/$categoryNames = array();/$categoryNames = array($categoryStringNew);/" include/variables.php

#################################
# Write language name to variable
#################################

languageName=$(perl -nle 'print $& if m{<title>.*</title>}' title.htm)
languageName2=${languageName%????????}
languageName3="${languageName2: 7}"
sed -i '' 's/$language = "Language1";/$language = \"'$languageName3'\";/' include/variables.php


#######################
# Set link to home page
#######################

if [ $# -eq 0 ]; 
then
	echo "no args"
else
	homepageAddress=$(printf %q "$1") # escape special charaters
	sed -i '' "s|$homepage = \"\";|$homepage = \"$homepageAddress\";|" include/variables.php
fi

###################################
# Swap index.htm with index-new.htm
###################################

if [ -f "index-new.htm" ];
then
	mv index.htm index-old.htm
	mv index-new.htm index.htm
fi