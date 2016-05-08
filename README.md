README.md

# Easy PHP Lexique Pro Website Extension

## About

This is an extension to the Lexique Pro (http://www.lexiquepro.com) web page output, which adds two main functionalities: 
- 1. Search is enabled while viewing the dictionary online. 
- 2. Mobile-friendly layout makes it easier to view the dictionary online on a mobile device. 

As input it takes the web page output of a Lexique Pro dictionary file. Lexique Pro in turn takes as input a Toolbox Lexicon, which is a simple backslash text file.

You will only need basic knowledge about editing text files and uploading files to a web provider.

It is based on a basic Bootstrap template (<http://getbootstrap.com>).

It was developed as part of the Mawng website project led by Ruth Singer <http://languages-linguistics.unimelb.edu.au/about/staff/dr-ruth-singer>.

The Mawng dictionary example can be found at <http://www.mawngngaralk.org.au/dictionary>.

## Instructions

- It is assumed that you have a running website with PHP enabled, where you can upload files.
- First, generate website output from Lexique Pro. 
- You should now have something like the following file structure. This basic structure will be kept and all these files will be used for the website extension, so there is no need to delete or alter any of the files produced by Lexique Pro.

```
.
+-- audio
+-- categories
|   +-- c001.htm
|   +-- ...
+-- images
|   +-- ...
+-- index-english
|   +-- 01.htm
|   +-- ...
+-- index.htm
+-- javascript
|   +-- ...
+-- lexicon
|   +-- 01.htm
|   +-- ...
+-- pictures
+-- stylesheets
|   +-- lexiquepro.css
+-- title.htm
```

- Download all the files for this extension from GitHub.
- Add all the extension files to the same folder as the Lexique Pro files.

```
.
+-- build.sh
+-- categories.php
+-- include
|   +-- boostrap.min.css
|   +-- bootstrap.min.js
|   +-- functions.php
|   +-- head.php
|   +-- nav.php
|   +-- scripts.js
|   +-- style.css
|   +-- variables.php
+-- index-english.php
+-- index-new.htm
+-- lexicon.php
+-- LICENSE
+-- README.md
+-- search.php
```

- The next two steps can be done manually or by running the script as described in the next section:
    - Delete the old `index.htm` file and rename `index-new.htm` to replace it.
    - Open the `variables.php` file in the `include` folder and manually enter the language name, update the language alphabet, English letter categories and category names.
- Upload files to your website. Make sure that the permissions of the folder are set to 755.
- You should now be able to access the new mobile friendly version of your Lexique Pro web pages :-)

## Running the Build Script (Optional, Mac only)
- A number of fields need to be filled out in the file `variables.php` in the `include` folder.
- Instead of filling out these fields by hand, you can run the build script to automatically fill these fields.
- This has only been tested on a Mac running OS X El Capitan 10.11.4.
- First open a Terminal window.
- Type in `./build.sh`.
- To add a link to a main website, add a parameter to the command, e.g. `./build.sh www.myhomepage.com`.
- Check in the `variables.php` that the four variables for the language name, index letters, language alphabet letters and categories have been filled out.

## Notes
- Feedback is welcome.
- Limited support can be provided.
- It was tested with PHP version 5.4 and Lexique Pro version 3.6.
- The Lexique Pro output was generated by using the Web Page Wizard (File > Export as Web Page...), with the options "Framed version" and all pictures and audio selected.
- It is assumed there is only one finder language, namely English. If there is demand for other langauges, please contact us and we can adapt the extension for them.
