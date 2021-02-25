# Remove index from usermap table ;
ALTER TABLE `#__jfbconnect_user_map` DROP INDEX `provider_user_id`;

# Update provider_user_id to handle large ID ;
ALTER TABLE `#__jfbconnect_user_map` MODIFY `provider_user_id` TEXT NOT NULL;

ALTER TABLE `#__jfbconnect_user_map` ADD INDEX `provider_provider_user_id` (`provider`,`provider_user_id`(20));