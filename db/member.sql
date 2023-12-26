CREATE TABLE `member`(
	`uid` INT NOT NULL PRIMARY KEY AUTO_INCREMENT
    ,`id` VARCHAR(16) NOT NULL UNIQUE
    ,`password` CHAR(64) NOT NULL
    ,`email` VARCHAR(64) NOT NULL
    ,`mobileNumber` CHAR(12) NOT NULL
    ,`telNumber` CHAR(12)
    ,`postalCode` CHAR(12) NOT NULL
    ,`address` VARCHAR(64) NOT NULL
    ,`additionalAddress` VARCHAR(32)
    ,`smsAgreed` BOOLEAN DEFAULT FALSE
    ,`mailAgreed` BOOLEAN DEFAULT FALSE
    ,`regDttm` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	,`modDttm` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;