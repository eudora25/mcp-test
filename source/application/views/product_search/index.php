<?php $this->load->view('templates/header'); ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">제품 검색</h5>
                    <form action="<?php echo site_url('product_search'); ?>" method="get" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-lg me-2" 
                               value="<?php echo $search_keyword; ?>" 
                               placeholder="제품명, 성분명, 보험코드로 검색"
                               style="min-width: 300px;">
                        <button type="submit" class="btn btn-primary">검색</button>
                    </form>
                </div>
                <div class="card-body">
                    <?php if (!empty($search_keyword)): ?>
                        <?php if (!empty($products)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>제품명</th>
                                            <th>제조사</th>
                                            <th>활성성분</th>
                                            <th>보험코드</th>
                                            <th>약가</th>
                                            <th>수수료율</th>
                                            <th>수수료</th>
                                            <th>상세분석</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($product->name); ?></td>
                                                <td><?php echo htmlspecialchars($product->manufacturer_name); ?></td>
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
                                                <td><?php echo htmlspecialchars($product->edi_code); ?></td>
                                                <td class="text-end">
                                                    <?php echo number_format($product->reimbursement_price); ?>원
                                                </td>
                                                <td class="text-end">
                                                    <?php echo number_format($product->sales_commission_rate * 100, 2); ?>%
                                                </td>
                                                <td class="text-end">
                                                    <?php echo number_format($product->commission); ?>원
                                                </td>
                                                <td>
                                                    <a href="<?php echo site_url('dashboard/product_analysis/'.$product->id); ?>" 
                                                       class="btn btn-sm btn-outline-primary">상세분석</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- 페이지네이션 -->
                            <div class="mt-4">
                                <?php echo $pagination_links; ?>
                            </div>
                            
                        <?php else: ?>
                            <div class="alert alert-info">
                                "<?php echo htmlspecialchars($search_keyword); ?>"에 대한 검색 결과가 없습니다.
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <h4 class="text-muted">제품명, 성분명 또는 보험코드로 검색해주세요.</h4>
                            <p class="text-muted">예시: 제품명, 성분명, 보험코드</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.table th {
    background-color: #f8f9fa;
    font-weight: 600;
}
.badge {
    font-weight: normal;
}
.pagination {
    margin-bottom: 0;
}
.page-link {
    color: #4e73df;
}
.page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
}
</style>

<?php $this->load->view('templates/footer'); ?> 