<?php

require 'conexion_dynamodb.php'; // Incluye el archivo de conexión a DynamoDB

// Verifica si se ha enviado el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han proporcionado los datos necesarios
    if (isset($_POST["id"]) && isset($_POST["nuevo_precio"]) && isset($_POST["descripcion"]) && isset($_POST["nueva_cantidad"])) {
        $id = $_POST["id"];
        $nuevo_precio = $_POST["nuevo_precio"];
        $nueva_descripcion = $_POST["descripcion"];
        $nueva_cantidad = $_POST["nueva_cantidad"];

        // Parámetros para actualizar el producto en DynamoDB
        $params = [
            'TableName' => 'InventarioProductos', // Reemplaza 'NombreDeTuTabla' con el nombre de tu tabla en DynamoDB
            'Key' => [
                'id' => ['S' => $id], // Suponiendo que el ID del producto es la clave primaria
            ],
            'UpdateExpression' => 'SET precio = :precio, descripcion = :descripcion, cantidad = :cantidad', // Actualiza los campos de precio, descripción y cantidad
            'ExpressionAttributeValues' => [
                ':precio' => ['N' => $nuevo_precio], // Especifica el nuevo precio del producto
                ':descripcion' => ['S' => $nueva_descripcion], // Especifica la nueva descripción del producto
                ':cantidad' => ['N' => $nueva_cantidad], // Especifica la nueva cantidad del producto
            ],
            'ReturnValues' => 'ALL_NEW', // Opcional: especifica qué valores devolver después de la actualización
        ];

        try {
            // Realiza la actualización en DynamoDB
            $result = $client->updateItem($params);
            echo "Producto actualizado con éxito en DynamoDB";
        } catch (Exception $e) {
            // Maneja cualquier error que ocurra durante la actualización
            echo "Error al actualizar el producto en DynamoDB: " . $e->getMessage();
        }
    } else {
        echo "Error: Debes proporcionar todos los datos necesarios para actualizar el producto";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <style>
        /* Estilos del navbar */
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
    <h1>Actualizar Producto</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id">ID del Producto:</label>
        <input type="text" id="id" name="id" required><br><br>
        <label for="descripcion">Nueva Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required><br><br>
        <label for="nuevo_precio">Nuevo Precio:</label>
        <input type="text" id="nuevo_precio" name="nuevo_precio" required><br><br>
        <label for="nueva_cantidad">Nueva Cantidad:</label>
        <input type="text" id="nueva_cantidad" name="nueva_cantidad" required><br><br>
        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
