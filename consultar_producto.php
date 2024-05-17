<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Producto</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>

<nav>
    <h1 style="color: white; float: left;">Sistema de Gestión de Inventario</h1>
    <ul>
        <li><a href="agregar_producto.php">Agregar nuevo producto</a></li>
        <li><a href="consultar_producto.php">Consultar productos</a></li>
        <li><a href="actualizar_producto.php">Actualizar productos</a></li>
        <li><a href="index.php">Listar productos</a></li>
        <li><a href="eliminar_producto.php">Eliminar productos</a></li>
    </ul>
</nav>
    <h1>Consultar Producto</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id">ID del Producto:</label>
        <input type="text" id="id" name="id" required><br><br>
        <button type="submit">Consultar Producto</button>
    </form>

    <?php
    require 'conexion_dynamodb.php'; // Incluye el archivo de conexión a DynamoDB

    // Verifica si se ha enviado el formulario de consulta
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verifica si se ha proporcionado el ID del producto
        if (isset($_POST["id"])) {
            $id = $_POST["id"];

            // Parámetros para consultar un producto en DynamoDB
            $params = [
                'TableName' => 'InventarioProductos', // Reemplaza 'NombreDeTuTabla' con el nombre de tu tabla en DynamoDB
                'Key' => [
                    'id' => ['S' => $id], // Suponiendo que el ID del producto es la clave primaria
                ],
            ];

            try {
                // Consulta el producto en DynamoDB
                $result = $client->getItem($params);
                if (!empty($result['Item'])) {
                    echo "<h2>Producto encontrado en DynamoDB:</h2>";
                    echo '<table>';
                    echo '<tr><th>ID</th><th>Descripción</th><th>Precio</th><th>Cantidad</th></tr>';
                    echo '<tr>';
                    echo '<td>' . $result['Item']['id']['S'] . '</td>';
                    echo '<td>' . $result['Item']['descripcion']['S'] . '</td>';
                    echo '<td>' . $result['Item']['precio']['N'] . '</td>';
                    echo '<td>' . $result['Item']['cantidad']['N'] . '</td>';
                    echo '</tr>';
                    echo '</table>';
                } else {
                    echo "<h2>Producto no encontrado en DynamoDB</h2>";
                }
            } catch (Exception $e) {
                // Maneja cualquier error que ocurra durante la consulta
                echo "Error al consultar el producto en DynamoDB: " . $e->getMessage();
            }
        } else {
            echo "<h2>Error: Debes proporcionar el ID del producto</h2>";
        }
    }
    ?>
</body>
</html>
