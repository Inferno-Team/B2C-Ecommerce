<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>B2C E-commerce</title>
</head>

<body style=" overflow: hidden;">
    <div id="application" style="margin:0;padding:0;font-family: 'Lato';">
    <app></app>
    </div>
    <script src="{{ mix('js/app.js') }}"> </script>
</body>

</html>