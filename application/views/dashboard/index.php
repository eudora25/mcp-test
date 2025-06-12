<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>의약품 관리 시스템 - 대시보드</title>
    
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
            --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
            
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-muted: #718096;
            
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

        /* 네비게이션 바 */
        .navbar {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--shadow-md);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: white !important;
            font-weight: 600;
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

        /* 대시보드 컨테이너 */
        .dashboard-container {
            padding: 2rem 0;
            min-height: calc(100vh - 100px);
        }

        /* 통계 카드 */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 20px 20px 0 0;
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .stats-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stats-card .primary-icon { background: var(--primary-gradient); }
        .stats-card .success-icon { background: var(--success-gradient); }
        .stats-card .warning-icon { background: var(--warning-gradient); }
        .stats-card .info-icon { background: var(--info-gradient); }

        .stats-card h3 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stats-card p {
            color: var(--text-secondary);
            font-weight: 500;
            margin-bottom: 0;
        }

        .stats-card .subtitle {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* 데이터 카드 */
        .data-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .data-card .card-header {
            background: rgba(102, 126, 234, 0.1);
            border-bottom: 1px solid rgba(102, 126, 234, 0.2);
            padding: 1.5rem;
            border-radius: 0;
        }

        .data-card .card-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .data-card .card-body {
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.8);
        }

        /* 테이블 스타일 */
        .table {
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .table th {
            border-color: rgba(102, 126, 234, 0.2);
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.9rem;
            padding: 1rem 0.75rem;
            background: rgba(102, 126, 234, 0.05);
        }

        .table td {
            border-color: rgba(102, 126, 234, 0.1);
            color: var(--text-secondary);
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.08);
        }

        /* 버튼 스타일 */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: var(--primary-gradient);
        }

        .btn-success {
            background: var(--success-gradient);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            background: var(--success-gradient);
        }

        .btn-sm {
            padding: 0.25rem 1rem;
            font-size: 0.875rem;
        }

        /* 웰컴 섹션 */
        .welcome-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h1 {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: none;
        }

        .welcome-section p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* 반응형 디자인 */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem 0;
            }
            
            .stats-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .stats-card h3 {
                font-size: 1.5rem;
            }
            
            .welcome-section h1 {
                font-size: 2rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* 로딩 애니메이션 */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* 뱃지 스타일 */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
        }

        .badge-success {
            background: var(--success-gradient);
        }

        .badge-danger {
            background: var(--secondary-gradient);
        }

        .badge-info {
            background: var(--info-gradient);
        }
    </style>
