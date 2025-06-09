<!doctype html>
<html lang="ko">
<head>
  <meta charset="utf-8">
  <title>관리자 대시보드</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .dashboard-container {
      max-width: 600px;
      margin: 80px auto;
      padding: 40px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="dashboard-container">
      <h2 class="mb-4">관리자 대시보드</h2>

      <p><strong>관리자명:</strong> <?= htmlspecialchars($admin->admin_name) ?></p>
      <p><strong>아이디:</strong> <?= htmlspecialchars($admin->admin_id) ?></p>
      <p><strong>타입:</strong> <?= htmlspecialchars($admin->type_cd) ?></p>

      <hr>
      <button class="btn btn-secondary" onclick="logout()">로그아웃</button>
    </div>
  </div>

  <script>
    function logout() {
      localStorage.removeItem("jwt_token");
      alert("로그아웃 되었습니다.");
      window.location.href = "<?= base_url('auth') ?>";
    }

    // JWT 미존재 시 차단
    const token = localStorage.getItem("jwt_token");
    if (!token) {
      alert("인증되지 않은 접근입니다.");
      window.location.href = "<?= base_url('auth') ?>";
    }
  </script>

</body>
</html>