<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Code Challenge</title>
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: sans-serif;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .img {
            width: 15vw;
            margin-right: 100px
        }

        .search {
            margin-left: 100px;
        }

    </style>
</head>

<body>
    <div class="flex-center full-height">
        <div>
            <img src="{{ $track['album']['images']['0']['url'] ?? 'https://media.tarkett-image.com/large/TH_25094225_25187225_001.jpg' }}" class="img-thumbnail rounded" width="300px">
            <label class="text"></label>
            <h1>Track: <i>{{ $track['name'] }}</i></h1>
            <h5>Album: <i>{{ $track['album']['name'] }}</i></h5>
            <h5>Artists: {{ implode(', ', array_column($track['artists'], 'name')) }}</h5>
            @if (!empty($track['external_urls']['spotify']))
                <a class="btn btn-success" href="{{ $track['external_urls']['spotify'] }}">Listen on Spotify</a>
            @endif
        </div>

    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>
