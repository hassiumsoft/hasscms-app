<?php

use yii\db\Migration;

class m151209_185057_migration extends Migration
{
    public function up()
    {
		$this->execute('SET foreign_key_checks = 0');
 
$this->createTable('{{%area}}', [
	'area_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'title' => 'VARCHAR(255) NOT NULL',
	'slug' => 'VARCHAR(255) NOT NULL',
	'description' => 'VARCHAR(255) NOT NULL',
	'blocks' => 'VARCHAR(255) NOT NULL',
	'PRIMARY KEY (`area_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%area_block}}', [
	'block_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'title' => 'VARCHAR(255) NOT NULL',
	'type' => 'VARCHAR(50) NULL',
	'widget' => 'TEXT NULL',
	'slug' => 'VARCHAR(255) NOT NULL',
	'config' => 'TEXT NULL',
	'template' => 'TEXT NULL',
	'cache' => 'INT(11) NOT NULL',
	'used' => 'SMALLINT(6) NOT NULL',
	'PRIMARY KEY (`block_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%attachment}}', [
	'attachment_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'author_id' => 'INT(11) NULL',
	'name' => 'VARCHAR(255) NULL',
	'title' => 'VARCHAR(255) NULL',
	'description' => 'VARCHAR(255) NULL',
	'hash' => 'VARCHAR(255) NOT NULL',
	'size' => 'INT(11) NOT NULL',
	'type' => 'VARCHAR(255) NOT NULL',
	'extension' => 'VARCHAR(255) NOT NULL',
	'created_at' => 'INT(11) NOT NULL',
	'updated_at' => 'INT(11) NOT NULL',
	'PRIMARY KEY (`attachment_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%attachment_index}}', [
	'attachment_id' => 'INT(11) NULL',
	'entity_id' => 'INT(11) UNSIGNED NULL',
	'entity' => 'VARCHAR(50) NULL',
	'attribute' => 'VARCHAR(50) NULL',
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_entity_id_9172_0','attachment_index','entity_id',0);
 
$this->createTable('{{%auth_assignment}}', [
	'item_name' => 'VARCHAR(64) NOT NULL',
	'user_id' => 'VARCHAR(64) NOT NULL',
	'created_at' => 'INT(11) NULL',
	'PRIMARY KEY (`item_name`,`user_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_auth_item_9177_01','{{%auth_assignment}}', 'item_name', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE' );
 
$this->createTable('{{%auth_item}}', [
	'name' => 'VARCHAR(64) NOT NULL',
	'type' => 'INT(11) NOT NULL',
	'description' => 'TEXT NULL',
	'rule_name' => 'VARCHAR(64) NULL',
	'data' => 'TEXT NULL',
	'created_at' => 'INT(11) NULL',
	'updated_at' => 'INT(11) NULL',
	'PRIMARY KEY (`name`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_auth_rule_9189_01','{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'CASCADE', 'CASCADE' );
 
$this->createIndex('idx_rule_name_9196_0','auth_item','rule_name',0);
$this->createIndex('idx_type_9196_1','auth_item','type',0);
 
$this->createTable('{{%auth_item_child}}', [
	'parent' => 'VARCHAR(64) NOT NULL',
	'child' => 'VARCHAR(64) NOT NULL',
	'PRIMARY KEY (`parent`,`child`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_auth_item_92_01','{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE' );
$this->addForeignKey('fk_auth_item_92_11','{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'CASCADE' );
 
$this->createIndex('idx_child_9206_0','auth_item_child','child',0);
 
$this->createTable('{{%auth_rule}}', [
	'name' => 'VARCHAR(64) NOT NULL',
	'data' => 'TEXT NULL',
	'created_at' => 'INT(11) NULL',
	'updated_at' => 'INT(11) NULL',
	'PRIMARY KEY (`name`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%cache}}', [
	'id' => 'CHAR(128) NOT NULL',
	'expire' => 'INT(11) NULL',
	'data' => 'BLOB NULL',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%comment}}', [
	'comment_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'entity' => 'VARCHAR(64) NOT NULL',
	'entity_id' => 'INT(11) NULL',
	'author_id' => 'INT(11) NULL',
	'username' => 'VARCHAR(128) NULL',
	'email' => 'VARCHAR(128) NULL',
	'parent_id' => 'INT(11) NULL',
	'status' => 'INT(1) UNSIGNED NOT NULL DEFAULT \'1\'',
	'created_at' => 'INT(11) NOT NULL',
	'updated_at' => 'INT(11) NOT NULL',
	'content' => 'TEXT NOT NULL',
	'user_ip' => 'VARCHAR(15) NULL',
	'PRIMARY KEY (`comment_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_entity_924_0','comment','entity',0);
$this->createIndex('idx_entity_924_1','comment','entity',0);
$this->createIndex('idx_status_924_2','comment','status',0);
$this->createIndex('idx_parent_id_924_3','comment','parent_id',0);
 
$this->createTable('{{%comment_info}}', [
	'entity' => 'VARCHAR(128) NULL',
	'entity_id' => 'INT(11) NULL',
	'status' => 'TINYINT(4) NULL',
	'total' => 'INT(11) NULL',
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_entity_9253_0','comment_info','entity',0);
 
$this->createTable('{{%config}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'name' => 'VARCHAR(128) NULL',
	'value' => 'MEDIUMTEXT NULL',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_UNIQUE_name_9263_0','config','name',1);
 
$this->createTable('{{%menu}}', [
	'slug' => 'VARCHAR(128) NOT NULL',
	'name' => 'VARCHAR(128) NULL',
	'title' => 'VARCHAR(128) NULL',
	'module' => 'VARCHAR(128) NULL',
	'original' => 'VARCHAR(128) NULL',
	'tree' => 'INT(11) NULL',
	'lft' => 'INT(11) NULL',
	'rgt' => 'INT(11) NULL',
	'options' => 'TEXT NULL',
	'depth' => 'INT(11) NULL',
	'status' => 'TINYINT(1) NULL DEFAULT \'1\'',
	'PRIMARY KEY (`slug`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%message}}', [
	'id' => 'INT(11) NOT NULL',
	'language' => 'VARCHAR(255) NOT NULL',
	'translation' => 'TEXT NULL',
	'PRIMARY KEY (`id`,`language`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_source_message_9281_01','{{%message}}', 'id', '{{%source_message}}', 'id', 'CASCADE', 'CASCADE' );
 
$this->createTable('{{%meta}}', [
	'meta_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'entity' => 'VARCHAR(128) NOT NULL',
	'entity_id' => 'INT(11) NOT NULL',
	'title' => 'VARCHAR(128) NULL',
	'keywords' => 'VARCHAR(128) NULL',
	'description' => 'VARCHAR(128) NULL',
	'PRIMARY KEY (`meta_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_UNIQUE_entity_9298_0','meta','entity',1);
 
$this->createTable('{{%module}}', [
	'package' => 'VARCHAR(50) NOT NULL',
	'id' => 'VARCHAR(50) NOT NULL',
	'class' => 'VARCHAR(128) NOT NULL',
	'status' => 'TINYINT(4) NULL',
	'installed' => 'TINYINT(4) NULL',
	'bootstrap' => 'VARCHAR(50) NULL',
	'PRIMARY KEY (`package`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%page}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'parent' => 'INT(11) NOT NULL',
	'title' => 'VARCHAR(128) NOT NULL',
	'content' => 'TEXT NOT NULL',
	'slug' => 'VARCHAR(128) NULL',
	'status' => 'TINYINT(1) NULL DEFAULT \'1\'',
	'published_at' => 'INT(11) NULL',
	'created_at' => 'INT(11) NOT NULL',
	'updated_at' => 'INT(11) NOT NULL',
	'weight' => 'INT(11) NOT NULL DEFAULT \'1\'',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_UNIQUE_slug_9323_0','page','slug',1);
 
$this->createTable('{{%post}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'author_id' => 'INT(11) NOT NULL',
	'title' => 'VARCHAR(128) NOT NULL',
	'short' => 'VARCHAR(1024) NULL',
	'content' => 'TEXT NOT NULL',
	'slug' => 'VARCHAR(128) NULL',
	'views' => 'INT(11) NULL',
	'status' => 'TINYINT(1) NULL DEFAULT \'1\'',
	'published_at' => 'INT(11) NULL',
	'created_at' => 'INT(11) NOT NULL',
	'updated_at' => 'INT(11) NOT NULL',
	'revision' => 'INT(11) NOT NULL DEFAULT \'1\'',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_UNIQUE_slug_9339_0','post','slug',1);
 
$this->createTable('{{%profile}}', [
	'user_id' => 'INT(11) NOT NULL',
	'name' => 'VARCHAR(255) NULL',
	'public_email' => 'VARCHAR(255) NULL',
	'gravatar_email' => 'VARCHAR(255) NULL',
	'gravatar_id' => 'VARCHAR(32) NULL',
	'location' => 'VARCHAR(255) NULL',
	'website' => 'VARCHAR(255) NULL',
	'bio' => 'TEXT NULL',
	'PRIMARY KEY (`user_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_user_9347_01','{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
 
$this->createTable('{{%revolutionslider}}', [
	'revolutionslider_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'captions' => 'TEXT NULL',
	'url' => 'TEXT NULL',
	'weight' => 'TINYINT(4) NULL',
	'PRIMARY KEY (`revolutionslider_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%session}}', [
	'id' => 'CHAR(40) NOT NULL',
	'expire' => 'INT(11) NULL',
	'data' => 'BLOB NULL',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%social_account}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'user_id' => 'INT(11) NULL',
	'provider' => 'VARCHAR(255) NOT NULL',
	'client_id' => 'VARCHAR(255) NOT NULL',
	'data' => 'TEXT NULL',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_user_9379_01','{{%social_account}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
 
$this->createIndex('idx_UNIQUE_provider_9386_0','social_account','provider',1);
$this->createIndex('idx_user_id_9386_1','social_account','user_id',0);
 
$this->createTable('{{%source_message}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'category' => 'VARCHAR(255) NULL',
	'message' => 'TEXT NULL',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%tag}}', [
	'tag_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'name' => 'VARCHAR(128) NOT NULL',
	'frequency' => 'INT(11) NULL',
	'PRIMARY KEY (`tag_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_UNIQUE_name_9405_0','tag','name',1);
 
$this->createTable('{{%tag_index}}', [
	'tag_id' => 'INT(11) NOT NULL',
	'entity_id' => 'INT(11) NOT NULL',
	'entity' => 'VARCHAR(128) NOT NULL',
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_entity_id_9415_0','tag_index','entity_id',0);
 
$this->createTable('{{%taxonomy}}', [
	'taxonomy_id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT',
	'slug' => 'VARCHAR(128) NULL',
	'name' => 'VARCHAR(128) NULL',
	'description' => 'TEXT NULL',
	'tree' => 'INT(11) NULL',
	'lft' => 'INT(11) NULL',
	'rgt' => 'INT(11) NULL',
	'depth' => 'INT(11) NULL',
	'status' => 'TINYINT(1) NULL DEFAULT \'1\'',
	'PRIMARY KEY (`taxonomy_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%taxonomy_index}}', [
	'taxonomy_index_id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'entity_id' => 'INT(11) UNSIGNED NOT NULL',
	'taxonomy_id' => 'INT(11) UNSIGNED NOT NULL',
	'entity' => 'VARCHAR(128) NULL',
	'PRIMARY KEY (`taxonomy_index_id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_taxonomy_id_9441_0','taxonomy_index','taxonomy_id',0);
$this->createIndex('idx_entity_id_9441_1','taxonomy_index','entity_id',0);
 
$this->createTable('{{%template}}', [
	'template_id' => 'INT(11) NULL',
	'entity' => 'VARCHAR(50) NULL',
	'entity_id' => 'INT(11) NULL',
	'path' => 'VARCHAR(50) NULL',
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%token}}', [
	'user_id' => 'INT(11) NOT NULL',
	'code' => 'VARCHAR(32) NOT NULL',
	'created_at' => 'INT(11) NOT NULL',
	'type' => 'SMALLINT(6) NOT NULL',
	'PRIMARY KEY (`user_id`,`code`,`type`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->addForeignKey('fk_user_9456_01','{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE' );
 
$this->createIndex('idx_UNIQUE_user_id_9462_0','token','user_id',1);
 
$this->createTable('{{%url_rule}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'name' => 'VARCHAR(50) NULL',
	'pattern' => 'VARCHAR(255) NOT NULL',
	'host' => 'VARCHAR(255) NULL',
	'route' => 'VARCHAR(255) NOT NULL',
	'defaults' => 'VARCHAR(255) NULL',
	'suffix' => 'VARCHAR(255) NULL',
	'verb' => 'VARCHAR(255) NULL',
	'mode' => 'TINYINT(4) NOT NULL',
	'encodeParams' => 'TINYINT(4) NOT NULL DEFAULT \'1\'',
	'status' => 'TINYINT(4) NULL DEFAULT \'1\'',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createTable('{{%user}}', [
	'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
	'username' => 'VARCHAR(25) NOT NULL',
	'email' => 'VARCHAR(255) NOT NULL',
	'password_hash' => 'VARCHAR(60) NOT NULL',
	'auth_key' => 'VARCHAR(32) NOT NULL',
	'confirmed_at' => 'INT(11) NULL',
	'unconfirmed_email' => 'VARCHAR(255) NULL',
	'blocked_at' => 'INT(11) NULL',
	'registration_ip' => 'VARCHAR(45) NULL',
	'created_at' => 'INT(11) NOT NULL',
	'updated_at' => 'INT(11) NOT NULL',
	'flags' => 'INT(11) NOT NULL',
	'PRIMARY KEY (`id`)'
], "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB");
 
$this->createIndex('idx_UNIQUE_username_949_0','user','username',1);
$this->createIndex('idx_UNIQUE_email_949_1','user','email',1);
 
$this->execute('SET foreign_key_checks = 1;');
$this->execute('SET foreign_key_checks = 0');
 
/* Table area */
$this->insert('{{%area}}',['area_id'=>'1','title'=>'首页头部','slug'=>'index-header','description'=>'default','blocks'=>'']);
$this->insert('{{%area}}',['area_id'=>'3','title'=>'侧边栏','slug'=>'slider','description'=>'侧边栏试试','blocks'=>'a:2:{i:0;s:1:\"7\";i:1;s:1:\"9\";}']);
 
/* Table area_block */
$this->insert('{{%area_block}}',['block_id'=>'7','title'=>'公告','type'=>'text','widget'=>'hass\\area\\widgets\\TextWidget','slug'=>'gong-gao','config'=>'','template'=>'<p>这里是公告</p>','cache'=>'0','used'=>'1']);
$this->insert('{{%area_block}}',['block_id'=>'9','title'=>'区域测试','type'=>'text','widget'=>'hass\\area\\widgets\\TextWidget','slug'=>'qu-yu-ce-shi','config'=>'','template'=>'<p>这里是侧边栏的区域中的一个区块</p>','cache'=>'0','used'=>'1']);
 
/* Table auth_assignment */
$this->insert('{{%auth_assignment}}',['item_name'=>'admin','user_id'=>'1','created_at'=>'1430564816']);
 
/* Table auth_item */
$this->insert('{{%auth_item}}',['name'=>'*','type'=>'2','description'=>'SUPER_PERMISSION','rule_name'=>'','data'=>'','created_at'=>'1449578246','updated_at'=>'1449578246']);
$this->insert('{{%auth_item}}',['name'=>'admin','type'=>'1','description'=>'管理员','rule_name'=>'','data'=>'','created_at'=>'1430498197','updated_at'=>'1448098717']);
$this->insert('{{%auth_item}}',['name'=>'area/block/create','type'=>'2','description'=>'block-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/block/delete','type'=>'2','description'=>'block-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/block/index','type'=>'2','description'=>'block-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/block/update','type'=>'2','description'=>'block-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/create','type'=>'2','description'=>'default-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/update-blocks','type'=>'2','description'=>'default-Update Blocks','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/update-blocks-create','type'=>'2','description'=>'default-Update Blocks Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'area/default/update-blocks-delete','type'=>'2','description'=>'default-Update Blocks Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/default/crop','type'=>'2','description'=>'default-Crop','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/default/uploader','type'=>'2','description'=>'default-Uploader','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/default/view','type'=>'2','description'=>'default-View','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/upload/create-imperavi','type'=>'2','description'=>'upload-Create Imperavi','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/upload/create-save','type'=>'2','description'=>'upload-Create Save','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/upload/create-temp','type'=>'2','description'=>'upload-Create Temp','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/upload/delete','type'=>'2','description'=>'upload-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/upload/delete-temp','type'=>'2','description'=>'upload-Delete Temp','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'attachment/upload/images-get','type'=>'2','description'=>'upload-Images Get','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'comment/default/config','type'=>'2','description'=>'default-Config','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'comment/default/create','type'=>'2','description'=>'default-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'comment/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'comment/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'comment/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'config/custom/delete','type'=>'2','description'=>'custom-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'config/custom/index','type'=>'2','description'=>'custom-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'config/custom/update','type'=>'2','description'=>'custom-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'config/default/basic','type'=>'2','description'=>'default-Basic','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'config/default/database','type'=>'2','description'=>'default-Database','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'config/default/mail','type'=>'2','description'=>'default-Mail','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/attachment/create-imperavi','type'=>'2','description'=>'attachment-Create Imperavi','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/attachment/create-save','type'=>'2','description'=>'attachment-Create Save','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/attachment/create-temp','type'=>'2','description'=>'attachment-Create Temp','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/attachment/delete','type'=>'2','description'=>'attachment-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/attachment/delete-temp','type'=>'2','description'=>'attachment-Delete Temp','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/attachment/images-get','type'=>'2','description'=>'attachment-Images Get','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/comment/create','type'=>'2','description'=>'comment-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/comment/replyform','type'=>'2','description'=>'comment-Replyform','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/page/read','type'=>'2','description'=>'page-Read','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/post/read','type'=>'2','description'=>'post-Read','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/search/index','type'=>'2','description'=>'search-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/site/captcha','type'=>'2','description'=>'site-Captcha','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/site/error','type'=>'2','description'=>'site-Error','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/site/index','type'=>'2','description'=>'site-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/tag/read','type'=>'2','description'=>'tag-Read','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/taxonomy/read','type'=>'2','description'=>'taxonomy-Read','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/profile/index','type'=>'2','description'=>'profile-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/profile/show','type'=>'2','description'=>'profile-Show','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/recovery/request','type'=>'2','description'=>'recovery-Request','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/recovery/reset','type'=>'2','description'=>'recovery-Reset','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/registration/confirm','type'=>'2','description'=>'registration-Confirm','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/registration/connect','type'=>'2','description'=>'registration-Connect','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/registration/register','type'=>'2','description'=>'registration-Register','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/registration/resend','type'=>'2','description'=>'registration-Resend','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/security/auth','type'=>'2','description'=>'security-Auth','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/security/login','type'=>'2','description'=>'security-Login','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/security/logout','type'=>'2','description'=>'security-Logout','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/settings/account','type'=>'2','description'=>'settings-Account','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/settings/avatar','type'=>'2','description'=>'settings-Avatar','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/settings/confirm','type'=>'2','description'=>'settings-Confirm','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/settings/disconnect','type'=>'2','description'=>'settings-Disconnect','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/settings/networks','type'=>'2','description'=>'settings-Networks','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'frontend/user/settings/profile','type'=>'2','description'=>'settings-Profile','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'gii/default/action','type'=>'2','description'=>'default-Action','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'gii/default/diff','type'=>'2','description'=>'default-Diff','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'gii/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'gii/default/preview','type'=>'2','description'=>'default-Preview','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'gii/default/view','type'=>'2','description'=>'default-View','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'guest','type'=>'1','description'=>'游客','rule_name'=>'','data'=>'','created_at'=>'1430498197','updated_at'=>'1430498197']);
$this->insert('{{%auth_item}}',['name'=>'i18n/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'i18n/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/check-env','type'=>'2','description'=>'default-Check Env','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/language','type'=>'2','description'=>'default-Language','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/license-agreement','type'=>'2','description'=>'default-License Agreement','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/select-db','type'=>'2','description'=>'default-Select Db','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/set-admin','type'=>'2','description'=>'default-Set Admin','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/set-db','type'=>'2','description'=>'default-Set Db','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'install/default/set-site','type'=>'2','description'=>'default-Set Site','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/create','type'=>'2','description'=>'default-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/create-link','type'=>'2','description'=>'default-Create Link','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/create-links-from-module','type'=>'2','description'=>'default-Create Links From Module','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/switcher','type'=>'2','description'=>'default-Switcher','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/view','type'=>'2','description'=>'default-View','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'menu/default/view-links','type'=>'2','description'=>'default-View Links','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'migration/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'module/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'module/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'module/default/install','type'=>'2','description'=>'default-Install','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'module/default/switcher','type'=>'2','description'=>'default-Switcher','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'module/default/uninstall','type'=>'2','description'=>'default-Uninstall','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/create','type'=>'2','description'=>'default-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/down','type'=>'2','description'=>'default-Down','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/switcher','type'=>'2','description'=>'default-Switcher','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/up','type'=>'2','description'=>'default-Up','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'page/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'post/default/create','type'=>'2','description'=>'default-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'post/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'post/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'post/default/switcher','type'=>'2','description'=>'default-Switcher','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'post/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'rbac/role/delete','type'=>'2','description'=>'role-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'rbac/role/index','type'=>'2','description'=>'role-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'rbac/role/permissions','type'=>'2','description'=>'role-Permissions','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'rbac/role/update','type'=>'2','description'=>'role-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'rbac/tool/index','type'=>'2','description'=>'tool-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'system/cache/clear-assets','type'=>'2','description'=>'cache-Clear Assets','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'system/cache/flush-cache','type'=>'2','description'=>'cache-Flush Cache','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'system/cache/index','type'=>'2','description'=>'cache-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'system/default/controlpanel','type'=>'2','description'=>'default-Controlpanel','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'system/default/error','type'=>'2','description'=>'default-Error','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'system/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'tag/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'tag/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'tag/default/list','type'=>'2','description'=>'default-List','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'tag/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/add-child','type'=>'2','description'=>'default-Add Child','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/down','type'=>'2','description'=>'default-Down','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/switcher','type'=>'2','description'=>'default-Switcher','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/up','type'=>'2','description'=>'default-Up','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'taxonomy/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/custom','type'=>'2','description'=>'default-Custom','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/demo','type'=>'2','description'=>'default-Demo','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/enabled','type'=>'2','description'=>'default-Enabled','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/upload','type'=>'2','description'=>'default-Upload','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'theme/default/view','type'=>'2','description'=>'default-View','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'urlrule/default/delete','type'=>'2','description'=>'default-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'urlrule/default/index','type'=>'2','description'=>'default-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'urlrule/default/update','type'=>'2','description'=>'default-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user','type'=>'1','description'=>'会员','rule_name'=>'','data'=>'','created_at'=>'1448317057','updated_at'=>'1448317057']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/assignments','type'=>'2','description'=>'admin-Assignments','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/block','type'=>'2','description'=>'admin-Block','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/confirm','type'=>'2','description'=>'admin-Confirm','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/create','type'=>'2','description'=>'admin-Create','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/delete','type'=>'2','description'=>'admin-Delete','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/index','type'=>'2','description'=>'admin-Index','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/info','type'=>'2','description'=>'admin-Info','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/update','type'=>'2','description'=>'admin-Update','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/admin/update-profile','type'=>'2','description'=>'admin-Update Profile','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/security/auth','type'=>'2','description'=>'security-Auth','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/security/in','type'=>'2','description'=>'security-In','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/security/login','type'=>'2','description'=>'security-Login','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
$this->insert('{{%auth_item}}',['name'=>'user/security/logout','type'=>'2','description'=>'security-Logout','rule_name'=>'','data'=>'','created_at'=>'1449592329','updated_at'=>'1449592329']);
 
/* Table auth_item_child */
$this->insert('{{%auth_item_child}}',['parent'=>'admin','child'=>'*']);
 
/* Table auth_rule */
 
/* Table menu */
$this->insert('{{%menu}}',['slug'=>'footer-menu','name'=>'底部菜单','title'=>'','module'=>'','original'=>'','tree'=>'2','lft'=>'1','rgt'=>'4','options'=>'','depth'=>'0','status'=>'1']);
$this->insert('{{%menu}}',['slug'=>'friend-links','name'=>'友情链接','title'=>'友情链接','module'=>'','original'=>'','tree'=>'4','lft'=>'1','rgt'=>'2','options'=>'','depth'=>'0','status'=>'1']);
$this->insert('{{%menu}}',['slug'=>'main-menu','name'=>'顶部菜单','title'=>'顶部菜单','module'=>'','original'=>'','tree'=>'1','lft'=>'1','rgt'=>'4','options'=>'','depth'=>'0','status'=>'1']);
$this->insert('{{%menu}}',['slug'=>'page-sidebar','name'=>'页面左侧菜单','title'=>'页面左侧菜单','module'=>'','original'=>'','tree'=>'3','lft'=>'1','rgt'=>'4','options'=>'','depth'=>'0','status'=>'1']);
$this->insert('{{%menu}}',['slug'=>'shou-ye','name'=>'','title'=>'','module'=>'page','original'=>'-1','tree'=>'1','lft'=>'2','rgt'=>'3','options'=>'','depth'=>'1','status'=>'1']);
 
/* Table module */
$this->insert('{{%module}}',['package'=>'hassium/hass-area','id'=>'area','class'=>'hass\\area\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-attachment','id'=>'attachment','class'=>'hass\\attachment\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-authclient','id'=>'authclient','class'=>'','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-backend','id'=>'backend','class'=>'hass\\backend\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-base','id'=>'base','class'=>'','status'=>'1','installed'=>'1','bootstrap'=>'1|2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-comment','id'=>'comment','class'=>'hass\\comment\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-config','id'=>'config','class'=>'hass\\config\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-frontend','id'=>'frontend','class'=>'hass\\frontend\\Module','status'=>'1','installed'=>'1','bootstrap'=>'1']);
$this->insert('{{%module}}',['package'=>'hassium/hass-gii','id'=>'gii','class'=>'hass\\gii\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-i18n','id'=>'i18n','class'=>'hass\\i18n\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-install','id'=>'install','class'=>'hass\\install\\Module','status'=>'1','installed'=>'1','bootstrap'=>'1|2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-menu','id'=>'menu','class'=>'hass\\menu\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-meta','id'=>'meta','class'=>'','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-migration','id'=>'migration','class'=>'hass\\migration\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-module','id'=>'module','class'=>'hass\\module\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-page','id'=>'page','class'=>'hass\\page\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-post','id'=>'post','class'=>'hass\\post\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-rbac','id'=>'rbac','class'=>'hass\\rbac\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-revolutionslider','id'=>'revolutionslider','class'=>'hass\\revolutionslider\\Module','status'=>'0','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-search','id'=>'search','class'=>'hass\\search\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-system','id'=>'system','class'=>'hass\\system\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-tag','id'=>'tag','class'=>'hass\\tag\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-taxonomy','id'=>'taxonomy','class'=>'hass\\taxonomy\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-theme','id'=>'theme','class'=>'hass\\theme\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-url-rule','id'=>'urlrule','class'=>'hass\\urlrule\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
$this->insert('{{%module}}',['package'=>'hassium/hass-user','id'=>'user','class'=>'hass\\user\\Module','status'=>'1','installed'=>'1','bootstrap'=>'2']);
 
$this->execute('SET foreign_key_checks = 1;');    }

    public function down()
    {
    
    	        $this->execute('SET foreign_key_checks = 0');
$this->execute('DROP TABLE IF EXISTS `area`');
$this->execute('DROP TABLE IF EXISTS `area_block`');
$this->execute('DROP TABLE IF EXISTS `attachment`');
$this->execute('DROP TABLE IF EXISTS `attachment_index`');
$this->execute('DROP TABLE IF EXISTS `auth_assignment`');
$this->execute('DROP TABLE IF EXISTS `auth_item`');
$this->execute('DROP TABLE IF EXISTS `auth_item_child`');
$this->execute('DROP TABLE IF EXISTS `auth_rule`');
$this->execute('DROP TABLE IF EXISTS `cache`');
$this->execute('DROP TABLE IF EXISTS `comment`');
$this->execute('DROP TABLE IF EXISTS `comment_info`');
$this->execute('DROP TABLE IF EXISTS `config`');
$this->execute('DROP TABLE IF EXISTS `menu`');
$this->execute('DROP TABLE IF EXISTS `message`');
$this->execute('DROP TABLE IF EXISTS `meta`');
$this->execute('DROP TABLE IF EXISTS `module`');
$this->execute('DROP TABLE IF EXISTS `page`');
$this->execute('DROP TABLE IF EXISTS `post`');
$this->execute('DROP TABLE IF EXISTS `profile`');
$this->execute('DROP TABLE IF EXISTS `revolutionslider`');
$this->execute('DROP TABLE IF EXISTS `session`');
$this->execute('DROP TABLE IF EXISTS `social_account`');
$this->execute('DROP TABLE IF EXISTS `source_message`');
$this->execute('DROP TABLE IF EXISTS `tag`');
$this->execute('DROP TABLE IF EXISTS `tag_index`');
$this->execute('DROP TABLE IF EXISTS `taxonomy`');
$this->execute('DROP TABLE IF EXISTS `taxonomy_index`');
$this->execute('DROP TABLE IF EXISTS `template`');
$this->execute('DROP TABLE IF EXISTS `token`');
$this->execute('DROP TABLE IF EXISTS `url_rule`');
$this->execute('DROP TABLE IF EXISTS `user`');
$this->execute('SET foreign_key_checks = 1;');				
        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
