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

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">분류별 현황</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($debug)): ?>
                    <div class="alert alert-info">
                        <h6>디버그 정보:</h6>
                        <pre><?php print_r($debug); ?></pre>
                    </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>분류코드</th>
                                    <th>분류명</th>
                                    <th>
                                        <a href="<?php echo site_url('drug_class?sort_by=product_count&sort_dir=' . getNextSortDir($sort_by, $sort_dir, 'product_count')); ?>" class="text-dark">
                                            제품수
                                            <?php echo getSortIcon($sort_by, $sort_dir, 'product_count'); ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="<?php echo site_url('drug_class?sort_by=avg_commission_rate&sort_dir=' . getNextSortDir($sort_by, $sort_dir, 'avg_commission_rate')); ?>" class="text-dark">
                                            평균 수수료율
                                            <?php echo getSortIcon($sort_by, $sort_dir, 'avg_commission_rate'); ?>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="<?php echo site_url('drug_class?sort_by=avg_commission&sort_dir=' . getNextSortDir($sort_by, $sort_dir, 'avg_commission')); ?>" class="text-dark">
                                            평균 수수료
                                            <?php echo getSortIcon($sort_by, $sort_dir, 'avg_commission'); ?>
                                        </a>
                                    </th>
                                    <th>수수료 순위</th>
                                    <th>수수료율 순위</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($classes) && !empty($classes)): ?>
                                    <?php foreach ($classes as $class): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($class->drug_class_cd); ?></td>
                                            <td>
                                                <a href="<?php echo site_url('drug_class/detail/' . $class->drug_class_cd); ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($class->drug_class_name ?: $class->drug_class_cd); ?>
                                                </a>
                                            </td>
                                            <td><?php echo number_format($class->product_count); ?></td>
                                            <td><?php echo number_format($class->avg_commission_rate, 2); ?>%</td>
                                            <td><?php echo number_format($class->avg_commission); ?></td>
                                            <td>
                                                <?php echo $class->commission_rank_num; ?>
                                                <small class="text-muted">/ <?php echo $class->total_count; ?></small>
                                            </td>
                                            <td>
                                                <?php echo $class->commission_rate_rank_num; ?>
                                                <small class="text-muted">/ <?php echo $class->total_count; ?></small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">데이터가 없습니다.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- 페이징 -->
                    <div class="mt-4">
                        <?php echo isset($pagination) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.fa-sort, .fa-sort-up, .fa-sort-down {
    margin-left: 5px;
}
a:hover {
    text-decoration: none;
}
</style>

<?php $this->load->view('templates/footer'); ?> 