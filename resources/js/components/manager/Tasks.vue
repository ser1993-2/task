<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center ">Заявки</div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <button v-on:click="sortTasks" type="button" class="btn btn-secondary">Сортировать</button>
                            </div>
                            <div class="col-md-2">
                                <input v-on:click="addFieldSort('id')" type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Номер заявки:</label>
                            </div>
                            <div class="col-md-2">
                                <input v-on:click="addFieldSort('name')"type="checkbox" class="form-check-input" id="exampleCheck2">
                                <label class="form-check-label" for="exampleCheck2">Имя пользователя:</label>
                            </div>
                            <div class="col-md-2">
                                <input v-on:click="addFieldSort('status')"type="checkbox" class="form-check-input" id="exampleCheck3">
                                <label class="form-check-label" for="exampleCheck3">Статус:</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Тема</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Пользватель</th>
                                <th scope="col">Просмотрен</th>
                                <th scope="col">Создан</th>
                                <th scope="col">Обнавлен</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="task in tasks" >
                                <th scope="row">{{ task.id }}</th>
                                <router-link :to="'/task/'+ task.id">
                                    <td>{{task.name}}</td>
                                </router-link>
                                <td>{{ task.status == true ? 'Активен' : 'Закрыт'}}</td>
                                <td>{{ task.user_name }}</td>
                                <td>{{ task.view == true ? '   Да' : 'Нет'}}</td>

                                <td><span>{{ task.created_at | moment().format('YYYY-MM-DD hh:mm:ss') }}</span></td>
                                <td><span>{{ task.updated_at | moment().format('YYYY-MM-DD hh:mm:ss') }}</span></td>
                                <td>
                                    <button v-if="task.status" v-on:click="closeTask(task.id)" type="button" class="btn btn-danger">Закрыть</button>
                                    <button v-if="!task.status" v-on:click="openTask(task.id)" type="button" class="btn btn-success">Открыть</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data: () => ({
            user: {},
            tasks: {},
            sort: [],
        }),
        created() {
            this.getUser();
        },
        watch: {
        },
        methods: {
            getUser() {
                axios.get('/account/')
                    .then((response) => {
                        this.user = response.data;
                        this.getTasks(this.user.id);
                    })
                    .catch((error) => {
                        alert('Ошибка загрузкипользователя');
                    });
            },
            getTasks(userId) {
                axios.get('/manager/task/')
                    .then((response) => {
                        this.tasks = response.data;
                    })
                    .catch((error) => {
                        alert('Ошибка загрузкипользователя');
                    });
            },
            addFieldSort(field) {
                if ( _.indexOf(this.sort, field) != -1 ) {
                    this.sort = _.pull(this.sort, field);
                } else {
                    this.sort.push(field)
                }
            },
            sortTasks() {
                if ( _.isEqual(this.tasks, _.orderBy(this.tasks, this.sort, 'desc') ) ) {
                    this.tasks = _.orderBy(this.tasks, this.sort, 'asc');
                } else {
                    this.tasks = _.orderBy(this.tasks, this.sort, 'desc');
                }
            },
            closeTask(taskId) {
                if (confirm('Вы уверены?')) {
                    axios.delete('/manager/task/' + taskId)
                        .then((response) => {
                            this.getTasks(this.user.id);
                        })
                        .catch((error) => {
                            alert('Ошибка закрытия');
                        });
                }
            },
            openTask(taskId) {
                if (confirm('Вы уверены?')) {
                    axios.put('/manager/task/' + taskId)
                        .then((response) => {
                            this.getTasks(this.user.id);
                        })
                        .catch((error) => {
                            alert('Ошибка закрытия');
                        });
                }
            },
        },
    }
</script>

<style scoped>
    .text-center {
        text-align: center;
        font-size: 24px;
    }
</style>
