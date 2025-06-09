# 의약품 관리 시스템 개선 작업

	1. 프로젝트 개요
		1.1 프로젝트명
			수수료 경쟁력 분석 시스템

		1.2 목적
			제약회사가 자사 제품의 영업 수수료율이 동일 성분을 가진 경쟁사 제품 대비 어느 정도의 경쟁력을 가지는지 분석할 수 있는 웹 기반 분석 도구 제공

 2. 주요 기능
		2.1 인증 및 접근 제어
			로그인 시스템: 제약회사별 ID/PW 기반 인증
			권한 관리: 로그인한 제약회사는 자사 데이터만 조회 가능
			세션 관리: 로그인 정보 및 회사 정보 관리
		2.2 공지사항 관리
			공지사항 조회: 날짜순 정렬된 공지사항 리스트 제공
			분류별 공지: 제품정보, 품절, 수수료변동, 프로모션, 기타 등 카테고리별 분류
			등급별 관리: 1~4등급으로 중요도 구분
		2.3 데이터 분석 기능
			2.3.1 기본 데이터 조회
			자사 제품 데이터: 로그인한 제약회사의 전체 제품 정보
			경쟁사 데이터: 자사를 제외한 모든 경쟁사 제품 정보
			데이터 구조: 헤더 정보 및 컬럼 구조 제공

			2.3.2 경쟁력 분석
			주성분코드 기반 분석: 동일 주성분을 가진 제품군별 비교
			수수료율 순위: 동일 성분 제품 중 수수료율 기준 순위 산출
			수수료 순위: 절대 수수료 금액 기준 순위 산출
			통계 정보: 최고/평균/최저 수수료율 및 수수료 제공

			2.3.3 대시보드 통계
			전체 제약사 통계: 제품 수, 평균 수수료율, 평균 수수료 기준 랭킹
			분류별 통계: 의약품 분류별 제약사 성과 분석
			다차원 분석: 제품 수, 수수료율, 수수료 등 다양한 지표별 순위