</head>
<body>
    <!-- 네비게이션 -->
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
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>대시보드
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('drug_class'); ?>">
                            <i class="fas fa-chart-bar me-1"></i>분류 현황
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('product_search'); ?>">
                            <i class="fas fa-search me-1"></i>제품 검색
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-user me-1"></i> 
                            <?php echo $this->session->userdata('admin_name') ?: '관리자'; ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>">
                            <i class="fas fa-sign-out-alt me-1"></i>로그아웃
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- 대시보드 컨테이너 -->
    <div class="container-fluid dashboard-container">
        <!-- 웰컴 섹션 -->
        <div class="welcome-section">
            <h1><i class="fas fa-chart-line me-3"></i>대시보드</h1>
            <p><?php echo $this->session->userdata('admin_name') ?: '관리자'; ?>님, 의약품 관리 시스템에 오신 것을 환영합니다!</p>
        </div>

        <!-- 통계 카드 -->
        <div class="row mb-4">
            <!-- 제조사 통계 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="icon primary-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3><?php echo number_format($manufacturer_stats['total'] ?? 0); ?></h3>
                    <p>총 제조사 수</p>
                    <div class="subtitle">
                        <span class="badge badge-success me-2">활성 <?php echo number_format($manufacturer_stats['active'] ?? 0); ?></span>
                        <span class="badge badge-danger">비활성 <?php echo number_format($manufacturer_stats['inactive'] ?? 0); ?></span>
                    </div>
                </div>
            </div>

            <!-- 제품 수 통계 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="icon success-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h3><?php echo number_format($product_stats['total'] ?? 0); ?></h3>
                    <p>총 제품 수</p>
                    <div class="subtitle">
                        <span class="badge badge-success me-2">판매중 <?php echo number_format($product_stats['on_sale'] ?? 0); ?></span>
                        <span class="badge badge-danger">중지 <?php echo number_format($product_stats['off_sale'] ?? 0); ?></span>
                    </div>
                </div>
            </div>

            <!-- 평균 수수료율 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="icon warning-icon">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h3><?php echo number_format(($commission_rate_rank['rate'] ?? 0) * 100, 2); ?>%</h3>
                    <p>평균 수수료율</p>
                    <?php if (($commission_rate_rank['rank'] ?? 0) > 0): ?>
                    <div class="subtitle">
                        <span class="badge badge-info"><?php echo $commission_rate_rank['rank']; ?>위 / <?php echo $commission_rate_rank['total']; ?>개사</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 평균 수수료 -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="icon info-icon">
                        <i class="fas fa-won-sign"></i>
                    </div>
                    <h3><?php echo number_format($commission_amount_rank['amount'] ?? 0, 0); ?></h3>
                    <p>평균 수수료 (원)</p>
                    <?php if (($commission_amount_rank['rank'] ?? 0) > 0): ?>
                    <div class="subtitle">
                        <span class="badge badge-info"><?php echo $commission_amount_rank['rank']; ?>위 / <?php echo $commission_amount_rank['total']; ?>개사</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- 분류 현황 -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="data-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">
                            <i class="fas fa-chart-pie me-2"></i>상위 10개 의약품 분류 현황
                        </h5>
                        <a href="<?php echo base_url('drug_class'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>모두 보기
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-tag me-1"></i>분류명</th>
                                        <th><i class="fas fa-boxes me-1"></i>제품수</th>
                                        <th><i class="fas fa-percentage me-1"></i>평균 수수료율</th>
                                        <th><i class="fas fa-trophy me-1"></i>수수료율 순위</th>
                                        <th><i class="fas fa-won-sign me-1"></i>평균 수수료</th>
                                        <th><i class="fas fa-medal me-1"></i>수수료 순위</th>
                                        <th><i class="fas fa-info-circle me-1"></i>상세</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($top_classes)): ?>
                                        <?php foreach ($top_classes as $class): ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                echo htmlspecialchars($class->drug_class_name ?? $class->drug_class_cd ?? 'N/A');
                                                ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-success"><?php echo number_format($class->product_count ?? 0); ?></span>
                                            </td>
                                            <td><?php echo number_format(($class->avg_commission_rate ?? 0) * 100, 2); ?>%</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    <?php echo number_format($class->commission_rate_rank_num ?? 0); ?>/<?php echo number_format($class->total_count ?? 0); ?>
                                                </span>
                                            </td>
                                            <td><?php echo number_format($class->avg_commission ?? 0, 0); ?>원</td>
                                            <td>
                                                <span class="badge badge-info">
                                                    <?php echo number_format($class->commission_rank_num ?? 0); ?>/<?php echo number_format($class->total_count ?? 0); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('drug_class/detail/'.($class->drug_class_cd ?? '')); ?>" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>상세보기
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">데이터가 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 최근 데이터 -->
        <div class="row">
            <!-- 최근 등록된 제품 -->
            <div class="col-xl-6 mb-4">
                <div class="data-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-clock me-2"></i>최근 등록된 제품
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>제품명</th>
                                        <th>제조사</th>
                                        <th>등록일</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_products)): ?>
                                        <?php foreach ($recent_products as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product->product_name ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($product->manufacturer_name ?? 'N/A'); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($product->created_at ?? 'now')); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">데이터가 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 최근 수정된 제조사 -->
            <div class="col-xl-6 mb-4">
                <div class="data-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-edit me-2"></i>최근 수정된 제조사
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>제조사명</th>
                                        <th>대표자</th>
                                        <th>수정일</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_manufacturers)): ?>
                                        <?php foreach ($recent_manufacturers as $manufacturer): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($manufacturer->biz_name ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($manufacturer->representative_name ?? 'N/A'); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($manufacturer->updated_at ?? 'now')); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center">데이터가 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 최근 제품 공지사항 -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="data-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title">
                            <i class="fas fa-bullhorn me-2"></i>경쟁사 공지사항
                        </h5>
                        <a href="<?php echo base_url('notice'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-list me-1"></i>전체보기
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>공지일</th>
                                        <th>제품명</th>
                                        <th>제조사</th>
                                        <th>분류</th>
                                        <th>중요도</th>
                                        <th>카테고리</th>
                                        <th>내용</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_notices)): ?>
                                        <?php foreach ($recent_notices as $notice): ?>
                                        <tr>
                                            <td><?php echo date('Y-m-d', strtotime($notice->noti_date ?? 'now')); ?></td>
                                            <td><?php echo htmlspecialchars($notice->product_name ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($notice->manufacturer_name ?? 'N/A'); ?></td>
                                            <td><?php echo htmlspecialchars($notice->notice_class_name ?? $notice->notice_class_cd ?? 'N/A'); ?></td>
                                            <td>
                                                <?php 
                                                $importance = $notice->importance ?? 'normal';
                                                $badge_class = $importance === 'high' ? 'badge-danger' : ($importance === 'medium' ? 'badge-info' : 'badge-success');
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>">
                                                    <?php echo $importance === 'high' ? '높음' : ($importance === 'medium' ? '보통' : '낮음'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($notice->category ?? 'N/A'); ?></td>
                                            <td>
                                                <?php 
                                                $content = $notice->contents ?? 'N/A';
                                                echo htmlspecialchars(mb_strlen($content) > 50 ? mb_substr($content, 0, 50) . '...' : $content);
                                                ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">데이터가 없습니다.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            // 통계 카드 애니메이션
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 150);
            });

            // 데이터 카드 애니메이션
            const dataCards = document.querySelectorAll('.data-card');
            dataCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, (index + 4) * 150);
            });

            // 테이블 행 호버 효과
            document.querySelectorAll('.table tbody tr').forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02)';
                    this.style.transition = 'transform 0.2s ease';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // 네비게이션 활성 상태 설정
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href'))) {
                    link.classList.add('active');
                }
            });
        });

        // 실시간 시계
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('ko-KR');
            const dateString = now.toLocaleDateString('ko-KR');
            
            // 시계 요소가 있다면 업데이트
            const clockElement = document.getElementById('current-time');
            if (clockElement) {
                clockElement.textContent = `${dateString} ${timeString}`;
            }
        }

        // 1초마다 시계 업데이트
        setInterval(updateClock, 1000);
        updateClock(); // 초기 호출

        // 부드러운 스크롤 효과
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // 로딩 상태 관리
        function showLoading(element) {
            const spinner = document.createElement('div');
            spinner.className = 'loading-spinner';
            element.appendChild(spinner);
        }

        function hideLoading(element) {
            const spinner = element.querySelector('.loading-spinner');
            if (spinner) {
                spinner.remove();
            }
        }

        // 툴팁 초기화 (Bootstrap 5)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        console.log('대시보드가 성공적으로 로드되었습니다! 🚀');
    </script>
</body>
</html> 