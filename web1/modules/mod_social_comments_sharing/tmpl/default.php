<?php
/*
* @version 2.1
* @package social sharing
* @copyright 2012 OrdaSoft
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @author 2012 Andrey Kvasnekskiy (akbet@ordasoft.com )
* @description social sharing, sharing WEB pages in LinkedIn, FaceBook, Twitter and Google+ (G+)
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
global $realestatemanager_configuration;
$document = JFactory::getDocument();
$database=JFactory::getDBO();
$docType = $document->getType();
$mosConfig_absolute_path = $GLOBALS['mosConfig_absolute_path'] = JPATH_SITE;
$mosConfig_live_site=JURI::base();
$config = JFactory::getConfig();

if(socialSharingHelper::checkJavaScriptIncludedSocial('jQuerOs-2.2.4.min.js') === false){
    $document->addScript($mosConfig_live_site .'/modules/mod_social_comments_sharing/assets/js/jQuerOs-2.2.4.min.js');
    $document->addScriptDeclaration("window.onload = function(){jQuerOs=jQuerOs.noConflict();}");
}
//default meta variables
$title = htmlspecialchars(strip_tags($document->getTitle()));
$description=htmlspecialchars(strip_tags($document->getMetaData("description")));
$uri = JURI::getInstance();
$url = htmlspecialchars($uri->toString());
//end

$code_twitter = '';
$code_google = '';
$code_in = '';
$style = '';
$htmlCodeComBox = '';
$htmlCodePage = '';
$htmlFbPage = '';
$htmlCode = '';
$meta = "";
$_google = 0;
$_tw = 0;
$_in = 0;
$icon_size = $icon_size_number =$params->get('icon_size','40');
$icon_size.='px';
$modId = $module->id;
$enable_twitter = $params->get('enable_twitter');
//$enable_google = $params->get('enable_google');
$enable_in = $params->get('enable_in');
$enable_vk = $params->get('enable_vk');
$enable_add_this = $params->get('enable_add_this');
$enable_ok = $params->get('enable_ok');
$enable_tumblr = $params->get('enable_tumblr');
$enable_instagram = $params->get('enable_instagram');
$enable_pinterest = $params->get('enable_pinterest');

//FB settings
$app_id = $params->get('fb_api_id');
$enable_like = $params->get('fb_enable_like');
$enable_share = $params->get('fb_enable_share');
$enable_comments = $params->get('fb_enable_comments');
$enable_page = $params->get('fb_enable_page');
$enable_send = $params->get('fb_enable_send');
//end FB
//Load language
if ($params->get('auto_language')) {
  $language = str_replace('-', '_', JFactory::getLanguage()->getTag());
} else {
  $language = $params->get('module_language');
}//end
$type = $params->get('type');
//end
?>
<style type="text/css">
    
    #mainCom .pinterest_follow a{
      cursor: pointer;
      display: block;
      box-sizing: border-box;
      box-shadow: inset 0 0 1px #888;
      border-radius: 3px;
      height: 20px;
      -webkit-font-smoothing: antialiased;
      background: #efefef;
      background-size: 75%;
      position: relative;
      font: 12px "Helvetica Neue", Helvetica, arial, sans-serif;
      color: #555;
      text-align: center;
      vertical-align: baseline;  
      line-height: 20px;
      padding: 1px 4px;
      text-decoration: none;    
    }


  <?php if($params->get('module_style') =='horizontal' || $params->get('module_style') =='horizontal_images'){ ?> 

  #mainCom{
    display: -webkit-flex;
    display: -moz-flex;
    display: -ms-flex;
    display: -o-flex;
    display: flex;

    -webkit-flex-wrap: wrap;
    -moz-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    -o-flex-wrap: wrap;
    flex-wrap: wrap;
  }

  <?php } ?>

    #mainF [class^=ig-b-] {
        position: relative;
    }
    #mainF [class^=ig-b-] img {
        height: 21px;
    }
    /*for small button*/
    #mainF span[class^=PIN_] {
        height: 21px;
        /*background-size: 21px 21px;*/
    }
    /*for big button*/
    #mainF div[class^=PIN_] span[class^=PIN_] {
        height: 21px;
        width: 31px;
        background-size: 48px;
        right: -31px;
        line-height: 23px
    }
    #addthis_icon .addthis_counter.addthis_bubble_style {
        margin: 0;
        padding: 0;
    }
    #mainF {
        z-index: 99999;
    }
    #mainF a div {
        -webkit-transition: all 0.3s ease-out;
       -moz-transition: all 0.3s ease-out;
        transition: all 0.3s ease-out;
    }
    
    .fb_send_button_container{
        width: 69px;
        height: 20px;
        background: #1877f2;
        border-radius: 3px;
        text-align: center;

    }
    .facebook-send-button{
        color: #fff;
        margin-top: 2px;
        margin-left: 7px;
    }
    .fb_send_button_container a{
        vertical-align: middle;
    }
    <?php
