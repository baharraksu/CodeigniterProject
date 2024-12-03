<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            margin-bottom: 30px;
        }

        .container {
            max-width: 800px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="d-flex">
                <a class="btn btn-outline-light" href="<?php echo site_url('login/logout'); ?>">Çıkış Yap</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-4">Merhaba, <?php echo $this->session->userdata('username'); ?>!</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Yeni Ürün Ekle</h3>
                <form action="<?php echo base_url('admin/add_product'); ?>" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ürün Adı</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Fiyat</label>
                        <input type="number" class="form-control" name="price" id="price" step="0.01" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Ürün Ekle</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>