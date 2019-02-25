
/**
 * The main strategy for having a chat :
 *      - We get all messages for the server between the last message's date and now
 *      - There may be duplicate so we just add those that are not included in the view
 *      - If there is no message, we just get all messages 
 * There may be some message that doesn't appear so we don't now if we will keep
 * this strategy in the future :
 *      - Because of the time interval between getting the current date and insertion in the database,
 *      some messages can be omitted (ex : insertion at 10h22m32s when creation date is set at 10h22m30s )
 */
var vmMessages = new Vue({
    el: "#messages",
    data: {
        messages: [], // messages in the view
        lastMessages: [], // last messages from the last update
        dateBefore: new Date(), 
        dateAfter: null,
        idUniverse: null,
        idStory: null,
        idChapter: null,
        intervalReload: 1000
    },
    computed: {
        /* Get the most recent message at first */
        reverseMessages: function() {
            return this.messages.slice().reverse()
        }
    },
    methods: {
        /* Load new messages and display them in the view */
        loadMessages: function () {
            this.dateBefore = new Date().toUTCString();

            const path = '/universe/' + this.idUniverse +
                '/story/' + this.idStory +
                '/chapter/' + this.idChapter +
                '/message/get/' + this.dateBefore + '/' +
                (this.dateAfter === null ? '' : this.dateAfter)


            axios.get(path)
                .then(function (response) {
                    let i = 0 

                    // Add new messages to the view and keep in memory
                    // these messages to avoid duplicate for the next
                    // update
                    let newLastMessages = []
                    for (; i < response.data.length; i++) {
                        let j = 0
                        // We check if there is no duplicate here
                        for (; j < vmMessages.lastMessages.length; j++) {
                            if (vmMessages.lastMessages[j].id === response.data[i].id) {
                                break
                            }
                        }

                        // if there isn't any duplicate we add the message to the view
                        if (j >= vmMessages.lastMessages.length) {
                            vmMessages.messages.push(response.data[i])
                        }

                        newLastMessages.push(response.data[i])
                    }

                    vmMessages.lastMessages = newLastMessages

                    // change the afterDate to the last message if there is one
                    if (vmMessages.messages.length > 0) { 
                        vmMessages.dateAfter = vmMessages.messages[vmMessages.messages.length - 1].creationDate.date
                    }
                })
                .catch(function (error) {
                    alert(error)
                })
                .then(function () { 
                    // Always try to load new message n seconds after the response of the last request
                    // in order to avoid a new request to finish before an older one
                    setTimeout(vmMessages.loadMessages, vmMessages.intervalReload)
                })

        },
        /* Send the message to the server when user hit the send button */
        sendMessage: function () {
            const message = document.getElementById('messageToSend')
            
            if (message.value.trim() === '') {
                return
            }
            
            axios.post('/universe/' + this.idUniverse +
                '/story/' + this.idStory +
                '/chapter/' + this.idChapter +
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
        this.idUniverse = document.getElementById('messages').getAttribute('universe')
        this.idStory = document.getElementById('messages').getAttribute('story')
        this.idChapter = document.getElementById('messages').getAttribute('chapter')
        this.loadMessages()
    },
    delimiters: ['${', '}']
})

