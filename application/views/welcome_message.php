<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>의약품 관리 시스템에 오신 것을 환영합니다</title>
	
	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<style>
		:root {
			--primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			--secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
			--success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
			--warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
			--info-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
			
			--text-primary: #2c3e50;
			--text-secondary: #7f8c8d;
			--text-muted: #bdc3c7;
			--text-dark: #2d3748;
			--text-light: #a0aec0;
			
			--shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
			--shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
			--shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
			--shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.1);
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Inter', sans-serif;
			background: var(--primary-gradient);
			min-height: 100vh;
			position: relative;
			overflow-x: hidden;
		}

		/* 배경 애니메이션 */
		body::before {
			content: '';
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: var(--primary-gradient);
			z-index: -2;
		}

		body::after {
			content: '';
			position: fixed;
			top: -50%;
			left: -50%;
			width: 200%;
			height: 200%;
			background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"><animate attributeName="cy" values="20;80;20" dur="4s" repeatCount="indefinite"/></circle><circle cx="40" cy="40" r="1.5" fill="rgba(255,255,255,0.08)"><animate attributeName="cy" values="40;10;40" dur="3s" repeatCount="indefinite"/></circle><circle cx="60" cy="30" r="1" fill="rgba(255,255,255,0.06)"><animate attributeName="cy" values="30;70;30" dur="5s" repeatCount="indefinite"/></circle><circle cx="80" cy="50" r="2.5" fill="rgba(255,255,255,0.04)"><animate attributeName="cy" values="50;20;50" dur="3.5s" repeatCount="indefinite"/></circle></svg>');
			opacity: 0.3;
			z-index: -1;
			animation: float 20s infinite linear;
		}

		@keyframes float {
			0% { transform: translate(-50%, -50%) rotate(0deg); }
			100% { transform: translate(-50%, -50%) rotate(360deg); }
		}

		/* 메인 컨테이너 */
		.welcome-container {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			padding: 2rem;
		}

		/* 웰컴 카드 */
		.welcome-card {
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(20px);
			border: 1px solid rgba(255, 255, 255, 0.3);
			border-radius: 25px;
			padding: 4rem 3rem;
			max-width: 800px;
			width: 100%;
			box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
			text-align: center;
			transition: all 0.3s ease;
		}

		.welcome-card:hover {
			background: rgba(255, 255, 255, 1);
			transform: translateY(-10px);
			box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
		}

		/* 로고 및 아이콘 */
		.welcome-icon {
			font-size: 5rem;
			background: var(--primary-gradient);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
			margin-bottom: 2rem;
			animation: pulse 2s infinite;
		}

		@keyframes pulse {
			0%, 100% { transform: scale(1); }
			50% { transform: scale(1.05); }
		}

		/* 제목 스타일 */
		.welcome-title {
			color: var(--text-primary);
			font-weight: 700;
			font-size: 3rem;
			margin-bottom: 1rem;
			line-height: 1.2;
		}

		.welcome-subtitle {
			color: var(--text-secondary);
			font-size: 1.3rem;
			margin-bottom: 3rem;
			font-weight: 400;
		}

		/* 기능 카드들 */
		.features-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
			gap: 2rem;
			margin: 3rem 0;
		}

		.feature-card {
			background: rgba(255, 255, 255, 0.8);
			border-radius: 20px;
			padding: 2rem 1.5rem;
			text-align: center;
			transition: all 0.3s ease;
			border: 1px solid rgba(102, 126, 234, 0.1);
		}

		.feature-card:hover {
			background: rgba(255, 255, 255, 1);
			transform: translateY(-5px);
			box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
		}

		.feature-icon {
			font-size: 2.5rem;
			margin-bottom: 1rem;
			background: var(--info-gradient);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
			background-clip: text;
		}

		.feature-title {
			color: var(--text-primary);
			font-weight: 600;
			font-size: 1.1rem;
			margin-bottom: 0.5rem;
		}

		.feature-desc {
			color: var(--text-secondary);
			font-size: 0.9rem;
			line-height: 1.5;
		}

		/* 액션 버튼들 */
		.action-buttons {
			display: flex;
			flex-wrap: wrap;
			gap: 1.5rem;
			justify-content: center;
			margin-top: 3rem;
		}

		.btn-action {
			background: var(--primary-gradient);
			border: none;
			color: white;
			padding: 1rem 2.5rem;
			border-radius: 20px;
			font-weight: 600;
			font-size: 1.1rem;
			text-decoration: none;
			transition: all 0.3s ease;
			box-shadow: var(--shadow-md);
			display: inline-flex;
			align-items: center;
			gap: 0.5rem;
		}

		.btn-action:hover {
			transform: translateY(-3px);
			box-shadow: var(--shadow-lg);
			color: white;
		}

		.btn-secondary {
			background: transparent;
			border: 2px solid rgba(255, 255, 255, 0.3);
			color: var(--text-primary);
		}

		.btn-secondary:hover {
			background: rgba(102, 126, 234, 0.1);
			border-color: #667eea;
			color: var(--text-primary);
		}

		/* 시스템 정보 */
		.system-info {
			background: rgba(102, 126, 234, 0.1);
			border-radius: 15px;
			padding: 1.5rem;
			margin-top: 3rem;
			border-left: 4px solid #667eea;
		}

		.system-info h5 {
			color: var(--text-primary);
			margin-bottom: 1rem;
			font-weight: 600;
		}

		.info-item {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0.5rem 0;
			border-bottom: 1px solid rgba(102, 126, 234, 0.1);
		}

		.info-item:last-child {
			border-bottom: none;
		}

		.info-label {
			color: var(--text-secondary);
			font-weight: 500;
		}

		.info-value {
			color: var(--text-primary);
			font-weight: 600;
			font-family: monospace;
		}

		/* 반응형 디자인 */
		@media (max-width: 768px) {
			.welcome-container {
				padding: 1rem;
			}
			
			.welcome-card {
				padding: 2rem 1.5rem;
			}
			
			.welcome-title {
				font-size: 2rem;
			}
			
			.welcome-subtitle {
				font-size: 1.1rem;
			}
			
			.features-grid {
				grid-template-columns: 1fr;
				gap: 1.5rem;
			}
			
			.action-buttons {
				flex-direction: column;
				align-items: center;
			}
			
			.btn-action {
				width: 100%;
				max-width: 300px;
				justify-content: center;
			}
		}

		/* 로딩 애니메이션 */
		.loading-spinner {
			display: inline-block;
			width: 20px;
			height: 20px;
			border: 3px solid rgba(102, 126, 234, 0.3);
			border-radius: 50%;
			border-top-color: #667eea;
			animation: spin 1s ease-in-out infinite;
		}

		@keyframes spin {
			to { transform: rotate(360deg); }
		}
	</style>
