

/* 추가 스타일 */
.detail-hero {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.detail-hero h2 {
    color: var(--text-primary);
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
}

.detail-hero .breadcrumb-text {
    color: var(--text-secondary);
    font-size: 1rem;
    margin-bottom: 1rem;
}

.back-btn {
    background: var(--primary-gradient);
    border: none;
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.back-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
}

.stat-card .icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 1rem;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-card h6 {
    color: var(--text-secondary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card .stat-value {
    color: var(--text-primary);
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 0;
}

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
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.data-card .card-body {
    padding: 1.5rem;
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

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background: rgba(102, 126, 234, 0.08);
    transform: scale(1.01);
}

/* 제품 상태 뱃지 */
.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.8rem;
}

.status-active {
    background: var(--success-gradient);
    color: white;
}

.status-inactive {
    background: var(--secondary-gradient);
    color: white;
}

/* 수수료 뱃지 */
.commission-badge {
    background: var(--info-gradient);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.8rem;
}

.price-badge {
    background: var(--warning-gradient);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.8rem;
}

/* 중단된 제품 스타일 */
.product-discontinued {
    background: rgba(220, 53, 69, 0.1) !important;
}

.product-discontinued td {
    color: rgba(220, 53, 69, 0.8) !important;
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
    .detail-hero h2 {
        font-size: 1.8rem;
    }
    
    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .stat-card {
        padding: 1.5rem;
    }
    
    .stat-card .stat-value {
        font-size: 1.5rem;
    }
}
</style>

<!-- 페이지 히어로 섹션 -->
<div class="detail-hero">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1">
            <div class="breadcrumb-text">
                <i class="fas fa-home me-1"></i>
                분류 현황 > 상세 정보
            </div>
            <h2>
                <i class="fas fa-info-circle me-2"></i>
                <?php 
                if (!empty($class_info->drug_class_name)) {
                    echo htmlspecialchars($class_info->drug_class_name);
                } else {
                    echo htmlspecialchars($class_info->drug_class_cd);
                }
                ?>
            </h2>
        </div>
        <a href="<?php echo base_url('drug_class'); ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            목록으로
        </a>
    </div>
</div>

<!-- 통계 카드 그리드 -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon">
            <i class="fas fa-layer-group"></i>
        </div>
        <h6>분류 코드</h6>
        <div class="stat-value"><?php echo htmlspecialchars($class_info->drug_class_cd); ?></div>
    </div>
    
    <div class="stat-card">
        <div class="icon">
            <i class="fas fa-boxes"></i>
        </div>
        <h6>총 제품 수</h6>
        <div class="stat-value"><?php echo number_format($class_info->product_count); ?></div>
    </div>
    
    <div class="stat-card">
        <div class="icon">
            <i class="fas fa-percentage"></i>
        </div>
        <h6>평균 수수료율</h6>
        <div class="stat-value"><?php echo number_format($class_info->avg_commission_rate * 100, 2); ?>%</div>
    </div>
    
    <div class="stat-card">
        <div class="icon">
            <i class="fas fa-won-sign"></i>
        </div>
        <h6>평균 수수료</h6>
        <div class="stat-value"><?php echo number_format($class_info->avg_commission); ?>원</div>
    </div>
</div>

<!-- 제품 목록 테이블 -->
<div class="data-card">
    <div class="card-header">
        <h5 class="card-title">
            <i class="fas fa-list"></i>
            제품 목록 (총 <?php echo count($products); ?>개)
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
                        <th><i class="fas fa-barcode me-1"></i>보험코드</th>
                        <th><i class="fas fa-tag me-1"></i>보험약가</th>
                        <th><i class="fas fa-percent me-1"></i>수수료율</th>
                        <th><i class="fas fa-money-bill me-1"></i>수수료</th>
                        <th><i class="fas fa-check-circle me-1"></i>상태</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr class="<?php echo $product->state == '1' ? '' : 'product-discontinued'; ?>">
                        <td>
                            <strong><?php echo htmlspecialchars($product->name); ?></strong>
                        </td>
                        <td>
                            <span class="text-muted"><?php echo htmlspecialchars($product->manufacturer_name); ?></span>
                        </td>
                        <td>
                            <code><?php echo htmlspecialchars($product->edi_code); ?></code>
                        </td>
                        <td>
                            <span class="price-badge">
                                <?php echo number_format($product->reimbursement_price); ?>원
                            </span>
                        </td>
                        <td>
                            <span class="commission-badge">
                                <?php echo number_format($product->sales_commission_rate * 100, 2); ?>%
                            </span>
                        </td>
                        <td class="text-end">
                            <strong class="text-success">
                                <?php echo number_format($product->commission); ?>원
                            </strong>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $product->state == '1' ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo $product->state == '1' ? '판매중' : '판매중지'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h5>등록된 제품이 없습니다</h5>
            <p>이 분류에는 현재 등록된 제품이 없습니다.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // 페이지 로드 시 애니메이션
    document.addEventListener('DOMContentLoaded', function() {
        // 히어로 섹션 애니메이션
        const hero = document.querySelector('.detail-hero');
        hero.style.opacity = '0';
        hero.style.transform = 'translateY(30px)';
        hero.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            hero.style.opacity = '1';
            hero.style.transform = 'translateY(0)';
        }, 100);

        // 통계 카드 순차 애니메이션
        const statCards = document.querySelectorAll('.stat-card');
        statCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 300 + (index * 100));
        });

        // 데이터 카드 애니메이션
        const dataCard = document.querySelector('.data-card');
        dataCard.style.opacity = '0';
        dataCard.style.transform = 'translateY(30px)';
        dataCard.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            dataCard.style.opacity = '1';
            dataCard.style.transform = 'translateY(0)';
        }, 700);

        // 테이블 행 순차 애니메이션
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
            }, index * 50 + 1000);
        });
    });

    // 백 버튼 호버 효과
    document.querySelector('.back-btn').addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px) scale(1.05)';
    });

    document.querySelector('.back-btn').addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });

    console.log('분류 상세 정보 페이지가 성공적으로 로드되었습니다! 📊');
</script> 