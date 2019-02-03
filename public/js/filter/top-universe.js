

var vm = new Vue({
    el: "#top5",
    data: {
        topUniversesFilter: null,
        topUniversesTypeFilter: [
            ['day', 'AUJOURD\'HUI'],
            ['week', 'CETTE SEMAINE'],
            ['month', 'CE MOIS-CI'],
            ['year', 'CETTE ANNEE'],
            ['all', 'DE TOUS LES TEMPS'],
        ],
        topUniverses: []
    },
    watch: {
        topUniversesFilter: function (newFilter) {
            this.changeFilter(newFilter)
        }
    },
    methods: {
        goToUniverse: function (id) {
            if (id >= 0) {
                document.location = '/universe/' + id;
            }
        },
        changeFilter: function (newFilter) {
            let date = new Date()
            switch (newFilter) {
                case 'day':
                    date.setDate(date.getDate() - 1)
                    break
                case 'week':
                    date.setDate(date.getDate() - 7)
                    break
                case 'month':
                    date.setDate(date.getDate() - 30)
                    break
                case 'year':
                    date.setDate(date.getDate() - 30)
                    break
                case 'all':
                    date = null;
                    break
                default:
                    return
            }

            axios.get('/universe/get/top/' + (date === null ? '' : date.toDateString()))
                .then(function (response) {
                    vm.topUniverses = [];
                    for (let i = 0; i < response.data.length && i < 5; i++) {
                        vm.topUniverses.push(response.data[i]);
                    }

                    for (let i = response.data.length; i < 5; i++) {
                        vm.topUniverses.push({ id: -1 * i, name: '...' })
                    }
                })
                .catch(function (error) {
                    alert(error)
                });
        }
    },
    created: function () {
        this.topUniversesFilter = this.topUniversesTypeFilter[0][0]
    },
    delimiters: ['${', '}']
})

