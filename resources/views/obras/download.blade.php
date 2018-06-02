<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $obra->titulo }}</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        #title {
            width: 80%;
            margin: 30% auto;
            height: 40%;
        }

        .row {
            width: 90%;
            margin: 0 auto;
        }

        p{
            word-wrap: break-word;
            -webkit-hyphens: auto;
            -moz-hyphens: auto;
            -ms-hyphens: auto;
            hyphens: auto;
        }

    </style>
</head>
<body>

    <div id="title">
        <h1 style="font-size: 40px;">
            {{ $obra->titulo }}
        </h1>
        <p>Autor: {{ $obra->autor->name }}</p>
    </div>

    <div class="page-break"></div>

    @foreach($capitulos as $capitulo)

        <div class="row">
            <h2 style="margin-bottom: 30px; text-align: center;">{{ $capitulo->titulo }}</h2>

            <p>{!! html_entity_decode($capitulo->texto) !!}</p>
        </div>

        <div class="page-break"></div>

    @endforeach

</body>
</html>