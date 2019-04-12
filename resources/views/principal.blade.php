<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Colección de notas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
</head>

<body class="app">
    <div id="app">


    <div class="app-body">
        
        <template>
            <categoria></categoria>
        </template>
    </div>   
    </div>
    <footer class="app-footer">
        <span class="ml-auto">Desarrollado por <a href="https://github.com/RwaGr">Roger Gutierrez</a></span>
    </footer>
    

    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>