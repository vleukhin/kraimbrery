{extends 'layout.tpl'}
{block 'photo'} active{/block}
{block 'bltitle'}Фото{/block}
{block 'content'}
    <h1>Фото</h1>
    <hr>
    {if !empty($msg_error)}
        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">×</a>{$msg_error}
        </div>
    {/if}
    {if !empty($msg_success)}
        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">×</a>{$msg_success}
        </div>
    {/if}
    <form action="/moderka/img/photo/add" method="post" enctype="multipart/form-data">
        <div class="form-group row">
            <div class="col-12">
                <label for="photo" class="custom-file">
                    Выберите изображение
                    <input type="file" class="form-control" multiple="multiple"  name="photo[]" id="photo" accept=".png,.jpg,.jpeg">
                </label>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </form>
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Фото</th>
            <th scope="col" class="text-right">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        {foreach $list as $key => $row}
            <tr>
                <th scope="row">{$key+1}</th>
                <td><img src="/uploads/photo/{$row['image']}" alt="" height="200px"><br>
                    <div>Ссылка:</div>
                    <form action="/moderka/img/photo/save" method="POST">
                        <input name="link" type="text" class="form-control pull-left" style="max-width: 60%" value="{$row['link']}">
                        <input type="hidden" name="image" value="{$row['image']}">
                        <button class="btn btn-primary pull-left"><i class="fa-fa-save"></i> сохранить</button>
                    </form>
                </td>
                <td class="text-right">
                    <a href="/moderka/img/photo/del/{$row['image']}" title="Удалить"><i class="fa fa-times" aria-hidden="true" style="color: #e60000"></i></a>
                </td>
            </tr>
            {foreachelse}
        {/foreach}
        </tbody>
    </table>
{/block}