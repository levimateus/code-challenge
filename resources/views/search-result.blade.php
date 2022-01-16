<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Code Challenge</title>
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: sans-serif;
            height: 100vh;
            margin: 50px;
        }

        .result {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="result">
                Your Search Term Was: <b>{{$searchTerm}}</b>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-muted">Tracks</h6>
                <div class="list-group col-12">
                        @foreach ($results['tracks']['items'] as $track)
                        <a class="list-group-item d-flex justify-content-between align-items-center" href="/track/{{ $track['id'] }}">
                            {{ $track['name'] }}
                            <div class="image-parent">
                                <img src="{{ $track['album']['images']['0']['url'] ?? 'https://media.tarkett-image.com/large/TH_25094225_25187225_001.jpg' }}" class="img-thumbnail rounded" alt="{{ $track['name'] }}" width="150px">
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-muted">Artists</h6>
                <div class="list-group col-12">
                        @foreach ($results['artists']['items'] as $artist)
                        <a class="list-group-item d-flex justify-content-between align-items-center" href="/artist/{{ $artist['id'] }}">
                            {{ $artist['name'] }}
                            <div class="image-parent">
                                <img src="{{ $artist['images'][0]['url'] ?? '' }}" class="img-thumbnail rounded" alt="{{ $artist['name'] }}" width="150px">
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="text-muted">Albums</h6>
                <div class="list-group col-12">
                        @foreach ($results['albums']['items'] as $album)
                        <a class="list-group-item d-flex justify-content-between align-items-center" href="/album/{{ $album['id'] }}">
                            {{ $album['name'] }}
                            <div class="image-parent">
                                <img src="{{ $album['images'][0]['url'] ?? '' }}" class="img-thumbnail rounded" alt="{{ $album['name'] }}" width="150px">
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
