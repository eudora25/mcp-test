<!-- 정렬 변수 기본값 설정 -->
<?php
$sort_by = isset($sort_by) ? $sort_by : 'product_count';
$sort_dir = isset($sort_dir) ? $sort_dir : 'DESC';

// 정렬 방향 토글 함수
function getNextSortDir($current_sort_by, $current_sort_dir, $this_sort_by) {
    // 현재 정렬 컬럼을 클릭한 경우에만 방향을 토글
    if ($current_sort_by === $this_sort_by) {
        return strtoupper($current_sort_dir) === 'DESC' ? 'ASC' : 'DESC';
    }
    // 다른 컬럼을 클릭한 경우 기본값은 DESC
    return 'DESC';
}

// 정렬 아이콘 표시 함수
function getSortIcon($current_sort_by, $current_sort_dir, $this_sort_by) {
    if ($current_sort_by === $this_sort_by) {
        return '<i class="fas fa-sort-' . (strtolower($current_sort_dir) === 'desc' ? 'down' : 'up') . '"></i>';
    }
    return '<i class="fas fa-sort"></i>';
}
?>

<style>
    /* 추가 스타일 */
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

    /* 정렬 버튼 스타일 */
    .sort-header {
        color: var(--text-primary);
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sort-header:hover {
        color: #667eea;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .sort-header i {
        font-size: 0.8rem;
        opacity: 0.7;
    }

    .sort-header.active {
        color: #667eea;
        font-weight: 700;
    }

    .sort-header.active i {
        opacity: 1;
    }

    /* 뱃지 스타일 */
    .count-badge {
        background: var(--success-gradient);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .rate-badge {
        background: var(--info-gradient);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.9rem;
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

    .fa-sort, .fa-sort-up, .fa-sort-down {
        margin-left: 5px;
    }

    a:hover {
        text-decoration: none;
    }
</style>

<!-- 분류별 현황 페이지 내용 -->

<div class="row">
    <div class="col-12">
        <div class="data-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list-alt me-2"></i>분류별 현황
                </h5>
            </div>
            <div class="card-body">
                <?php if(isset($debug)): ?>
                <div class="alert alert-info">
                    <h6>디버그 정보:</h6>
                    <pre><?php print_r($debug); ?></pre>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($classes)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>분류코드</th>
                                <th>분류명</th>
                                <th>
                                    <a href="?sort_by=product_count&sort_dir=<?php echo getNextSortDir($sort_by, $sort_dir, 'product_count'); ?>" 
                                       class="sort-header <?php echo $sort_by === 'product_count' ? 'active' : ''; ?>">
                                        제품 수
                                        <?php echo getSortIcon($sort_by, $sort_dir, 'product_count'); ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?sort_by=avg_commission_rate&sort_dir=<?php echo getNextSortDir($sort_by, $sort_dir, 'avg_commission_rate'); ?>" 
                                       class="sort-header <?php echo $sort_by === 'avg_commission_rate' ? 'active' : ''; ?>">
                                        평균 수수료율
                                        <?php echo getSortIcon($sort_by, $sort_dir, 'avg_commission_rate'); ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?sort_by=avg_commission&sort_dir=<?php echo getNextSortDir($sort_by, $sort_dir, 'avg_commission'); ?>" 
                                       class="sort-header <?php echo $sort_by === 'avg_commission' ? 'active' : ''; ?>">
                                        평균 수수료
                                        <?php echo getSortIcon($sort_by, $sort_dir, 'avg_commission'); ?>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($classes as $class): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?php echo htmlspecialchars($class->drug_class_cd); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($class->drug_class_name ?: '미분류'); ?></strong>
                                    </td>
                                    <td>
                                        <span class="count-badge">
                                            <?php echo number_format($class->product_count); ?>개
                                        </span>
                                    </td>
                                    <td>
                                        <span class="rate-badge">
                                            <?php echo number_format($class->avg_commission_rate * 100, 2); ?>%
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">
                                            <?php echo number_format($class->avg_commission); ?>원
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- 페이지네이션 -->
                <?php if (isset($pagination) && !empty($pagination)): ?>
                <div class="mt-4 d-flex justify-content-center">
                    <?php echo $pagination; ?>
                </div>
                <?php endif; ?>
                
                <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-chart-bar"></i>
                    <h5>분류 데이터가 없습니다</h5>
                    <p>현재 등록된 분류별 현황 데이터가 없습니다.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

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

        // 데이터 카드 애니메이션
        const dataCard = document.querySelector('.data-card');
        dataCard.style.opacity = '0';
        dataCard.style.transform = 'translateY(30px)';
        dataCard.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            dataCard.style.opacity = '1';
            dataCard.style.transform = 'translateY(0)';
        }, 300);

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

    // 정렬 헤더 호버 효과
    document.querySelectorAll('.sort-header').forEach(header => {
        header.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        header.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    console.log('분류별 현황 페이지가 성공적으로 로드되었습니다! 📊');
</script> 