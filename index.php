
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Productos</title>
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
    <h1>Listar Productos</h1>
    <?php
    require 'conexion_dynamodb.php'; // Incluye el archivo de conexión a DynamoDB

    // Parámetros para listar todos los productos en DynamoDB
    $params = [
        'TableName' => 'InventarioProductos', // Reemplaza 'NombreDeTuTabla' con el nombre de tu tabla en DynamoDB
    ];

    try {
        // Lista todos los productos en DynamoDB
        $result = $client->scan($params);
        if (!empty($result['Items'])) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Descripción</th><th>Precio</th><th>Cantidad</th></tr>';
            foreach ($result['Items'] as $item) {
                echo '<tr>';
                echo '<td>' . $item['id']['S'] . '</td>';
                echo '<td>' . $item['descripcion']['S'] . '</td>';
                echo '<td>' . $item['precio']['N'] . '</td>';
                echo '<td>' . $item['cantidad']['N'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo "No se encontraron productos en DynamoDB";
        }
    } catch (Exception $e) {
        // Maneja cualquier error que ocurra durante la consulta
        echo "Error al listar los productos en DynamoDB: " . $e->getMessage();
    }
    ?>
</body>
</html>
