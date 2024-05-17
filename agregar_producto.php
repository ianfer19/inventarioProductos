<?php

require 'conexion_dynamodb.php'; // Incluye el archivo de conexión a DynamoDB

// Verifica si se ha enviado el formulario de agregar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se han proporcionado los datos necesarios
    if (isset($_POST["id"]) && isset($_POST["descripcion"]) && isset($_POST["precio"]) && isset($_POST["cantidad"])) {
        $id = $_POST["id"];
        $descripcion = $_POST["descripcion"];
        $precio = $_POST["precio"];
        $cantidad = $_POST["cantidad"];

        // Parámetros para agregar un nuevo producto a DynamoDB
        $params = [
            'TableName' => 'InventarioProductos', // Reemplaza 'NombreDeTuTabla' con el nombre de tu tabla en DynamoDB
            'Item' => [
                'id' => ['S' => $id], // Agrega el atributo 'id' con su valor
                'descripcion' => ['S' => $descripcion],
                'precio' => ['N' => $precio],
                'cantidad' => ['N' => $cantidad],
            ],
        ];

        try {
            // Agrega el nuevo producto a DynamoDB
            $result = $client->putItem($params);
            echo "Producto agregado con éxito en DynamoDB";
        } catch (Exception $e) {
            // Maneja cualquier error que ocurra durante la inserción
            echo "Error al agregar el producto en DynamoDB: " . $e->getMessage();
        }
    } else {
        echo "Error: Debes proporcionar todos los datos del producto";
    }
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
</head>
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
    <h1>Agregar Producto</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id">ID del Producto:</label>
        <input type="text" id="id" name="id" required><br><br>
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required><br><br>
        <label for="precio">Precio:</label>
        <input type="text" id="precio" name="precio" required><br><br>
        <label for="cantidad">Cantidad:</label>
        <input type="text" id="cantidad" name="cantidad" required><br><br>
        <button type="submit">Agregar Producto</button>
    </form>
</body>
</html>
