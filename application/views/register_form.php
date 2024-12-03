<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Formu</title>
    <!-- Bootstrap CSS bağlantısı -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Kullanıcı Kaydı</h4>
                    </div>
                    <div class="card-body">
                        <!-- Başarı veya hata mesajları -->
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                        <?php elseif ($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                        <?php endif; ?>

                        <!-- Form doğrulama hataları -->
                        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                        <!-- Kayıt formu -->
                        <form action="<?php echo base_url('register/store'); ?>" method="post">
                            <div class="form-group">
                                <label for="username">Kullanıcı Adı:</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo set_value('username'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Şifre:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="role">Rol:</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="user" <?php echo set_select('role', 'user'); ?>>Kullanıcı</option>
                                    <option value="admin" <?php echo set_select('role', 'admin'); ?>>Admin</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Kaydol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS ve bağımlılıkları -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>