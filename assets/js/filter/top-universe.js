var vmTop = new Vue({
    el: "#top5",
    data: {
        topUniversesFilter: null, // chosen filter
        topUniversesTypeFilter: [ // type of filters
            ['day', 'AUJOURD\'HUI'],
            ['week', 'CETTE SEMAINE'],
            ['month', 'CE MOIS-CI'],
            ['year', 'CETTE ANNEE'],
            ['all', 'DE TOUS LES TEMPS'],
        ],
        topUniverses: [],
        topLimit: 5
    },
    watch: {
        /* Update the top when the filter changes */
        topUniversesFilter: function (newFilter) {
            this.changeFilter(newFilter)
        }
    },
    methods: {
        /* Redirect to an universe when an user clicks on it */
        goToUniverse: function (id) {
            if (id >= 0) {
                document.location = '/universe/' + id
            }
        },
        /* Change the top universes by requesting the server
        the new top according to the new filter
         */
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
                    date = null
                    break
                default:
                    return
            }

            // Get the new top
            axios.get('/universe/get/top/' + (date === null ? '' : date.toUTCString()))
                .then(function (response) {
                    vmTop.topUniverses = []
                    console.log(this.topLimit)
                    for (let i = 0; i < response.data.length && i < vmTop.topLimit; i++) {
                        vmTop.topUniverses.push(response.data[i])
                    }

                    for (let i = response.data.length; i < vmTop.topLimit; i++) {
                        vmTop.topUniverses.push({ id: -1 * i, name: '...' })
                    }
                })
                .catch(function (error) {
                    alert(error)
                })
        }
    },
    created: function () {
        // default filter is the first one in topUniversesTypeFilter
        this.topUniversesFilter = this.topUniversesTypeFilter[0][0]
    },
    delimiters: ['${', '}']
})

