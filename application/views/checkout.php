<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ödeme Sayfası</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Ödeme Sayfası</h1>

        <!-- Hata mesajı gösterimi -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <!-- Sepet Tablosu -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Miktar</th>
                    <th>Birim Fiyat</th>
                    <th>Toplam</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>
                            <input type="number" name="quantity[<?= $item['product_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control" />
                        </td>
                        <td><?= number_format($item['price'], 2) ?> ₺</td>
                        <td><?= number_format($item['quantity'] * $item['price'], 2) ?> ₺</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Toplam Ücret -->
        <h3 class="text-end">Toplam: <?= number_format($total_price, 2) ?> ₺</h3>

        <!-- Adres Seçim Alanı -->
        <form method="POST" action="order_success.php">
            <div class="mb-3">
                <label for="address" class="form-label">Adres Bilgisi</label>
                <select class="form-select" id="address" name="address" required>
                    <option value="">Adres seçin</option>
                    <?php if (!empty($addresses)): ?>
                        <?php foreach ($addresses as $address): ?>
                            <option value="<?= $address['id'] ?>">
                                <?= $address['address_line1'] . ' ' . ($address['address_line2'] ? $address['address_line2'] . ', ' : '') . $address['city'] . ', ' . $address['state'] . ', ' . $address['postal_code'] . ', ' . $address['country'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>Adres bulunamadı</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Ödeme Yöntemi Seçim Alanı -->
            <div class="mb-3">
                <label for="payment_method" class="form-label">Ödeme Yöntemi</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="">Ödeme Yöntemi Seçin</option>
                    <option value="credit_card">Kredi Kartı</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Banka Havalesi</option>
                </select>
            </div>

            <!-- Siparişi Tamamla Butonu -->
            <button type="submit" class="btn btn-primary w-100">Siparişi Tamamla</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>