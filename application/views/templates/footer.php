    </div> <!-- main-content 닫기 -->

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <footer class="footer mt-auto">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h6 class="footer-title">
                        <i class="fas fa-pills me-2"></i>의약품 관리 시스템
                    </h6>
                    <p class="footer-desc">
                        전문적이고 효율적인 의약품 정보 관리를 위한 통합 플랫폼
                    </p>
                </div>
                
                <div class="footer-section">
                    <h6 class="footer-title">빠른 링크</h6>
                    <ul class="footer-links">
                        <li><a href="<?php echo base_url('dashboard'); ?>">대시보드</a></li>
                        <li><a href="<?php echo base_url('product_search'); ?>">제품 검색</a></li>
                        <li><a href="<?php echo base_url('drug_class'); ?>">분류 현황</a></li>
                        <li><a href="<?php echo base_url('notice'); ?>">공지사항</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h6 class="footer-title">시스템 정보</h6>
                    <ul class="footer-links">
                        <li>CodeIgniter <?php echo CI_VERSION; ?></li>
                        <li>PHP <?php echo phpversion(); ?></li>
                        <li><?php echo ucfirst(ENVIRONMENT); ?> 환경</li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h6 class="footer-title">지원</h6>
                    <ul class="footer-links">
                        <li><a href="#">이용 가이드</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">문의하기</a></li>
                        <li><a href="#">기술 지원</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <span class="copyright">
                        © <?php echo date('Y'); ?> 의약품 관리 시스템. All rights reserved.
                    </span>
                    <div class="footer-bottom-links">
                        <a href="#" class="footer-link">이용약관</a>
                        <span class="divider">|</span>
                        <a href="#" class="footer-link">개인정보처리방침</a>
                        <span class="divider">|</span>
                        <a href="#" class="footer-link">쿠키 정책</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // 활성 메뉴 표시
        $(document).ready(function() {
            // 현재 URL 경로 가져오기
            var path = window.location.pathname;
            var currentPage = path.split('/').pop() || 'dashboard';
            
            // 네비게이션 링크들을 순회하면서 현재 페이지와 일치하는 링크 찾기
            $('.nav-link').each(function() {
                var href = $(this).attr('href');
                if (href) {
                    var linkPage = href.split('/').pop();
                    if (linkPage === currentPage || 
                        (currentPage === '' && linkPage === 'dashboard') ||
                        href.includes(currentPage)) {
                        $(this).addClass('active');
                    }
                }
            });
            
            // 네비게이션 호버 효과 강화
            $('.nav-link').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
            
            // 푸터 애니메이션
            $('.footer').css({
                'opacity': '0',
                'transform': 'translateY(30px)'
            }).animate({
                'opacity': '1',
                'transform': 'translateY(0)'
            }, 800);
        });
        
        // 스크롤 이벤트 처리
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var navbar = $('.navbar');
            
            if (scroll >= 50) {
                navbar.css('background', 'rgba(255, 255, 255, 0.35)');
                navbar.css('backdrop-filter', 'blur(25px)');
            } else {
                navbar.css('background', 'rgba(255, 255, 255, 0.25)');
                navbar.css('backdrop-filter', 'blur(20px)');
            }
        });
        
        // 부드러운 스크롤
        $('a[href^="#"]').on('click', function(event) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });
        
        console.log('의약품 관리 시스템이 성공적으로 로드되었습니다! 💊');
    </script>

    <style>
        /* 푸터 스타일 */
        .footer {
            position: relative;
            bottom: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            margin-top: 3rem;
            padding: 3rem 0 1rem;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h6.footer-title {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .footer-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #667eea;
            transform: translateX(5px);
            text-decoration: underline;
        }

        .footer-links li:not(:has(a)) {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .footer-bottom {
            border-top: 1px solid rgba(102, 126, 234, 0.1);
            padding-top: 1.5rem;
        }

        .footer-bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .copyright {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .footer-bottom-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .footer-link:hover {
            color: #667eea;
            text-decoration: underline;
        }

        .divider {
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* 활성 네비게이션 링크 */
        .nav-link.active {
            color: white !important;
            font-weight: 600 !important;
            background: rgba(255, 255, 255, 0.2) !important;
        }

        /* 반응형 디자인 */
        @media (max-width: 768px) {
            .footer {
                padding: 2rem 0 1rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }

        /* 스크롤바 스타일링 */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(102, 126, 234, 0.5);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(102, 126, 234, 0.7);
        }

        /* 로딩 상태 */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* 페이지 전환 애니메이션 */
        .page-transition {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html> 