///////////////////////end\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

    /////////////////////Start for custom blocks\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    if($params->get('module_style') =='horizontal' || $params->get('module_style') =='horizontal_images'){?>
        #mainF [class^=ig-b-] {
            /*top: -7px;*/
            margin-right: 4px;
        }
        #mainF .fb_like_button_container span,#mainF .fb_send_button_container span{
            /*width: 450px!important;*/
        }
        #mainCom{
            padding-left: 8px!important;
        }
        #mainCom .fb_like_button_container,#mainCom .fb_share_button_container,#mainCom .fb_send_button_container,
        #mainCom .cmp_in_container,#mainCom .cmp_twitter_container,#mainCom .cmp_vk_container,.cmp_google_container,
        #mainCom .cmp_ok_container{
            float: left;
        }
        #mainCom .cmp_ok_container{
            margin-right: 4px;
        }
        #mainCom .fb_like_button_container{
            margin: 0px 4px 0px 0;
        }
        #mainF .fb_send_button_container{
            margin: 0px 4px 0px 0;
        }
        #mainCom .cmp_twitter_container{
            margin-right: 4px;
            position: relative;
        }
        #mainCom .pinterest_follow{
          margin-right: 4px;
        }
        #mainCom .tumblr-share-container{
          margin-right: 2px;
        }

        #mainCom a[data-pin-do="buttonPin"]{
            margin-right: 4px;
        }

        #mainCom .cmp_google_container,#mainCom .cmp_vk_container,#mainCom .cmp_ok_container{
            position: relative;
        }
        #mainCom .cmp_AddThis_container{
            position: relative;
            display: inline-block;
        }
        #mainCom .cmp_vk_container{
            margin-right: 3px;
            /*margin-left: -30px;*/
            position: relative;
        }
        #mainCom .pluginButtonContainer{
            width: 62px;
        }
        #mainF .fb_send_button_container span{
            margin-right: 4px;
        }
        #mainF .addthis_button_more #addthis_icon {
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/addthis-icon.png';?>);
            background-position: center;
            -moz-background-size: 100%; /* Firefox 3.6+ */
            -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
            -o-background-size: 100%; /* Opera 9.6+ */
            background-size: 100%; /* Современные браузеры */
            width: 20px;
            height: 20px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -o-border-radius: 2px;
        }
        #mainF .addthis_button_more #addthis_icon:hover {
           opacity: 0.8;
        }
        #mainF .addthis_button_more {
            display: inline-block;
            margin-right: 3px;
            border-radius: 2px;
            position: relative;
            z-index: 999;
        }
    <?php
    }elseif($params->get('module_style') =='vertical' || $params->get('module_style') =='vertical_images'){ ?>

        #mainCom .pinterest_follow a{
          display: inline-block;
          margin-bottom: 5px;
        }
        .mainCom .buttonPin{
            margin-bottom: 5px;
        }        

        .fb_send_button_container{
          margin-bottom: 5px;
        }

        .fb-send.fb_iframe_widget{
          line-height: 20px;
          vertical-align: top;
        }

        .fb_send_button_container{
          margin-bottom: 5px;
        }


        #mainF [class^=ig-b-] {
            display: block;
        }
        #mainF span[class^=PIN_] {
            display: inline-block;
            margin: 5px 0 0 0;
        }
        #mainF span[class^=PIN_] span[class^=PIN_] {
            margin: 0;
        }
        #mainF .addthis_button_more #addthis_icon {
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/addthis-icon.png';?>);
            background-position: center;
            -moz-background-size: 100%; /* Firefox 3.6+ */
            -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
            -o-background-size: 100%; /* Opera 9.6+ */
            background-size: 100%; /* Современные браузеры */
            width: 20px;
            height: 20px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -o-border-radius: 2px;
        }
        #mainF .addthis_button_more #addthis_icon:hover {
           opacity: 0.8;
        }
        #mainF .addthis_button_more {
            display: block;
            margin:5px 3px 5px 0;
            border-radius: 2px;
            position: relative;
            z-index: 999;
        }
        #mainF .fb_like_button_container span,#mainF .fb_send_button_container span{
            /*width: 450px!important;*/
        }


        div.fb_share_button_container{
          margin-bottom: 5px;
        }

        div.cmp_twitter_container,
        div.cmp_in_container,
        .mainCom [class^=ig-b-],
        [class^=ig-b-],
         .buttonPin,
         .addthis_button_more,
         .tumblr-share-container{
          /*margin-top: -4px;*/
          height: 20px;
          line-height: 20px;
          margin-bottom: 5px;
        }

         [class^=ig-b-] a{
          height: 20px;
          display: inline-block;
        }

        [class^=ig-b-] img{
          max-height: 100%;
        }

        .fb_iframe_widget span{
          vertical-align: top !important;
        }

        .fb_share_button_container,
        .fb_send_button_container,
        .cmp_google_container{
          line-height: 20px;
        }

        .cmp_google_container{
          /*height: 20px;*/
          margin-bottom: 5px;
        }


        #mainF a div,#mainF #addthis_icon{
            position: relative;
        }
        .addthis_counter {
            width: <?php echo $icon_size; ?>!important;
            height: <?php echo $icon_size; ?>!important;
        }
        #addthis_icon a.addthis_counter.addthis_bubble_style {
            width: 0!important;
        }
        #addthis_icon  .addthis_button_more.at300b, .cmp_AddThis_container  .addthis_button_more.at300b {
            padding: 0;
        }
        .cmp_AddThis_container  .addthis_button_more.at300b, #mainCom .fb_like_button_container,
        #mainCom .fb_send_button_container, #mainCom .cmp_ok_container{
            margin-top: 4px;
        }
        span[id$=_count_box]{
            position: absolute;
            bottom: 0;
            left:0;
            right: 0;
            text-align: center;
            color: #000;
            line-height: 18px;
        }
        
        #mainF #fb_share_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/face.png';?>);
            background-position: center;
            -moz-background-size: 100%; /* Firefox 3.6+ */
            -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
            -o-background-size: 100%; /* Opera 9.6+ */
            background-size: 100%; /* Современные браузеры */
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #facebook-share-dialog {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        #mainF #liked_in_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/liked_in.png';?>);
                -moz-background-size: 100%; /* Firefox 3.6+ */
            -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
            -o-background-size: 100%; /* Opera 9.6+ */
            background-size: 100%; /* Современные браузеры */
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #mainF #twitter_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/twitter_icon.png';?>);
                -moz-background-size: 100%; /* Firefox 3.6+ */
    -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
    -o-background-size: 100%; /* Opera 9.6+ */
    background-size: 100%; /* Современные браузеры */
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #mainF #google_plus_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/google_plus_icon.png';?>);
                -moz-background-size: 100%; /* Firefox 3.6+ */
            -webkit-background-size: 100%; /* Safari 3.1+ и Chrome 4.0+ */
            -o-background-size: 100%; /* Opera 9.6+ */
            background-size: 100%; /* Современные браузеры */
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #mainF #vk_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/vk_icon.png';?>);
                -moz-background-size: 100%;
            -webkit-background-size: 100%;
            -o-background-size: 100%;
            background-size: 100%;
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #mainF #odnoklasniki_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/odnoklasniki_icon.png';?>);
            -moz-background-size: 100%;
            -webkit-background-size: 100%;
            -o-background-size: 100%;
            background-size: 100%;
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #mainF #fb_send_icon{
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/face_send.png';?>);
            -moz-background-size: 100%;
            -webkit-background-size: 100%;
            -o-background-size: 100%; 
            background-size: 100%;
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
        }
        #mainF .at4-icon.aticon-more {
            background-image: url(<?php echo $mosConfig_live_site.
                'modules/mod_social_comments_sharing/images/addthis-icon.png';?>)!important;
            -moz-background-size: 100%;
            -webkit-background-size: 100%;
            -o-background-size: 100%;
            background-size: 100% !important;
            background-position: center;
            width: <?php echo $icon_size; ?>;
            height: <?php echo $icon_size; ?>;
            -webkit-transition: all 0.3s ease-out;
           -moz-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }
        #mainF .addthis_counter.addthis_bubble_style{
            background-image: none!important;
            position: absolute;
            bottom: 0;
            left:0;
            right: 0;
            text-align: center;
        }
        #addthis_icon a.addthis_counter .addthis_button_expanded {
            padding-bottom: 0;
            margin-bottom: 0;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -o-box-sizing: border-box;
            color: #000;
            font-size: 13px;
            font-weight: 400;
            line-height: 18px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: <?php echo $icon_size; ?>!important;
            height: 18px;
            -webkit-transition: all 0.3s ease-out;
           -moz-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        .cmp_vk_container, .fb_share_button_container, 
        .fb_like_button_container{
            margin-bottom: 5px;
        }
        
        #mainCom .fb_like_button_container .fb_iframe_widget iframe,
        #mainCom .fb_share_button_container .fb_iframe_widget iframe {
          position: static;
        }

    <?php
    }
    ?>
    .mainCom > div {
      -ms-align-items: center;
      align-items: center;
    }
    .mainCom .ig-b-.ig-b-v-24 img {
      margin-top: -3px;
    }
    .mainCom .buttonPin {
      margin-top: -2px;
    }
    .mainCom .tumblr-share-container {
      max-width: 55px;
      height: 20px;
    }
    .mainCom .addthis_button_more {
      height: 20px;
    }
    .mainCom .buttonPin span[class^=PIN_] {
      display: inline-block;
    }
    
    #mainButtons<?php echo $modId; ?> img{
      
      height: 25px;
    }
    
    <?php 
    if($params->get('module_style') =='horizontal_images'){?>
        #mainButtons<?php echo $modId; ?> a{
            display: inline-block !important;
            margin: 3px;
        }
        #pinterest_img{
            cursor:pointer;
        }
    <?php }elseif($params->get('module_style') =='vertical_images'){ ?>
        #mainButtons<?php echo $modId; ?> a{
            //margin: 3px;
        }
        #pinterest_img{
            cursor:pointer;
        }
        #mainButtons<?php echo $modId; ?> img{
            vertical-align: unset;
        }
    <?php } ?>
