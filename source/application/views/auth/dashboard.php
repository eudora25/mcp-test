<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>관리자 대시보드</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5; /* 참고 페이지와 유사한 배경색 */
            font-family: 'Segoe UI', 'Malgun Gothic', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif;
        }
        .dashboard-wrapper {
            max-width: 960px; /* 참고 페이지와 유사한 너비 */
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .header-section {
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-section h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
        }
        .summary-card-container {
            margin-bottom: 30px;
        }
        .summary-card {
            background-color: #f7f9fc; /* 요약 카드 배경색 */
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            height: 100%; /* 같은 높이 유지 */
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,.05);
        }
        .summary-card .value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #007bff; /* 주요 값 강조 */
            margin-bottom: 5px;
        }
        .summary-card .label {
            font-size: 0.95rem;
            color: #555;
            font-weight: 500;
        }
        .main-content-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        .main-content-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .list-group-item {
            padding: 12px 20px;
            border-color: #f0f0f0; /* 리스트 구분선 */
            font-size: 0.95rem;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        .list-group-item .item-content {
            flex-grow: 1;
            margin-right: 15px;
        }
        .list-group-item .item-content .product-name {
            font-weight: 600;
            color: #007bff;
        }
        .list-group-item .item-content .notice-text {
            color: #495057;
        }
        .list-group-item .item-date {
            color: #888;
            font-size: 0.85rem;
            white-space: nowrap; /* 날짜 잘림 방지 */
        }
    </style>
</head>
<body>

<div class="container dashboard-wrapper">
    <div class="header-section">
        <div>
            <h2>📊 관리자 대시보드</h2>
            <p class="lead text-muted mb-0">안녕하세요, <strong><?php echo htmlspecialchars($this->session->userdata('admin_name') ?: '게스트'); ?></strong>님!</p>
        </div>
        <div>
            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-outline-secondary">로그아웃</a>
        </div>
    </div>

    <h4 class="mb-3 text-muted">내 제약사 현황</h4>
    <div class="row summary-card-container g-3">
        <div class="col-md-4">
            <div class="summary-card">
                <div class="value"><?= html_escape($current_manufacturer_name) ?></div>
                <div class="label">현재 로그인 제약사</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <div class="value"><?= html_escape($current_manufacturer_total_products) ?>개</div>
                <div class="label">총 제품 수</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <div class="value">
                    <?= html_escape($current_manufacturer_rank) ?><?= ($current_manufacturer_rank !== 'N/A' && $current_manufacturer_rank !== null) ? '위' : '' ?>
                </div>
                <div class="label">제품 수 순위</div>
            </div>
        </div>
    </div>

    <div class="main-content-card">
        <div class="card-header">
            <strong>📝 최근 공지사항</strong>
            <a href="<?= site_url('notice') ?>" class="btn btn-sm btn-outline-primary">전체 공지사항 보기</a>
        </div>
        <div class="card-body p-0">
            <?php if (empty($notices)): ?>
                <p class="text-muted text-center py-4 mb-0">새로운 공지사항이 없습니다.</p>
            <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($notices as $notice): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="item-content d-flex flex-column">
                                <span class="product-name"><?= html_escape($notice['product_name'] ?: 'N/A') ?></span>
                                <a href="#" class="text-decoration-none notice-text" title="<?= html_escape($notice['content']) ?>">
                                    <?= html_escape(mb_substr($notice['content'], 0, 70)) ?><?= (mb_strlen($notice['content']) > 70) ? '...' : '' ?>
                                </a>
                            </div>
                            <span class="item-date"><?= date('Y-m-d', strtotime($notice['noti_date'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="main-content-card p-4">
                <h5 class="card-title text-primary mb-3">📈 전체 제조사 순위</h5>
                <p class="card-text text-muted">모든 제조사의 제품 수 순위를 확인하고, 시장 동향을 파악하세요.</p>
                <a href="<?= site_url('manufacturer/rank') ?>" class="btn btn-outline-primary">자세히 보기</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="main-content-card p-4">
                <h5 class="card-title text-success mb-3">⚙️ 관리 설정 바로가기</h5>
                <p class="card-text text-muted">사용자 관리, 시스템 환경 설정 등 필요한 관리 기능을 빠르게 이용하세요.</p>
                <a href="#" class="btn btn-outline-success">설정 페이지 이동</a>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>