3. 데이터 구조
      CREATE TABLE `tb_admin` (
        `idx` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'IDX',
        `admin_id` varchar(50) NOT NULL COMMENT '관리자 ID',
        `admin_pw` varchar(255) NOT NULL COMMENT '비밀번호',
        `admin_name` varchar(50) NOT NULL COMMENT '관리자명',
        `admin_phone` varchar(15) DEFAULT NULL COMMENT '관리자 연락처',
        `admin_email` varchar(250) DEFAULT NULL COMMENT '관리자 Email',
        `biz_name` varchar(50) DEFAULT NULL COMMENT '관리자 소속사',
        `type_cd` varchar(20) DEFAULT 'A' COMMENT '관리자 타입코드(A:관리자, M:제약사, T:기타)',
        `manufacturer_id` int(10) unsigned DEFAULT NULL COMMENT '관라지 타입이 제약사 일때 제약사 ID',
        `state` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '상태(0:비활성, 1:활성)',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        PRIMARY KEY (`idx`),
        UNIQUE KEY `uk_admin_id` (`admin_id`),
        KEY `idx_type_cd` (`type_cd`)
      ) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='관리자 계정 관리'

      CREATE TABLE `tb_manufacturer` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '제조사ID',
        `biz_reg_no` varchar(20) NOT NULL COMMENT '사업자등록번호',
        `biz_name` varchar(150) NOT NULL COMMENT '업체명',
        `representative_name` varchar(50) NOT NULL COMMENT '대표자명',
        `address_1` varchar(255) DEFAULT NULL COMMENT '주소',
        `address_2` varchar(255) DEFAULT NULL COMMENT '상세주소',
        `permit` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '업체허가정보, [{permit_number:허가번호, permit_date:허가일자, industry_type_cd:업종구분코드, address:주소}]',
        `is_closed` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '폐업여부(0:계속, 1:폐업)',
        `close_date` date DEFAULT NULL COMMENT '폐업일자',
        `state` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '상태(0:비활성, 1:활성)',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uk_manufacturer_biz_reg_no` (`biz_reg_no`) USING BTREE
      ) ENGINE=InnoDB AUTO_INCREMENT=256 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='의약품업체(의약품허가업체)'

      CREATE TABLE `administrative_code` (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '코드ID',
        `group_code` varchar(20) NOT NULL COMMENT '그룹코드',
        `code` varchar(20) NOT NULL COMMENT '코드',
        `parent_code` varchar(20) DEFAULT NULL COMMENT '상위코드',
        `name` varchar(50) NOT NULL COMMENT '코드명',
        `description` varchar(255) DEFAULT NULL COMMENT '코드설명',
        `order` bigint(20) unsigned NOT NULL COMMENT '정렬순서(내림차순)',
        `state` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '상태(0:비활성, 1:활성)',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uk_administrative_code_code` (`group_code`,`code`)
      ) ENGINE=InnoDB AUTO_INCREMENT=1305 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='행정(기관)코드'

      CREATE TABLE `administrative_group_code` (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '그룹코드ID',
        `code` varchar(20) NOT NULL COMMENT '그룹코드',
        `name` varchar(50) NOT NULL COMMENT '그룹코드명',
        `description` varchar(255) DEFAULT NULL COMMENT '그룹코드설명',
        `order` bigint(20) unsigned NOT NULL COMMENT '정렬순서(내림차순)',
        `state` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '상태(0:비활성, 1:활성)',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uk_administrative_group_code_code` (`code`)
      ) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='행정(기관)그룹코드'

      CREATE TABLE `pb_code` (
        `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '코드ID',
        `group_code` varchar(20) NOT NULL COMMENT '그룹코드',
        `parent_code` varchar(20) DEFAULT NULL COMMENT '상위코드',
        `code` varchar(20) NOT NULL COMMENT '코드',
        `name` varchar(50) NOT NULL COMMENT '코드명',
        `description` varchar(255) DEFAULT NULL COMMENT '코드설명',
        `order` bigint(20) unsigned NOT NULL COMMENT '정렬순서(내림차순)',
        `state` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '상태(0:비활성, 1:활성)',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uk_code_code` (`code`),
        KEY `idx_code_group_code` (`group_code`),
        KEY `fk_code_parent_code` (`parent_code`),
        CONSTRAINT `fk_code_parent_code` FOREIGN KEY (`parent_code`) REFERENCES `pb_code` (`code`)
      ) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='코드'

      CREATE TABLE `tb_active_ingredient` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '성분ID',
        `code` varchar(50) NOT NULL COMMENT '성분코드',
        `name` varchar(255) NOT NULL COMMENT '성분명',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uk_ingredient_code` (`code`),
        UNIQUE KEY `uk_ingredient_name` (`name`)
      ) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='활성 성분 마스터 정보'

      CREATE TABLE `tb_product` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '제품ID',
        `manufacturer_id` int(10) NOT NULL COMMENT '제약사 ID',
        `drug_class_cd` varchar(20) DEFAULT NULL COMMENT '의약품분류코드-행정코드참조',
        `name` varchar(255) NOT NULL COMMENT '제품명',
        `edi_code` varchar(20) DEFAULT NULL COMMENT '보험코드',
        `reimbursement_price` decimal(15,3) DEFAULT NULL COMMENT '보험약가',
        `sales_commission_rate` decimal(5,4) DEFAULT NULL COMMENT '판매수수료율',
        `commission` decimal(15,3) unsigned DEFAULT 0.000 COMMENT '수수료',
        `state` varchar(10) NOT NULL DEFAULT '1' COMMENT '상태 (0: 판매중지, 1: 판매중)',
        `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
        `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
        `is_self_product` tinyint(1) NOT NULL DEFAULT 0 COMMENT '자사제품 여부 (0:아님, 1:자사)',
        PRIMARY KEY (`id`),
        UNIQUE KEY `uk_product_name_manufacturer` (`name`,`manufacturer_id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=10220 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='의약품 제품 정보'

      CREATE TABLE `tb_product_active_ingredient` (
  `product_id` int(10) unsigned NOT NULL COMMENT '제품ID (tb_product 참조)',
  `ingredient_id` int(10) unsigned NOT NULL COMMENT '성분ID (tb_active_ingredient 참조)',
  PRIMARY KEY (`product_id`,`ingredient_id`),
  KEY `fk_prod_ingredient_ingredient_id` (`ingredient_id`),
  CONSTRAINT `fk_prod_ingredient_ingredient_id` FOREIGN KEY (`ingredient_id`) REFERENCES `tb_active_ingredient` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_prod_ingredient_product_id` FOREIGN KEY (`product_id`) REFERENCES `tb_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='제품-활성 성분 연결'

CREATE TABLE `tb_product_notice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '제품공지ID',
  `noti_date` date DEFAULT NULL COMMENT '공지일',
  `product_id` int(10) unsigned DEFAULT NULL COMMENT '제품ID (tb_product 참조)',
  `notice_class_cd` varchar(20) NOT NULL COMMENT '공지분류코드',
  `content` text DEFAULT NULL COMMENT '공지내용',
  `noti_crisis_level` char(1) DEFAULT NULL COMMENT '공지 중요도 (예: A, B, C)',
  `noti_category` char(1) DEFAULT NULL COMMENT '공지 카테고리 (예: L, M, S)',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '생성일시',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '수정일시',
  PRIMARY KEY (`id`),
  KEY `idx_notice_noti_date` (`noti_date`),
  KEY `fk_product_notice_product_id` (`product_id`),
  CONSTRAINT `fk_product_notice_product_id` FOREIGN KEY (`product_id`) REFERENCES `tb_product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='제품 공지사항'
