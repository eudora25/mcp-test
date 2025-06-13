<?php $this->load->view('templates/header'); ?>

<!-- 미리보기 페이지 스타일 -->
<style>
/* 미리보기 페이지 전용 스타일 */
.preview-hero {
    background: linear-gradient(135deg, var(--info-color) 0%, var(--primary-color) 100%);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    color: white;
    margin-bottom: 2rem;
}

.notice-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-soft);
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
}

.notice-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.notice-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.notice-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
    flex: 1;
}

.notice-meta {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.priority-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-weight: 600;
}

.priority-a {
    background: var(--danger-light);
    color: var(--danger-dark);
}

.priority-b {
    background: var(--warning-light);
    color: var(--warning-dark);
}

.priority-c {
    background: var(--success-light);
    color: var(--success-dark);
}

.notice-content {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.notice-footer {
    display: flex;
    justify-content: between;
    align-items: center;
    font-size: 0.8rem;
    color: var(--text-muted);
    border-top: 1px solid var(--border-light);
    padding-top: 1rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.stats-summary {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid var(--glass-border);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    display: block;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
}
</style>

<div class="container-fluid p-4">
    <!-- 히어로 섹션 -->
    <div class="preview-hero">
        <i class="fas fa-eye mb-3" style="font-size: 3rem;"></i>
        <h1 class="mb-2">공지사항 미리보기</h1>
        <p class="mb-0">현재 등록된 공지사항 데이터를 확인하세요</p>
    </div>

    <!-- 통계 요약 -->
    <div class="stats-summary">
        <div class="row">
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number"><?= count($notices) ?></span>
                    <span class="stat-label">총 공지사항</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">
                        <?= count(array_filter($notices, function($n) { return isset($n->noti_crisis_level) && $n->noti_crisis_level === '1'; })) ?>
                    </span>
                    <span class="stat-label">긴급 공지</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">
                        <?= count(array_filter($notices, function($n) { return isset($n->noti_crisis_level) && $n->noti_crisis_level === '2'; })) ?>
                    </span>
                    <span class="stat-label">중요 공지</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item">
                    <span class="stat-number">
                        <?= count(array_filter($notices, function($n) { return isset($n->noti_crisis_level) && $n->noti_crisis_level === '3'; })) ?>
                    </span>
                    <span class="stat-label">일반 공지</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 액션 버튼 -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-list text-primary me-2"></i>
            공지사항 목록
        </h4>
        <div>
            <a href="<?= base_url('notice_upload') ?>" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>업로드 페이지로
            </a>
            <button class="btn btn-outline-secondary ms-2" onclick="window.print()">
                <i class="fas fa-print me-2"></i>인쇄
            </button>
        </div>
    </div>

    <!-- 공지사항 목록 -->
    <?php if (empty($notices)): ?>
        <div class="notice-card">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h5>등록된 공지사항이 없습니다</h5>
                <p>새로운 공지사항을 업로드해보세요.</p>
                <a href="<?= base_url('notice_upload') ?>" class="btn btn-primary mt-3">
                    <i class="fas fa-upload me-2"></i>공지사항 업로드
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($notices as $index => $notice): ?>
                <div class="col-lg-6 mb-3">
                    <div class="notice-card" style="animation-delay: <?= $index * 50 ?>ms;">
                        <div class="notice-header">
                                                         <div class="notice-title">
                                 <?= isset($notice->noti_content) ? substr($notice->noti_content, 0, 50) . (strlen($notice->noti_content) > 50 ? '...' : '') : '제목 없음' ?>
                            </div>
                            <div class="notice-meta">
                                                                 <?php 
                                 $priority = isset($notice->noti_crisis_level) ? $notice->noti_crisis_level : '3';
                                 $priority_text = '';
                                 $priority_class = '';
                                 
                                 switch($priority) {
                                     case '1':
                                         $priority_text = '긴급';
                                         $priority_class = 'priority-a';
                                         break;
                                     case '2':
                                         $priority_text = '중요';
                                         $priority_class = 'priority-b';
                                         break;
                                     case '3':
                                     default:
                                         $priority_text = '일반';
                                         $priority_class = 'priority-c';
                                         break;
                                 }
                                 ?>
                                <span class="priority-badge <?= $priority_class ?>"><?= $priority_text ?></span>
                                <?php if (isset($notice->noti_category)): ?>
                                    <span class="badge bg-secondary">
                                        <?php
                                        switch($notice->noti_category) {
                                            case 'L': echo '법령'; break;
                                            case 'M': echo '제조'; break;
                                            case 'S': echo '안전'; break;
                                            default: echo '기타'; break;
                                        }
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                                                 <div class="notice-content">
                             <?php 
                             $content = isset($notice->noti_content) ? $notice->noti_content : '';
                             if (strlen($content) > 150) {
                                 echo substr($content, 0, 150) . '...';
                             } else {
                                 echo $content ?: '내용 없음';
                             }
                             ?>
                         </div>

                        <div class="notice-footer">
                            <div>
                                <i class="fas fa-calendar-alt me-1"></i>
                                <?= isset($notice->noti_date) ? date('Y-m-d', strtotime($notice->noti_date)) : '날짜 없음' ?>
                            </div>
                            <div>
                                <i class="fas fa-hashtag me-1"></i>
                                ID: <?= isset($notice->id) ? $notice->id : 'N/A' ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 더 많은 데이터가 있는 경우 알림 -->
        <?php if (count($notices) >= 20): ?>
            <div class="alert alert-info text-center mt-4">
                <i class="fas fa-info-circle me-2"></i>
                최근 20개의 공지사항만 표시됩니다. 전체 데이터를 보시려면 공지사항 관리 페이지를 이용하세요.
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 카드 애니메이션
    const cards = document.querySelectorAll('.notice-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    });

    // 인쇄 스타일 적용
    const printStyles = `
        @media print {
            .btn, .notice-footer, .preview-hero {
                display: none !important;
            }
            .notice-card {
                break-inside: avoid;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
            .container-fluid {
                padding: 0 !important;
            }
        }
    `;
    
    const styleSheet = document.createElement("style");
    styleSheet.innerText = printStyles;
    document.head.appendChild(styleSheet);
});
</script>

<?php $this->load->view('templates/footer'); ?> 