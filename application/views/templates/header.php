<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - 의약품 관리 시스템' : '의약품 관리 시스템'; ?></title>
    
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
            padding-bottom: 120px; /* 푸터 공간 확보 */
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

        /* 네비게이션 바 */
        .navbar {
            background: rgba(255, 255, 255, 0.25) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: var(--shadow-md);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            color: white !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem !important;
            border-radius: 10px;
            margin: 0 0.2rem;
        }

        .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: white !important;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: white;
            border-radius: 2px;
        }

        /* 사용자 정보 스타일 */
        .user-info {
            color: rgba(255, 255, 255, 0.9) !important;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 0.4rem 1rem !important;
            margin-right: 0.5rem;
            font-weight: 500;
        }

        /* 로그아웃 버튼 */
        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white !important;
            border-radius: 15px;
            padding: 0.4rem 1rem !important;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            color: white !important;
        }

        /* 메인 컨테이너 */
        .main-content {
            padding: 2rem 0;
            min-height: calc(100vh - 100px);
        }

        /* 토글 버튼 스타일 */
        .navbar-toggler {
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* 페이지 헤더 스타일 */
        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .page-header h1 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* 반응형 디자인 */
        @media (max-width: 991.98px) {
            .navbar-nav {
                background: rgba(255, 255, 255, 0.1);
                border-radius: 15px;
                padding: 1rem;
                margin-top: 1rem;
            }
            
            .nav-link {
                margin: 0.2rem 0;
            }
            
            .user-info, .logout-btn {
                margin: 0.2rem 0;
            }

            .page-header h1 {
                font-size: 2rem;
            }
            
            .page-header {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <i class="fas fa-pills me-2"></i>의약품 관리 시스템
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php
                    $current_url = uri_string(); // 현재 URL 세그먼트 가져오기
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($current_url === 'dashboard' || $current_url === '') ? 'active' : ''; ?>" href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>대시보드
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($current_url, 'drug_class') === 0) ? 'active' : ''; ?>" href="<?php echo base_url('drug_class'); ?>">
                            <i class="fas fa-chart-bar me-1"></i>분류 현황
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($current_url, 'product_search') === 0) ? 'active' : ''; ?>" href="<?php echo base_url('product_search'); ?>">
                            <i class="fas fa-search me-1"></i>제품 검색
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($current_url, 'notice') === 0) ? 'active' : ''; ?>" href="<?php echo base_url('notice'); ?>">
                            <i class="fas fa-bell me-1"></i>공지사항
                        </a>
                    </li>
                </ul>
                
                <?php if ($this->session->userdata('admin_logged_in')): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link user-info">
                            <i class="fas fa-user me-1"></i> 
                            <?php echo $this->session->userdata('admin_name') ?: '관리자'; ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link logout-btn" href="<?php echo base_url('auth/logout'); ?>">
                            <i class="fas fa-sign-out-alt me-1"></i>로그아웃
                        </a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container-fluid main-content">
        <?php if (isset($page_title) && isset($page_description)): ?>
        <!-- 페이지 헤더 -->
        <div class="page-header">
            <h1><?php echo isset($page_icon) ? '<i class="' . $page_icon . ' me-3"></i>' : ''; ?><?php echo $page_title; ?></h1>
            <p><?php echo $page_description; ?></p>
        </div>
        <?php endif; ?> 