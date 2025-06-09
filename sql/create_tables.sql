-- 제조사 테이블
CREATE TABLE IF NOT EXISTS `tb_manufacturer` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `biz_name` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 제품 테이블
CREATE TABLE IF NOT EXISTS `tb_product` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `manufacturer_id` INT NOT NULL,
    `product_name` VARCHAR(200) NOT NULL,
    `commission_rate` DECIMAL(5,2) DEFAULT 0.00 COMMENT '수수료율 (%)',
    `commission_amount` INT DEFAULT 0 COMMENT '수수료 금액',
    `state` TINYINT(1) DEFAULT 1 COMMENT '상태 (1: 판매중, 0: 판매중지)',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`manufacturer_id`) REFERENCES `tb_manufacturer`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 샘플 데이터 추가
INSERT INTO `tb_manufacturer` (`biz_name`) VALUES 
('삼성전자'),
('LG전자'),
('SK하이닉스'),
('현대자동차'),
('기아자동차');

-- 샘플 제품 데이터 추가
INSERT INTO `tb_product` (`manufacturer_id`, `product_name`, `commission_rate`, `commission_amount`, `state`) VALUES 
(1, 'Galaxy S24', 3.50, 35000, 1),
(1, 'Galaxy Tab S9', 4.00, 40000, 1),
(1, 'Samsung TV QN90C', 2.50, 75000, 1),
(2, 'LG OLED TV C3', 2.75, 82500, 1),
(2, 'LG 그램', 3.25, 45500, 1),
(3, 'DDR5 RAM', 5.00, 25000, 1),
(3, 'NAND Flash', 4.50, 22500, 1),
(4, '아이오닉 6', 1.75, 525000, 1),
(5, 'EV6', 1.50, 450000, 1); 