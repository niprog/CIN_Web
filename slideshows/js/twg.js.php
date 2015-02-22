<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_TWG' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javaScript">

// offset if the iframes adjustment is wrong!
var xoffset = <?php echo $iframe_xoffset; ?>;
var yoffset = <?php echo $iframe_yoffset; ?>;

<!-- begin code provided by createblog.com -->
//script obtained from createBlog.com
function makevisible(cur,which){
    strength=(which==0)? 1 : 0.<?php echo $fading_level; ?>; 
    if (cur.style.filter) {
      cur.style.filter='progid:DXImageTransform.Microsoft.Alpha(Opacity=' + strength*100 + ')';
    } else if (cur.style.opacity) {
    cur.style.opacity=strength;
    } else if (cur.filters) {
    cur.filters.alpha.opacity=strength*100
    }
}

function makevisibleAll(cur,which){
var strength=(which==0)? 1 : 0.<?php echo $fading_level; ?>;

var myid = cur.id.substring(2);
var idd = (Math.floor(myid / 10)) * 10;
for (i = 0; i < 4; i++) {
  cur = document.getElementById("id" + (idd + i));
  if (cur) {
     if (cur.style.filter) { // IE 8 !
      cur.style.filter='progid:DXImageTransform.Microsoft.Alpha(Opacity=' + strength*100 + ')';
    } else if (cur.style.opacity) {
      cur.style.opacity=strength
    } else if (cur.filters) {
      cur.filters.alpha.opacity=strength*100
    }
  }
}
}

function makegray(cur,which){
var strength=(which==0)? 1 : 0.<?php echo $gray_fading_level; ?>;
var grray=(which==1)? true : false;

if (cur.style.MozOpacity) {
cur.style.MozOpacity=strength;
}
else if (cur.filters)
cur.filters.gray.enabled = grray;
}

function makegrayAll(cur,which){
var strength=(which==0)? 1 : 0.<?php echo $gray_fading_level; ?>;
var grray=(which==1)? true : false;

var myid = cur.id.substring(2);
var idd = (Math.floor(myid / 10)) * 10;
for (i = 0; i < 4; i++) {
  cur = document.getElementById("id" + (idd + i));
  if (cur) {
    if (cur.style.MozOpacity) {
      cur.style.MozOpacity=strength
    } else if (cur.filters)
      cur.filters.gray.enabled = grray;
    }
  }
}

function openTitel() {
   openIframe('i_caption', <?php echo $lang_height_caption; ?> );
}

function openComment() {
   openIframe('i_comment', <?php echo $lang_height_comment; ?> );
}
 
function openInfo(){
   openIframe('i_info', <?php echo $lang_height_info; ?> );
}

function openOptions(){
   openIframe('i_options', <?php echo $lang_height_options; ?> );
}

function openTags(){
   openIframe('i_tags', <?php echo $lang_height_tags_insert; ?> );
}

function openLogin() {
   openIframe('loginlink', <?php echo $lang_height_login; ?> );
}

function openRate() {
   openIframe('i_rate', <?php echo $lang_height_rating; ?> );
}

function openSearch(){
   openIframe('i_search', <?php echo $lang_height_search; ?> );
}


<?php
if ($disable_enhanced_keybord_navigation) {
?>
function openIframe(_id, _height) { }
<?php } else { ?>
function openIframe(_id, _height) {
 if (document.getElementById) {
    if (document.getElementById(_id)) { 
			    if (document.getElementById('details')) {
			      details.location.href=document.getElementById(_id).href;
					  twg_showSec(_height)
					}
		}
  }
}
<?php } ?>

var fileLoadingImage = "<?php echo $install_dir; ?>lightbox/images/loading.gif";		
var fileBottomNavCloseImage = "<?php echo $install_dir; ?>lightbox/images/closelabel.gif";
var fileBottomNavZoomImage = "<?php echo $install_dir; ?>lightbox/images/closelabel.gif"; //Added by Bas
var lightboxImage = "<?php echo $lang_picture; ?>";
var lightboxOf = "<?php echo $lang_of; ?>";

<?php
if ($iframe_include) {
?>
var includeoffset=0.99;
<?php } else { ?>
var includeoffset=1;
<?php } ?>

<?php
if ($disable_right_click) {
?>
var message="<?php echo $lang_right_message; ?>";
function clickIE4(){if (event.button==2){alert(message);return false;}}function clickNS4(e){if (document.layers||document.getElementById&&!document.all){if (e.which==2||e.which==3){alert(message);return false;}}}if (document.layers){document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS4;}else if (document.all&&!document.getElementById){document.onmousedown=clickIE4;}document.oncontextmenu=new Function("alert(message);return false")
<?php } ?>

<?php
if ($twg_mobile || $isTablet) {
?>
var down_x = null;
var up_x = null;
var down_y = null;
var up_y = null;

$().ready(function(){

   $("#twg_content_div").swipe( {
      //Generic swipe handler for all directions
      swipeLeft:function(event, direction, distance, duration, fingerCount) {
         slide_left();
      },
      swipeRight:function(event, direction, distance, duration, fingerCount) {
         slide_right();
      }
   });
   
    imgs = $("#defaultslide");
    imgs.swipe( {
      //Generic swipe handler for all directions
      swipeLeft:function(event, direction, distance, duration, fingerCount) {
        slide_left();
      },
      swipeRight:function(event, direction, distance, duration, fingerCount) {
         slide_right();
      }
   });
   
   
    
   $(".twg_folderdescription").dotdotdot({watch:true, height:<?php echo $twg_mobile_max_description_height; ?> });  
});
function do_work()
{
    if ((down_x - up_x) > 100) {
        slide_right();
        return;
    }
    if ((up_x - down_x) > 100) {
        slide_left();
        return;
    }
}
function slide_right()
{
  if (window.key_back) {
    key_back();
  }  
}
function slide_left()
{
  if (window.key_foreward) {
    key_foreward();
  } 
}
function slide_up_down()
{
  if (window.key_up) {
    key_up();
  } 
}

<?php } ?>

$().ready(function(){ 
   $(".albumtxt div").dotdotdot({watch:true, height:<?php echo ($menu_pic_size_y +8); ?> });   
});

</script>