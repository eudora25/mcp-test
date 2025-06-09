<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>제조사별 제품 수 순위</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 40px;
            margin-bottom: 40px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
            font-weight: 700;
            text-align: center;
        }
        .table th {
            background-color: #e9ecef;
            color: #495057;
            font-weight: 600;
        }
        .table tbody tr:hover {
            background-color: #f1f3f5;
        }
        .search-form {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-form .form-control {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>제조사별 제품 수 순위</h1>

        <?php echo form_open('manufacturer/rank', array('method' => 'GET', 'class' => 'search-form')); ?>
            <input type="text" class="form-control" name="q" placeholder="제조사명 검색..." value="<?= html_escape($search_keyword) ?>">
            <button type="submit" class="btn btn-secondary">검색</button>
            <a href="<?= site_url('manufacturer/rank') ?>" class="btn btn-outline-secondary">초기화</a>
        <?php echo form_close(); ?>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">순위</th>
                        <th scope="col">제조사명</th>
                        <th scope="col">제품 수</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($manufacturers)): ?>
                        <?php $rank = $current_page_start_rank; ?>
                        <?php foreach ($manufacturers as $manufacturer): ?>
                            <tr>
                                <td><?= $rank++ ?></td>
                                <td><?= html_escape($manufacturer['manufacturer_name']) ?></td>
                                <td><?= html_escape($manufacturer['product_count']) ?>개</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">제조사 정보가 없습니다.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?= $pagination_links ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>