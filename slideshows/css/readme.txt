Please note.

The files *-min.css are compressed versions of the *-css files.
You should not need to make any changes here! But if you do you should 
make the change in original files and minimize it by yourself.

All changes should go to the my_style.css or my_style_ie.css

Since TWG 1.8.8 all css files are combinded dynamically ($optimize_css = true) 
and the result is stored as temporary css file in the cache folder.

So if you make changes in the css you should turn off the optimization
$optimize_css = false. After you are done make sure to delete the session 
cache as well to make sure thatold css files are removed.