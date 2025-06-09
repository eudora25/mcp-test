<?php $this->load->view('templates/header'); ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">공지사항 목록</h5>
                    <!-- 검색 폼 -->
                    <form action="<?php echo site_url('notice'); ?>" method="get" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                               value="<?php echo $search_keyword; ?>" placeholder="검색어를 입력하세요">
                        <button type="submit" class="btn btn-primary btn-sm">검색</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>공지일</th>
                                    <th>제품명</th>
                                    <th>제조사</th>
                                    <th>제품분류</th>
                                    <th>공지분류</th>
                                    <th>중요도</th>
                                    <th>카테고리</th>
                                    <th>내용</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($notices)): ?>
                                    <?php foreach ($notices as $notice): ?>
                                        <tr>
                                            <td><?php echo date('Y-m-d', strtotime($notice->noti_date)); ?></td>
                                            <td><?php echo $notice->product_name; ?></td>
                                            <td><?php echo $notice->manufacturer_name; ?></td>
                                            <td><?php echo $notice->drug_class_name ?: $notice->drug_class_cd; ?></td>
                                            <td><?php echo $notice->notice_class_name ?: $notice->notice_class_cd; ?></td>
                                            <td>
                                                <span class="badge <?php 
                                                    echo $notice->noti_crisis_level === 'A' ? 'bg-danger' : 
                                                        ($notice->noti_crisis_level === 'B' ? 'bg-warning text-dark' : 'bg-info text-dark'); 
                                                ?>">
                                                    <?php echo $notice->crisis_level_name; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $notice->category_name; ?></td>
                                            <td>
                                                <a href="#" class="text-decoration-none notice-content" 
                                                   data-bs-toggle="modal" 
                                                   data-bs-target="#noticeModal"
                                                   data-notice-title="<?php echo htmlspecialchars($notice->product_name); ?> - <?php echo date('Y-m-d', strtotime($notice->noti_date)); ?>"
                                                   data-notice-content="<?php echo htmlspecialchars($notice->content); ?>">
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
                                        <td colspan="8" class="text-center">공지사항이 없습니다.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- 페이징 -->
                    <div class="mt-4">
                        <?php echo $pagination_links; ?>
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

<?php $this->load->view('templates/footer'); ?>