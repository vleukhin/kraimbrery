{extends 'layout.tpl'}
{block 'active'} active{/block}
{block 'bltitle'}Настройки{/block}
{block 'content'}
    <h1>Настройки сайта</h1>
    <hr>
    {if !empty($msg_error)}
        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">×</a>{$msg_error}
        </div>
    {/if}
    {if !empty($msg_success)}
        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">×</a>{$msg_success}
        </div>
    {/if}
    <form action="/moderka" method="post" enctype="multipart/form-data">
        <h3>Кто она</h3>
        <div class="form-group row">
            <div class="col-12">
                {if $c.who_is_she_img?}<img src="{$c.who_is_she_img ?: ''}" alt="" width="100px">{/if}
                <label for="who_is_she_img" class="custom-file">
                    Изображение размером 300x300px
                    <input type="file" class="form-control" name="who_is_she_img" id="who_is_she_img" accept=".png,.jpg,.jpeg">
                </label>
            </div>
        </div>
        <div class="form-group">
            <label for="text1">Заголовок</label>
            <textarea class="form-control" id="text1" name="c[who_is_she_head]" rows="3">{$c.who_is_she_head ?: ''}</textarea>
        </div>
        <div class="form-group">
            <label for="text2">Вступление</label>
            <textarea class="form-control" id="text2" name="c[who_is_she_intro]" rows="3">{$c.who_is_she_intro ?: ''}</textarea>
        </div>
        <div class="form-group">
            <label for="text3">Скрытый текст</label>
            <textarea class="form-control" id="text3" name="c[who_is_she_full]" rows="3">{$c.who_is_she_full ?: ''}</textarea>
        </div>
        <h3>Социальные сети Мари</h3>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="mari_vk">Вконтакте</label>
                <input type="text" class="form-control" name="c[mari_vk]" value="{$c.mari_vk ?: ''}" id="mari_vk" required>
            </div>
            <div class="col-md-4">
                <label for="mari_instagram">Instagram</label>
                <input type="text" class="form-control" name="c[mari_instagram]" value="{$c.mari_instagram ?: ''}" id="mari_instagram" required>
            </div>
            <div class="col-md-4">
                <label for="mari_facebook">Facebook</label>
                <input type="text" class="form-control" name="c[mari_facebook]" value="{$c.mari_facebook ?: ''}" id="mari_facebook" required>
            </div>
        </div>
        <h3>Аудио</h3>
        <div class="form-group row">
            <div class="col-4">
                <div>
                    <audio controls>
                        <source src="{$c.audio}" type="audio/mp3">
                    </audio>
                </div>
                <label for="audio" class="custom-file">
                    mp3 файл
                    <input type="file" class="form-control" name="audio" id="audio" accept=".mp3">
                </label>
                <br><br>
                <label for="audio_name">Название</label>
                <input type="text" name="c[audio_name]" class="form-control" value="{$c.audio_name}">
            </div>
            <div class="col-4">
                <div>
                    <audio controls>
                        <source src="{$c.audio2}" type="audio/mp3">
                    </audio>
                </div>
                <label for="audio" class="custom-file">
                    mp3 файл
                    <input type="file" class="form-control" name="audio2" id="audio" accept=".mp3">
                </label>
                <br><br>
                <label for="audio_name">Название</label>
                <input type="text" name="c[audio2_name]" class="form-control" value="{$c.audio2_name}">
            </div>
            <div class="col-4">
                <div>
                    <audio controls>
                        <source src="{$c.audio3}" type="audio/mp3">
                    </audio>
                </div>
                <label for="audio" class="custom-file">
                    mp3 файл
                    <input type="file" class="form-control" name="audio3" id="audio" accept=".mp3">
                </label>
                <br><br>
                <label for="audio_name">Название</label>
                <input type="text" name="c[audio3_name]" class="form-control" value="{$c.audio3_name}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="audio_all">Ссылка на все треки</label>
                <input type="text" class="form-control" name="c[audio_all]" value="{$c.audio_all ?: ''}" id="audio_all" required>
            </div>
        </div>
        <h3>Видео</h3>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="video">Видео</label>
                <input type="text" class="form-control" name="c[video]" value="{$c.video ?: ''}" id="video" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="video_cover">Обложка видео</label><br>
                {if !empty($c.video_cover) }
                    <div class="video-cover">
                        <img src="/{$c.video_cover}" alt="" style="max-width: 400px ">
                        <button class="btn btn-danger" style="cursor:pointer;" type="button" data-js="remove-video-cover">
                            <i class="fa fa-trash"></i> Удалить
                        </button>
                        <br><br>
                    </div>
                {/if}
                <input type="file" class="form-control" name="video_cover" id="video_cover" accept=".png,.jpg,.jpeg">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="video_all">Ссылка на все видео</label>
                <input type="text" class="form-control" name="c[video_all]" value="{$c.video_all ?: ''}" id="video_all" required>
            </div>
        </div>
        <h3>Организация концертов</h3>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="organization_name">Имя</label>
                <input type="text" class="form-control" name="c[organization_name]" value="{$c.organization_name ?: ''}" id="organization_name" required>
            </div>
            <div class="col-md-4">
                <label for="validationCustom04">Телефон</label>
                <input type="text" class="form-control" name="c[organization_phone]" value="{$c.organization_phone ?: ''}" id="organization_phone" required>
            </div>
            <div class="col-md-4">
                <label for="manager_email">E-mail</label>
                <input type="text" class="form-control" name="c[organization_email]" value="{$c.organization_email ?: ''}" id="organization_email" required>
            </div>
        </div>
        <h3>Менеджер артиста</h3>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="manager_name">Имя</label>
                <input type="text" class="form-control" name="c[manager_name]" value="{$c.manager_name ?: ''}" id="manager_name" required>
            </div>
            <div class="col-md-4">
                <label for="manager_phone">Телефон</label>
                <input type="text" class="form-control" name="c[manager_phone]" value="{$c.manager_phone ?: ''}" id="manager_phone" required>
            </div>
            <div class="col-md-4">
                <label for="manager_email">E-mail</label>
                <input type="text" class="form-control" name="c[manager_email]" value="{$c.manager_email ?: ''}" id="manager_email" required>
            </div>
        </div>
        <h3>Velvet</h3>
        <div class="form-group row">
            <div class="col-md-12">
                <label for="velvet_address">Адрес</label>
                <input type="text" class="form-control" name="c[velvet_address]" value="{$c.velvet_address ?: ''}" id="velvet_address" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="velvet_phone">Телефон</label>
                <input type="text" class="form-control" name="c[velvet_phone]" value="{$c.velvet_phone ?: ''}" id="velvet_phone" required>
            </div>
            <div class="col-md-4">
                <label for="velvet_email">E-mail</label>
                <input type="text" class="form-control" name="c[velvet_email]" value="{$c.velvet_email ?: ''}" id="velvet_email" required>
            </div>
            <div class="col-md-4">
                <label for="velvet_site">Сайт</label>
                <input type="text" class="form-control" name="c[velvet_site]" value="{$c.velvet_site ?: ''}" id="velvet_site" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-4">
                <label for="velvet_vk">Вконтакте</label>
                <input type="text" class="form-control" name="c[velvet_vk]" value="{$c.velvet_vk ?: ''}" id="velvet_vk" required>
            </div>
            <div class="col-md-4">
                <label for="velvet_instagram">Instagram</label>
                <input type="text" class="form-control" name="c[velvet_instagram]" value="{$c.velvet_instagram ?: ''}" id="velvet_instagram" required>
            </div>
            <div class="col-md-4">
                <label for="velvet_youtube">YouTube</label>
                <input type="text" class="form-control" name="c[velvet_youtube]" value="{$c.velvet_youtube ?: ''}" id="velvet_youtube" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </form>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('[data-js=remove-video-cover]').click(function () {
                    $.post('/moderka/settings/remove-video-cover').then(function () {
                        $('.video-cover').remove();
                    }.bind($(this)))
                })
            });
        })(window.jQuery);
    </script>
{/block}