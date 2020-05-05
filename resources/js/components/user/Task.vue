<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center ">Заявка № {{ this.task.id}}</div>
                    <div class="card-header">

                        <router-link :to="'/task'">
                            <button type="button" class="btn btn-primary">К списку</button>
                        </router-link>

                    </div>
                    <div class="card-body">
                        <h3 class="text-center">{{ task.name }}</h3>
                        <div v-for="item in message" class="alert" role="alert"
                        :class="{'alert-info' : item.user_id ,'alert-warning' : item.manager_id  }">
                            <p class="text-date">{{ user.name }} | {{ task.updated_at | moment().format('YYYY-MM-DD hh:mm:ss') }}</p>
                            {{ item.text }}
                        </div>

                        <div class="alert alert-dark" role="alert" v-if="task.status">
                            <input v-model="newText" type="text" class="form-control" placeholder="Сообщение">
                            <button v-on:click="sendMessage" type="button" class="btn btn-success" style="margin-top: 5px">Отправить</button>
                        </div>
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
            taskId: '',
            task: {},
            message: {},
            newText: '',
        }),
        created() {
            this.getUser();
            this.taskId = this.$route.params.id;
            this.getTask();
        },
        methods: {
            getUser() {
                axios.get('/account/')
                    .then((response) => {
                        this.user = response.data;
                    })
                    .catch((error) => {
                        alert('Ошибка загрузкипользователя');
                    });
            },
            getTask() {
                axios.get('/user/task/' + this.taskId)
                    .then((response) => {
                        this.task = response.data.task;
                        this.message = response.data.message;
                    })
                    .catch((error) => {
                        alert('Ошибка');
                    });
            },
            sendMessage() {
                if (this.newText == '') {
                    alert('Сообщение пустое');
                    return;
                }

                let data = {
                    'user_id' : this.user.id,
                    'text' : this.newText
                }

                axios.post('/user/task/' + this.taskId + '/message', data)
                    .then((response) => {
                        this.newText = '';
                        this.getTask();
                    })
                    .catch((error) => {
                        alert('Ошибка');
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

    .text-date {
        text-align: right;
        font-size: 12px;
        font-weight: bold;
    }
</style>
