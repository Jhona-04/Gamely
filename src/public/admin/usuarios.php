<?php
    require "./../../../database/config/database.php";
    require "./../../functions/funciones.php";

    //Verificar que sea admin
    requiereAdmin();

    $mensaje = '';
    $error = '';

    // CREAR USUARIO
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
        $nombre = trim($_POST['nombre']);
        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];
        $rol = $_POST['rol'];

        if (empty($nombre) || empty($usuario) || empty($password) || empty($rol)) {
            $error = "Todos los campos son obligatorios";
        } elseif (strlen($password) < 6) {
            $error = "La contraseña debe tener al menos 6 caracteres";
        } else {
            $resultado = crearUsuario($pdo, $nombre, $usuario, $password, $rol);
            if ($resultado['success']) {
                $mensaje = $resultado['message'];
            } else {
                $error = $resultado['message'];
            }
        }
    }

    // EDITAR USUARIO
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
        $idEditar = (int)$_POST['id'];
        $nombre = trim($_POST['nombre']);
        $usuario = trim($_POST['usuario']);
        $rol = $_POST['rol'];

        if (empty($nombre) || empty($usuario) || empty($rol)) {
            $error = "Todos los campos son obligatorios para editar";
        } elseif ($idEditar <= 0) {
            $error = "ID de usuario inválido para editar";
        } else {
            $resultado = editarUsuario($pdo, $idEditar, $nombre, $usuario, $rol);
            if ($resultado['success']) {
                $mensaje = $resultado['message'];
            } else {
                $error = $resultado['message'];
            }
        }
    }

    // ELIMINAR USUARIO (usa GET con confirmación en JS)
    if (isset($_GET['eliminar'])) {
        $idEliminar = (int)$_GET['eliminar'];
        if ($idEliminar > 0) {
            $resultado = eliminarUsuario($pdo, $idEliminar);
            if ($resultado['success']) {
                $mensaje = $resultado['message'];
            } else {
                $error = $resultado['message'];
            }
        } else {
            $error = "ID de usuario inválido para eliminar";
        }
    }

    //Obtener todos los usuarios
    $usuarios = obtenerUsuarios($pdo);

    //Si se pide editar un usuario específico, cargar sus datos
    $editando = null;
    if (isset($_GET['editar'])) {
        $idCargar = (int)$_GET['editar'];
        if ($idCargar > 0) {
            foreach ($usuarios as $u) {
                if ((int)$u['id'] === $idCargar) {
                    //No permitir editar al usuario admin desde la interfaz
                    if ($u['usuario'] === 'admin') {
                        $error = "No se puede editar al usuario \"admin\" por defecto";
                    } else {
                        $editando = $u;
                    }
                    break;
                }
            }
            if (!$editando && empty($error)) {
                $error = "No se encontró el usuario para editar";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Usuarios - Gamely</title>

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
            <section>
                <a href="admin_dashboard.php" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
                </a>
                <h1 class="title__admin"><i class="fa-solid fa-wrench"></i> Gestión de Usuarios</h1>
            </section>
            <section>
                <span class="limpiar">Admin: <?php echo limpiar($_SESSION['nombre']); ?></span>
            </section>
        </header>

        <?php if ($mensaje): ?>
            <div class="mensaje success"><?php echo limpiar($mensaje); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="mensaje error"><?php echo limpiar($error); ?></div>
        <?php endif; ?>

        <!-- Formulario crear usuario -->
        <?php if (!$editando): ?>
        <section class="form-card">
            <h2 class="title__form"><i class="fa-solid fa-user-plus"></i> Crear Nuevo Usuario</h2>
            <form method="POST">
                <article class="form-grid">
                    <div class="form-group">
                        <label>Nombre completo:</label>
                        <input type="text" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label>Usuario:</label>
                        <input type="text" name="usuario" required>
                    </div>

                    <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>Rol:</label>
                        <select name="rol" required>
                            <option value="cliente">Cliente</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </article>

                <button type="submit" name="crear" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Crear Usuario
                </button>
            </form>
        </section>
        <?php endif; ?>

        <!-- Formulario editar usuario (solo aparece cuando se hace clic en editar una fila) -->
        <?php if ($editando): ?>
        <section class="form-card">
            <h2 class="title__form"><i class="fa-solid fa-pen-to-square"></i> Editar Usuario</h2>
            <form method="POST">
                <!-- ID oculto para identificar al usuario que se edita -->
                <input type="hidden" name="id" value="<?php echo limpiar($editando['id']); ?>">

                <article class="form-grid">
                    <div class="form-group">
                        <label>Nombre completo:</label>
                        <input type="text" name="nombre" value="<?php echo limpiar($editando['nombre']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Usuario:</label>
                        <input type="text" name="usuario" value="<?php echo limpiar($editando['usuario']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Rol:</label>
                        <select name="rol" required>
                            <option value="cliente" <?php echo $editando['rol'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                            <option value="admin" <?php echo $editando['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                </article>

                <div class="btn-group">
                    <button type="submit" name="editar" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Guardar Cambios
                    </button>
                    <!-- Botón para cancelar la edición y volver a la vista normal -->
                    <a href="usuarios.php" class="btn btn-secondary">
                        <i class="fa-solid fa-xmark"></i> Cancelar
                    </a>
                </div>
            </form>
        </section>
        <?php endif; ?>



        <!-- Tabla de usuarios -->
        <section class="table-container">
            <h2 class="title__container"><i class="fa-solid fa-users"></i> Lista de Usuarios</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="5">No hay usuarios registrados</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td><?php echo limpiar($u['id']); ?></td>
                                <td><?php echo limpiar($u['nombre']); ?></td>
                                <td><?php echo limpiar($u['usuario']); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $u['rol']; ?>">
                                        <?php echo limpiar($u['rol']); ?>
                                    </span>
                                </td>
                                <td class="acciones">
                                    <?php if ($u['usuario'] === 'admin'): ?>
                                        <!-- Usuario admin por defecto: solo mostrar etiqueta, sin botones -->
                                        <span class="badge badge-protegido">
                                            <i class="fa-solid fa-lock"></i> Protegido
                                        </span>
                                    <?php else: ?>
                                        <!-- Usuarios normales: mostrar botones editar y eliminar -->
                                        <a href="usuarios.php?editar=<?php echo (int)$u['id']; ?>" class="btn btn-edit">
                                            <i class="fa-solid fa-pen-to-square"></i> Editar
                                        </a>
                                        <a href="usuarios.php?eliminar=<?php echo (int)$u['id']; ?>" 
                                           class="btn btn-delete" 
                                           onclick="return confirmarEliminar('<?php echo limpiar($u['nombre']); ?>')">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
<script src="./../scripts/script.js"></script>
</html>