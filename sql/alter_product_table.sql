-- 수수료율 컬럼 추가
ALTER TABLE `tb_product` 
ADD COLUMN `commission_rate` DECIMAL(5,2) DEFAULT 0.00 COMMENT '수수료율 (%)' AFTER `product_name`;

-- 수수료 금액 컬럼 추가
ALTER TABLE `tb_product` 
ADD COLUMN `commission_amount` INT DEFAULT 0 COMMENT '수수료 금액' AFTER `commission_rate`;

-- 상태 컬럼 추가
ALTER TABLE `tb_product` 
ADD COLUMN `state` TINYINT(1) DEFAULT 1 COMMENT '상태 (1: 판매중, 0: 판매중지)' AFTER `commission_amount`;

-- 기존 데이터 삭제
TRUNCATE TABLE `tb_product`;

-- 샘플 데이터 추가
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