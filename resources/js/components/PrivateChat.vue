<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-8">
                <textarea class="form-control" rows="10" readonly="">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage"
                       @keydown="actionUser">
                <span v-if="isActive">{{isActive.name}} набирает сообщение...</span>
            </div>
            <div class="col-sm-4">
                <ul>
                    <li v-for="user in activeUsers">{{user}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios"

    export default {
        props: ['room', 'user'],
        data() {
            return {
                messages: [],
                textMessage: '',
                isActive: false,
                typingTimer: false,
                activeUsers: []
            }
        },
        computed: {
            channel() {
                return window.Echo.join('room.' + this.room.id)
            }
        },
        mounted() {
            this.channel
                .here((users) => {
                    this.activeUsers = users;
                })
                .joining((user) => {
                    this.activeUsers.push(user);
                })
                .leaving((user) => {
                    this.activeUsers.splice(this.activeUsers.indexOf(user), 1);
                })
                .listen('PrivateChat', ({data}) => {
                    this.messages.push(data.user.name + ': ' + data.body);
                    this.isActive = false;
                })
                .listenForWhisper('typing', (e) => {
                    this.isActive = e;

                    if (this.typingTimer) clearTimeout(this.typingTimer)
                    this.typingTimer = setTimeout(() => {
                        this.isActive = false;
                    }, 2000);
                });
            this.getMessages();
        },
        methods: {
            sendMessage() {
                axios.post('/messages', {body: this.textMessage, room_id: this.room.id, user: this.user});

                this.messages.push(`Вы: ${this.textMessage}`);

                this.textMessage = '';
            },
            actionUser() {
                this.channel
                    .whisper('typing', {
                        name: this.user.name
                    })
            },
            getMessages() {
                axios.get(`/messages/get/${this.room.id}/${this.user.id}`)
                    .then(({data}) => {
                        data.map(item => {
                            let name = item.user.name === this.user.name ? 'Вы' : item.user.name;
                            let message = `${name}: ${item.text}`;

                            this.messages.push(message);
                        });
                    })
                    .catch(e => {
                        console.error(e);
                    });
            }
        },
    }
</script>
