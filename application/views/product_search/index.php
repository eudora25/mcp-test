<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>의약품 관리 시스템 - 제품 검색</title>
    
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
            --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
            
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

        /* 메인 컨테이너 */
        .main-container {
            padding: 2rem 0;
            min-height: calc(100vh - 100px);
        }

        /* 페이지 헤더 */
        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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

        /* 검색 카드 */
        .search-hero {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .search-hero:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
        }

        .search-hero h2 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .search-hero p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .search-form {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .search-input-group {
            display: flex;
            gap: 1rem;
            align-items: stretch;
        }

        .search-input {
            flex: 1;
            border: 3px solid rgba(102, 126, 234, 0.2);
            border-radius: 20px;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
            background: white;
            outline: none;
            transform: scale(1.02);
        }

        .search-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            min-width: 140px;
        }

        .search-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .search-examples {
            margin-top: 1.5rem;
            text-align: center;
        }

        .search-examples span {
            display: inline-block;
            background: rgba(102, 126, 234, 0.1);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin: 0.25rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-examples span:hover {
            background: rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        /* 결과 카드 */
        .results-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .results-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 1);
        }

        .results-card .card-header {
            background: rgba(102, 126, 234, 0.1);
            border-bottom: 1px solid rgba(102, 126, 234, 0.2);
            padding: 1.5rem;
        }

        .results-card .card-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .results-card .card-body {
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
            white-space: nowrap;
        }

        .table td {
            border-color: rgba(102, 126, 234, 0.1);
            color: var(--text-secondary);
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(102, 126, 234, 0.08);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* 제품명 스타일 */
        .product-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        /* 뱃지 스타일 */
        .ingredient-badge {
            background: var(--info-gradient);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            margin: 0.1rem;
            display: inline-block;
        }

        .edi-code-badge {
            background: rgba(102, 126, 234, 0.1);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-family: monospace;
            font-weight: 600;
        }

        /* 가격 스타일 */
        .price-cell {
            font-weight: 600;
            color: var(--text-primary);
        }

        .commission-rate {
            background: var(--success-gradient);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .commission-amount {
            color: #e74c3c;
            font-weight: 700;
        }

        /* 버튼 스타일 */
        .btn-analysis {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-analysis:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        /* 빈 상태 및 알림 */
        .empty-search-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-search-state i {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .empty-search-state h3 {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .empty-search-state p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .no-results {
            background: rgba(255, 193, 7, 0.1);
            border-left: 4px solid #ffc107;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
        }

        .no-results i {
            color: #ffc107;
            margin-right: 0.5rem;
        }

        /* 반응형 디자인 */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem 0;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
            
            .search-hero {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }
            
            .search-input-group {
                flex-direction: column;
                gap: 1rem;
            }
            
            .search-btn {
                width: 100%;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .table th, .table td {
                padding: 0.5rem 0.25rem;
            }
        }

        /* 로딩 스피너 */
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

        /* 검색어 하이라이팅 */
        mark {
            background: rgba(255, 235, 59, 0.3);
            padding: 0.1rem 0.3rem;
            border-radius: 4px;
            font-weight: 600;
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
                        <a class="nav-link" href="<?php echo base_url('dashboard'); ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>대시보드
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('drug_class'); ?>">
                            <i class="fas fa-chart-bar me-1"></i>분류 현황
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url('product_search'); ?>">
                            <i class="fas fa-search me-1"></i>제품 검색
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('notice'); ?>">
                            <i class="fas fa-bell me-1"></i>공지사항
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

    <!-- 메인 컨테이너 -->
    <div class="container-fluid main-container">
        <!-- 검색 히어로 섹션 -->
        <div class="search-hero">
            <h2><i class="fas fa-search me-3"></i>제품 검색</h2>
            <p>제품명, 성분명, 보험코드로 의약품을 빠르게 찾아보세요</p>
            
            <form action="<?php echo site_url('product_search'); ?>" method="get" class="search-form" id="searchForm">
                <div class="search-input-group">
                    <input type="text" name="search" class="search-input" 
                           value="<?php echo htmlspecialchars($search_keyword ?? ''); ?>" 
                           placeholder="제품명, 성분명, 보험코드를 입력하세요..."
                           autocomplete="off">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search me-2"></i>검색
                    </button>
                </div>
            </form>
            
            <div class="search-examples">
                <small class="text-muted d-block mb-2">검색 예시:</small>
                <span onclick="searchExample('타이레놀')">타이레놀</span>
                <span onclick="searchExample('아세트아미노펜')">아세트아미노펜</span>
                <span onclick="searchExample('640000080')">640000080</span>
                <span onclick="searchExample('낙센')">낙센</span>
            </div>
        </div>

        <!-- 검색 결과 -->
        <?php if (!empty($search_keyword)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="results-card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="fas fa-list-alt me-2"></i>검색 결과
                                <small class="text-muted">- "<?php echo htmlspecialchars($search_keyword); ?>"</small>
                                <?php if (!empty($products)): ?>
                                    <span class="badge bg-primary ms-2"><?php echo count($products); ?>건</span>
                                <?php endif; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($products)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-pills me-1"></i>제품명</th>
                                                <th><i class="fas fa-industry me-1"></i>제조사</th>
                                                <th><i class="fas fa-flask me-1"></i>활성성분</th>
                                                <th><i class="fas fa-barcode me-1"></i>보험코드</th>
                                                <th><i class="fas fa-won-sign me-1"></i>약가</th>
                                                <th><i class="fas fa-percentage me-1"></i>수수료율</th>
                                                <th><i class="fas fa-money-bill-wave me-1"></i>수수료</th>
                                                <th><i class="fas fa-chart-line me-1"></i>분석</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product): ?>
                                                <tr>
                                                    <td>
                                                        <div class="product-name">
                                                            <?php echo htmlspecialchars($product->name); ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-secondary">
                                                            <?php echo htmlspecialchars($product->manufacturer_name); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if (!empty($product->ingredients)) {
                                                            $ingredients = explode(',', $product->ingredients);
                                                            foreach ($ingredients as $ingredient) {
                                                                echo '<span class="ingredient-badge">' 
                                                                    . htmlspecialchars(trim($ingredient)) . '</span>';
                                                            }
                                                        } else {
                                                            echo '<span class="text-muted">-</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span class="edi-code-badge">
                                                            <?php echo htmlspecialchars($product->edi_code); ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end price-cell">
                                                        <?php echo number_format($product->reimbursement_price); ?>원
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="commission-rate">
                                                            <?php echo number_format($product->sales_commission_rate * 100, 2); ?>%
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="commission-amount">
                                                            <?php echo number_format($product->commission); ?>원
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?php echo site_url('dashboard/product_analysis/'.$product->id); ?>" 
                                                           class="btn-analysis">
                                                            <i class="fas fa-chart-line me-1"></i>상세분석
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- 페이지네이션 -->
                                <?php if (isset($pagination_links) && !empty($pagination_links)): ?>
                                <div class="pagination-wrapper mt-4">
                                    <?php echo $pagination_links; ?>
                                </div>
                                <?php endif; ?>
                                
                            <?php else: ?>
                                <div class="no-results">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>"<?php echo htmlspecialchars($search_keyword); ?>"</strong>에 대한 검색 결과가 없습니다.
                                    <br><small class="text-muted mt-2 d-block">다른 검색어로 시도해보시거나 검색어의 철자를 확인해주세요.</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- 검색 전 상태 -->
            <div class="row">
                <div class="col-12">
                    <div class="results-card">
                        <div class="card-body">
                            <div class="empty-search-state">
                                <i class="fas fa-search"></i>
                                <h3>제품을 검색해보세요</h3>
                                <p>제품명, 성분명, 보험코드 중 하나를 입력하여 원하는 의약품을 찾으실 수 있습니다.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        // 페이지 로드 시 애니메이션
        document.addEventListener('DOMContentLoaded', function() {
            // 검색 히어로 애니메이션
            const searchHero = document.querySelector('.search-hero');
            searchHero.style.opacity = '0';
            searchHero.style.transform = 'translateY(30px)';
            searchHero.style.transition = 'all 0.8s ease';
            
            setTimeout(() => {
                searchHero.style.opacity = '1';
                searchHero.style.transform = 'translateY(0)';
            }, 100);

            // 결과 카드 애니메이션
            const resultsCard = document.querySelector('.results-card');
            if (resultsCard) {
                resultsCard.style.opacity = '0';
                resultsCard.style.transform = 'translateY(30px)';
                resultsCard.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    resultsCard.style.opacity = '1';
                    resultsCard.style.transform = 'translateY(0)';
                }, 400);
            }

            // 테이블 행 애니메이션
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    row.style.transition = 'all 0.4s ease';
                    
                    setTimeout(() => {
                        row.style.opacity = '1';
                        row.style.transform = 'translateX(0)';
                    }, 100);
                }, index * 50 + 800);
            });

            // 검색 입력 필드에 포커스
            const searchInput = document.querySelector('.search-input');
            searchInput.focus();
        });

        // 검색 예시 클릭 처리
        function searchExample(keyword) {
            const searchInput = document.querySelector('.search-input');
            searchInput.value = keyword;
            searchInput.focus();
            
            // 검색 입력 애니메이션
            searchInput.style.transform = 'scale(1.05)';
            setTimeout(() => {
                searchInput.style.transform = 'scale(1)';
            }, 200);
        }

        // 검색 폼 제출 시 로딩 표시
        document.getElementById('searchForm').addEventListener('submit', function() {
            const submitBtn = this.querySelector('.search-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="loading-spinner me-2"></div>검색 중...';
            submitBtn.disabled = true;
            
            // 검색어가 비어있을 경우 제출 방지
            const searchInput = this.querySelector('.search-input');
            if (!searchInput.value.trim()) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                searchInput.focus();
                return false;
            }
        });

        // 검색어 하이라이팅
        const searchKeyword = '<?php echo addslashes($search_keyword ?? ''); ?>';
        if (searchKeyword) {
            const tableBody = document.querySelector('tbody');
            if (tableBody) {
                const regex = new RegExp(`(${searchKeyword})`, 'gi');
                tableBody.innerHTML = tableBody.innerHTML.replace(regex, '<mark>$1</mark>');
            }
        }

        // 분석 버튼 호버 효과
        document.querySelectorAll('.btn-analysis').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // 검색 입력 필드 실시간 검증
        document.querySelector('.search-input').addEventListener('input', function() {
            const submitBtn = document.querySelector('.search-btn');
            if (this.value.trim()) {
                submitBtn.style.background = 'var(--primary-gradient)';
                submitBtn.disabled = false;
            } else {
                submitBtn.style.background = 'var(--text-muted)';
                submitBtn.disabled = true;
            }
        });

        // 키보드 단축키 (Enter 키 검색)
        document.addEventListener('keydown', function(e) {
            if (e.key === '/' && !e.ctrlKey && !e.metaKey) {
                e.preventDefault();
                document.querySelector('.search-input').focus();
            }
        });

        console.log('제품 검색 페이지가 성공적으로 로드되었습니다! 🔍');
    </script>
</body>
</html> 