<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepetiniz</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (İconlar için) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4 text-center">Sepetiniz</h1>

        <?php if ($cart_item_count > 0): ?>
            <form action="<?= site_url('cart/updateCart') ?>" method="post">
                <table class="table table-bordered table-hover shadow-sm rounded">
                    <thead class="table-dark text-white">
                        <tr>
                            <th>Ürün Adı</th>
                            <th>Fiyat</th>
                            <th>Miktar</th>
                            <th>Toplam</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td><?= number_format($item['price'], 2) ?> ₺</td>
                                <td>
                                    <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1"
                                        class="form-control quantity-input" data-price="<?= $item['price'] ?>"
                                        onchange="updateTotal(this)">
                                </td>
                                <td><span class="total-price"><?= number_format($item['price'] * $item['quantity'], 2) ?> ₺</span></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="removeItem(<?= $item['id'] ?>)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Sil
                                    </a>
                                </td>
                                <script>
                                    function removeItem(cartId) {
                                        if (confirm("Bu ürünü sepetinizden silmek istediğinizden emin misiniz?")) {
                                            window.location.href = "<?= site_url('cart/removeItem/') ?>" + cartId;
                                        }
                                    }
                                </script>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-warning text-white">Sepeti Güncelle</button>
                    <a href="<?= site_url('checkout') ?>" class="btn btn-success text-white">Ödeme Sayfasına Git</a>
                </div>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                Sepetiniz boş. Hemen alışveriş yapın!
                <br>
                <a href="<?= site_url('dashboard') ?>" class="btn btn-success mt-2">Alışverişe Devam Et</a>
            </div>
        <?php endif; ?>

        <!-- Bootstrap 5 JS ve Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

        <!-- JavaScript: Miktar Değiştiğinde Toplamı Güncelleme -->
        <script>
            function updateTotal(input) {
                var quantity = input.value;
                var price = input.getAttribute('data-price');
                var total = (quantity * price).toFixed(2);
                input.closest('tr').querySelector('.total-price').innerHTML = total + " ₺";
            }
        </script>
</body>

</html>