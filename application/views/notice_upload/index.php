<?php $this->load->view('templates/header'); ?>

<style>
    /* 공지사항 업로드 페이지 전용 스타일 */
    .upload-hero {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .upload-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(102,126,234,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }

    .upload-hero:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
    }

    .upload-hero h1, .upload-hero p, .upload-hero i {
        position: relative;
        z-index: 2;
    }

    .upload-hero h1 {
        color: var(--text-primary);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .upload-hero p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    .upload-hero i {
        color: #667eea;
        margin-bottom: 1rem;
    }

    .upload-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .upload-card:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.15);
    }

    .file-drop-area {
        border: 3px dashed rgba(102, 126, 234, 0.3);
        border-radius: 15px;
        padding: 3rem 2rem;
        text-align: center;
        background: rgba(102, 126, 234, 0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .file-drop-area:hover,
    .file-drop-area.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .file-drop-area i {
        font-size: 4rem;
        color: #667eea;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .file-drop-area:hover i {
        color: #5a67d8;
        transform: scale(1.1);
    }

    .file-drop-area h5 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .file-drop-area p {
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .file-input {
        display: none;
    }

    .file-info {
        background: rgba(76, 175, 80, 0.1);
        color: #2e7d32;
        padding: 1rem;
        border-radius: 10px;
        margin-top: 1rem;
        display: none;
        border: 1px solid rgba(76, 175, 80, 0.2);
    }

    .format-info {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .format-info h5 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .format-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .format-table th {
        background: var(--primary-gradient);
        color: white;
        padding: 1rem 0.75rem;
        font-weight: 600;
        text-align: center;
        font-size: 0.9rem;
    }

    .format-table td {
        padding: 0.75rem;
        text-align: center;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        color: var(--text-secondary);
    }

    .format-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
    }

    .progress-container {
        display: none;
        margin-top: 1rem;
    }

    .progress {
        height: 10px;
        border-radius: 5px;
        overflow: hidden;
        background: rgba(102, 126, 234, 0.1);
    }

    .progress-bar {
        height: 100%;
        background: var(--primary-gradient);
        border-radius: 5px;
        transition: width 0.3s ease;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
    }

    .stat-card i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .stat-card.primary i {
        color: #667eea;
    }

    .stat-card.success i {
        color: #4caf50;
    }

    .stat-card.warning i {
        color: #ff9800;
    }

    .stat-card.info i {
        color: #2196f3;
    }

    .stat-card h6 {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .stat-card .number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .btn-upload {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-upload:disabled {
        background: var(--text-muted);
        transform: none;
        box-shadow: none;
    }

    /* 알림 스타일 */
    .alert {
        border-radius: 15px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
    }

    .alert-success {
        background: rgba(76, 175, 80, 0.1);
        color: #2e7d32;
        border: 1px solid rgba(76, 175, 80, 0.2);
    }

    .alert-danger {
        background: rgba(244, 67, 54, 0.1);
        color: #c62828;
        border: 1px solid rgba(244, 67, 54, 0.2);
    }

    /* 반응형 디자인 */
    @media (max-width: 768px) {
        .upload-hero {
            padding: 2rem 1rem;
        }
        
        .upload-card {
            padding: 1.5rem;
        }
        
        .file-drop-area {
            padding: 2rem 1rem;
        }
        
        .file-drop-area i {
            font-size: 3rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- 히어로 섹션 -->
<div class="upload-hero">
    <i class="fas fa-cloud-upload-alt" style="font-size: 4rem;"></i>
    <h1>공지사항 일괄 업로드</h1>
    <p>엑셀 또는 CSV 파일을 업로드하여 공지사항 데이터를 한 번에 등록하세요</p>
</div>

<!-- 알림 메시지 -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- 업로드 카드 -->
<div class="upload-card">
    <h4 class="mb-4">
        <i class="fas fa-file-upload me-2"></i>파일 업로드
    </h4>
    
    <form id="uploadForm" action="<?= base_url('notice_upload/upload') ?>" method="post" enctype="multipart/form-data">
        <div class="file-drop-area" id="fileDropArea">
            <i class="fas fa-cloud-upload-alt"></i>
            <h5>파일을 여기에 드래그하거나 클릭하여 선택하세요</h5>
            <p>지원 형식: .xlsx, .xls, .csv (최대 10MB)</p>
            <input type="file" id="fileInput" name="excel_file" class="file-input" accept=".xlsx,.xls,.csv">
            <button type="button" class="btn-upload" onclick="document.getElementById('fileInput').click()">
                <i class="fas fa-folder-open me-2"></i>파일 선택
            </button>
        </div>
        
        <div class="file-info" id="fileInfo">
            <i class="fas fa-file-check me-2"></i>
            <span id="fileName"></span>
            <span id="fileSize" class="text-muted ms-2"></span>
        </div>
        
        <div class="progress-container" id="progressContainer">
            <div class="progress">
                <div class="progress-bar" id="progressBar" style="width: 0%"></div>
            </div>
            <small class="text-muted mt-1 d-block">업로드 진행률: <span id="progressText">0%</span></small>
        </div>
        
        <div class="text-center mt-3">
            <button type="submit" class="btn-upload" id="submitBtn" disabled>
                <i class="fas fa-upload me-2"></i>업로드 시작
            </button>
        </div>
    </form>
</div>

<!-- 파일 형식 안내 -->
<div class="format-info">
    <h5>
        <i class="fas fa-info-circle me-2"></i>파일 형식 안내
    </h5>
    <p class="text-muted mb-3">업로드할 파일은 다음 형식을 따라야 합니다:</p>
    
    <div class="table-responsive">
        <table class="format-table table">
            <thead>
                <tr>
                    <th>컬럼명</th>
                    <th>설명</th>
                    <th>필수여부</th>
                    <th>예시</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>A열</strong></td>
                    <td>미사용 (비워두세요)</td>
                    <td><span class="badge bg-secondary">미사용</span></td>
                    <td>-</td>
                </tr>
                <tr>
                    <td><strong>B열</strong></td>
                    <td>공지일자</td>
                    <td><span class="badge bg-danger">필수</span></td>
                    <td>2024-01-15</td>
                </tr>
                <tr>
                    <td><strong>C열</strong></td>
                    <td>공지내용</td>
                    <td><span class="badge bg-warning">선택</span></td>
                    <td>제품 안전성 관련 공지사항</td>
                </tr>
                <tr>
                    <td><strong>D열</strong></td>
                    <td>중요도 (A:긴급, B:중요, C:일반)</td>
                    <td><span class="badge bg-warning">선택</span></td>
                    <td>A, B, C</td>
                </tr>
                <tr>
                    <td><strong>E열</strong></td>
                    <td>카테고리 (L:법령, M:제조, S:안전, E:기타)</td>
                    <td><span class="badge bg-warning">선택</span></td>
                    <td>L, M, S, E</td>
                </tr>
                <tr>
                    <td><strong>F열</strong></td>
                    <td>공지분류코드</td>
                    <td><span class="badge bg-warning">선택</span></td>
                    <td>001, 002, 003</td>
                </tr>
                <tr>
                    <td><strong>G열</strong></td>
                    <td>제품명 (정확한 제품명 입력)</td>
                    <td><span class="badge bg-danger">필수</span></td>
                    <td>타이레놀정, 아스피린정</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        <small class="text-muted">
            <i class="fas fa-lightbulb me-1"></i>
            <strong>팁:</strong> 첫 번째 행은 컬럼명으로 사용되며, 데이터는 두 번째 행부터 시작됩니다.
        </small>
        <div class="mt-2">
            <a href="<?= base_url('notice_upload/download_sample') ?>" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-download me-1"></i>샘플 파일 다운로드
            </a>
        </div>
    </div>
</div>

<!-- 통계 정보 -->
<?php if (isset($upload_stats)): ?>
<div class="stats-grid">
    <div class="stat-card primary">
        <i class="fas fa-file-upload"></i>
        <h6>총 업로드 횟수</h6>
        <div class="number"><?= number_format($upload_stats['total_uploads'] ?? 0) ?></div>
    </div>
    <div class="stat-card success">
        <i class="fas fa-check-circle"></i>
        <h6>성공한 업로드</h6>
        <div class="number"><?= number_format($upload_stats['successful_uploads'] ?? 0) ?></div>
    </div>
    <div class="stat-card warning">
        <i class="fas fa-exclamation-triangle"></i>
        <h6>실패한 업로드</h6>
        <div class="number"><?= number_format($upload_stats['failed_uploads'] ?? 0) ?></div>
    </div>
    <div class="stat-card info">
        <i class="fas fa-database"></i>
        <h6>총 등록된 공지</h6>
        <div class="number"><?= number_format($upload_stats['total_notices'] ?? 0) ?></div>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileDropArea = document.getElementById('fileDropArea');
    const fileInput = document.getElementById('fileInput');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');
    const uploadForm = document.getElementById('uploadForm');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');

    // 드래그 앤 드롭 이벤트
    fileDropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileDropArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileDropArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });

    fileDropArea.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            handleFileSelect(this.files[0]);
        }
    });

    function handleFileSelect(file) {
        // 파일 형식 검증
        const allowedTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel',
            'text/csv'
        ];
        
        if (!allowedTypes.includes(file.type)) {
            alert('지원하지 않는 파일 형식입니다. .xlsx, .xls, .csv 파일만 업로드 가능합니다.');
            return;
        }

        // 파일 크기 검증 (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('파일 크기가 너무 큽니다. 10MB 이하의 파일만 업로드 가능합니다.');
            return;
        }

        // 파일 정보 표시
        fileName.textContent = file.name;
        fileSize.textContent = `(${formatFileSize(file.size)})`;
        fileInfo.style.display = 'block';
        submitBtn.disabled = false;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // 폼 제출 처리
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!fileInput.files.length) {
            alert('업로드할 파일을 선택해주세요.');
            return;
        }

        const formData = new FormData(this);
        
        // 진행률 표시
        progressContainer.style.display = 'block';
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>업로드 중...';

        // AJAX 업로드
        const xhr = new XMLHttpRequest();
        
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                progressBar.style.width = percentComplete + '%';
                progressText.textContent = Math.round(percentComplete) + '%';
            }
        });

        xhr.addEventListener('load', function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('파일이 성공적으로 업로드되었습니다.');
                        location.reload();
                    } else {
                        alert('업로드 중 오류가 발생했습니다: ' + response.message);
                    }
                } catch (e) {
                    // JSON 파싱 실패 시 페이지 리로드
                    location.reload();
                }
            } else {
                alert('업로드 중 오류가 발생했습니다.');
            }
            
            // 초기화
            progressContainer.style.display = 'none';
            progressBar.style.width = '0%';
            progressText.textContent = '0%';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-upload me-2"></i>업로드 시작';
        });

        xhr.addEventListener('error', function() {
            alert('업로드 중 네트워크 오류가 발생했습니다.');
            progressContainer.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-upload me-2"></i>업로드 시작';
        });

        xhr.open('POST', this.action);
        xhr.send(formData);
    });

    // 카드 애니메이션
    const cards = document.querySelectorAll('.upload-hero, .upload-card, .format-info, .stat-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }, index * 150);
    });

    console.log('공지사항 업로드 페이지가 성공적으로 로드되었습니다! 📤');
});
</script>

<?php $this->load->view('templates/footer'); ?> 