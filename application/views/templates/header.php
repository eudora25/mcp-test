<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>의약품 관리 시스템</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <style>
    .navbar-brand {
        font-weight: bold;
    }
    .nav-link {
        color: rgba(255,255,255,.75);
    }
    .nav-link:hover {
        color: rgba(255,255,255,1);
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">의약품 관리</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('dashboard'); ?>">대시보드</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('drug_class'); ?>">분류 현황</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('product_search'); ?>">
                            <i class="fas fa-search"></i> 제품 검색
                        </a>
                    </li>
                </ul>
                
                <?php if ($this->session->userdata('admin_logged_in')): ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-user"></i> 
                            <?php echo $this->session->userdata('admin_name'); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>">
                            <i class="fas fa-sign-out-alt"></i> 로그아웃
                        </a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4"> 