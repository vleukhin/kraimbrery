<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{block 'bltitle'}{/block} - панель управления</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    {ignore}<style type="text/css">body {min-height: 75rem;padding-top: 4.5rem;}</style>{/ignore}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.2.1/vue-resource.js"></script>
    <script
            src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
    <a class="navbar-brand" href="/moderka/">Мари Краймбрери</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item{block 'afi'}{/block}">
                <a class="nav-link" href="/moderka/events">Афиша</a>
            </li>
            <li class="nav-item {block 'albums'}{/block}">
                <a class="nav-link" href="/moderka/albums">Альбомы</a>
            </li>
            <li class="nav-item{block 'news'}{/block}">
                <a class="nav-link" href="/moderka/news">Новости</a>
            </li>
            <li class="nav-item{block 'slider'}{/block}">
                <a class="nav-link" href="/moderka/img/slider">Слайдер</a>
            </li>
            <li class="nav-item{block 'photo'}{/block}">
                <a class="nav-link" href="/moderka/img/photo">Фото</a>
            </li>
            <li class="nav-item{block 'active'}{/block}">
                <a class="nav-link" href="/moderka">Настройки</a>
            </li>
        </ul>
    </div>
    </div>
</nav>
<main role="main" class="container">
    {block 'content'}{/block}
</main>
</body>
</html>