<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your CRUD App</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        nav {
            background-color: #333;
            padding: 10px;
            color: white;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<nav>
    <a href="{{ route('categories.index') }}">Categories</a>
    <a href="{{ route('attributes.index') }}">Attributes</a>
    <a href="{{ route('products.index') }}">Products</a>
</nav>

<div>
    @yield('content')
</div>
</body>
</html>
