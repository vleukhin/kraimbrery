<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Мари Краймбрери</title>
    <link rel="stylesheet" href="/templates/css/main.css">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16"/>
</head>
<body>
<div class="gradient">
    <div class="neon-line t1"><span>Мари Краймбрери:<br>всё о ней</span></div>
    <nav>
        <img class="burger" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAA2klEQVR4Xu2ZsQ2AQAwD+ZYxWIv5WIsxaGEDXKSyfbTRS7FzSRSxtvJvlevfMAACyh2gBcoBYAjSArRAuQO0QDkAbAHZAs99vs6U7Mf1qxEDVHUhoL0FFCHucTkD3AWq/DFAOZQeh4D0Cit9EKAcSo9DQHqFlT4IUA6lxyUBXIPt1yAEtBNQPwQxINwBuQbD9fNjBALSEVf6IEA5lB6HgPQKK30QoBziGmy/BiGgnQA1I9zjbAH3Ck7zh4Cpg+7vIcC9gtP8IWDqoPt7CHCv4DR/CJg66P6+noAPAdcwQYCZJXoAAAAASUVORK5CYII=">
        <ul class="menu">
            <li><a href="#who">Кто она</a></li>
            <li><a href="#look">Посмотри на неё</a></li>
            <li><a href="#weapons">Её главное оружие</a></li>
            <li><a href="#events">Туси с ней</a></li>
            <li><a href="#contacts">Свяжись с ней</a></li>
        </ul>

    </nav>
    <img src="/templates/img/main.png" class="header-img" alt="">
</div>
<div class="yellow-block">
    {if $mari_soc.vk?}<a href="{$mari_soc.vk}" target="_blank" class="fa fa-vk" aria-hidden="true"></a>{/if}
    {if $mari_soc.instagram?}
    <a href="{$mari_soc.instagram}" target="_blank" class="fa fa-instagram" aria-hidden="true"></a>{/if}
    {if $mari_soc.facebook?}
    <a href="{$mari_soc.facebook}" target="_blank" class="fa fa-facebook" aria-hidden="true"></a>{/if}