</style>
<?php

//////////////////Start facebook like,share and sent button/////////////////////////////
if ($enable_like || $enable_share || $enable_comments || $enable_send || $enable_page) {
////Start initialise FB script code
    $url_FB = $url;
      $temp_param = $params->get('fb_sharing_url') ;
      if( !empty( $temp_param ) ) {
          $url_FB = $params->get('fb_sharing_url');
      }
?>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/<?php echo $language; ?>/sdk.js#xfbml=1&version=v7.0&appId=<?php echo $app_id; ?>&autoLogAppEvents=1">
            
//            if('<?php echo $enable_google_analytics; ?>' == 1){
//                  FB.Event.subscribe('edge.create', function(url) {
//                    ga('send', 'social', 'Facebook', 'Like', "<?php echo $url_FB; ?>");
//                  });
//
//                  FB.Event.subscribe('edge.remove', function(url) {
//                    ga('send', 'social', 'Facebook', 'Unlike', '<?php echo $url_FB; ?>');
//                  });
//
//                  FB.Event.subscribe('message.send', function(targetUrl) {
//                    ga('send', 'social', 'Facebook', 'Send', '<?php echo $url_FB; ?>');
//                  });
//                }
        </script>
        <script type="text/javascript">
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.async=true;
              js.src = "//connect.facebook.net/<?php echo $language; ?>/sdk.js";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));


            function facebookSend(elem){
                  event.preventDefault();
                  
                  jQuerOs.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
                      FB.init({
                        appId: '<?php echo $app_id; ?>',
                        version: 'v7.0'
                      });     
                      FB.ui({app_id:'<?php echo $app_id; ?>',method: 'send', link: '<?php echo $url; ?>',},function(response) {})
                    });
                  
            }
        </script>
    <?php
