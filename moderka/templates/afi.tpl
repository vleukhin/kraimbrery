{extends 'layout.tpl'}
{block 'afi'} active{/block}
{block 'bltitle'}Афиша{/block}
{block 'content'}
    <div id="afi">
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
                <input type="date" class="form-control" name="c[date]" value="" id="f_date" required v-model="currentEvent.date">
            </div>
            <div class="col-md-4">
                <label for="f_city">Город</label>
                <input type="text" class="form-control" name="c[city]" value="" id="f_city" required v-model="currentEvent.city">
            </div>
            <div class="col-md-4">
                <label for="f_link">Ссылка</label>
                <input type="text" class="form-control" name="c[link]" value="" id="f_link" required v-model="currentEvent.link">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary" v-if="!editing">Добавить</button>
                <button type="button" class="btn btn-warning" v-if="editing" v-on:click="save()">Сохранить</button>
                <button type="button" class="btn btn-default" v-if="editing" v-on:click="cancel()">Отмена</button>
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
            <tr v-for="event in events" v-bind:class="{ editing: event.id == currentEvent.id }">
                <td v-html="formatDate(event)"></td>
                <td v-html="event.city"></td>
                <td v-html="event.link"></td>
                <td class="text-right">
                    <a href="#" title="Удалить" v-on:click.prevent="edit(event)" v-if="!editing">
                        <i class="fa fa-edit" aria-hidden="true" style="color: #000"></i>
                    </a>
                    <a :href="'/moderka/afi/del/' +  event.id" title="Удалить" v-if="!editing">
                        <i class="fa fa-times" aria-hidden="true" style="color: #e60000"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
    <style>
        button{
            cursor: pointer;
        }
        tr.editing td{
            background-color: #de9ffd;
        }
    </style>
    <script>
        var afi = new Vue({
            el: '#afi',

            data: {
                events: {$events|json_encode:$.const.JSON_PRETTY_PRINT},
                editing: false,
                currentEvent: {
                    id: '',
                    date: '',
                    city: '',
                    link: ''
                },
                savedEvent: {
                    id: '',
                    date: '',
                    city: '',
                    link: ''
                }
            },

            methods: {
                edit: function (event) {
                    this.editing = true;
                    this.currentEvent = event;
                    Object.assign(this.savedEvent, event);

                    window.scrollTo(0, 0);
                },

                formatDate: function (event) {
                    date = event.date.split('-');

                    return date[2] + '.' + date[1] + '.' + date[0];
                },

                cancel: function () {
                    Object.assign(this.currentEvent, this.savedEvent);
                    this.savedEvent = {
                        id: '',
                        date: '',
                        city: '',
                        link: ''
                    };
                    this.editing = false;
                    this.currentEvent = {
                        id: '',
                        date: '',
                        city: '',
                        link: ''
                    }
                },

                save: function () {
                    this.$http.post('/moderka/afiUpdate/' + this.currentEvent.id, {
                        event: this.currentEvent
                    }).then(function (response) {
                        alert('Сохранено');
                        this.editing = false;
                        this.currentEvent = {
                            id: '',
                            date: '',
                            city: '',
                            link: ''
                        }
                    }.bind(this), function () {
                        alert('Не удалось сохранить');
                    });
                }
            }
        })
    </script>
{/block}