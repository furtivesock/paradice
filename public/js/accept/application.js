var vmApplications = new Vue({
    el: "#applications",
    data: {
        applications: [],
        idUniverse: null
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
            const path = '/universe/' + this.idUniverse + '/application/get';
            axios.get(path)
                .then(function (response) {
                    vmApplications.applications = response.data
                })
                .catch(function (error) {
                    alert(error)
                })
        },
        accept: function (idApplicant, accept) {
            const path = '/universe/' + this.idUniverse +
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
        this.idUniverse = document.getElementById('applications').getAttribute('universe')
        this.loadApplications()
    },
    delimiters: ['${', '}']
})

