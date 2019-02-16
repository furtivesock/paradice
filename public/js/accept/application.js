
const idUniverse = document.getElementById('applications').getAttribute('universe')

var vm = new Vue({
    el: "#applications",
    data: {
        applications: []
    },
    computed: {
        waitedApplication: function () {
            return this.applications.filter(function (el) {
                return el.accepted === null
            })
        },
        acceptedApplication: function () {
            return this.applications.filter(function (el) {
                return el.accepted === true
            })
        },
        refusedApplication: function () {
            return this.applications.filter(function (el) {
                return el.accepted === false
            })
        }
    },
    methods: {
        loadApplications: function () {
            const path = '/universe/' + idUniverse + '/application/get';
            axios.get(path)
                .then(function (response) {
                    vm.applications = response.data
                })
                .catch(function (error) {
                    alert(error)
                })
        },
        accept: function (idApplicant, accept) {
            const path = '/universe/' + idUniverse +
                '/application/' + idApplicant + '/accept'

            let application = this.applications.find(function (el) {
                return el.applicant.id === idApplicant
            })

            if (accept) {
                axios.post(path, { accept: true })
                    .then(function () {
                        application.accepted = true
                    })
                    .catch(function (error) {
                        alert(error);
                    })
            } else {
                axios.post(path, { accept: false })
                    .then(function () {
                        application.accepted = false
                    })
                    .catch(function (error) {
                        alert(error);
                    })
            }
        }
    },
    created: function () {
        this.loadApplications()
    },
    delimiters: ['${', '}']
})

