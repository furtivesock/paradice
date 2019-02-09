const idUniverse = document.getElementById('messages').getAttribute('universe')
const idStory = document.getElementById('messages').getAttribute('story')
const idChapter = document.getElementById('messages').getAttribute('chapter')

var vm = new Vue({
    el: "#messages",
    data: {
        messages: [],
        lastMessages: [],
        dateBefore: new Date(),
        dateAfter: null,
    },
    computed: {
        reverseMessages: function() {
            return this.messages.slice().reverse()
        }
    },
    methods: {
        loadMessages: function () {
            this.dateBefore = new Date().toUTCString();

            const path = '/universe/' + idUniverse +
                '/story/' + idStory +
                '/chapter/' + idChapter +
                '/message/get/' + this.dateBefore + '/' +
                (this.dateAfter === null ? '' : this.dateAfter);


            axios.get(path)
                .then(function (response) {
                    let i = 0 

                    let newLastMessages = []
                    for (; i < response.data.length; i++) {
                        let j = 0
                        for (; j < vm.lastMessages.length; j++) {
                            if (vm.lastMessages[j].id === response.data[i].id) {
                                break
                            }
                        }

                        // not included
                        if (j >= vm.lastMessages.length) {
                            vm.messages.push(response.data[i])
                        }

                        newLastMessages.push(response.data[i])
                    }

                    vm.lastMessages = newLastMessages

                    if (vm.messages.length > 0) {
                        vm.dateAfter = vm.messages[vm.messages.length - 1].creationDate.date
                    }
                })
                .catch(function (error) {
                    alert(error)
                })
                .then(function () {
                    setTimeout(vm.loadMessages, 1000);
                })

        },
        sendMessage: function () {
            const message = document.getElementById('messageToSend')
            
            if (message.value.trim() === '') {
                return
            }

            axios.post('/universe/' + idUniverse +
                '/story/' + idStory +
                '/chapter/' + idChapter +
                '/message/post', {
                    message: message.value.trim()
                })
                .then(function (response) {
                    console.log('perfect')
                })
                .catch(function (error) {
                    alert(error)
                })
            message.value = ''
        }
    },
    created: function () {
        this.loadMessages()
    },
    delimiters: ['${', '}']
})

