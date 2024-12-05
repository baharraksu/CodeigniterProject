<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstikbal Tarzı Web Sitesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sabit Üst Menü */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            background-color: #007bff;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            height: 100%;
            color: #fff;
            padding-top: 60px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar a:hover {
            background-color: #007bff;
        }

        .content {
            margin-left: 250px;
            padding: 80px 20px;
            overflow-y: auto;
            height: 100vh;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .navbar .cart-icon {
            position: relative;
        }

        .navbar .cart-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff0000;
            color: #fff;
            border-radius: 50%;
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    </style>
</head>

<body>
    <!-- Sabit Üst Menü -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="<?php echo site_url('cart/viewCart'); ?>">
                            <i class="fas fa-shopping-cart"></i> Sepetim
                            <span class="badge"><?php echo $cart_item_count ?? 0; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo site_url('login/logout'); ?>">Çıkış Yap</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sabit Yan Menü -->
    <div class="sidebar">
        <h4 class="text-center py-3 border-bottom">Kategoriler</h4>
        <a href="#" onclick="filterProducts('all')"><i class="fas fa-list"></i> Tüm Ürünler</a>
        <a href="#" onclick="filterProducts('mobilya')"><i class="fas fa-couch"></i> Mobilya</a>
        <a href="#" onclick="filterProducts('halı')"><i class="fas fa-rug"></i> Halı</a>
        <a href="#" onclick="filterProducts('aydınlatma')"><i class="fas fa-lightbulb"></i> Aydınlatma</a>
    </div>

    <!-- İçerik -->
    <div class="content">
        <h1 class="text-center text-primary mb-4">Merhaba, <?php echo $this->session->userdata('username'); ?>!</h1>
        <h2 class="mt-4 text-center">Admin Tarafından Eklenen Ürünler:</h2>
        <div id="product-container" class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col product-item" data-category="<?php echo $product['category']; ?>">
                    <div class="card shadow-lg">
                        <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Ürün Resmi">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <p class="card-text"><strong>Fiyat:</strong> <?php echo $product['price']; ?> TL</p>

                            <a href="<?php echo site_url('cart/addToCart/' . $product['id']); ?>" class="btn btn-success">
                                <i class="fas fa-cart-plus"></i> Sepete Ekle
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterProducts(category) {
            const products = document.querySelectorAll('.product-item');
            products.forEach(product => {
                if (category === 'all' || product.getAttribute('data-category') === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>