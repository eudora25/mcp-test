<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>의약품 관리 시스템 - 로그인</title>
    
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        /* 컬러 시스템 */
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            
            --primary-color: #2ECC71;
            --primary-dark: #27AE60;
            --primary-light: rgba(46, 204, 113, 0.1);
            
            --success-color: #2ECC71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --info-color: #3498db;
            
            --white: #ffffff;
            --light-gray: #f8f9fa;
            --gray: #6c757d;
            --dark-gray: #495057;
            --black: #212529;
            
            --text-primary: #2c3e50;
            --text-secondary: #7f8c8d;
            --text-muted: #bdc3c7;
            --text-white: #ffffff;
        }

        /* 기본 스타일 */
        body {
            font-family: 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* 메인 배경 */
        .main-background {
            background: var(--gradient-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
        }

        /* 배경 애니메이션 요소 */
        .main-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(2deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }

        /* 인증 컨테이너 */
        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 50px 40px;
            max-width: 450px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* 인증 헤더 */
        .auth-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .auth-header .logo {
            margin-bottom: 20px;
        }

        .auth-header .logo i {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 3rem;
        }

        .auth-header h2 {
            font-size: 2rem;
            font-weight: 300;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .auth-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        /* 폼 스타일 */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .form-control-modern {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(46, 204, 113, 0.1);
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .form-control-modern:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(46, 204, 113, 0.15);
            background: var(--white);
            transform: translateY(-1px);
        }

        .form-control-modern::placeholder {
            color: var(--text-muted);
            font-size: 14px;
        }

        /* 비밀번호 입력 그룹 */
        .input-group .btn {
            border-left: none;
            background: transparent;
            border: 2px solid rgba(46, 204, 113, 0.1);
            border-left: none;
            border-radius: 0 10px 10px 0;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .input-group .btn:hover {
            color: var(--primary-color);
            background: rgba(46, 204, 113, 0.05);
        }

        .input-group .form-control-modern {
            border-radius: 10px 0 0 10px;
        }

        /* 체크박스 스타일 */
        .form-check {
            margin: 20px 0;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(46, 204, 113, 0.25);
        }

        .form-check-label {
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* 버튼 스타일 */
        .btn-auth {
            background: var(--gradient-primary);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }

        .btn-auth:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-auth:hover:before {
            left: 100%;
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        /* 알림 스타일 */
        .alert-modern {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .alert-success.alert-modern {
            background: linear-gradient(135deg, rgba(46, 204, 113, 0.1) 0%, rgba(39, 174, 96, 0.05) 100%);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .alert-danger.alert-modern {
            background: linear-gradient(135deg, rgba(231, 76, 60, 0.1) 0%, rgba(192, 57, 43, 0.05) 100%);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .alert-modern i {
            margin-right: 10px;
            font-size: 16px;
        }

        /* 링크 스타일 */
        .auth-links {
            text-align: center;
            margin-top: 30px;
        }

        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .auth-links a:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }

        .auth-links a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 50%;
            background: var(--gradient-primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .auth-links a:hover:after {
            width: 100%;
        }

        .auth-links p {
            margin: 8px 0;
            color: var(--text-secondary);
            font-size: 14px;
        }

        /* 반응형 디자인 */
        @media (max-width: 575.98px) {
            .auth-container {
                padding: 30px 20px;
                margin: 20px;
                max-width: none;
            }
            
            .btn-auth {
                padding: 15px 20px;
                font-size: 16px;
            }

            .auth-header h2 {
                font-size: 1.75rem;
            }

            .auth-header .logo i {
                font-size: 2.5rem;
            }
        }

        /* 로딩 스피너 */
        .spinner-modern {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* 입력 필드 포커스 효과 */
        .form-group {
            position: relative;
        }

        .form-group.focused .form-label {
            color: var(--primary-color);
        }

        .form-group.focused .form-label i {
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="main-background">
        <div class="auth-container">
            <!-- 인증 헤더 -->
            <div class="auth-header">
                <div class="logo">
                    <i class="fas fa-pills"></i>
                </div>
                <h2>시스템 로그인</h2>
                <p>의약품 관리 시스템에 로그인하세요</p>
            </div>

            <!-- 알림 메시지 -->
            <?php if($this->session->flashdata('error_msg')): ?>
                <div class="alert alert-danger alert-modern" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
            <?php endif; ?>
            
            <?php if($this->session->flashdata('success_msg')): ?>
                <div class="alert alert-success alert-modern" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $this->session->flashdata('success_msg'); ?>
                </div>
            <?php endif; ?>

            <?php if(validation_errors()): ?>
                <div class="alert alert-danger alert-modern" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <!-- 로그인 폼 -->
            <?php echo form_open('/auth/login', array('id' => 'loginForm')); ?>
                <!-- CSRF 토큰 (CodeIgniter에서 자동 추가) -->
                <div class="form-group">
                    <label for="admin_id" class="form-label">
                        <i class="fas fa-user"></i>관리자 ID
                    </label>
                    <input type="text" name="admin_id" id="admin_id" 
                           class="form-control form-control-modern" 
                           value="<?php echo set_value('admin_id'); ?>" 
                           placeholder="아이디를 입력하세요" 
                           required autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="admin_pw" class="form-label">
                        <i class="fas fa-lock"></i>비밀번호
                    </label>
                    <div class="input-group">
                        <input type="password" name="admin_pw" id="admin_pw" 
                               class="form-control form-control-modern" 
                               placeholder="비밀번호를 입력하세요" 
                               required autocomplete="current-password">
                        <button type="button" class="btn" onclick="togglePassword()">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        로그인 정보 저장
                    </label>
                </div>

                <button type="submit" class="btn btn-auth" id="loginButton">
                    <div class="spinner-modern"></div>
                    <span>로그인</span>
                </button>
            <?php echo form_close(); ?>

            <!-- 링크 -->
            <div class="auth-links">
                <p>계정이 없으신가요? <a href="#">회원가입</a></p>
                <p><a href="#">비밀번호 찾기</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // 비밀번호 표시/숨김 토글
        function togglePassword() {
            const passwordInput = document.getElementById('admin_pw');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // 폼 입력 필드 포커스 효과
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            const inputs = document.querySelectorAll('.form-control-modern');
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.form-group').classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.closest('.form-group').classList.remove('focused');
                });
            });

            // 폼 제출 시 로딩 스피너
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const spinner = loginButton.querySelector('.spinner-modern');
            const buttonText = loginButton.querySelector('span');
            
            loginForm.addEventListener('submit', function() {
                loginButton.disabled = true;
                spinner.style.display = 'inline-block';
                buttonText.textContent = '로그인 중...';
                
                // 5초 후 자동 복구 (네트워크 문제 대비)
                setTimeout(function() {
                    loginButton.disabled = false;
                    spinner.style.display = 'none';
                    buttonText.textContent = '로그인';
                }, 5000);
            });

            // 엔터 키 지원
            inputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        loginForm.submit();
                    }
                });
            });
        });

        // 접근성 개선 - 키보드 네비게이션
        document.addEventListener('keydown', function(e) {
            if (e.altKey && e.key === 'l') {
                document.getElementById('admin_id').focus();
            }
        });
    </script>
</body>
</html>