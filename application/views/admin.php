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

        .navbar-brand {
            font-size: 1.5rem;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-nav .nav-item {
            margin-right: 20px;
        }

        .navbar-nav .nav-item:last-child {
            margin-right: 0;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #adb5bd;
        }

        .sidebar {
            background: #343a40;
            color: #fff;
            padding-top: 20px;
            padding-right: 20px;
            padding-left: 20px;
            height: 100vh;
            position: fixed;
            width: 220px;
        }

        .sidebar h4 {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin: 15px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: #495057;
            text-decoration: none;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            border-radius: 10px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-action {
            padding: 5px 10px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .container-fluid {
            padding: 0;
        }

        .page-title {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/products'); ?>">Ürünler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('admin/users'); ?>">Kullanıcılar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('login/logout'); ?>">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <h4>Admin Menü</h4>
        <a href="<?php echo site_url('admin/products'); ?>">Ürün Yönetimi</a>
        <a href="<?php echo site_url('admin/users'); ?>">Kullanıcı Yönetimi</a>
        <a href="<?php echo site_url('admin/orders'); ?>">Sipariş Yönetimi</a>
        <a href="<?php echo site_url('admin/reports'); ?>">Raporlar</a>
    </div>

    <div class="content">
        <div class="container-fluid">
            <h1 class="page-title">Merhaba, <?php echo $this->session->userdata('username'); ?>!</h1>

            <div class="row">
                <div class="col-md-6">
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

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-4">Kullanıcı Yönetimi</h3>
                            <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-outline-primary w-100 btn-action">Kullanıcıları Görüntüle</a>
                            <a href="<?php echo site_url('admin/add_user'); ?>" class="btn btn-outline-success w-100 btn-action">Yeni Kullanıcı Ekle</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Ürün Listeleme</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ürün Adı</th>
                                <th>Fiyat</th>
                                <th>Aksiyonlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product->id; ?></td>
                                    <td><?php echo $product->name; ?></td>
                                    <td><?php echo $product->price; ?> TL</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning">Düzenle</a>
                                        <a href="#" class="btn btn-sm btn-danger">Sil</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>