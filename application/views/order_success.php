<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Sipariş Tamamlandı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .success-icon {
            font-size: 3rem;
            color: #28a745;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="text-center">
            <i class="success-icon bi bi-check-circle"></i>
            <h1 class="text-success">Sipariş Tamamlandı</h1>
            <p class="text-muted">Siparişiniz başarıyla oluşturuldu! Detaylar aşağıda yer almaktadır.</p>
        </div>

        <!-- Sipariş Özeti -->
        <div class="order-summary my-4">
            <h4 class="text-center">Sipariş Detayları</h4>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Ürün Adı</th>
                        <th>Miktar</th>
                        <th>Birim Fiyat</th>
                        <th>Toplam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'], 2) ?> ₺</td>
                            <td><?= number_format($item['quantity'] * $item['price'], 2) ?> ₺</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end">
                <h5><strong>Toplam Tutar:</strong> <?= number_format($total_price, 2) ?> ₺</h5>
            </div>
        </div>

        <!-- Ana Sayfaya Dön ve Yönlendirme -->
        <div class="text-center">
            <p class="text-muted">5 saniye içinde yönetim paneline yönlendirileceksiniz.</p>
            <a href="<?= site_url('dashboard') ?>" class="btn btn-primary">Yönetim Paneline Git</a>
        </div>
    </div>

    <script>
        // 5 saniye sonra otomatik yönlendirme
        setTimeout(function() {
            window.location.href = "http://localhost/Codeigniter/dashboard";
        }, 5000);
    </script>
</body>

</html>