</head>
<body>
	<div class="welcome-container">
		<div class="welcome-card">
			<!-- 로고 및 아이콘 -->
			<div class="welcome-icon">
				<i class="fas fa-pills"></i>
			</div>
			
			<!-- 메인 제목 -->
			<h1 class="welcome-title">의약품 관리 시스템</h1>
			<p class="welcome-subtitle">
				전문적이고 효율적인 의약품 정보 관리를 위한 통합 플랫폼
			</p>
			
			<!-- 주요 기능 소개 -->
			<div class="features-grid">
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-search"></i>
					</div>
					<h5 class="feature-title">제품 검색</h5>
					<p class="feature-desc">제품명, 성분명, 보험코드로 빠른 검색</p>
				</div>
				
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-chart-bar"></i>
					</div>
					<h5 class="feature-title">분류 현황</h5>
					<p class="feature-desc">의약품 분류별 통계 및 현황 분석</p>
				</div>
				
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-bell"></i>
					</div>
					<h5 class="feature-title">공지사항</h5>
					<p class="feature-desc">중요한 의약품 관련 정보 및 업데이트</p>
				</div>
				
				<div class="feature-card">
					<div class="feature-icon">
						<i class="fas fa-tachometer-alt"></i>
					</div>
					<h5 class="feature-title">대시보드</h5>
					<p class="feature-desc">한눈에 보는 종합 관리 현황</p>
				</div>
			</div>
			
			<!-- 액션 버튼들 -->
			<div class="action-buttons">
				<a href="<?php echo base_url('auth/login'); ?>" class="btn-action">
					<i class="fas fa-sign-in-alt"></i>로그인하기
				</a>
				<a href="<?php echo base_url('dashboard'); ?>" class="btn-action btn-secondary">
					<i class="fas fa-tachometer-alt"></i>대시보드 보기
				</a>
			</div>
			
			<!-- 시스템 정보 -->
			<div class="system-info">
				<h5><i class="fas fa-info-circle me-2"></i>시스템 정보</h5>
				<div class="info-item">
					<span class="info-label">플랫폼</span>
					<span class="info-value">CodeIgniter <?php echo CI_VERSION; ?></span>
				</div>
				<div class="info-item">
					<span class="info-label">PHP 버전</span>
					<span class="info-value"><?php echo phpversion(); ?></span>
				</div>
				<div class="info-item">
					<span class="info-label">환경</span>
					<span class="info-value"><?php echo ucfirst(ENVIRONMENT); ?></span>
				</div>
				<div class="info-item">
					<span class="info-label">페이지 로딩 시간</span>
					<span class="info-value">{elapsed_time} 초</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

	<script>
		// 페이지 로드 시 애니메이션
		document.addEventListener('DOMContentLoaded', function() {
			// 웰컴 카드 애니메이션
			const welcomeCard = document.querySelector('.welcome-card');
			welcomeCard.style.opacity = '0';
			welcomeCard.style.transform = 'translateY(50px) scale(0.9)';
			welcomeCard.style.transition = 'all 1s ease';
			
			setTimeout(() => {
				welcomeCard.style.opacity = '1';
				welcomeCard.style.transform = 'translateY(0) scale(1)';
			}, 200);

			// 기능 카드들 순차 애니메이션
			const featureCards = document.querySelectorAll('.feature-card');
			featureCards.forEach((card, index) => {
				setTimeout(() => {
					card.style.opacity = '0';
					card.style.transform = 'translateY(30px)';
					card.style.transition = 'all 0.6s ease';
					
					setTimeout(() => {
						card.style.opacity = '1';
						card.style.transform = 'translateY(0)';
					}, 100);
				}, index * 200 + 800);
			});

			// 액션 버튼들 애니메이션
			const actionButtons = document.querySelectorAll('.btn-action');
			actionButtons.forEach((btn, index) => {
				setTimeout(() => {
					btn.style.opacity = '0';
					btn.style.transform = 'translateX(-30px)';
					btn.style.transition = 'all 0.5s ease';
					
					setTimeout(() => {
						btn.style.opacity = '1';
						btn.style.transform = 'translateX(0)';
					}, 100);
				}, index * 200 + 1400);
			});

			// 시스템 정보 애니메이션
			const systemInfo = document.querySelector('.system-info');
			setTimeout(() => {
				systemInfo.style.opacity = '0';
				systemInfo.style.transform = 'translateY(20px)';
				systemInfo.style.transition = 'all 0.6s ease';
				
				setTimeout(() => {
					systemInfo.style.opacity = '1';
					systemInfo.style.transform = 'translateY(0)';
				}, 100);
			}, 1800);
		});

		// 로그인 버튼 클릭 시 로딩 표시
		document.querySelector('a[href*="login"]').addEventListener('click', function(e) {
			const originalText = this.innerHTML;
			this.innerHTML = '<div class="loading-spinner me-2"></div>로그인 페이지로 이동 중...';
			this.style.pointerEvents = 'none';
			
			// 실제 페이지 이동을 위해 약간의 지연
			setTimeout(() => {
				window.location.href = this.href;
			}, 500);
			
			e.preventDefault();
		});

		// 버튼 호버 효과
		document.querySelectorAll('.btn-action, .feature-card').forEach(element => {
			element.addEventListener('mouseenter', function() {
				this.style.transform = 'translateY(-5px)';
			});
			
			element.addEventListener('mouseleave', function() {
				this.style.transform = 'translateY(0)';
			});
		});

		// 환영 메시지 타이핑 효과 (선택적)
		function typeWriter(element, text, speed = 100) {
			let i = 0;
			element.innerHTML = '';
			
			function type() {
				if (i < text.length) {
					element.innerHTML += text.charAt(i);
					i++;
					setTimeout(type, speed);
				}
			}
			type();
		}

		// 3초 후 환영 메시지 시작
		setTimeout(() => {
			const subtitle = document.querySelector('.welcome-subtitle');
			const originalText = subtitle.textContent;
			typeWriter(subtitle, originalText, 50);
		}, 2500);

		console.log('의약품 관리 시스템 환영 페이지가 성공적으로 로드되었습니다! 💊');
	</script>
</body>
</html>
