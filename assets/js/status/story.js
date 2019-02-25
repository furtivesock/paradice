var vmStatus = new Vue({
    el: "#status",
    data: {
        allStatus: [],
        curStatus: null,
        idUniverse: null,
        idStory: null
    },
    watch: {
        curStatus: function (newStatus, oldStatus) {
            this.changeStatus(newStatus, oldStatus)
        }
    },
    methods: {
        changeStatus: function (newStatus, oldStatus) {
            const path = '/universe/' + this.idUniverse +
                '/story/' + this.idStory +
                '/status'
            axios.post(path, { status: newStatus })
                .catch(function (error) {
                    alert(error)
                })
        },
        loadAllStatus: function () {
            const path = '/status/get'
            axios.get(path)
                .then(function (response) {
                    vmStatus.allStatus = response.data
                })
                .catch(function (error) {
                    alert(error)
                })
        },
        loadCurStatus: function () {
            const path = '/universe/' + this.idUniverse +
                '/story/' + this.idStory + '/get'

            axios.get(path)
                .then(function (response) {
                    vmStatus.curStatus = response.data.status.id
                })
                .catch(function (error) {
                    alert(error)
                })
        },
    },
    created: function () {
        this.idUniverse = document.getElementById('status').getAttribute('universe')
        this.idStory = document.getElementById('status').getAttribute('story')
        this.loadAllStatus()
        this.loadCurStatus()
    },
    delimiters: ['${', '}']
})