//    $FbCode = <<<FACEBOOK
//        (function(d, s, id) {
//          var js, fjs = d.getElementsByTagName(s)[0];
//          if (d.getElementById(id)) return;
//          js = d.createElement(s); js.id = id;
//          js.async=true;
//          js.src = "//connect.facebook.net/$language/sdk.js#xfbml=1&appId=$app_id&version=v5.0&autoLogAppEvents=1";
//          fjs.parentNode.insertBefore(js, fjs);
//        }(document, 'script', 'facebook-jssdk'));
//FACEBOOK;
//    $document->addScriptDeclaration($FbCode);
}
//end
if($params->get('module_style')=='horizontal' || $params->get('module_style')=='vertical'){
    //////////////////Start facebook like,share and sent buttons/////////////////////////////
    //
    if ($enable_share) {
          
          $share_button_style = $params->get('fb_layout_style');
          $htmlCode.= "<div id=\"fb-root\"></div>";
           $temp_param = $params->get('fb_sharing_url') ;
           if(!empty( $temp_param ) ) {
             echo("<script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.async=true;
                        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0';
                        fjs.parentNode.insertBefore(js, fjs);
                      }(document, 'script', 'facebook-jssdk'));</script>");
            
              $htmlCode.= "<div style=\"margin-right:4px;\" class=\"fb-share-button\" data-event=\"Share\" data-social=\"Facebook\" data-href=\"" . $url_FB ."\" data-layout=\"$share_button_style\" data-size=\"small\" data-mobile-iframe=\"true\"><a class=\"fb-xfbml-parse-ignore\" target=\"_blank\" href=\"https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse\">Share</a></div>";
           }
           else {
               $tmp = "<div class=\"fb-share-button\" data-href=\"$url_FB\" data-layout=\"$share_button_style\"></div>". PHP_EOL;
               $htmlCode.= "<div style=\"margin-right:4px;\" data-social=\"Facebook\" data-event=\"Share\" class=\"fb_share_button_container\">$tmp</div>";
           }    
        }
        //FB like button
        if ($enable_like ) {
          $layout_style = $params->get('fb_like_layout_style');
          $verb_to_display = $params->get('fb_like_verb_to_display');
          $color_scheme = $params->get('fb_like_color_scheme', 'light');
          $show_faces=$params->get('fb_like_show_faces');
          $tmp ="<div class=\"fb-like\"
                      data-href=\"$url_FB\"
                      data-layout=\"$layout_style\"
                      data-action=\"$verb_to_display\"
                      data-show-faces=\"$show_faces\"
                      data-share=\"false\"
                      data-social=\"Facebook\"
                      data-event=\"Like\"
                      colorscheme=\"$color_scheme\"></div>";
          $tmp= $tmp . PHP_EOL;
          $htmlCode.= "<div class=\"fb_like_button_container\">$tmp</div>";
        }
        //FB send
        if ($enable_send) {
//              $tmp = "<a data-social='Facebook' data-event='Send' class='facebook-send-button' href='#' onclick='javascript:facebookSend(this)' sdk='false'>
//                <div id='fb_send_icon'><i class='fa icon icon-os-paper-plane'></i> Send</div>
//              </a>";
            $tmp = "<a data-social='Facebook' data-event='Send' class='facebook-send-button' href='#' onclick='javascript:facebookSend(this)' sdk='false'>
                Send
              </a>";

              $tmp= $tmp . PHP_EOL;
              $htmlCode.= "<div class=\"fb_send_button_container\">$tmp</div>";
        }
        
        //////////////////Start OK share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if($enable_ok){

            //check API connect

            if(socialSharingHelper::checkApiConnect("https://connect.ok.ru/connect.js")){
                if($params->get('ok_comment_style'))$style = ",vt:'1'";
                $tmp = "
                    <div id=\"ok_shareWidget\"></div>
                    <script>
                    !function (d, id, did, st) {
                      var js = d.createElement(\"script\");
                      js.src = \"//connect.ok.ru/connect.js\";
                      js.onload = js.onreadystatechange = function () {
                      if (!this.readyState || this.readyState == \"loaded\" || this.readyState == \"complete\") {
                        if (!this.executed) {
                          this.executed = true;
                          setTimeout(function () {
                            OK.CONNECT.insertShareWidget(id,did,st);
                          }, 0);
                        }
                      }};
                      d.documentElement.appendChild(js);
                    }(document,\"ok_shareWidget\",'".$url."',\"{width:75,height:65,st:'rounded',sz:20".$style.",nt:1}\");
                    </script>";
                $tmp.= PHP_EOL;
                $htmlCode.= "<div class=\"cmp_ok_container\" >$tmp</div>";
            }
        }
        //////////////////End OK share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        ////////////////////////Start LIKEDIN share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if ($enable_in == 1) {
                $data_counter_in = $params->get('data_counter_in');
                $data_showzero_in = $params->get('data_showzero_in');
                if ($data_counter_in == "none") {
                    $data_counter_in = "";
                    $data_showzero_in = "";
                } else {
                    $data_counter_in = "data-counter=\"$data_counter_in\"";
                    if ($data_showzero_in == "0") {
                        $data_showzero_in = "";
                    } else {
                        $data_showzero_in = 'data-showzero=\"true\"';
                    }
                }
                $tmp = "";
                $tmp.="<script src=\"//platform.linkedin.com/in.js\" type=\"text/javascript\"> lang: $language</script>". PHP_EOL;
                $tmp.= "<script type=\"IN/Share\" data-url=\"$url\" $data_counter_in $data_showzero_in ></script>". PHP_EOL;
                $htmlCode.= "<div class=\"cmp_in_container\">$tmp</div>";
        }
        /////////////////////////End LIKEDIN share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        ////////////////////Start TWITER share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if ($enable_twitter == 1) {
            $TwCode = "
              window.twttr=(function(d,s,id){
                var js,
                fjs=d.getElementsByTagName(s)[0],
                t=window.twttr||{};
                if(d.getElementById(id))return t;
                js=d.createElement(s);
                js.id=id;
                js.src=\"https://platform.twitter.com/widgets.js\";
                fjs.parentNode.insertBefore(js,fjs);
                t._e=[];t.ready=function(f){t._e.push(f);};
                    return t;
            }(document,\"script\",\"twitter-wjs\"));";
            $document->addScriptDeclaration($TwCode);
        //Twitter button
            $data_via_twitter = $params->get('data_via_twitter');
            $data_related_twitter = $params->get('data_related_twitter');
            $show_count_twitter = $params->get('show_count_twitter', 'horizontal');
            $hashtags_twitter = $params->get('hashtags_twitter', '');
            $datasize_twitter = $params->get('datasize_twitter');
            $language_twitter = 'data-lang="'.$language.'"';
            if ($data_via_twitter != "") {
                $data_via_twitter = 'data-via="'.$data_via_twitter.'"';
            } else {
                $data_via_twitter = '';
            }
            if ($data_related_twitter != "") {
                $data_related_twitter = 'data-related="'.$data_related_twitter.'"';
            } else {
                $data_related_twitter = '';
            }
            if ($hashtags_twitter != "") {
                $hashtags_twitter = 'data-hashtags="'.$hashtags_twitter.'"';
            }

            $datasize_twitter = 'data-size="medium"';

            $tmp = "<a href=\"//twitter.com/share\" class=\"twitter-share-button\" ";
            $tmp.= " $language_twitter $data_via_twitter $hashtags_twitter $data_related_twitter $datasize_twitter ";
            $tmp.= "data-url=\"$url\" ";
            $tmp.= "data-count=\"$show_count_twitter\">Tweet</a>";
            $tmp.= PHP_EOL;
            $htmlCode.= "<div class=\"cmp_twitter_container\" >$tmp</div>";
        }
        ///////////////////End TWITER share\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



        // <!-- ///////////////////////////////////////////START VK SHARE BUTTON\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->
        if ($enable_vk) {
        ///initialise vk script

            //check API connect
            if(socialSharingHelper::checkApiConnect("https://vk.com/js/api/share.js?90")){
                $document->addScript('//vk.com/js/api/share.js?90','text/javascript',true,true);
                $vk_button_style = $params->get('vk_button_style');
                $vk_button_text = $params->get('vk_button_text');
                $vk_logo_type = $params->get('vk_logo_type');
                if($vk_button_style == 'custom'){
                    if($vk_logo_type)
                        $vk_button_text = "<img src=\"//vk.com/images/share_32_eng.png\" width=\"32\" height=\"32\" />";
                    else
                        $vk_button_text = "<img src=\"//vk.com/images/share_32.png\" width=\"32\" height=\"32\" />";
                }
                $image = (isset($image) && $image!='')? $image : '';
                $htmlCode.= "<div class=\"cmp_vk_container\">";
                $htmlCode.="
                <script type='text/javascript'>
                    document.write(VK.Share.button(false,{
                    url: '".$url."',
                    title: '".addslashes($title)."',
                    description: '".addslashes($description)."',
                    image: '".$image."',
                    type: '".$vk_button_style."',
                    text: '".$vk_button_text."',
                    eng: '".$vk_logo_type."',
                    noparse: true
                    }));
                </script>";
                $htmlCode.="</div>";
            }

        }
        // <!-- //////////////////////////////////////////End VK share button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

        //////////////////START add_this button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if($enable_add_this ){
            $document->addScript('//s7.addthis.com/js/300/addthis_widget.js','text/javascript',true,true);
            $htmlCode.="<div><a href='#' class=\"addthis_button_more\" data-social=\"Add This\" data-event=\"Share\">
                          <div id='addthis_icon'>";
            $htmlCode.="</div></a></div>";
        }
        //////////////////end add_this button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        //////////////////START tumblr button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if ($enable_tumblr) {
          $document->addScript('https://assets.tumblr.com/share-button.js','text/javascript',true,true);
          $htmlCode.= '<div class="tumblr-share-container" ><a class="tumblr-share-button" href="https://www.tumblr.com/share" data-social="Tumblr" data-event="Share"></a></div>';

        }
        //////////////////end tumblr button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        //////////////////START instagram button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if($enable_instagram){
            $instagram_user = str_replace('@', '', $params->get("instagram_user"));
            $htmlCode.= '<div class="ig-b- ig-b-v-24" ><a data-social="Instagram" data-event="Follow" href="https://www.instagram.com/'.$instagram_user.'/?ref=badge" >
                          <img src="//badges.instagram.com/static/images/ig-badge-view-24.png" alt="Instagram" />
                        </a></div>';
        }


        //////////////////end inst button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        //////////////////START pinterest button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        if ($enable_pinterest) {
            $labelImage = $params->get('pinterest_label_image','');
            if($params->get('pinterest_large',0)){
              $pinterest_large = 'data-pin-tall="'.$params->get('pinterest_round').'"';
            }else{
              $pinterest_large = '';
            }

            if($params->get('pinterest_round',0)){
              $pinterest_round = 'data-pin-round="'.$params->get('pinterest_large').'"';
            }else{
              $pinterest_round = '';
            }

            if($params->get('pinterest_count','')){
              $pinterest_count = 'data-pin-count="'.$params->get('pinterest_count').'"';
            }else{
              $pinterest_count = '';
            }
            if($params->get('pinterest_color','')){
              $pinterest_color = 'data-pin-color="'.$params->get('pinterest_color').'"';
            }else{
              $pinterest_color = '';
            }
            if(!$labelImage){
              if($params->get('pinterest_color','') == "gray"){
                $labelImage = "//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png";
              }else{
                $labelImage = "//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png";
              }
              $p_cust = '';
            }else{
              $p_cust = 'data-pin-custom="true"';
              $pinterest_large = $pinterest_round = '';
            }
            $document->addScript('//assets.pinterest.com/js/pinit.js','text/javascript',true,true);
            $htmlCode.= '<div class="buttonPin" ><a data-pin-do="buttonPin" '.$pinterest_count.' '.$pinterest_large.
                          ' '.$pinterest_round.' '.$pinterest_color.'
                          href="//www.pinterest.com/pin/create/button/" '.$p_cust.' data-social="Pinterest" data-event="Follow">
                          <img src="'.$labelImage.'"/>
                        </a></div>';


        }
        //////////////////END pinterest button\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        
      }
      
      if($params->get('module_style')=='horizontal_images' || $params->get('module_style')=='vertical_images'){
          //var_dump($params->get('module_style'));
        $box_counter=0;
        $box = '';
        $box .= '<div id="mainButtons'. $modId . '">';
        if($enable_share){

        $box_counter++;
        $box.="<a data-social='Facebook' data-event='Share' class='facebook-button' href='#' onclick=\"
                    window.open(
                    '//www.facebook.com/sharer/sharer.php?u='+
                    encodeURIComponent(location.href),
                    'share-dialog','height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
                <div><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/fb_share.png'>";
                    if($params->get('show_count_box')){
                        $box.= "<span id='fb_share_count_box'>".$fb_count."</span>";
                    }
                    $box.="
                </div>
            </a>";
      }
      if($enable_send){
        $box_counter++;
        $box.="<a data-social='Facebook' data-event='Send' class='facebook-send-button' href='#' onclick='javascript:facebookSend(this)' sdk='false'>
            <div id='fb_send_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/fb_send.png'></div>
        </a>";
      }
            

            
      if($enable_ok){
        $box_counter++;
        $box.="<a data-social='Odnoklassniki' data-event='Share' class='ok-button' href='#' onclick=\"
                    window.open(
                    '\/\/connect.ok.ru\/offer?url='+
                    encodeURIComponent(location.href),
                    'share-dialog','height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
            <div id='ok_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/ok.png'>";
            if($params->get('show_count_box')){
              $box.="<span id='ok_count_box'>$ok_count</span>";
            }
            $box.="</div>
        </a>";

      }
            

            
      if($enable_in){
        $box_counter++;
        $box.="<a data-social='Linkedin' data-event='Share' class='linkedin-button' href='#' onclick=\"
                    window.open(
                    '\/\/www.linkedin.com\/shareArticle?url='+encodeURIComponent(location.href),
                    'share-dialog',
                    'height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
            <div id='liked_in_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/linked_in_share.png'>";
                if($params->get('show_count_box')){
                    $box.="<span id='liked_in_count_box'>$likedin_count</span>";
                }
            $box.="</div>
        </a>";
      }
            

            
      if($enable_twitter){
        $box_counter++;
        $box.="<a data-social='Twiter' data-event='Share' class='twiter-button' href='#' onclick=\"
                    window.open(
                    '\/\/twitter.com\/intent\/tweet?url='+encodeURIComponent(location.href),
                    'share-dialog',
                    'height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
            <div id='twitter_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/tweet_share.png'>";
                if($params->get('show_count_box')){
                    $box.="<span id='twitter_count_box'>$tweet_count</span>";
                }
            $box.="</div>
        </a>";
      }
            


            
      if($enable_vk){
        $box_counter++;
        $box.="<a data-social='VK' data-event='Share' class='vk-button' href='#' onclick=\"
                    window.open(
                    '\/\/vkontakte.ru\/share.php?url='+encodeURIComponent(location.href),
                    'share-dialog','height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
                    <div id='vk_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/vk.png'>";
                    if($params->get('show_count_box')){
                      $box.="<span id='vk_count_box'>$vk_count</span>";
                    }
                    $box.= "</div>
                </a>";
      }
            

            
      if($enable_tumblr){
        $box_counter++;
        $box.="<a data-social='Tumblr' data-event='Share' class='tumblr-button' href='#' onclick=\"
                    window.open(
                    '\/\/www.tumblr.com\/share?url='+encodeURIComponent(location.href),
                    'share-dialog','height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
                    <div id='tumblr_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/tumblr.png'></div>".
                    "</a>";
      }
            

            
      
      if($enable_pinterest){
        $box_counter++;
        $document->addScript('//assets.pinterest.com/js/pinit.js', 'text/javascript', false, true);
        $box.='<a class="pint_social" data-social="Pinterest" data-event="Pin" class="pin-button" data-pin-do="buttonPin"
                  href="//www.pinterest.com/pin/create/button/" data-pin-custom="true">
                    <img id="pinterest_img" src="'.JURI::Root().'/modules/mod_social_comments_sharing/images/pinit.jpg">'.
                '</a>';

      }
                  

            
      if($enable_instagram){
        $box_counter++;
        $instagram_user = str_replace('@', '', $params->get("instagram_user"));
        $box.="<a class='instagram-button' data-social='Instagram' data-event='Follow' href='#' onclick=\"
                    window.open(
                    '\/\/www.instagram.com\/".$instagram_user."\/?ref=badge',
                    'share-dialog','height='+Math.min(436, screen.availHeight)+
                    ',width='+Math.min(626, screen.availWidth)+
                    ',left='+Math.max(0, ((document.documentElement.clientWidth - 626)/2 + window.screenX))+
                    ',top='+Math.max(0, ((document.documentElement.clientHeight - 436)/2 + window.screenY)));
                    return false;\">
                    <div id='instagram_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/instagram.png'></div>".
                "</a>";
      }
            
      if($enable_add_this){
        $box_counter++;

        $box.="<a href='#' data-social='Add This' data-event='Share' class=\"addthis_button_more\" onclick='javascript:getAddThis(this)' addThisLoad='false'>
                  <div id='addthis_icon'><img src='".JURI::Root()."/modules/mod_social_comments_sharing/images/addthis-icon.png'>";
                  // if($params->get('show_count_box')){
                  //   $box.="<a class='addthis_counter addthis_bubble_style'></a>";
                  // }
        $box.="</div></a>";
      }    
        $box .= "</div>";
        echo $box;
  }
      //FB comments
      if ($enable_comments){
        $number_comments = $params->get('fb_number_comments');
        $comments_width = $params->get('fb_comments_width');
        $box_color = $params->get('fb_comments_box_color');
        $tmp ="<div class=\"fb-comments\"
                    data-href=\"$url_FB\"
                    data-width=\"$comments_width\"
                    data-numposts=\"$number_comments\"
                    data-colorscheme=\"$box_color\"></div>";
        $tmp= $tmp . PHP_EOL;
        $htmlCodeComBox.= "<div class=\"fb_comment_container\">$tmp</div>";
      }

      if($enable_page){
          $page_url = $params->get('fb_page_url');
          $page_width = $params->get('fb_page_width');
          $page_height = $params->get('fb_page_height');
          $page_tabs = $params->get('fb_page_tabs');
          
          $tmp = '<div class="fb-page" '
                  . 'data-href="'.$page_url.'" '
                  . 'data-tabs="'.$page_tabs.'" '
                  . 'data-width="'.$page_width.'" '
                  . 'data-height="'.$page_height.'">'
                  . '<blockquote cite="'.$page_url.'" '
                  . 'class="fb-xfbml-parse-ignore">'
                  . '<a href="'.$page_url.'"></a></blockquote></div>';
          $tmp= $tmp . PHP_EOL;
          
          $htmlFbPage .= "<div class=\"fb_page_container\">$tmp</div>";
      }
    


?>

<noscript>Javascript is required to use Joomla Social Comments and Sharing<a href="https://ordasoft.com/social-comments-share-joomla-module">Joomla Social Share</a>,
    <a href="https://ordasoft.com/social-comments-share-joomla-module">Joomla Social Comments and Sharing - share and comment on Joomla site to social media: Facebook, Twitter, LinkedI,Vkontakte, Odnoklassniki</a>
</noscript>
<div id="mainF">
    <div id="mainCom"> <?php echo $htmlCode; ?> </div>
    <div id="FbComBox"> <?php echo $htmlCodeComBox; ?> </div>
    <?php if($htmlFbPage)?>
    <div id="FbPage"> <?php echo $htmlFbPage; ?> </div>
</div>
<div style="text-align: center;"><a href="https://ordasoft.com/social-comments-share-joomla-module" style="font-size: 10px;">Joomla Social</a>by OrdaSoft!</div>
<!--               CSS for all block-->
<script>
    function facebookSend(elem){
        event.preventDefault();

        jQuerOs.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
              appId: '<?php echo $app_id; ?>',
              version: 'v7.0'
            });     
            FB.ui({app_id:'<?php echo $app_id; ?>',method: 'send', link: '<?php echo $url; ?>',},function(response) {})
          });

    }

    function getAddThis(elem){
        event.preventDefault();
        var addThisLoad = jQuerOs(elem).attr('addThisLoad');
        if(addThisLoad == 'false'){
            var addthisScript = document.createElement('script');
            addthisScript.setAttribute('src', '//s7.addthis.com/js/300/addthis_widget.js#domready=1')
            document.body.appendChild(addthisScript)

            jQuerOs(elem).attr('addThisLoad', 'true');

            addthisScript.onload = function() {
              setTimeout(addThisInit, 1000);
            };
        }

    }
    function addThisInit(){
        jQuerOs('.addthis_button_more').trigger('click')
    }
</script>

    