# 4.1 Remove unused keys ;
ALTER TABLE `#__jfbconnect_user_map` ADD COLUMN `access_token` VARCHAR(255) DEFAULT NULL;
ALTER TABLE `#__jfbconnect_config` ADD UNIQUE (`setting`);

DELETE FROM `#__jfbconnect_config` WHERE `setting` = "facebook_update_status_msg";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "facebook_perm_status_update";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "facebook_perm_email";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "facebook_perm_profile_data";

# 4.0 Remove unused keys, missed in previous release so doing it here ;
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "facebook_api_key";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_comment_max_num";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_comment_width";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_comment_color_scheme";

DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_comment_max_num";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_comment_width";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_comment_color_scheme";

DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_layout_style";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_show_faces";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_show_send_button";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_width";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_verb_to_display";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_font";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_color_scheme";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_like_show_extra_social_buttons";

DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_layout_style";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_show_faces";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_show_send_button";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_width";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_verb_to_display";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_font";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_color_scheme";
DELETE FROM `#__jfbconnect_config` WHERE `setting` = "social_k2_like_show_extra_social_buttons";
