<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_JEXEC') or die('Restricted access');

$color1 = "#00517a";
$color2 = "#000000";
$color3 = "#00ff00";
$color4 = "#615861";
$color5 = "#a860a8";
$color6 = "#4f4f4f";
$color7 = "#00ff00";
$color8 = "#0a0a0a";
$color9 = "#D34034";
$color10 = "#D34034";

$style = "
		div#tp_filter_in div#jsjobs_object_jqueryautocomplete_left > a{border-left: 1px solid ".$color5.";}
		div#tp_filter_in div#jsjobs_object_jqueryautocomplete_left ul.jsjobs-input-list-jsjobs{border:1px solid ".$color5.";}
		div.js-jobs-jobs-applie div.resumeaction1ton{border-top: 1px solid ".$color5."; }
		span.jsjobs_appliedresume_tab span.jsjobs-applied-resume-field div.field-btn div.jsjobs-field-btn{border-top: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 {border-bottom:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button span a{color:".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-1{border-bottom:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-area-2 div.jsjobs-data-2-wrapper-jobsno{border:1px ".$color5." solid; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-data-area-2 div.jsjobs-comment-wrapper{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check  span.jsjobs-checkbox-gender{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check  span.jsjobs-checkbox-eduction{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check  span.jsjobs-checkbox-subcategory{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-right-area a.company-icon{border: 1px solid ".$color5.";}

		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist{border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap{border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-logo span.jsjobs-img-wrap{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-data div.jsjobs-data-wrapper span.jsjobs-job-main {border-bottom:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper span.jsjobs-img-sender span.jsjobs-img-area{border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults{ border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-image-area div.jsjobs-img-border{border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title {border-bottom:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-data-3-myresume{ border-bottom:1px ".$color5." solid;border-left:1px ".$color5." solid;border-right:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area  span.jsjobs-btn-save a{border:1px ".$color5." solid;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1{border-bottom: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-company-logo span.jsjobs-company-logo-wrap{border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-comoany-data div.js_job_data_wrapper{border-bottom:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper{ border: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap{border-bottom:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-left div.jsjobs-graph-wrp{border:1px ".$color5." solid;background-color: #FFFFFF;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-left div.jsjobs-graph-wrp span.jsjobs-graph-title{border-bottom:1px ".$color5." solid;background-color: #f6f6f6;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-right div.jsjobs-graph-wrp{border:1px ".$color5." solid;background-color: #FFFFFF;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-right div.jsjobs-graph-wrp span.jsjobs-graph-title{border-bottom:1px ".$color5." solid;background-color: #f6f6f6;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-adding-section span.js-sample-title{border:1px solid ".$color5."; background-color:#f6f6f6;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-adding-section div.js-adding-btn div.js-cp-employer-icon a{border:1px ".$color5." solid;background-color: #ffffff; color:#7d7b6d;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-suggested-jobs div.js-cp-wrap-resume-jobs{border:1px ".$color5." solid;background-color: #FFFFFF;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.js-cp-stats-panel span.js-sample-title{border:1px solid ".$color5."; background-color:#f6f6f6;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.js-cp-stats-panel div.js-adding-btn div.js-cp-employer-icon a{border:1px ".$color5." solid;background-color: #ffffff; color:  #7d7b6d;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobseeker-cp-wrapper div.js-cp-graph-area span.js-cp-graph-title{border:1px ".$color5." solid;background-color:#f6f6f6;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobseeker-cp-wrapper div.js-cp-graph-area div.jsjobs-cp-graph-area{  padding:0px; background-color:#FFFFFF;border:1px ".$color5." solid; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-categories div.jsjobs-cp-jobseeker-categories-btn span.js-cp-graph-title{border:1px ".$color5." solid;background-color:#f6f6f6;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-categories div.jsjobs-cp-jobseeker-categories-btn div.jsjobs-cp-jobseeker-category-btn div.js-cp-jobseeker-icon a{border:1px ".$color5." solid;background-color: #ffffff;color:#7d7b6d;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs{border: 1px ".$color5." solid;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs{border: 1px ".$color5." solid;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-stats span.js-sample-title{border:1px solid ".$color5."; background-color:#f6f6f6;} 
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-stats div.js-cp-jobseeker-stats div.js-cp-jobseeker-icon a{border:1px ".$color5." solid;   background-color: #ffffff; color:  #7d7b6d;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now span.stats_data_value{background: ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper{border: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values{border-bottom:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-package-data-detail span.jsjobs-package-values{border-bottom:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap{border-bottom: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a img{border-right:1px solid ".$color5." ;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper{  border: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values{border-bottom:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-package-data-detail span.jsjobs-package-values{border-bottom:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap{border-bottom: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a img{  border-right:1px solid ".$color5." ;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a img{  border-right:1px solid ".$color5." ;}
		div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.js_job_data_value{ border-right: 1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs-location-wrap{border-right: 1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area div.jsjobs-jobs-overview-area div.js_job_data_wrapper{border-bottom: 1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-map-wrap span.jsjobs-loction-wrap{border-bottom: 1px ".$color5." solid}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info div.jsjobs_full_width_data{border:1px solid ".$color5.";}
		table#js-table thead th:first-child{border-left:1px solid ".$color5.";}
		table#js-table tbody td{color: #444;  border:1px solid ".$color5.";border-left:0px;}

		div#js_menu_wrapper{border-bottom:7px solid ".$color1."; ?>;background:".$color2."; ?>;}
		div#js_menu_wrapper a.js_menu_link{color:".$color3."; ?>;}
		div#js_menu_wrapper a.js_menu_link:hover{background:".$color3."; ?>;color:".$color2."; ?>;}
		div#js_main_wrapper a.chosen-single{color:#000;}
		div#js_main_wrapper a,
		div#jsjobs_module a,div#jsjobs_modulelist_databar a,
		div.js_apply_loginform a{color:".$color2."; ?>;}
		div#js_main_wrapper a:hover,
		div#jsjobs_module a:hover,div#jsjobs_modulelist_databar a:hover,
		div.js_apply_loginform a:hover{text-decoration:none;}
		div#js_main_wrapper span.js_controlpanel_section_title{color:".$color8.";?>; border-bottom:2px solid".$color2.";?>;}
		div#tp_heading,
		div#jsjobs_modulelist_titlebar{border-bottom:2px solid ".$color2."; ?>;color:".$color2."; ?>}
		div.jsjobs-stats{background:".$color5."; ?>;border:1px solid ".$color2."; ?>; color:".$color2."; ?>;}
		div#js_main_wrapper a.js_controlpanel_link{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;}
		div#js_main_wrapper a.js_controlpanel_link:hover{border:1px solid ".$color2."; ?>;background:".$color3."; ?>;box-shadow:0px 0px 8px #abaeae;}
		div#js_main_wrapper a.js_controlpanel_link div.js_controlpanel_link_text_wrapper span.js_controlpanel_link_title{color:".$color6."; ?>}
		div#js_main_wrapper a.js_controlpanel_link:hover div.js_controlpanel_link_text_wrapper span.js_controlpanel_link_title{color:".$color2."; ?>}
		div#js_main_wrapper a.js_controlpanel_link div.js_controlpanel_link_text_wrapper span.js_controlpanel_link_description{color:".$color6."; ?>}
		div#js_main_wrapper span.js_column_layout{border:1px solid ".$color4."; ?>;background:".$color5."; ?>}
		div#js_main_wrapper span.js_column_layout:hover{background:".$color2."; ?>;box-shadow:0px 0px 8px #abaeae;}
		div#js_main_wrapper span.js_column_layout a{color:".$color6."; ?>;}
		div#js_main_wrapper span.js_column_layout a:hover{color:".$color3."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper{background:".$color3."; ?>;border:1px solid ".$color4."; ?>}
		div#jsjobs_module{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper span.js_coverletter_title{color:".$color6."; ?>}
		div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area span.js_coverletter_created{color:".$color4."; ?>;border-left:1px solid ".$color4."; ?>;border-right:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area a.js_listing_icon{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area a.js_listing_icon:hover{background:".$color2."; ?>;}

		div#js_main_wrapper div.js_job_company_logo{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_data_wrapper span.js_job_data_title{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;color:".$color6."; ?>;}
		div#js_main_wrapper div.js_job_data_wrapper span.js_job_data_value{border:1px solid ".$color4."; ?>;color:".$color6."; ?>;}
		div#js_main_wrapper a.js_job_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper a.js_job_button:hover{color:".$color3."; ?>;background:".$color2."; ?>;}
		div#js_main_wrapper div.js_job_share_pannel{background:".$color5."; ?>;border: 1px solid ".$color4."; ?>;}
		div#js_main_wrapper span#js_job_fb_commentheading{color:".$color3."; ?>;background:".$color1."; ?>;}
		div#js_main_wrapper div.js_message_button_area span.js_message_created{border-left:1px solid ".$color4."; ?>;border-right: 1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_message_button_area a.js_button_message{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_message_button_area a.js_button_message:hover{color:".$color3."; ?>;background:".$color2."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper.listcompany div.js_job_data_area div.js_listcompany_button a.js_listcompany_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper.listcompany div.js_job_data_area div.js_listcompany_button a.js_listcompany_button:hover{color:".$color3."; ?>;background:".$color2."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper span.stats_data_title{border-bottom:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper span.stats_data_value{border-bottom:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper span.stats_data_title.last-child{border-bottom:0px;}
		div#js_main_wrapper div.js_listing_wrapper span.stats_data_value.last-child{border-bottom:0px;}
		div#js_main_wrapper div.js_job_main_wrapper{border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div.js_job_filter_wrapper{border-bottom:2px solid ".$color2."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_image_wrapper{border: 1px solid ".$color5."; ?>; border-left:4px solid ".$color2."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_1{border-bottom:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper.listcompany div.js_job_data_area div.js_listcompany_button{border-left:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_1{border-bottom:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_5{border-top:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_1 span.js_job_title{background:none;color:".$color6."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_1 span.js_job_title{background:none;color:".$color6."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3{border-bottom:1px solid ".$color5."; ?>; border-top:none; }
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_comment_wrapper{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3{border-top:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.js_job_data_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.js_job_data_button:hover{color:".$color3."; ?>;background:".$color2."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.company_icon{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4 a.company_icon:hover{border:1px solid ".$color4."; ?>;background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_gold{background:#FFAB03;color:".$color3."; ?>;/* gold job background color */}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_featured{background:#00A0F6;color:".$color3."; ?>;/* featured job background color */}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_new{background:#7BBF00;color:".$color3."; ?>;/* new job background color */}
		div#js_main_wrapper span.js_controlpanel_section_title div.js_job_new{background:#7BBF00;color:".$color3."; ?>;/* new job background color */}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_number{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.publish{background:#45BD01;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.notpublish{background:#444442;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.expired{background:#A30903;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.rejected{background:#E22F27;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_publish.pending{background:#DF9500;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper span.stats_data_value.description{background:#ffffff;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_button input.js_job_button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper.paymentmethod span.payment_method_button input.js_job_button:hover{background:".$color2."; ?>;;color:".$color3."; ?>;}
		div#js_main_wrapper span.js_job_title span.js_job_message_subtitle.jobseeker{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper span.js_job_title span.js_job_message_subtitle.resume{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper span.js_job_title span.js_job_message_subtitle.message{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_message_subtitle span.js_job_message_jobseeker{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;}
		div#js_main_wrapper div.js_job_data_wrapper.button input.js_send_message_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_data_wrapper.button input.js_send_message_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_message_history_wrapper.yousend{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_message_history_wrapper.yousend div.js_job_message_right_top{background:".$color5."; ?>;border:1px solid ".$color4."; ?>;color:".$color6."; ?>;}
		div#js_main_wrapper div.js_job_message_history_wrapper.yousend div.js_job_message_left_top{background:".$color5."; ?>;border:1px solid ".$color4."; ?>;color:".$color6."; ?>;}
		div#js_main_wrapper div.js_job_message_history_wrapper.othersend{border:1px solid ".$color2."; ?>;}
		div#js_main_wrapper div.js_job_message_history_wrapper.othersend div.js_job_message_right_top{background:".$color2."; ?>;color:".$color3."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_message_history_wrapper.othersend div.js_job_message_left_top{background:".$color5."; ?>;color:".$color6."; ?>;border:1px solid ".$color2."; ?>;}
		div#js_main_wrapper div.js_job_full_width_data{background:#ffffff;border:1px solid ".$color2."; ?>;}
		div#js_main_wrapper div#sortbylinks span a{background:".$color1."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div#sortbylinks span a.selected,
		div#js_main_wrapper div#sortbylinks span a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area a.applied_resume_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area a.applied_resume_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a.selected,
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a:hover{background:".$color3."; ?>;color:".$color2."; ?>;border:1px solid ".$color2."; ?>;border-bottom:0px;}
		div#js_main_wrapper div.fieldwrapper.view div.fieldtitle{background:".$color5."; ?>;color:".$color6."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.fieldwrapper.view div.fieldvalue{background:".$color3."; ?>;color:".$color6."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.idTabs span a{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;border-bottom:0px;}
		div#js_main_wrapper div.idTabs span a.selected,
		div#js_main_wrapper div.idTabs span a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.bottom{ border-top: 1px solid ".$color5.";?>; background:".$color3.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume div.js_job_data_2_wrapper span.heading{color:".$color8.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume div.js_job_data_2_wrapper span.text{color:".$color4.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper.folderresume{border-left:4px solid ".$color2."; ?>;}
		div#js_main_wrapper span.js_controlpanel_section_title span a{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper span.js_controlpanel_section_title span a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.fieldwrapper input#button.button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.fieldwrapper input#button.button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder span.js_job_data_2_created_myresume{color: ".$color4.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder span.jobtype{border-left: 1px solid ".$color5.";?>; border-right: 1px solid ".$color5.";?>; border-top: 1px solid ".$color5.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume div.js_job_data_2_wrapper a{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume div.js_job_data_2_wrapper a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume div.title{font-size:14px; font-weight:bold; color: ".$color2.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume span.js_job_data_2_created_myresume{color: ".$color4.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3.myresume_folder div.title{font-weight:bold; color: ".$color2.";?>;}
		div#js_main_wrapper div.js_job_form_wrapper div.js_job_form_value input[type=\"text\"]{color:".$color2."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_form_wrapper.button input.js_job_form_button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_form_wrapper.button input.js_job_form_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}

		div#js_jobapply_main_wrapper span.js_job_applynow_heading{background:".$color1."; ?>;border-bottom:5px solid ".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper span.js_job_applynow_heading{background:".$color1."; ?>;border-bottom:5px solid ".$color2."; ?>;color:".$color3."; ?>;}
		div.js_job_error_messages_wrapper{border:1px solid #B8B8B8;background:#FDFDFD;}
		div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper span.js_job_messages_main_text{color:#D30907;}
		div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper span.js_job_messages_block_text{background:#252429;color:#ffffff;}
		div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper div.js_job_messages_button_wrapper a.js_job_message_button{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div.js_job_error_messages_wrapper div.js_job_messages_data_wrapper div.js_job_messages_button_wrapper a.js_job_message_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#tp_filter_in div.js_job_filter_button_wrapper button.tp_filter_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#tp_filter_in div.js_job_filter_button_wrapper button.tp_filter_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#savesearch_form div.js_button_field input{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#savesearch_form div.js_button_field input:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#jsjobs_appliedresume_tab_search_data span.jsjobs_appliedresume_tab_search_data_text div.field input.button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#jsjobs_appliedresume_tab_search_data span.jsjobs_appliedresume_tab_search_data_text div.field input.button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_quick_view_wrapper a{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_quick_view_wrapper a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_4.myjob a{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_4.myjob a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_3_myjob_no a.applied_resume_button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_3.myjob div.js_job_data_3_myjob_no a.applied_resume_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper span.js_controlpanel_section_title span.js_apply_view_job{border:1px solid ".$color2."; ?>;color:".$color4."; ?>;}
		div#map{background:#FFFFFF;border:1px solid ".$color4."; ?>;}
		div#closetag a{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#closetag a:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#jl_pagination{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;}
		span#jsjobs_module_heading{border-bottom:1px solid ".$color4."; ?>;}
		div#jsjobs_modulelist_databar{background:".$color5."; ?>;border:1px solid ".$color4."; ?>;}
		div.js_listing_wrapper.paymentmethod.text-center input.jsjobs_button{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div.js_listing_wrapper.paymentmethod.text-center input.jsjobs_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js_listing_wrapper div.js_message_title.job_message{border-right:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div.fieldwrapper div.fieldtitle,
		div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area,
		div#js_main_wrapper div.js_job_full_width_data,
		div#js_main_wrapper div.js_listing_wrapper,div#jsjobs_module,div#jsjobs_modulelist_databar{color:".$color6."; ?>;}
		div#personal_info_data div.resume_photo{background:".$color5."; ?>;border:1px solid ".$color4."; ?>;}
		div#jsjobs_apply_visitor{border:1px solid ".$color4."; ?>;}
		div#jsjobs_apply_visitor div.js_apply_loginform div.js_apply_login_30 input.js_apply_button{background:".$color7."; ?>;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div#jsjobs_apply_visitor div.js_apply_loginform div.js_apply_login_30 input.js_apply_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		
		@media all and (max-width: 481px) {
			div#js_menu_wrapper a.js_menu_link{border-bottom:2px solid ".$color3."; ?>;}
			div#js_main_wrapper div.js_listing_wrapper span.js_coverletter_title{border-bottom:1px solid ".$color4."; ?>;}
			div#js_main_wrapper div.js_listing_wrapper div.js_coverletter_button_area span.js_coverletter_created{border:none;border-bottom:1px solid ".$color4."; ?>;}
			div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_2.myresume.first-child{border-right:0px;}
			div#js_main_wrapper div.js_listing_wrapper span.js_job_message_title{border-bottom:1px solid ".$color4."; ?>;}
			div#js_main_wrapper div.js_message_button_area span.js_message_created{border:0px;border-bottom:1px solid ".$color4."; ?>;}
			div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_4.mycompany{border-top:1px solid ".$color4."; ?>;}
			div#js_main_wrapper div.js_job_main_wrapper div.js_job_data_area div.js_job_data_3 div.js_job_data_4{border-top:1px solid ".$color4."; ?>;}
			div#js_main_wrapper div.js_job_main_wrapper.listcompany div.js_job_data_area div.js_listcompany_button{border-top:1px solid ".$color4."; ?>;}
		}    
		
		<?php /* New code for job shortlist designs */ ?>
		div#shortlistPopup.shortlistPopup{background:".$color3."; ?>;}
		div#shortlistPopup div#shortlist_headline{background:".$color1."; ?>;color:".$color3."; ?>;border-bottom:5px solid ".$color2."; ?>;}
		div#addtoshortlist div.jsjobs-container-small{border-bottom: 2px solid ".$color2."; ?>;}
		div#addtoshortlist div#shortlist_btn_margin input[type=\"button\"].js_job_shortlist_button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#addtoshortlist div#shortlist_btn_margin input[type=\"button\"].js_job_shortlist_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		<?php /* New code for coverletter popup designs */ ?>
		div#coverletterPopup.coverletterPopup{background:".$color3."; ?>;}
		div#coverletterPopup div#coverletter_headline{background:".$color1."; ?>;color:".$color3."; ?>;border-bottom:5px solid ".$color2."; ?>;}
		div#coverletterPopup div#coverletter_title{border-bottom:1px solid ".$color8."; ?>;}
		div#coverletterPopup div#coverletter_description{border-bottom:1px solid ".$color8."; ?>;}
		div#coverletterPopup.coverletterPopup div.fieldwrapper.fullwidth input[type=\"button\"].js_job_cletter_popup_button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#coverletterPopup.coverletterPopup div.fieldwrapper.fullwidth input[type=\"button\"].js_job_cletter_popup_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div.js-resume-section-title{background:".$color1."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div div.js-resume-section-title{background:".$color3."; ?>;color:".$color8."; ?>;border-bottom:2px solid ".$color1."; ?>;}
		div#js_main_wrapper div div.js-resume-section-title img.jsjobs-resume-section-image{background:".$color2."; ?>;}
		div#js_main_wrapper div.resume-section-no-record-found{background:#ffffff;color:".$color8."; ?>;border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body{background:".$color3."; ?>;border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-field-container{color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div.js-resume-checkbox-container{color:".$color4."; ?>;border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.upload-field{border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.files-field{border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.files-field div.selectedFiles span.selectedFile{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div.uploadedFiles{border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div.uploadedFiles span.selectedFile{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div div.filesList{border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div div.filesList ul li.selectedFile{border:1px solid ".$color4."; ?>;background:".$color5."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div div.filesList a.zip-downloader{background:".$color2."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container span.upload_btn{border:1px solid ".$color5."; ?>;background:".$color6."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.upload-field:hover span.upload_btn{background:".$color2."; ?>;color:".$color3."; ?>;border:1px solid ".$color2."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container div.files-field:hover span.upload_btn{background:".$color2."; ?>;color:".$color3."; ?>;border:1px solid ".$color2."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-field-container ul{border:1px solid ".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-show-hide-btn span{border:1px solid ".$color5."; ?>;background:".$color6."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-show-hide-btn span:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.loc-field a.map-link{border:1px solid ".$color5."; ?>;background:".$color6."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.loc-field a.map-link:hover{background:".$color2."; ?>;color:".$color3."; ?>;border:1px solid ".$color2."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-submit-container{border-top:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-submit-container button{background:".$color3."; ?>;border:1px solid ".$color5."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body form div div.js-resume-submit-container button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_main_wrapper div div.js-resume-section-view{color:".$color3."; ?>;}
		div#js_main_wrapper div div#js-resume-section-view div.js-resume-section-view{background:#FFFFFF;border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div.js-resume-section-view div.js-resume-profile div img.avatar{border:1px solid ".$color5."; ?>;box-shadow:0px 0px 10px #999;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div.js-row{border-bottom:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div.js-row:last-child{border-bottom:0px;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div div.js-resume-profile-name{color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div.profile-name-outer{border-bottom:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div.js-resume-profile-email{color:".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-profile-info div.js-resume-profile-cell{color:".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div div.js-resume-data-title{color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-section-view div.js-resume-data div div.js-resume-data-value{color:".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view{border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.addressheading{border-bottom:2px solid ".$color2."; ?>;background:".$color3."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.addressvalue{border-bottom:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div span.addressDetails{color:".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div#editorView div span{color:".$color9."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div span.sectionText{color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.map-toggler{background:".$color3."; ?>; border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-address-section-view div.map-toggler span{color:".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.add-resume-address a{color:".$color1."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.add-resume-form a{color:".$color8."; ?>;border:1px solid ".$color5."; ?>;background:".$color6."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view{border:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-resume-data-head{background:".$color3."; ?>;border-bottom:2px solid ".$color1."; ?>;color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div div.js-resume-data-title{color:".$color8."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div div.js-resume-data-value{color:".$color4."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-row{border-bottom:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view form.jsautoz_form div.js-row{border-bottom:0px;padding:0px;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-row:last-child{border-bottom:0px;}
		div#js_main_wrapper div div.js-resume-section-body div div#editorView div.resumeditor{border:1px solid ".$color5."; ?>;background:#ffffff;}
		div#js_main_wrapper div div.js-resume-section-body div form.jsautoz_form{width:96%;margin:0 2%;background:#ffffff;border:1px solid ".$color5."; ?>;margin-bottom:20px;}
		div#js_main_wrapper div div.js-resume-section-body div form.jsautoz_form.editform{width:100%;border:0px;margin:0px;}
		div#js_main_wrapper div div.js-resume-section-body div form.jsautoz_form div.jsjobsformheading{width:94%;margin:0 3%;padding:5px 5px;background:".$color3."; ?>;border:1px solid ".$color5."; ?>;border-bottom:2px solid ".$color1."; ?>;font-weight:bold;margin-bottom:20px;}
		div#js_main_wrapper div div.js-resume-section-body div div.js-resume-data-section-view div.js-resume-data-head{border-bottom:2px solid ".$color1."; ?>;}
		<?php /* Resume Form file popup designs */ ?>
		div#resumeFilesPopup.resumeFilesPopup{background:".$color3."; ?>;}
		div#resumeFilesPopup div#resumeFiles_headline{background:".$color1."; ?>;color:".$color3."; ?>;border-bottom:5px solid ".$color2."; ?>;}
		div#resumeFilesPopup div.chosenFiles_heading{border-bottom:1px solid ".$color2."; ?>;color:".$color8."; ?>}
		div#resumeFilesPopup div.filesInfo{border-bottom:1px solid ".$color2."; ?>;}
		div#resumeFilesPopup div.fileSelectionButton span.fileSelector{border:1px solid ".$color5."; ?>;background:".$color6."; ?>;color:".$color8."; ?>;}
		div#resumeFilesPopup div.fileSelectionButton:hover span.fileSelector{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#resumeFilesPopup div.resumeFiles_close span{border:1px solid ".$color5."; ?>;background:".$color6."; ?>;color:".$color8."; ?>;}
		div#resumeFilesPopup div.resumeFiles_close span:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#resumeFilesPopup div.filesInfo div.chosenFiles div.hoverLayer span.deleteChosenFiles{border:1px solid ".$color2."; ?>;background:".$color7."; ?>;color:".$color8."; ?>;}
		div#resumeFilesPopup div.filesInfo div.chosenFiles div.hoverLayer span.deleteChosenFiles:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#resumeFilesPopup div.filesInfo div.chosenFiles div.hoverLayer{border:1px solid ".$color2."; ?>;}
		div.js_job_messages_button_wrapper a.js_job_message_button{border:1px solid ".$color4."; ?>;background:".$color7."; ?>;color:".$color8.";?>;}
		div.js_job_messages_button_wrapper a.js_job_message_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js-jobs-old-experience span.experience{border:1px solid ".$color5."; ?>;}
		div#js-jobs-wrapper{border: 1px solid ".$color5.";?>; color: ".$color4.";?>;}
		div#js-jobs-wrapper div.js-toprow div.js-image img{border: 1px solid ".$color1.";?>;border-left: 4px solid ".$color1.";?>;}
		div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row{border-bottom: 1px solid ".$color5.";?>;}
		div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row span.js-title a{text-decoration:none;color: ".$color1."; ?>;}
		div#js-jobs-wrapper div.js-toprow div.js-data div.js-first-row span.js-jobtype span.js-type{border: 1px solid ".$color5.";?>; border-bottom: none;background: ".$color3."; ?>;}
		div#js-jobs-wrapper div.js-toprow div.js-data div.js-second-row div.js-fields span.js-totaljobs{border: 1px solid ".$color5.";?>;background: ".$color3."; ?>;}
		div#js-jobs-wrapper div.js-bottomrow{border-top: 1px solid ".$color5.";?>;background: ".$color3."; ?>; color: ".$color4.";?>;}
		div#js-jobs-wrapper div.js-bottomrow div.js-actions a.js-button{border: 1px solid ".$color5.";?>;background: ".$color6."; ?>;}
		div#js-jobs-wrapper div.js-bottomrow div.js-actions a.js-btn-apply{background: ".$color1."; ?>; color: ".$color7.";?>;}
		div#jsjobs-wrapper div.page_heading{color:".$color8."; ?>;border-bottom:2px solid ".$color2."; ?>;}

		div#tellafriend.tellafriend{background:#FFFFFF;border:1px solid ".$color4."; ?>;}
		div#tellafriend.tellafriend div#tellafriend_headline{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#tellafriend.tellafriend div.fieldwrapper.fullwidth input[type=\"button\"].js_job_tellafreind_button{background:".$color7."; ?>;border:1px solid ".$color4."; ?>;color:".$color8."; ?>;}
		div#tellafriend.tellafriend div.fieldwrapper.fullwidth input[type=\"button\"].js_job_tellafreind_button:hover{background:".$color2."; ?>;color:".$color3."; ?>;}


		div#jsjobs-cat-block a#jsjobs-cat-block-a{border:1px solid ".$color5."; ?>; background: ".$color3.";?>; color: ".$color4."; ?>;}
		div#for_subcat div.jsjobs_subcat_wrapper{border:1px solid ".$color5."; ?>; background: ".$color7.";?>;}
		div#for_subcat a#jsjobs-subcat-block-a{border:1px solid ".$color5."; ?>; background: ".$color3.";?>; color: ".$color4."; ?>;}

		div#jsjobs_subcatpopups a#jsjobs-subcat-popup-a{border:1px solid ".$color5."; ?>; background: ".$color3.";?>; color: ".$color4."; ?>;}

		div#js_jobs_main_popup_area div#js_jobs_main_popup_head{background:".$color2."; ?>;color:".$color3."; ?>;}
		div#js_jobs_main_popup_area div#jspopup_work_area {border: 1px solid ".$color5."; ?>;}

		span.jsjobs_job_in_formation{border-bottom:3px solid ".$color2."; ?>;}

		div#js_main_wrapper div.js_job_data_jobapply{border-bottom:1px solid ".$color5."; ?>;}
		div#js_main_wrapper div.js_job_data_jobapply span.js_job_data_apply_title{}
		div#js_main_wrapper div.js_job_data_jobapply span.js_job_data_apply_value{}

		div#jsquickview_wrapper1{background: ".$color3."; ?>; border-bottom: 2px solid ".$color5."; ?>;}
		div#jsquickview_block_bottom div#jsquick_view_title{background: ".$color3."; ?>; border-bottom: 3px solid ".$color2."; ?>;}
		div#jsquickview_block_bottom div.jsquick_view_rows{border-bottom:1px solid ".$color5."; ?>;}
		div#jsquickview_block_bottom div.jsquickview_decs{border: 1px solid ".$color5."; ?>;}
		div.js_job_form_quickview_wrapper a.jsquick_view_btns{border: 1px solid ".$color5."; ?>;background: ".$color3."; ?>;color: ".$color5."; ?>;}
		div.js_job_form_quickview_wrapper a.applynow{background: ".$color2."; ?>;color: ".$color7."; ?>;}

		div#jsjobs-shortlist_btn_margin input.js_job_shortlist_button{color:".$color7.";?>; background:".$color2.";?>;}

		div.js_job_form_quickview_wrapper a.applynow:hover{border: 1px solid ".$color5."; ?>;background: ".$color3."; ?>;color: ".$color5."; ?>;}
		div.js_job_form_quickview_wrapper a.jsquick_view_btns:hover{background: ".$color2."; ?>;color: ".$color7."; ?>;}

		div#for_subcat span#showmore_p {background: ".$color1.";?>; color: ".$color7."; ?>;}

		div#jsjobs-main-wrapper form#adminForm input.jsjobs_button{border:1px solid ".$color2.";?>;background:".$color1.";?>; color:".$color7.";?>;}

		div#jsjobs_jobs_pagination_wrapper{background: ".$color3.";?>;border:1px solid ".$color5."; ?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area a{border: 1px solid ".$color5.";?>; border-left: 2px solid ".$color1.";?>}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-image-area a{border: 1px solid ".$color5.";?>; border-left: 2px solid ".$color1.";?>}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-3 span.jsjobs-data-location-value{color: ".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.com-logo a.img{border: 1px solid ".$color5."; ?>;border-left: 2px solid ".$color1.";?>;}
		div#jsjobs-main-wrapper span.jsjobs-main-page-title{color:".$color8.";?>;border-bottom:2px solid ".$color1.";?>;}
		div#jsjobs-main-wrapper span.jsjobs-btn{border:1px solid".$color10.";?>;}
		div#jsjobs-main-wrapper span.jsjobs-btn a{color:".$color10.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-field-wrapper div.jsjobs-value input#title{background:".$color3.";?>; }
		div#jsjobs-main-wrapper a.jsjobs-add-cover-btn{background:".$color6.";?>;color:".$color8.";?>; border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper span.jsjobs-add-cover-btn a{color:".$color8.";?>;}
		div#jsjobs-main-wrapper{background:".$color7.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-field-wrapper div.jsjobs-value textarea#description{background:".$color3.";?>; }
		div#jsjobs-main-wrapper div#btn input#button{background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-form-button-wrapper{color:".$color8.";?>;border-top:2px solid ".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area{background:".$color3.";?>;border:1px solid ".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created{color:".$color4.";?>;border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area span.jsjobs-edit-icon{background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-image-area div.jsjobs-image-wrapper-mycompany div.jsjobs-image-border{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a.jsjobs-resumes-edit-btn{background:".$color6.";?>; border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a.jsjobs-resumes-view-btn{background:".$color6.";?>; border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a.jsjobs-resumes-delete-btn{background:".$color6.";?>; border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a.jsjobs-resumes-featured-btn{border:1px solid<?php echo$color5;?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn a.jsjobs-resumes-gold-btn{border:1px solid<?php echo$color5;?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname span.jsjobs-fulltime-btn{ color:".$color4.";?>; border:1px solid <?php ".$color4.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname span.jsjobs-titleresume{color:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname span.jsjobs-date-created{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-application-title{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-emailaddress span.jsjobs-emailaddress-color{ color:".$color8.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-image-area div.jsjobs-image-wrapper{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn {border:1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-emailaddress span.jsjobs-address{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-salary-value{color:".$color4.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-content-shortlist-area div.jsjobs-data-1 span.jsjobs-posted{border:1px solid ".$color5.";?>; border-bottom:none; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-totexprience span.jsjobs-totalexpreience-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename span.jsjobs-categoryjob span.jsjobs-valuecategory{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#sortbylinks{background:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_share_pannel_fb{border:1px solid ".$color5.";?>; color: ".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listresume div.jsjobs-main-wrapper-resumeslist div.jsjobs-main-resumeslist div.jsjobs-image-area a.logo_a{border:1px solid ".$color5.";?>;border-left:4px solid ".$color1.";?>; }
		div#jsjobs-main-wrapper div#sortbylinks span.my_resume_sbl_links a:hover{background:".$color1.";?>;}
		div#jsjobs-main-wrapper div#sortbylinks span.my_appliedjobs_sbl_links a:hover{background:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn span.jsjobs-noofjob-value{background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-image-area div.jsjobs-image-wrapper{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn a:hover{color:".$color7.";?>; background:".$color1.";?>; border:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn-tablet a:hover{color:".$color7.";?>; background:".$color1.";?>; border:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn{background:".$color3.";?>; border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn a{color:".$color8.";?>; background:".$color6.";?>; border:1px solid".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist-btn div.jsjobs-data-btn-tablet a{color:".$color8.";?>; background:".$color6.";?>; border:1px solid".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-data-1 span.jsjobs-posted-days{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-data-1 span.jsjobs-posted{border:1px solid".$color5.";?>;color:".$color4.";?>;background:".$color3.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area div.js-job-image-wrapper-boder{border-left:3px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue input.inputbox-required{border:1px solid".$color5.";?>; background:".$color3.";?>; color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper-btn{border-top:2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper-btn div.jsjobs-folder-info-btn span.jsjobs-folder-btn input{border:1px solid".$color5.";?>;color:".$color7.";?>;background:".$color3.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist{ border:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-4 a.company-icon{border:1px solid".$color5.";?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-4 a.company-icon-gold{border:1px solid".$color5.";?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn div.jsjobs-data-4 a.company-icon-featured{border:1px solid".$color5.";?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist-btn {border:1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-image-area div.jsjobs-image-area-boder {border-left:3px solid".$color1.";?>; border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-right-area a{border:1px solid".$color5.";?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-right-area a.applied_resume_button_no{border:1px solid".$color5.";?>;background:".$color1.";?>; color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn{background:".$color3.";?>;border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;border-bottom:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1 span.jsjobs-jobs-types{border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;border-top:1px solid".$color5.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-3-myjob-no span.jsjobs-noof-jobs {border:1px solid".$color5.";?>;background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1 span.jsjobs-posted{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.js_job_data_2_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.js_job_data_2_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn div.jsjobs-data-myjob-left-area span.js_job_data_location_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#sortbylinks span.my_myjobs_sbl_links a:hover{color:".$color7.";?>;background:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area a{border:1px solid".$color5.";?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-coverletter-title span.jsjobs-coverletter-created{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist {background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-category-status span.jsjobs-listing-title-child span.jsjobs-company{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-btn a {background:".$color6.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders{background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-fieldwrapper div.jsjobs-fieldvalue input{background:".$color3.";?>;border:1px solid".$color5.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjsobs-resumes-btn a.jsjobs-savesearch-btn{background:".$color6.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created {border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-resumesearch-list span.jsjobs-coverletter-title{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-resumesearch-list{background:".$color3.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-resumes-by-category a span.jsjobs-category-title{color:".$color4.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-resumes-by-category a {color:".$color4.";border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-resumes-by-category a:hover{color:".$color1.";?>;border:1px solid".$color1.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn a{background:".$color6.";?>;border:1px solid".$color5.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list{background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs_message_title span.jsjobs_message{color:".$color8.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs_message_title {color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle span.jsjobs-message-created {color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-company a{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs_message_title-vlaue span.jsjobs_message{color:".$color8.";?>;} 
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs_message_title-vlaue {color:".$color4.";?>;} 
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message {background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-value input {background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-logo span.jsjobs-img-wrap span.jsjobs-img-border{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper-bitton input {background:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list span.jsjobs-controlpanel-section-title {background:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper span.jsjobs-img-sender span.jsjobs-img-area span.jsjobs-img-area-wrap{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper div.jsjobs-message-right-top span.jsjobs-message-name {background:".$color1.";border:1px solid".$color5.";border-left:1px solid".$color1.";color:".$color7.";}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper{background:".$color3.";?>;color:".$color4.";?>;border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div#sortbylinks ul li a{ display:inline-block;padding:5px;color:#fff; text-decoration:none;}
		div#jsjobs-main-wrapper div#savesearch-form{border-bottom:2px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-data-3-myresume span.jsjobs-view-resume a{background:".$color1.";?>;color:".$color7.";border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title span.jsjobs-name-title {color:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title span.jsjobs-jobs-types{background:".$color3.";?>;color:".$color4.";border-right:1px solid ".$color5.";border-top:1px solid ".$color5.";border-left:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper-title span.jsjobs-posted{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-data-area div.jsjobs-data-2-wrapper{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-image-area div.jsjobs-image-wrapper{border-left:3px solid".$color1.";?>;} 
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button span.jsjobs-viewalljobs-btn a{color:".$color4.";?>;background:".$color6.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-image-area div.jsjobs-image-wrapper span.jsjobs-image-wrap{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div#sortbylinks ul li a:hover{ color:".$color7.";?>;background:".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area div.jsjobs-coverletter-button-area div.jsjobs-icon a  {background:".$color6.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area span.jsjobs-coverletter-title  {color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-data-jobtitle-title span.jsjobs-data-jobtitle {color:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button{background:".$color3.";?>;color:".$color4.";?>;border-right:1px solid".$color5.";?>;border-bottom:1px solid".$color5.";?>;border-left:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 span.jsjobs-data-2-value{color:".$color4.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-2 span.jsjobs-data-2-title{color:".$color8.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-posted { color:".$color4.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-jobstypes {color:".$color4.";?>;border:1px solid".$color5.";?>; background:".$color3.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn span.jsjobs-resume-btn a{color:".$color8.";border:1px ".$color5." solid;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save {background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save span.jsjobs-coverletter-title { color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-coverletter-created{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-btn-save a{background:".$color6.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area div.js-job-image-wrapper{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue input{background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-image-area div.jsjobs-image-area-boder div.jsjobs-image-wrapper{border-left:3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-1{border-bottom:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-title{color:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-1 span.jsjobs-posted{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-2-wrapper span.jsjobs-data-2-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-gender{background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-location{background:".$color3.";?>;color:".$color4.";?>;border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-eduction {background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-eduction {background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-check span.jsjobs-checkbox-subcategory{background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue-radio-button div#resumeapplyfilter span.jsjobs-radio-email-me {background:".$color3.";?>;color:".$color4.";border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper-btn span.jsjobs-save-formjobs input{background:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist-btn a.applied-resume-button-no{background:".$color1.";?>;color:".$color7.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper-btn div.jsjobs-folder-info-btn span.jsjobs-folder-btn input.button{background:".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-jobstyoes-maain a.jsjobs-job-types{background:".$color7.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-jobstyoes-maain a:hover{background:".$color7.";?>;color:".$color4.";?>;border:1px solid".$color1.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-jobstyoes-maain a:hover span{background:".$color7.";?>;color:".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-cat-data-wrapper a.jsjobs-cat-blocka{background:".$color7.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-cat-data-wrapper a:hover{background:".$color7.";?>;color:".$color4.";?>;border:1px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-cat-data-wrapper a:hover span.jsjobs-cat-counter{background:".$color7.";?>;color:".$color1.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-field-wrapper-title div.jsjobs-value input#title {background:".$color3.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-field-wrapper-description div.jsjobs-value textarea#description {background:".$color3.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue span.jsjobs-mapvalue span.jsjobs-get-btn div#coordinatebutton input{background:".$color7.";?>;border:1px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.fieldwrapper div.fieldvalue textarea{background:".$color3.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a{ background:".$color6.";?>;color:".$color8.";?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a:hover{ background:".$color1.";?>;color:".$color7.";?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container a.selected{ background:".$color1.";?>;color:".$color7.";?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container{border-bottom: 1px solid".$color1.";?>;  }
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container div#jsjobs_appliedresume_action_allexport a#jsjobs-expot-all-btn{background:".$color3.";?>;color:".$color8.";?>;border:1px solid".$color5.";?>;}
		div#js_main_wrapper div#jsjobs_appliedapplication_tab_container div#jsjobs_appliedresume_action_allexport a#jsjobs-expot-all-btn:hover{background:".$color1.";?>;color:".$color7.";?>;border:1px solid".$color1.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area div.js_job_image_wrapper{border: 2px solid".$color1.";?>; }
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area div.js_job_image_wrapper img.js_job_image{border: 1px solid".$color5.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area a.view_resume_button{background:".$color1.";?>;color:".$color7.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_image_area div.view_coverltr_button{border:1px solid".$color1.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1 span.js_job_title{color:".$color1.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1 span.js_job_posted span.js_jobapply_title{color:".$color8.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_1 span.js_job_posted span.js_jobapply_value{color:".$color4.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_2 div.jsjobsapp_wrapper span.jsjobs-apptitle{color:".$color8.";?>;}
		div#js_main_wrapper div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_2 div.jsjobsapp_wrapper span.jsjobs-appvalue{color:".$color4.";?>;}
		div.js-jobs-jobs-applie div.js_job_data_area div.js_job_data_2 div.appnotes_wrapper span.jsjobs-appnotesvalue{border: 1px solid".$color5.";?>;background:".$color3.";?>;color:".$color4.";?>; }
		div.js-jobs-jobs-applie div.js_job_data_5{border-top: 1px solid".$color5.";?> ; background:".$color3.";?>;}
		div.js-jobs-jobs-applie div.js_job_data_5 div.jsjobs_appliedresume_action{border: 1px solid".$color5.";?> ; background:".$color6.";?>;}
		div#jsjobs_appliedresume_tab_search_data{border-bottom:1px solid".$color1.";?>;}
		span.jsjobs_appliedresume_tab span.jsjobs-applied-resume-field div.field-btn div.jsjobs-field-btn input{background:".$color1.";?>;border: 1px solid".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-name{border-bottom:1px solid".$color5.";?> ;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-name span.jsjobs-company-title {color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-data-wrapper-email-location span.jsjob-data-value-email{color:".$color1.";?>;border-right:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-data-wrapper-email-location span.jsjobs-location-comapny {color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-name div.jsjobs-full-width-data{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-comoany-data div.js_job_data_wrapper span.js_job_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-comoany-data div.js_job_data_wrapper span.js_job_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-company-logo span.jsjobs-company-logo-wrap span.jsjobs-left-border{border-left:5px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.js_job_apply_button a{border:1px solid".$color5.";?>;color:".$color8.";?>;background:".$color6.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.js_job_apply_button a:hover{border:1px solid".$color5.";?>;color:".$color7.";?>;background:".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.js_job_apply_button {border-top:2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper span.jsjobs-main-page-title span.jsjobs-add-resume-btn a.jsjobs-resume-a{border:1px solid".$color5.";?>;color:".$color8.";?>;background:".$color6.";?>;}
		div#jsjobs-main-wrapper span.jsjobs-main-page-title span.jsjobs-title-componet{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest{border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-image-area img.js-cp-imge-user{border: 1px solid".$color5.";?>;border-left:3px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-content-area div.js-cp-company-title{border-bottom:1px solid".$color5.";?>;color:".$color8.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-content-area div.js-cp-company-location{color:".$color4.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied{border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-image-area img.js-cp-imge-user{border: 1px solid".$color5.";?>;border-left:3px solid".$color1.";?>;  }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-title{border-bottom:1px solid".$color5.";?>;color:".$color1.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-location{color:".$color4.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-email span.jsjobs-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-email span.jsjobs-value {color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-catagory span.jsjobs-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-content-area div.js-cp-company-catagory span.jsjobs-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied-lower span.jsjobs-location{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-suggested-jobs div.js-cp-wrap-resume-jobs div.js-cp-jobs-wrap div.js-cp-jobs-sugest{border:1px solid".$color5.";?>;  }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied-lower{background:".$color3.";?>;border:1px solid ".$color5.";}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-suggested-jobs div.js-cp-wrap-resume-jobs div.js-cp-jobs-wrap div.js-cp-jobs-sugest div.js-cp-image-area img.js-cp-imge-user{border: 1px solid".$color5.";?> ;border-left:3px solid".$color1.";?>;   }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-suggested-jobs div.js-cp-wrap-resume-jobs div.js-cp-jobs-wrap div.js-cp-jobs-sugest div.js-cp-content-area div.js-cp-company-title{border-bottom: 1px solid".$color5.";?>;color:".$color8.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-message-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-created{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-suggested-jobs div.js-cp-wrap-resume-jobs div.js-cp-jobs-wrap div.js-cp-jobs-sugest div.js-cp-content-area div.js-cp-company-location{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume{border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-image-area img.js-cp-imge-user{border: 1px solid".$color5.";?>;border-left:3px solid".$color1.";?>;   }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-content-area div.js-cp-company-title{border-bottom: 1px solid".$color5.";?>; color:".$color1.";?>;  }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-company-location{color:".$color4.";?>; }
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-company-email-address span.jsjobs-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-company-email-address span.jsjobs-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-company-category span.jsjobs-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-company-category span.jsjobs-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume-lower{background:".$color3.";border:1px solid ".$color5.";border-top:none}
		div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume-lower span.jsjobs-loction{color:".$color4.";?>;}

		div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-data span.js_job_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-data span.js_job_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-description span.js_controlpanel_section_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-description span.js_job_full_width_data{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-data-wrapper div.jsjobs-view-letter-data{border-bottom:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist{ border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail-gold-featured span.jsjobs-package-values span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-package-data-detail-gold-featured span.jsjobs-package-values span.stats_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button{background:".$color3.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button span.jsjobs-view-btn a{background:".$color7.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a{background:".$color1.";?>;color:".$color7.";?>;border:1px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-image-area div.jsjobs-image-boder{border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-1{border-bottom:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-coverletter-title{border-bottom:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-left span.jsjobs-category-status span.jsjobs-listing-title-child span.jsjobs-title-status{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area{border-left:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders{border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfon div.jsjobs-listfolders div.jsjobs-status-button span.jsjobs-message-created{border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list{border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-title span.jsjobs-messages-covertitle{border-bottom:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn{ border-left: 1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-main-resumeslist{border:1px  solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-image-area div.jsjobs-image-wrapper{border:1px  solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-data-area div.jsjobs-data-titlename div.jsjobs-applyname{border-bottom:1px  solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany{border:1px solid".$color5.";?>;background:#fff;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-image-area div.jsjobs-image-wrapper-mycompany{ border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-data-jobtitle-title{border-bottom:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-data-area div.jsjob-data-1 span.jsjobs-listcompany-website{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist{border:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-image-area div.jsjobs-image-boder{border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-1 {border-bottom:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-appliedjobslist-btn{border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save{border:1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-jobs-save div.jsjobs-cover-button-area span.jsjobs-coverletter-created {border-left: 1px solid".$color5.";?>;  border-right: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-myresume-btn span.jsjobs-resume-loction{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.fieldwrapper-btn{border-top:2px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-jobsalertinfo-save-btn{border-top:2px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-listcompany-button span.jsjobs-viewalljobs-btn a:hover{background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-main-wrapper div.jsjobs-listing-area span.jsjobs-coverletter-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail span.jsjobs-package-values span.stats_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail-gold-featured span.jsjobs-package-values span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-package-data-detail-gold-featured span.jsjobs-package-values span.stats_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button{background:".$color3.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-view-btn a{background:".$color7.";?>;color:".$color4.";?>;border:1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a{background:".$color1.";?>;color:".$color7.";?>;border:1px solid".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title{border: 1px solid".$color5.";?>; border-bottom:2px solid".$color1.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.jsjobs-package-price span.stats_data_value{background:".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.stats_data_value{background:".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.jsjobs-package-name{background:".$color3.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now{border: 1px solid".$color5.";?>; border-bottom:2px solid".$color1.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now span.jsjobs-package-price span.stats_data_value{background:".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now span.jsjobs-package-name{background:".$color3.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.js-job-title{background:".$color8.";?>; border:1px solid".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.js-job-title span.js-job-package-price span.stats_data_value{border-left: 1px solid".$color1.";?>;border-right: 1px solid".$color1.";?>;color:".$color7.";?>;background:".$color1.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data span.js-job-title span.js-job-package-title{color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper span.stats_data_value{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper span.jsjobs-description span.stats_data_descrptn-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper span.jsjobs-description span.stats_data_descrptn-value{color:".$color4.";?>;border: 1px solid".$color5.";?>;background:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper{border: 1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper span.stats_data_title{border-bottom: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper span.stats_data_value{border-bottom: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.js_listing_wrapper div.js_job_apply_button a.js_job_button{border: 1px solid".$color1.";?>;background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-info{border-bottom: 1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-data div.jsjobs-menubar-wrap ul li a{border: 1px solid".$color5.";?>;background:".$color6.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-data div.jsjobs-menubar-wrap ul li a:hover{border: 1px solid".$color1.";?>;background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data span.js_controlpanel_section_title{background:".$color3.";?>;color:".$color8.";?>;border-bottom: 2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area div.jsjobs-jobs-overview-area div.js_job_data_wrapper span.js_job_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea{background:".$color3.";?>;border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area div.jsjobs-jobs-overview-area div.js_job_data_wrapper span.js_job_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-left-area span.jsjobs-controlpanel-section-title{background:".$color3.";?>;color:".$color8.";?>;border-bottom: 2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data span.jsjobs_controlpanel_section_title{background:".$color3.";?>;color:".$color8.";?>;border-bottom: 2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-map-wrap div.js_job_full_width_data{border: 1px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info span.js_controlpanel_title{background:".$color3.";?>;color:".$color8.";?>;border-bottom: 2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info div.js_job_apply_button a.js_job_button{background:".$color1.";?>;color:".$color7.";?>;border: 1px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-jobmore-info div.js_job_apply_button{border-top: 2px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div#js_job_fb_commentparent span#js_job_fb_commentheading{background:".$color8.";?>;color:".$color7.";?>;border: 1px solid".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_logo div.jsjobs-company-logo-wrap{border: 1px solid".$color5.";?>; border-left: 3px solid".$color1.";?>; background:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_data span.js_job_data_value a.js_jobs_company_anchor{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-title-cover span.jsjobs-resume-data span.jsjobs-resume-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-data-area div.jsjobs-data-title-cover span.jsjobs-cover-letter-data span.jsjobs-cover-letter-title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-cp-applied-resume-not-found div.jsjobs-cp-not-found-data{background:".$color3.";?>;}
		div#js_main_wrapper div.js_job_main_wrapper div.bottom div.btn-view a{background: ".$color2.";?>; color: ".$color7.";?>;}
		div#jsjobs-main-wrapper span.jsjobs-stats-title{ background:".$color8.";?>;color:".$color3.";?>; border: 1px solid".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-icon-wrap{background:".$color3.";?>;border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-packgehistory-title{background:".$color8.";?>;border: 1px solid".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-packgehistory-title span.jsjobs-allow{border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;  }
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-resumes-title{background:".$color3.";?>;border: 1px solid".$color5.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-resumes-title span.jsjobs-allow-value{border-left:1px solid".$color5.";?>;border-right:1px solid".$color5.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-resumes-title span.jsjobs-available-value{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-listing-stats-wrapper div.jsjobs-icon-wrap span.stats-data-title{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button{border-left: 1px solid".$color5.";?>;border-bottom: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button{border-left: 1px solid".$color5.";?>;}
		table#js-table thead th {background:".$color8.";?>;color:".$color7.";?>;border: 1px solid".$color5.";?>;}
		table#js-table tbody td.color3 {background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-description{border: 1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-description span.jsjobs-description-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-expiredays{border-top: 1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data{border: 1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data span.stats_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-btn-area{border-top: 1px solid".$color1.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-btn-area span.jsjobs-btn-buys a.jsjob_button{border: 1px solid".$color1.";?>;background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-btn-area span.jsjobs-btn-buys a.jsjob_button img{border-right: 1px solid".$color5.";?>;}

		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-description{border: 1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-description span.jsjobs-description-value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button span.jsjobs-expiredays{border-top: 1px solid".$color5.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data{border: 1px solid".$color5.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data span.stats_data_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-descriptions div.jsjob-description-data span.stats_data_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-btn-area{border-top: 1px solid".$color1.";?>;background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-btn-area span.jsjobs-btn-buys a.jsjob_button{border: 1px solid".$color1.";?>;background:".$color1.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-btn-area span.jsjobs-btn-buys a.jsjob_button img{border-right: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title span.jsjobs-package-price-details span.stats_data_value{border: 1px solid".$color8.";?>;background:".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data span.jsjobs-package-title-buy-now span.jsjobs-package-price-details span.stats_data_value{border: 1px solid".$color8.";?>;background:".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper span.jsjobs-paymentmethods-title{background:".$color8.";?>;border: 1px solid".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap span.payment_method_button input#jsjobs_button{background:".$color8.";?>;border: 1px solid".$color5.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper span.jsjobs-paymentmethods-title{background:".$color8.";?>;border: 1px solid".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-listing-wrapperes div.jsjobs-list-wrap span.payment_method_button input#jsjobs_button{background:".$color8.";?>;border: 1px solid".$color5.";?>;color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.js_jobs_data_wrapper{border-bottom: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap{border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap span.jsjobs-price-wrap span.stats_data_value{background:".$color8.";?>;border: 1px solid".$color8.";?>;color:".$color7.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-expire-days{border-top:2px solid".$color1.";?> }
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap span.stats_data_title{color:".$color8.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-listing-datawrap-details div.jsjobs-listing-wrap div.jsjobs-values-wrap span.stats_data_value{color:".$color4.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main div.jsjobs-purchase-listing-wrapper div.jsjobs-expire-days{background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap{background:".$color3.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap span.jsjobs-date-wrap{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-purchasehistory-main span.jsjobs-title-wrap span.jsjobs-title-wrap-purchase a.anchor{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist span.jsjobs-image-area a.jsjobs-image-area-achor{border: 1px solid".$color5.";?>;border-left: 3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-3-wrapper span.js_job_data_2_value{color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist div.jsjobs-data-area div.jsjobs-data-2 div.jsjobs-data-3-wrapper span.js_job_data_2_title{color:".$color8.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.jsjobs-image-area a.jsjobs-image-area-achor{border: 1px solid".$color5.";?>;border-left: 3px solid".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button{border-top:2px solid ".$color1.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-value-subject{border: 1px solid".$color5.";?>;background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-data-wrapper div.jsjobs-data-value-message{border: 1px solid".$color5.";?>;background:".$color3.";?>;color:".$color4.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-data-title-cover{border: 1px solid".$color5.";?>;}
		div#jsjobs-main-wrapper div.jsjobs-data-title-cover span.jsjobs-cover-letter-title{color:".$color8.";?>; }
		div#jsjobs-main-wrapper div.jsjobs-data-title-cover span.jsjobs-resume-title{color:".$color8.";?>;  }
		
		
		@media (max-width: 480px){
			div#js-jobs-wrapper div.js-toprow div.js-image img{border: 1px solid ".$color5.";?>;border-left: 4px solid ".$color1.";?>;
			-webkit-box-shadow: 0px 3px 6px 1px rgba(0,0,0,0.57);
			-moz-box-shadow: 0px 3px 6px 1px rgba(0,0,0,0.57);
			box-shadow: 0px 3px 6px 1px rgba(0,0,0,0.57);}
		    div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resumeslist div.jsjobs-image-area div.jsjobs-image-wrapper span{border-left:3px solid".$color1.";?>;}
		    div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area div.js-job-image-wrapper-boder{border-left:3px solid".$color1.";?>;}
			div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-coverletter-button-area span.jsjobs-coverletter-created {border-top:1px solid".$color5.";?>;border-bottom:1px solid".$color5.";?>;color:".$color4.";?>;}
		    div.jsjobs_rs_heading{background:".$color8.";?>;color:".$color7.";?>;border:1px solid".$color8.";?>}
		}";


	// Language is RTL Then add following css too.
	$language = JFactory::getLanguage();
	if($language->isRtl()){
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-mydepartmentlist div.jsjob-main-department div.jsjobs-main-department-right div.jsjobs-coverletter-button-area{border-left:none;border-right:1px solid '.$color5.';}';
		$style .= 'div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-image-area img.js-cp-imge-user{border: 1px solid'.$color5.';border-right:3px solid'.$color1.'; }';
		$style .= 'div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-applied-resume div.js-cp-resume-jobs div.js-appliedresume-area div.jsjobs-cp-resume-applied div.js-cp-image-area img.js-cp-imge-user {border-right:2px solid '.$color1.';border-left:1px solid '.$color5.'}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listresume div.jsjobs-main-wrapper-resumeslist div.jsjobs-main-resumeslist div.jsjobs-image-area a.logo_a {border-right:4px solid '.$color1.';border-left:1px solid '.$color5.'}';
		$style .= 'div#js-jobs-wrapper div.js-toprow div.js-image img {border-right:4px solid '.$color1.';border-left:1px solid '.$color5.'}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listcompany div.jsjobs-wrapper-listcompany div.jsjobs-listcompany div.jsjobs-image-area div.jsjobs-image-wrapper-mycompany div.jsjobs-image-border{border-right:3px solid'.$color1.';border-left:none;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-main-wrapper-listappliedjobs div.jsjobs-main-wrapper-appliedjobslist div.jsjobs-image-area a{border: 1px solid '.$color5.'; border-right: 2px solid '.$color1.';}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-message-history-wrapper span.jsjobs-img-sender span.jsjobs-img-area span.jsjobs-img-area-wrap{;border-left:none;border-right:3px solid'.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-listing-wrapper div.jsjobs-messages-list div.jsjobs-message-button-area span.jsjsobs-message-btn{ border-left:none;border-right: 1px solid'.$color5.';?>; }';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-message-send-list div.jsjobs-main-message-wrap div.jsjobs-company-logo span.jsjobs-img-wrap span.jsjobs-img-border{border-left:none;border-right:3px solid'.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-wrapper-mycompanies div.jsjobs-main-companieslist div.jsjobs-main-wrap-imag-data div.com-logo a.img{border: 1px solid '.$color5.'; ?>;border-right: 2px solid '.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-folderinfo div.jsjobs-main-myjobslist span.jsjobs-image-area a.jsjobs-image-area-achor{border: 1px solid '.$color5.'; ?>;border-right: 2px solid '.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobs-resume-panel div.js-cp-applied-resume div.js-cp-wrap-resume-jobs div.js-cp-resume-wrap div.js-cp-applied-resume div.js-cp-image-area img.js-cp-imge-user{border: 1px solid '.$color5.'; ?>;border-right: 2px solid '.$color1.';?>;}';
		$style .= 'div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_image_wrapper{border: 1px solid '.$color5.'; ?>;border-right: 2px solid '.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-job-information-data div.jsjobs-right-raea div.js_job_company_logo div.jsjobs-company-logo-wrap{border: 1px solid '.$color5.'; ?>;border-left: 3px solid '.$color1.';?>;}';
		$style .= 'div#js_main_wrapper div.js_job_main_wrapper div.js_job_image_area div.js_job_image_wrapper{border: 1px solid '.$color5.'; ?>;border-right: 2px solid '.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-main-wrapper-resume-searchresults div.jsjobs-resume-searchresults div.jsjobs-resume-search div.jsjobs-image-area div.jsjobs-image-wrapper{border-left:none;border-right: 3px solid '.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div.jsjobs-company-applied-data div.jsjobs-company-logo span.jsjobs-company-logo-wrap span.jsjobs-left-border{border-left:none;border-right: 3px solid '.$color1.';?>;}';
		$style .= 'div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-suggested-applied-panel div.js-cp-suggested-jobs div.js-cp-resume-jobs div.js-suggestedjobs-area div.js-cp-jobs-sugest div.js-cp-image-area img.js-cp-imge-user{border:1px solid '.$color5.';border-right: 3px solid '.$color1.';?>;}';
		$style .= "div#jsjobs-main-wrapper div.jsjobs-main-wrapper-shortjoblist div.jsjobs-image-area a{border: 1px solid ".$color5.";?>; border-right: 2px solid ".$color1.";?>}";
		$style .= "div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color3 {border-left: 5px solid #9260E9;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color2 {border-left: 5px solid #E69200;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color1 {border-left: 5px solid #53BF58;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow a.color4 {border-left: 5px solid #ED473A;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-left div.jsjobs-graph-wrp span.jsjobs-graph-title {border-right: 5px solid #4285F4;border-left:none;}
					div#jsjobs-main-wrapper divjsjobs-emp-cp-wrapper div.jsjobs-cp-graph-wrap div.js-graph-right div.jsjobs-graph-wrp span.jsjobs-graph-title {border-right: 5px solid #ED473A;border-left:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-adding-section span.js-sample-title {border-width: 1px 5px 1px 1px;border-style: solid;border-color: ".$color5." #EF348A ".$color5." ".$color5.";}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.js-cp-stats-panel span.js-sample-title {border-width: 1px 5px 1px 1px;border-style: solid;border-color: ".$color5." #ED473A ".$color5." ".$color5.";}
					div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.jsjobs-location-wrap {border-left: 1px solid rgb(204, 204, 204);}
					div#jsjobs-main-wrapper div.jsjobs-job-info div.jsjobs-data-jobs-wrapper span.js_job_data_value{border-right:none;}
					div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a img {border-left: 1px solid ".$color5.";border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color3 {border-left: 5px solid #EF348A;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color2 {border-left: 5px solid #9260E9;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color1 {border-left: 5px solid #53BF58;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-toprow-job-seeker a.color4 {border-left: 5px solid #4285F4;border-right:none;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-jobseeker-cp-wrapper div.js-cp-graph-area span.js-cp-graph-title {border-width: 1px 5px 1px 1px;border-style: solid;border-color: ".$color5." #0097C9 ".$color5." ".$color5." ;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-categories div.jsjobs-cp-jobseeker-categories-btn span.js-cp-graph-title {border-width: 1px 5px 1px 1px;border-style: solid;border-color: ".$color5." #0097C9 ".$color5." ".$color5." ;}
					div#jsjobs-main-wrapper div#jsjobs-emp-cp-wrapper div.jsjobs-cp-jobseeker-stats span.js-sample-title {border-width: 1px 5px 1px 1px;border-style: solid;border-color: ".$color5." #9260E9 ".$color5." ".$color5." ;}
					div#jsjobs-main-wrapper div.jsjobs-package-data div.jsjobs-package-buy-now-listing-wrapper div.jsjobs-apply-button span.jsjobs-buy-btn a img{border:none;border-left: 1px solid ".$color5.";}
					table#js-table tbody td.bodercolor1 {border-right: 3px solid #4020CD;border-left: none;}
					table#js-table tbody td.bodercolor2 {border-right: 3px solid #E37900;border-left: none;}
					table#js-table tbody td.bodercolor3 {border-right: 3px solid #86C544;border-left: none;}
					table#js-table tbody td.bodercolor4 {border-right: 3px solid #633;border-left: none;}
				";
	}
    $document = JFactory::getDocument();
    $document->addStyleDeclaration($style);
?>