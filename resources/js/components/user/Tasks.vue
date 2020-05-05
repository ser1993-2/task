<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center ">Заявки</div>
                    <div class="card-header">
                        <button type="button" class="btn btn-primary"
                                data-toggle="modal" data-target="#exampleModal">Новая заявка</button>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">Тема</th>
                                <th scope="col">Сообщение</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="task in tasks">
                                <th scope="row">{{task.id}}</th>
                                <td>{{task.name}}</td>
                                <td>{{task.text}}</td>
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
                        <h5 class="modal-title" id="exampleModalLabel">Новая заявка</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Тема обращения:</p>
                        <input v-model="newTask.name" type="text" class="form-control" placeholder="Тема">
                        <p>Сообщение:</p>
                        <textarea v-model="newTask.text" type="text" class="form-control" placeholder="Текст..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button v-on:click="createTask" type="button" class="btn btn-primary" data-dismiss="modal">Создать</button>
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
            newTask: {},
        }),
        created() {
            this.getUser();
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
                axios.get('/user/task/'+ userId)
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
                        this.tasks = response.data;
                        this.newTask = {};
                        this.getTasks(this.user.id);
                    })
                    .catch((error) => {
                        alert('Ошибка создания');
                        this.newTask = {};
                    });
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
