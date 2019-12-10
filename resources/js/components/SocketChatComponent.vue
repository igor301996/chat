<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row form-group">
                    <div class="col-sm-4">
                        <select name="" id="" multiple="" class="form-control" v-model="usersSelect">
                            <option value="" v-for="user in users" :value="'news-action.' + user.id">{{user.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                         <textarea name="" cols="30" rows="6" class="form-control">{{dataMessages.join('\n')}}</textarea>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Наберите сообщение" v-model="message">
                    <div class="input-group-append">
                        <button @click="dataMessages" class="btn btn-outline-secondary" type="button">Отправить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios"

    export default {
        data: function () {
            return {
                dataMessages: [],
                message: "",
                usersSelect: []
            }
        },
        props: [
            'users',
            'user'
        ],
        mounted() {
            var socket = io.connect('http://localhost:3000');

            socket.on("news-action." + this.user.id + ":App\\Events\\PrivateMessage", function (data) {
                console.log(data.message);
                this.dataMessages.push(data.message.user + ': ' + data.message.message);
            }.bind(this));

            socket.on("news-action.:App\\Events\\PrivateMessage", function (data) {
                this.dataMessages.push(data.message.user + ': ' + data.message.message);
            }.bind(this));
        },
        methods: {
            sendMessage: function () {
                if (!this.usersSelect.length)
                    this.usersSelect.push('news-action.');
                axios({
                    method: 'get',
                    url: '/start/send-private-message',
                    params: {channels: this.usersSelect, message: this.message, user: this.user.name}
                })
                    .then((response) => {
                        this.dataMessages.push(this.user.name + ': ' + this.message);
                        app.message = "";
                    });
            }
        }
    }
</script>

<style scoped>

</style>
