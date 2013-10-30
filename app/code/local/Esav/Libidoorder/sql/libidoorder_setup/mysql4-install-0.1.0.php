<?php
$installer = $this;
$installer->startSetup();
$sql=<<<SQLTEXT
create table `libidoorder`(
`libidoorder_id` int not null auto_increment,
`created_at`  TIMESTAMP not null DEFAULT
CURRENT_TIMESTAMP,
`name` varchar(30) not null DEFAULT '',
`last_name` varchar(30) NULL DEFAULT '',
`email`   varchar(39),
`mobile` varchar(20),
`address`  varchar(30)  not null DEFAULT '',
`zipcode` varchar(7)  not null DEFAULT '',
`location` varchar(150)  not null DEFAULT '',
`country`  varchar(30)  not null DEFAULT '',
`city`  varchar(30)  not null DEFAULT '',
`qty`  int(5)   null DEFAULT '0',
`qty_per_month`   int(5)   null DEFAULT '0',
`how_many_months` int(5)   null DEFAULT '0',
`sum` DECIMAL(10, 2) NOT NULL DEFAULT '0',
`currency` varchar(20)  not null DEFAULT '',
`use_this_address_for_delivery` tinyint(1) not null DEFAULT '0',
`newsletter` tinyint(1) not null DEFAULT '0',
`monthly_shipments`  tinyint(2) not null DEFAULT '0',
`both_products_every_month` tinyint(2) not null DEFAULT '0',
`user_id` int null,
`product_id` int null,
`product_sku` varchar(64)  not null ,
`price` DECIMAL(10,2) NOT NULL DEFAULT '0',
primary key(`libidoorder_id`)
)
ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

SQLTEXT;

$installer->run($sql);
//demo 
//Mage::getModel('core/url_rewrite')->setId(null);
//demo 
$installer->endSetup();
	 