<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center ">Заявки</div>
                    <div class="card-header">
                        <button type="button" class="btn btn-success" v-on:click="editTaskId = null"
                                data-toggle="modal" data-target="#exampleModal">Новая заявка</button>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Тема</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Создан</th>
                                <th scope="col">Обнавлен</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="task in tasks" >
                                <th scope="row">{{task.id}}</th>
                                    <router-link :to="'/task/'+ task.id">
                                        <td>{{task.name}}</td>
                                    </router-link>
                                <td>{{task.status == true ? 'Активен' : 'Закрыт'}}</td>
                                <td><span>{{ task.created_at | moment().format('YYYY-MM-DD hh:mm:ss') }}</span></td>
                                <td><span>{{ task.updated_at | moment().format('YYYY-MM-DD hh:mm:ss') }}</span></td>
                                <td>
                                    <button v-if="task.status" type="button" class="btn btn-primary" v-on:click="getTask(task.id)"
                                            data-toggle="modal" data-target="#exampleModal">Редактировать</button>
                                    <button v-if="task.status" v-on:click="closeTask(task.id)"  type="button" class="btn btn-danger">Закрыть</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ editTaskId == null ? 'Новая заявка' : 'Редактировать' }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Тема обращения:</p>
                        <input v-model="newTask.name" type="text" class="form-control" placeholder="Тема">
                        <p v-if="!editTaskId">Сообщение:</p>
                        <textarea v-if="!editTaskId" v-model="newTask.text" type="text" class="form-control" placeholder="Текст..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button v-if="editTaskId" v-on:click="editTask" type="button" class="btn btn-primary" data-dismiss="modal">Редактировать</button>
                        <button v-if="!editTaskId" v-on:click="getLastTsk(user.id)" type="button" class="btn btn-primary" data-dismiss="modal">Создать</button>
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
            newTask: {
                name : '',
                text : '',
                user_id : '',
            },
            lastTask: '',
            editTaskId: null,
        }),
        created() {
            this.getUser();
        },
        watch: {
            editTaskId: function (val) {
                if (val == null) {
                    this.newTask.name = '';
                }
            },
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
                axios.get('/user/task/')
                    .then((response) => {
                        this.tasks = response.data;
                    })
                    .catch((error) => {
                        alert('Ошибка загрузкипользователя');
                    });
            },
            createTask() {
                this.newTask.user_id = this.user.id;

                axios.post('/user/task/', this.newTask)
                    .then((response) => {

                        if (response.data == false) {
                            alert('Ошибка заполнения');
                        }

                        this.tasks = response.data;
                        this.newTask = {};
                        this.getTasks(this.user.id);
                    })
                    .catch((error) => {
                        alert('Ошибка создания');
                        this.newTask = {};
                    });
            },
            getLastTsk(userId) {
                axios.get('/user/task/' + userId + '/last' )
                    .then((response) => {
                        if (response.data) {
                            this.createTask();
                        } else {
                            alert('Не чаще одного обращения в сутки');
                        }
                    });
            },
            closeTask(taskId) {
                if (confirm('Вы уверены?')) {
                    axios.delete('/user/task/' + taskId)
                        .then((response) => {
                            this.getTasks(this.user.id);
                        })
                        .catch((error) => {
                            alert('Ошибка закрытия');
                        });
                }
            },
            getTask(id) {
                for (let key in this.tasks) {
                    if (this.tasks[key].id == id) {
                        this.editTaskId = id;
                        this.newTask.name = this.tasks[key].name;
                    }
                }
            },
            editTask() {
                let data = {};
                data.name = this.newTask.name;
                data.taskId = this.editTaskId;

                axios.put('/user/task/', data)
                    .then((response) => {
                        this.getTasks(this.user.id);
                    });

            }
        },
    }
</script>

<style scoped>
.text-center {
    text-align: center;
    font-size: 24px;
}
</style>
