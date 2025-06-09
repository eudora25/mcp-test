<div class="container-fluid mt-4">
    <!-- 통계 카드 -->
    <div class="row mb-4">
        <!-- 제조사 통계 -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">제조사</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                총 <?php echo number_format($manufacturer_stats['total']); ?>개
                            </div>
                            <div class="small mt-2">
                                <span class="text-success">활성 <?php echo number_format($manufacturer_stats['active']); ?></span> /
                                <span class="text-danger">비활성 <?php echo number_format($manufacturer_stats['inactive']); ?></span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 제품 수 통계 -->
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">총 제품 수</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($product_stats['total']); ?>개
                            </div>
                            <div class="small mt-2">
                                <span class="text-success">판매중 <?php echo number_format($product_stats['on_sale']); ?></span> /
                                <span class="text-danger">판매중지 <?php echo number_format($product_stats['off_sale']); ?></span>
                            </div>
                            <?php if ($product_rank['rank'] > 0): ?>
                                <div class="small mt-2 text-info">
                                    전체 <?php echo $product_rank['total']; ?>개 제조사 중 <?php echo $product_rank['rank']; ?>위
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 평균 수수료율 -->
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">평균 수수료율</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($commission_rate_rank['rate'] * 100, 4); ?>%
                            </div>
                            <?php if ($commission_rate_rank['rank'] > 0): ?>
                                <div class="small mt-2 text-info">
                                    전체 <?php echo $commission_rate_rank['total']; ?>개 제조사 중 <?php echo $commission_rate_rank['rank']; ?>위
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 평균 수수료 -->
        <div class="col-md-6 col-xl-4 mb-4">
            <div class="card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">평균 수수료</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo number_format($commission_amount_rank['amount'], 3); ?>원
                            </div>
                            <?php if ($commission_amount_rank['rank'] > 0): ?>
                                <div class="small mt-2 text-info">
                                    전체 <?php echo $commission_amount_rank['total']; ?>개 제조사 중 <?php echo $commission_amount_rank['rank']; ?>위
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-won-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 분류 현황 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">상위 10개 의약품 분류 현황</h5>
                    <a href="<?php echo base_url('drug_class'); ?>" class="btn btn-primary">모두 보기</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>분류명</th>
                                    <th>제품수</th>
                                    <th>평균 수수료율</th>
                                    <th>수수료율 순위</th>
                                    <th>평균 수수료</th>
                                    <th>수수료 순위</th>
                                    <th>상세</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_classes as $class): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (!empty($class->drug_class_name)) {
                                                echo htmlspecialchars($class->drug_class_name);
                                            } else {
                                                echo htmlspecialchars($class->drug_class_cd);
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo number_format($class->product_count); ?></td>
                                        <td><?php echo number_format($class->avg_commission_rate * 100, 2); ?>%</td>
                                        <td><?php echo number_format($class->commission_rate_rank_num) . '/' . number_format($class->total_count); ?></td>
                                        <td><?php echo number_format($class->avg_commission, 2); ?></td>
                                        <td><?php echo number_format($class->commission_rank_num) . '/' . number_format($class->total_count); ?></td>
                                        <td>
                                            <a href="<?php echo base_url('drug_class/detail/' . $class->drug_class_cd); ?>"
                                                class="btn btn-sm btn-primary">상세보기</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">최근 등록된 제품</h5>
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
                                <?php foreach ($recent_products as $product): ?>
                                    <tr>
                                        <td><?php echo $product->product_name; ?></td>
                                        <td><?php echo $product->manufacturer_name; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($product->created_at)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- 최근 수정된 제조사 -->
        <div class="col-xl-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">최근 수정된 제조사</h5>
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
                                <?php foreach ($recent_manufacturers as $manufacturer): ?>
                                    <tr>
                                        <td><?php echo $manufacturer->biz_name; ?></td>
                                        <td><?php echo $manufacturer->representative_name; ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($manufacturer->updated_at)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">경쟁사 공지사항</h5>
                    <a href="<?php echo base_url('notice'); ?>" class="btn btn-primary btn-sm">전체보기</a>
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
                                <?php foreach ($recent_notices as $notice): ?>
                                    <tr>
                                        <td><?php echo date('Y-m-d', strtotime($notice->noti_date)); ?></td>
                                        <td><?php echo htmlspecialchars($notice->product_name); ?></td>
                                        <td><?php echo htmlspecialchars($notice->manufacturer_name); ?></td>
                                        <td><?php echo htmlspecialchars(isset($notice->notice_class_name) && !empty($notice->notice_class_name) ? $notice->notice_class_name : $notice->notice_class_cd); ?></td>
                                        <td>
                                            <span class="badge <?php
                                                                echo $notice->noti_crisis_level === 'A' ? 'bg-danger' : ($notice->noti_crisis_level === 'B' ? 'bg-warning text-dark' : 'bg-info text-dark');
                                                                ?>">
                                                <?php echo htmlspecialchars($notice->crisis_level_name); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($notice->category_name); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars(mb_strimwidth($notice->content, 0, 100, "..."))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
                <h5 class="modal-title" id="noticeModalLabel">공지사항 내용</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="noticeContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<script>
    // 툴팁 초기화
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // 공지사항 모달 이벤트 처리
    document.addEventListener('DOMContentLoaded', function() {
        var noticeLinks = document.querySelectorAll('.notice-content');
        noticeLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                var title = this.getAttribute('data-notice-title');
                var content = this.getAttribute('data-notice-content');

                document.getElementById('noticeModalLabel').textContent = title;
                document.getElementById('noticeContent').innerHTML = content.replace(/\n/g, '<br>');
            });
        });
    });
</script>

<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }

    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }

    .text-primary {
        color: #4e73df !important;
    }

    .text-success {
        color: #1cc88a !important;
    }

    .text-danger {
        color: #e74a3b !important;
    }

    .text-gray-300 {
        color: #dddfeb !important;
    }

    .text-gray-800 {
        color: #5a5c69 !important;
    }

    .text-xs {
        font-size: 0.7rem;
    }

    /* 모달 스타일 */
    .modal-lg {
        max-width: 800px;
    }

    #noticeContent {
        white-space: pre-line;
        line-height: 1.6;
        margin-bottom: 0;
    }

    .notice-content {
        cursor: pointer;
        color: #4e73df;
    }

    .notice-content:hover {
        text-decoration: underline !important;
    }
</style>
