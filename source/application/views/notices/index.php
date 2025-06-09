<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>공지사항</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">📢 경쟁사 공지사항</h2>
    
    <?php if (empty($notices)): ?>
        <div class="alert alert-info">공지사항이 없습니다.</div>
    <?php else: ?>
        <div class="card shadow-sm">
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
                            <?php foreach ($notices as $notice): ?>
                            <tr>
                                <td><?php echo date('Y-m-d', strtotime($notice->noti_date)); ?></td>
                                <td><?php echo $notice->product_name; ?></td>
                                <td><?php echo $notice->manufacturer_name; ?></td>
                                <td><?php echo $notice->notice_class_cd; ?></td>
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
                                            if (mb_strlen($content, 'UTF-8') > 20) {
                                                echo htmlspecialchars(mb_substr($content, 0, 20, 'UTF-8')) . '...';
                                            } else {
                                                echo htmlspecialchars($content);
                                            }
                                        ?>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (isset($pagination)): ?>
                <div class="d-flex justify-content-center mt-4">
                    <?php echo $pagination; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.table th {
    font-weight: 600;
    background-color: #f8f9fa;
}
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
</body>
</html>