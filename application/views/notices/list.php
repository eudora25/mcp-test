<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>의약품 관리 시스템 - 공지사항</title>
    
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
        .search-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-card:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .search-form {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-input {
            flex: 1;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
            outline: none;
        }

        .search-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        /* 데이터 카드 */
        .data-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
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

        /* 뱃지 스타일 */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .badge-danger {
            background: var(--danger-gradient);
            color: white;
        }

        .badge-warning {
            background: var(--warning-gradient);
            color: white;
        }

        .badge-info {
            background: var(--info-gradient);
            color: white;
        }

        .badge-success {
            background: var(--success-gradient);
            color: white;
        }

        /* 모달 스타일 */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 2rem;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .modal-footer {
            border-top: 1px solid rgba(102, 126, 234, 0.1);
            padding: 1rem 1.5rem;
        }

        /* 컨텐츠 링크 */
        .content-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .content-link:hover {
            color: #764ba2;
            text-decoration: underline;
            transform: translateX(3px);
        }

        /* 빈 상태 스타일 */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 0;
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
            
            .search-form {
                flex-direction: column;
                gap: 1rem;
            }
            
            .search-input {
                width: 100%;
            }
            
            .search-btn {
                width: 100%;
                justify-self: stretch;
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
                        <a class="nav-link" href="<?php echo base_url('product_search'); ?>">
                            <i class="fas fa-search me-1"></i>제품 검색
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo base_url('notice'); ?>">
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
        <!-- 페이지 헤더 -->
        <div class="page-header text-center">
            <h1><i class="fas fa-bell me-3"></i>공지사항</h1>
            <p>중요한 의약품 관련 공지사항과 업데이트 정보를 확인하세요</p>
        </div>

        <!-- 검색 카드 -->
        <div class="search-card">
            <form action="<?php echo site_url('notice'); ?>" method="get" class="search-form">
                <div class="search-icon-wrapper">
                    <i class="fas fa-search text-muted"></i>
                </div>
                <input type="text" name="search" class="search-input" 
                       value="<?php echo $search_keyword ?? ''; ?>" 
                       placeholder="제품명, 제조사, 공지 내용으로 검색...">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search me-2"></i>검색
                </button>
            </form>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="data-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-list-alt me-2"></i>공지사항 목록
                            <?php if (isset($search_keyword) && !empty($search_keyword)): ?>
                                <small class="text-muted">- "<?php echo htmlspecialchars($search_keyword); ?>" 검색 결과</small>
                            <?php endif; ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-calendar me-1"></i>공지일</th>
                                        <th><i class="fas fa-pills me-1"></i>제품명</th>
                                        <th><i class="fas fa-industry me-1"></i>제조사</th>
                                        <th><i class="fas fa-tags me-1"></i>제품분류</th>
                                        <th><i class="fas fa-bullhorn me-1"></i>공지분류</th>
                                        <th><i class="fas fa-exclamation-triangle me-1"></i>중요도</th>
                                        <th><i class="fas fa-folder me-1"></i>카테고리</th>
                                        <th><i class="fas fa-file-alt me-1"></i>내용</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($notices)): ?>
                                        <?php foreach ($notices as $notice): ?>
                                            <tr>
                                                <td>
                                                    <span class="text-muted small">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        <?php echo date('Y-m-d', strtotime($notice->noti_date)); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($notice->product_name); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="text-secondary"><?php echo htmlspecialchars($notice->manufacturer_name); ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        <?php echo htmlspecialchars($notice->drug_class_name ?: $notice->drug_class_cd); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">
                                                        <?php echo htmlspecialchars($notice->notice_class_name ?: $notice->notice_class_cd); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?php 
                                                        echo $notice->noti_crisis_level === 'A' ? 'badge-danger' : 
                                                            ($notice->noti_crisis_level === 'B' ? 'badge-warning' : 'badge-info'); 
                                                    ?>">
                                                        <i class="fas fa-<?php 
                                                            echo $notice->noti_crisis_level === 'A' ? 'exclamation-triangle' : 
                                                                ($notice->noti_crisis_level === 'B' ? 'exclamation-circle' : 'info-circle'); 
                                                        ?> me-1"></i>
                                                        <?php echo htmlspecialchars($notice->crisis_level_name); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-secondary"><?php echo htmlspecialchars($notice->category_name); ?></span>
                                                </td>
                                                <td>
                                                    <a href="#" class="content-link notice-content" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#noticeModal"
                                                       data-notice-title="<?php echo htmlspecialchars($notice->product_name); ?> - <?php echo date('Y-m-d', strtotime($notice->noti_date)); ?>"
                                                       data-notice-content="<?php echo htmlspecialchars($notice->content); ?>">
                                                        <i class="fas fa-eye me-1"></i>
                                                        <?php 
                                                            $content = strip_tags($notice->content);
                                                            if (mb_strlen($content, 'UTF-8') > 25) {
                                                                echo htmlspecialchars(mb_substr($content, 0, 25, 'UTF-8')) . '...';
                                                            } else {
                                                                echo htmlspecialchars($content);
                                                            }
                                                        ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox"></i>
                                                    <h5>공지사항이 없습니다</h5>
                                                    <p>현재 등록된 공지사항이 없거나 검색 조건에 맞는 결과가 없습니다.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- 페이징 -->
                        <?php if (isset($pagination_links) && !empty($pagination_links)): ?>
                        <div class="pagination-wrapper mt-4">
                            <?php echo $pagination_links; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 공지사항 모달 -->
    <div class="modal fade" id="noticeModal" tabindex="-1" aria-labelledby="noticeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noticeModalLabel">
                        <i class="fas fa-bell me-2"></i>공지사항 내용
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="noticeContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>닫기
                    </button>
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
            // 페이지 헤더 애니메이션
            const pageHeader = document.querySelector('.page-header');
            pageHeader.style.opacity = '0';
            pageHeader.style.transform = 'translateY(30px)';
            pageHeader.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                pageHeader.style.opacity = '1';
                pageHeader.style.transform = 'translateY(0)';
            }, 100);

            // 검색 카드 애니메이션
            const searchCard = document.querySelector('.search-card');
            searchCard.style.opacity = '0';
            searchCard.style.transform = 'translateY(20px)';
            searchCard.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                searchCard.style.opacity = '1';
                searchCard.style.transform = 'translateY(0)';
            }, 200);

            // 데이터 카드 애니메이션
            const dataCard = document.querySelector('.data-card');
            dataCard.style.opacity = '0';
            dataCard.style.transform = 'translateY(30px)';
            dataCard.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                dataCard.style.opacity = '1';
                dataCard.style.transform = 'translateY(0)';
            }, 400);

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
                }, index * 50 + 600);
            });
        });

        // 공지사항 모달 이벤트 처리
        const noticeLinks = document.querySelectorAll('.notice-content');
        noticeLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const title = this.getAttribute('data-notice-title');
                const content = this.getAttribute('data-notice-content');
                
                document.getElementById('noticeModalLabel').innerHTML = 
                    '<i class="fas fa-bell me-2"></i>' + title;
                document.getElementById('noticeContent').innerHTML = 
                    content.replace(/\n/g, '<br>');
            });
        });

        // 검색 폼 제출 시 로딩 표시
        document.querySelector('.search-form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('.search-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="loading-spinner me-2"></div>검색 중...';
            submitBtn.disabled = true;
            
            // 실제 제출을 위해 약간의 지연 후 원래 상태로 복원
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1000);
        });

        // 컨텐츠 링크 호버 효과
        document.querySelectorAll('.content-link').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(3px)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });

        // 검색어 하이라이팅
        const searchKeyword = '<?php echo addslashes($search_keyword ?? ''); ?>';
        if (searchKeyword) {
            const tableBody = document.querySelector('tbody');
            const regex = new RegExp(`(${searchKeyword})`, 'gi');
            
            tableBody.innerHTML = tableBody.innerHTML.replace(regex, '<mark style="background: #fff3cd; padding: 0.1rem 0.2rem; border-radius: 0.25rem;">$1</mark>');
        }

        console.log('공지사항 페이지가 성공적으로 로드되었습니다! 📢');
    </script>
</body>
</html>