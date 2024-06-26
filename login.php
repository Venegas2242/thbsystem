<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/login-style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <img src="/images/logo.png" alt="TEHIBA">
            </div>
        </div>
        <div class="login-right">
            <h3>Login</h3>
            <form action="check-login.php" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="Contraseña">
                    <i class="fas fa-lock"></i>
                </div>
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
