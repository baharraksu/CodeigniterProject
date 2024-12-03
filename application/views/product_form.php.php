<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
</head>

<body>
    <h1>Ürün Ekle</h1>
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color: red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>
    <form action="<?php echo base_url('product/add_action'); ?>" method="post">
        <label>Ürün Adı:</label><br>
        <input type="text" name="name" required><br>

        <label>Açıklama:</label><br>
        <textarea name="description" required></textarea><br>

        <label>Fiyat:</label><br>
        <input type="number" name="price" step="0.01" required><br><br>

        <button type="submit">Ürünü Ekle</button>
    </form>
</body>

</html>