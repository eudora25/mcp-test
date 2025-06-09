<?php $this->load->view('templates/header'); ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">제품 상세 분석</h5>
                    <a href="javascript:history.back()" class="btn btn-secondary">뒤로가기</a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" width="30%">제품명</th>
                                    <td>
                                        <?php echo htmlspecialchars($product->name); ?>
                                        <?php if ($product->state != '1'): ?>
                                            <span class="badge bg-danger ms-2">판매중지</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">제조사</th>
                                    <td><?php echo htmlspecialchars($product->manufacturer_name); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">분류</th>
                                    <td><?php echo htmlspecialchars($product->drug_class_name); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">활성성분</th>
                                    <td>
                                        <?php 
                                        if (!empty($product->ingredients)) {
                                            $ingredients = explode(',', $product->ingredients);
                                            foreach ($ingredients as $ingredient) {
                                                echo '<span class="badge bg-info me-1">' 
                                                    . htmlspecialchars(trim($ingredient)) . '</span>';
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" width="30%">보험코드</th>
                                    <td><?php echo htmlspecialchars($product->edi_code); ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">보험약가</th>
                                    <td><?php echo number_format($product->reimbursement_price); ?>원</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">수수료율</th>
                                    <td><?php echo number_format($product->sales_commission_rate * 100, 2); ?>%</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">수수료</th>
                                    <td><?php echo number_format($product->commission); ?>원</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- 추가 분석 섹션 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">동일 분류 내 순위</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-4">
                                        <h3 class="mb-1"><?php echo $rankings['current_rank']; ?>위</h3>
                                        <p class="text-muted">전체 <?php echo $rankings['total_count']; ?>개 제품 중</p>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>순위</th>
                                                    <th>제품명</th>
                                                    <th class="text-end">수수료</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($rankings['top_products'] as $rank_product): ?>
                                                <tr <?php echo ($rank_product['name'] == $product->name) ? 'class="table-primary"' : ''; ?>>
                                                    <td><?php echo $rank_product['rank']; ?></td>
                                                    <td><?php echo htmlspecialchars($rank_product['name']); ?></td>
                                                    <td class="text-end"><?php echo number_format($rank_product['commission']); ?>원</td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">수수료 추이</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="trendChart" width="400" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
.badge {
    font-weight: normal;
}
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 1rem;
}
.table-sm td, .table-sm th {
    padding: 0.5rem;
}
.table-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
}
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// 차트 데이터는 나중에 서버에서 받아와서 구현
</script>

<?php $this->load->view('templates/footer'); ?> 