</div>
<div class="gradient">
    <div class="neon-line" id="who">Кто она</div>
    <div class="text-info color-yellow">
        {if $who_is_she_img}
            <div><img src="{$who_is_she_img}" alt=""></div>{/if}
        {if $who_is_she_head}
            <div class="strong">{$who_is_she_head}</div>{/if}
        {if $who_is_she_intro}
            <div class="intro-text">{$who_is_she_intro}</div>{/if}
        {if $who_is_she_full}
            <div class="full-text">{$who_is_she_full}</div>{/if}
        <div class="btn btn-text">Читать далее</div>
    </div>
    <div class="neon-line" id="look">Посмотри на неё</div>
    <div class="carousel-box">
        <div class="btn btn-photo color-yellow">Фотогалерея</div>
        <div class="slider-02 owl-carousel owl-theme">
            {foreach $slider as $key => $row}
                {if !empty($slides[$row]) }
                    <a href="{$slides[$row]}" target="_blank">
                        <img src="/uploads/slider/{$row}" alt="" class="owl-responsive">
                    </a>
                {else}
                    <img src="/uploads/slider/{$row}" alt="" class="owl-responsive">
                {/if}
            {/foreach}
        </div>
        <div class="youtube-video">
            {$video}
        </div>
        <a href="{$video_all}" target="_blank" class="btn btn-video color-yellow">Смотреть все</a>
    </div>
    <div class="neon-line" id="weapons">Её главное оружие</div>
    <div class="audio-box">
        <div class="weapon">
            <div class="playlist">
                <div class="plyr">
                    <audio controls>
                        <source src="{$audio}" type="audio/mp3">
                    </audio>
                </div>
                {*<ul class='playlist--list'>
                    <li data-id="0" data-audio="uploads/audio/01.mp3">Не в адеквате</li>
                    <li data-id="1" data-audio="uploads/audio/02.mp3">Она тебе не идет</li>
                    <li data-id="2" data-audio="uploads/audio/03.mp3">Туси сам</li>
                </ul>*}
            </div>
            <a href="{$audio_all}" target="_blank" class="btn btn-video color-yellow">Слушать все</a>

            <div style="display: none;">
                <svg xmlns="http://www.w3.org/2000/svg">
                    <symbol id="plyr-captions-off" viewBox="0 0 18 18">
                        <path d="M1 1c-.6 0-1 .4-1 1v11c0 .6.4 1 1 1h4.6l2.7 2.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3l2.7-2.7H17c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1H1zm4.52 10.15c1.99 0 3.01-1.32 3.28-2.41l-1.29-.39c-.19.66-.78 1.45-1.99 1.45-1.14 0-2.2-.83-2.2-2.34 0-1.61 1.12-2.37 2.18-2.37 1.23 0 1.78.75 1.95 1.43l1.3-.41C8.47 4.96 7.46 3.76 5.5 3.76c-1.9 0-3.61 1.44-3.61 3.7 0 2.26 1.65 3.69 3.63 3.69zm7.57 0c1.99 0 3.01-1.32 3.28-2.41l-1.29-.39c-.19.66-.78 1.45-1.99 1.45-1.14 0-2.2-.83-2.2-2.34 0-1.61 1.12-2.37 2.18-2.37 1.23 0 1.78.75 1.95 1.43l1.3-.41c-.28-1.15-1.29-2.35-3.25-2.35-1.9 0-3.61 1.44-3.61 3.7 0 2.26 1.65 3.69 3.63 3.69z" fill-rule="evenodd" fill-opacity=".5"/>
                    </symbol>
                    <symbol id="plyr-captions-on" viewBox="0 0 18 18">
                        <path d="M1 1c-.6 0-1 .4-1 1v11c0 .6.4 1 1 1h4.6l2.7 2.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3l2.7-2.7H17c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1H1zm4.52 10.15c1.99 0 3.01-1.32 3.28-2.41l-1.29-.39c-.19.66-.78 1.45-1.99 1.45-1.14 0-2.2-.83-2.2-2.34 0-1.61 1.12-2.37 2.18-2.37 1.23 0 1.78.75 1.95 1.43l1.3-.41C8.47 4.96 7.46 3.76 5.5 3.76c-1.9 0-3.61 1.44-3.61 3.7 0 2.26 1.65 3.69 3.63 3.69zm7.57 0c1.99 0 3.01-1.32 3.28-2.41l-1.29-.39c-.19.66-.78 1.45-1.99 1.45-1.14 0-2.2-.83-2.2-2.34 0-1.61 1.12-2.37 2.18-2.37 1.23 0 1.78.75 1.95 1.43l1.3-.41c-.28-1.15-1.29-2.35-3.25-2.35-1.9 0-3.61 1.44-3.61 3.7 0 2.26 1.65 3.69 3.63 3.69z" fill-rule="evenodd"/>
                    </symbol>
                    <symbol id="plyr-enter-fullscreen" viewBox="0 0 18 18">
                        <path d="M10 3h3.6l-4 4L11 8.4l4-4V8h2V1h-7zM7 9.6l-4 4V10H1v7h7v-2H4.4l4-4z"/>
                    </symbol>
                    <symbol id="plyr-exit-fullscreen" viewBox="0 0 18 18">
                        <path d="M1 12h3.6l-4 4L2 17.4l4-4V17h2v-7H1zM16 .6l-4 4V1h-2v7h7V6h-3.6l4-4z"/>
                    </symbol>
                    <symbol id="plyr-fast-forward" viewBox="0 0 18 18">
                        <path d="M7.875 7.171L0 1v16l7.875-6.171V17L18 9 7.875 1z"/>
                    </symbol>
                    <symbol id="plyr-muted" viewBox="0 0 18 18">
                        <path d="M12.4 12.5l2.1-2.1 2.1 2.1 1.4-1.4L15.9 9 18 6.9l-1.4-1.4-2.1 2.1-2.1-2.1L11 6.9 13.1 9 11 11.1zM3.786 6.008H.714C.286 6.008 0 6.31 0 6.76v4.512c0 .452.286.752.714.752h3.072l4.071 3.858c.5.3 1.143 0 1.143-.602V2.752c0-.601-.643-.977-1.143-.601L3.786 6.008z"/>
                    </symbol>
                    <symbol id="plyr-pause" viewBox="0 0 18 18">
                        <path d="M6 1H3c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h3c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1zM12 1c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h3c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1h-3z"/>
                    </symbol>
                    <symbol id="plyr-play" viewBox="0 0 18 18">
                        <path d="M15.562 8.1L3.87.225C3.052-.337 2 .225 2 1.125v15.75c0 .9 1.052 1.462 1.87.9L15.563 9.9c.584-.45.584-1.35 0-1.8z"/>
                    </symbol>
                    <symbol id="plyr-restart" viewBox="0 0 18 18">
                        <path d="M9.7 1.2l.7 6.4 2.1-2.1c1.9 1.9 1.9 5.1 0 7-.9 1-2.2 1.5-3.5 1.5-1.3 0-2.6-.5-3.5-1.5-1.9-1.9-1.9-5.1 0-7 .6-.6 1.4-1.1 2.3-1.3l-.6-1.9C6 2.6 4.9 3.2 4 4.1 1.3 6.8 1.3 11.2 4 14c1.3 1.3 3.1 2 4.9 2 1.9 0 3.6-.7 4.9-2 2.7-2.7 2.7-7.1 0-9.9L16 1.9l-6.3-.7z"/>
                    </symbol>
                    <symbol id="plyr-rewind" viewBox="0 0 18 18">
                        <path d="M10.125 1L0 9l10.125 8v-6.171L18 17V1l-7.875 6.171z"/>
                    </symbol>
                    <symbol id="plyr-volume" viewBox="0 0 18 18">
                        <path d="M15.6 3.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4C15.4 5.9 16 7.4 16 9c0 1.6-.6 3.1-1.8 4.3-.4.4-.4 1 0 1.4.2.2.5.3.7.3.3 0 .5-.1.7-.3C17.1 13.2 18 11.2 18 9s-.9-4.2-2.4-5.7z"/>
                        <path d="M11.282 5.282a.909.909 0 0 0 0 1.316c.735.735.995 1.458.995 2.402 0 .936-.425 1.917-.995 2.487a.909.909 0 0 0 0 1.316c.145.145.636.262 1.018.156a.725.725 0 0 0 .298-.156C13.773 11.733 14.13 10.16 14.13 9c0-.17-.002-.34-.011-.51-.053-.992-.319-2.005-1.522-3.208a.909.909 0 0 0-1.316 0zM3.786 6.008H.714C.286 6.008 0 6.31 0 6.76v4.512c0 .452.286.752.714.752h3.072l4.071 3.858c.5.3 1.143 0 1.143-.602V2.752c0-.601-.643-.977-1.143-.601L3.786 6.008z"/>
                    </symbol>
                </svg>
            </div>
        </div>
    </div>
    {if $afi?}
    <div class="neon-line" id="events">Туси с ней</div>
    <div class="ticket">
        <div class="yellow-link">
            <div class="table">
                <div class="date">Дата</div>
                <div class="city">Город</div>
                <div class="link"></div>
            </div>
        </div>
        {foreach $afi as $key => $row}
            <div class="table color-yellow">
                <div class="date">{$row.date|date_format:"%d.%m"}</div>
                <div class="city">{$row.city}</div>
                <div class="link"><a href="{$row.link}" target="_blank" class="btn">Купить билет</a></div>
            </div>
        {/foreach}
    </div>
    {/if}
    <div class="neon-line" id="contacts">Свяжись с ней</div>
    <div class="contacts-box">
        <div class="btn-line">
            <div class="contacts">
                <div class="strong">Организация концертов</div>
                {if $organization.name?}
                    <div>{$organization.name}</div>{/if}
            </div>
            {if $organization.phone?}
                <div><a href="tel:{$organization.phone}">{$organization.phone}</a></div>{/if}
        </div>
    </div>
    <div class="contacts-box">
        <div class="btn-line">
            <div class="contacts">
                <div class="strong">Менеджер артиста</div>
                {if $manager.name?}
                    <div>{$manager.name}</div>{/if}
            </div>
            {if $manager.phone?}
                <div><a href="tel:{$manager.phone}">{$manager.phone}</a></div>{/if}
            {if $manager.email?}
                <div><a href="mailto:{$manager.email}">{$manager.email}</a></div>{/if}
        </div>
    </div>
    <div class="contacts-box">
        <a href="{if $velvet_site?}{$velvet_site}{/if}" target="_blank" class="velvet-logo"><img src="/templates/img/velvetmusic-logo.png" alt="velvetmusic"></a>
        {if $velvet_address?}
            <address>{$velvet_address}</address>{/if}
        {if $velvet_phone?}
            <div><a href="tel:{$velvet_phone}" target="_blank">{$velvet_phone}</a></div>{/if}
        {if $velvet_email?}
            <div><a href="mailto:{$velvet_email}" target="_blank">{$velvet_email}</a></div>{/if}
        {if $velvet_site?}
            <div><a href="http://{$velvet_site}" target="_blank">{$velvet_site}</a></div>{/if}
    </div>
    <div class="velvet-soc">
        {if $velvet_soc.vk?}<a href="{$velvet_soc.vk}" target="_blank" class="fa fa-vk" aria-hidden="true"></a>{/if}
        {if $velvet_soc.instagram?}
        <a href="{$velvet_soc.instagram}" target="_blank" class="fa fa-instagram" aria-hidden="true"></a>{/if}
        {if $velvet_soc.youtube?}
        <a href="{$velvet_soc.youtube}" target="_blank" class="fa fa-youtube-play" aria-hidden="true"></a>{/if}
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/templates/vendor/jquery-3.2.1.min.js"><\/script>')</script>
<script src="/templates/js/main.js"></script>
</body>
</html>