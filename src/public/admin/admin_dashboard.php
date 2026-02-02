<?php
    require "./../../../database/config/database.php";
    require "./../../functions/funciones.php";

    // Verificar que sea admin
    requiereAdmin();

    // Obtener estadísticas
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $totalUsuarios = $stmt->fetch()['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'");
    $totalClientes = $stmt->fetch()['total'];

    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'admin'");
    $totalAdmins = $stmt->fetch()['total'];

    // Últimos usuarios registrados
    $stmt = $pdo->query("SELECT id, nombre, usuario, rol FROM usuarios ORDER BY id ASC");
    $ultimosUsuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gamely</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/admin/admin.css">

    <!-- FONTS -->
        <!-- ROBOTO -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- POPPINS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 class="title__admin">Panel de Administración</h1>
            <section class="header-info">
                <span class="welcome-message">
                    Bienvenido, <?php echo limpiar($_SESSION['nombre']); ?>
                </span>
                <a href="../logout.php" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                </a>
                <a class="back-link" href="../client/catalogo.php"><i class="fa-solid fa-arrow-left"></i> Ver catálogo</a>
            </section>
        </header>

        <!-- Estadísticas -->
        <section class="stats-grid">
            <article class="stat-card">
                <h3><i class="fa-solid fa-users"></i> TOTAL USUARIOS</h3>
                <div class="stat-number"><?php echo $totalUsuarios; ?></div>
            </article>

            <article class="stat-card">
                <h3><i class="fa-solid fa-user"></i> CLIENTES</h3>
                <div class="stat-number"><?php echo $totalClientes; ?></div>
            </article>

            <article class="stat-card">
                <h3><i class="fa-solid fa-shield-alt"></i> ADMINISTRADORES</h3>
                <div class="stat-number"><?php echo $totalAdmins; ?></div>
            </article>
        </section>

        <!-- Menú de gestión -->
        <section class="menu-grid">
            <a href="usuarios.php" class="menu-card">
                <i class="fa-solid fa-users-gear"></i>
                <h3>Gestionar Usuarios</h3>
            </a>

            <a href="#" class="menu-card">
                <i class="fa-solid fa-gamepad"></i>
                <h3>Gestionar Juegos</h3>
            </a>

            <a href="#" class="menu-card">
                <i class="fa-solid fa-box"></i>
                <h3>Ver Pedidos</h3>
            </a>

            <a href="#" class="menu-card">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Reportes</h3>
            </a>
        </section>

        <!-- Últimos usuarios -->
        <section class="table-container">
            <h2 class="title__container"><i class="fa-solid fa-clock-rotate-left"></i> Últimos Registros</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimosUsuarios as $u): ?>
                        <tr>
                            <td><?php echo limpiar($u['id']); ?></td>
                            <td><?php echo limpiar($u['nombre']); ?></td>
                            <td><?php echo limpiar($u['usuario']); ?></td>
                            <td>
                                <span class="badge badge-<?php echo $u['rol']; ?>">
                                    <?php echo limpiar($u['rol']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>