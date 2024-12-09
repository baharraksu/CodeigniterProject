<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoriler</title>
</head>

<body>
    <h1>Kategoriler</h1>
    <ul>
        <?php if (isset($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <li><?= $category['categoryName'] ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Kategori bulunamadı.</p>
        <?php endif; ?>
    </ul>
</body>

</html>