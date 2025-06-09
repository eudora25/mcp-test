<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>분류 상세 정보</h2>
        <a href="<?php echo base_url('drug_class'); ?>" class="btn btn-secondary">목록으로</a>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">분류 통계</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-item">
                        <h6>분류명</h6>
                        <p class="h4">
                            <?php 
                            if (!empty($class_info->drug_class_name)) {
                                echo htmlspecialchars($class_info->drug_class_name);
                            } else {
                                echo htmlspecialchars($class_info->drug_class_cd);
                            }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h6>제품수</h6>
                        <p class="h4"><?php echo number_format($class_info->product_count); ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h6>평균 수수료율</h6>
                        <p class="h4"><?php echo number_format($class_info->avg_commission_rate * 100, 2); ?>%</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h6>평균 수수료</h6>
                        <p class="h4"><?php echo number_format($class_info->avg_commission, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">제품 목록</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>제품명</th>
                            <th>제조사</th>
                            <th>보험코드</th>
                            <th>보험약가</th>
                            <th>수수료율</th>
                            <th>수수료</th>
                            <th>상태</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr class="<?php echo $product->state == '1' ? '' : 'discontinued'; ?>">
                            <td><?php echo $product->name; ?></td>
                            <td><?php echo $product->manufacturer_name; ?></td>
                            <td><?php echo $product->edi_code; ?></td>
                            <td><?php echo number_format($product->reimbursement_price, 2); ?></td>
                            <td><?php echo number_format($product->sales_commission_rate * 100, 2); ?>%</td>
                            <td><?php echo number_format($product->commission, 2); ?></td>
                            <td>
                                <span class="badge <?php echo $product->state == '1' ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $product->state == '1' ? '판매중' : '판매중지'; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.stat-item {
    text-align: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
}
.stat-item h6 {
    color: #6c757d;
    margin-bottom: 10px;
}
.stat-item .h4 {
    color: #495057;
    margin-bottom: 0;
}
.discontinued {
    background-color: #fff3f3 !important;
}
.discontinued td {
    color: #dc3545;
}
.badge {
    font-weight: normal;
    padding: 5px 10px;
}
</style> 