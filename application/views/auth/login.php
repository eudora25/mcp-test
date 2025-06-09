<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        /* 차분한 분위기를 위한 커스텀 스타일 */
        body {
            background-color: #f8f9fa; /* 아주 연한 회색 배경 */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* 부드러운 폰트 */
        }
        .login-container {
            background-color: #ffffff; /* 흰색 로그인 박스 */
            padding: 40px;
            border-radius: 10px; /* 부드러운 모서리 */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* 은은한 그림자 */
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40; /* 어두운 회색 제목 */
            font-weight: 600;
        }
        .form-label {
            color: #495057; /* 폼 라벨 색상 */
        }
        .form-control {
            border-color: #dee2e6; /* 연한 테두리 색상 */
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(108, 117, 125, 0.25); /* 회색 포커스 그림자 */
            border-color: #adb5bd;
        }
        .btn-primary {
            background-color: #6c757d; /* 부드러운 회색 버튼 */
            border-color: #6c757d;
            font-weight: 600;
            padding: 10px 0;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .text-muted {
            font-size: 0.9em;
        }
        a {
            color: #6c757d; /* 링크 색상 */
            text-decoration: none;
        }
        a:hover {
            color: #495057;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>로그인</h2>
		 <?php if($this->session->flashdata('error_msg')): ?>
            <div class="alert alert-danger fade show"><?php echo $this->session->flashdata('error_msg'); ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-success fade show"><?php echo $this->session->flashdata('success_msg'); ?></div>
        <?php endif; ?>

        <?php echo validation_errors('<div class="alert alert-danger fade show">', '</div>'); ?>
        <?php echo form_open('/auth/login'); ?>
            <div class="mb-3">
                <label for="username" class="form-label">아이디</label>
                <input type="text" name="admin_id" id="admin_id" class="form-control" value="<?php echo set_value('admin_id'); ?>"  placeholder="아이디를 입력하세요" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">비밀번호</label>
                <input type="password" name="admin_pw" id="admin_pw" class="form-control" placeholder="비밀번호를 입력하세요" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">로그인 정보 저장</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">로그인</button>
            <div class="mt-3 text-center text-muted">
                <p>계정이 없으신가요? <a href="#">회원가입</a></p>
                <p><a href="#">비밀번호 찾기</a></p>
            </div>
         <?php echo form_close(); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>