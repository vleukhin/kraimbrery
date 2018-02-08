{extends 'layout.tpl'}
{block 'afi'} active{/block}
{block 'bltitle'}Слайдер{/block}
{block 'content'}
    <h1>Афиша</h1>
    <hr>
    {if !empty($msg_error)}
        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">×</a>{$msg_error}
        </div>
    {/if}
    {if !empty($msg_success)}
        <div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">×</a>{$msg_success}
        </div>
    {/if}
    <form action="/moderka/afi/add/" method="post">
        <div class="form-group row">
            <div class="col-md-4">
                <label for="f_date">Дата</label>
                <input type="date" class="form-control" name="c[date]" value="" id="f_date" required>
            </div>
            <div class="col-md-4">
                <label for="f_city">Город</label>
                <input type="text" class="form-control" name="c[city]" value="" id="f_city" required>
            </div>
            <div class="col-md-4">
                <label for="f_link">Ссылка</label>
                <input type="text" class="form-control" name="c[link]" value="" id="f_link" required>
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
            <th scope="col">Дата</th>
            <th scope="col">Город</th>
            <th scope="col">Ссылка</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        {foreach $list as $key => $row}
            <tr>
                <td>{$row.date|date_format:"%d.%m.%Y"}</td>
                <td>{$row.city}</td>
                <td>{$row.link}</td>
                <td class="text-right">
                    <a href="/moderka/afi/del/{$key}" title="Удалить"><i class="fa fa-times" aria-hidden="true" style="color: #e60000"></i></a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}