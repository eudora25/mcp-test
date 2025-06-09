    </div> <!-- container-fluid 닫기 -->

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (일부 부트스트랩 플러그인에 필요) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted">© <?php echo date('Y'); ?> 의약품 관리 시스템. All rights reserved.</span>
                <div>
                    <a href="#" class="text-muted text-decoration-none me-3">이용약관</a>
                    <a href="#" class="text-muted text-decoration-none">개인정보처리방침</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
    // 활성 메뉴 표시
    $(document).ready(function() {
        // 현재 URL 경로 가져오기
        var path = window.location.pathname;
        
        // 네비게이션 링크들을 순회하면서 현재 페이지와 일치하는 링크 찾기
        $('.nav-link').each(function() {
            var href = $(this).attr('href');
            if (href && path.indexOf(href.split('//').pop()) !== -1) {
                $(this).addClass('active');
            }
        });
    });
    </script>

    <style>
    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }
    
    body {
        /* footer 높이만큼 하단 패딩 추가 */
        padding-bottom: 80px;
    }
    
    .nav-link.active {
        color: #ffffff !important;
        font-weight: bold;
    }
    </style>
</body>
</html> 