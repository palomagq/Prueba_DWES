<?php

session_start();

unset($_SESSION['user_id']);
unset($_SESSION['role']);

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../db.php';
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar la base de datos
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if($user['role'] == "admin"){
            header("Location: index_admin.php"); // Cambia esto según la página de destino
        }else{
            header("Location: index_client.php"); // Cambia esto según la página de destino
        }
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center;">Iniciar Sesión</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="login.php">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Tu correo" required>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Tu contraseña" required>
                
                <input type="submit" value="Iniciar Sesión">
            </form>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
