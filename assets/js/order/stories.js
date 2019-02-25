
var vm = new Vue({
    el: "#stories",
    data: {
        storiesOrder: null, // chosen order
        storiesTypeOrder: [ // type of orders
            ['update', 'Dernière date de mise à jour'],
            ['create', 'Date de création'],
            ['top_day', 'Popularité (jour)'],
            ['top_week', 'Popularité (semaine)'],
            ['top_month', 'Popularité (mois)'],
            ['top_year', 'Popularité (année)'],
            ['top_all', 'Popularité (de tous les temps)'],
        ],
        stories: [],
        idUniverse: null,
    },
    watch: {
        /* Update the list of stories when the order changes */
        storiesOrder: function (newOrder) {
            this.changeOrder(newOrder)
        }
    },
    methods: {
        /* Redirect to a story when an user clicks on it */
        goToStory: function (idStory) {
            document.location = '/universe/' + this.idUniverse + '/story/' + idStory
        },
        /* Change the list of stories by requesting the server
        the new list according to the new order
         */
        changeOrder: function (newOrder) {

            const order = this.storiesOrder.startsWith('top') ? 'top' : this.storiesOrder

            let date = new Date()
            switch (this.storiesOrder) {
                case 'top_day':
                    date.setDate(date.getDate() - 1)
                    break
                case 'top_week':
                    date.setDate(date.getDate() - 7)
                    break
                case 'top_month':
                    date.setDate(date.getDate() - 30)
                    break
                case 'top_year':
                    date.setDate(date.getDate() - 365)
                    break
                default:
                    date = null
                    break
            }

            // Get the new list
            axios.get('/universe/' + this.idUniverse + '/story/get/'
                + order + '/' + (date === null ? '' : date.toUTCString()))
                .then(function (response) {
                    vm.stories = response.data
                })
                .catch(function (error) {
                    alert(error)
                })
        }
    },
    created: function () {
        // default order is the first one in storiesTypeOrder
        this.idUniverse = document.getElementById('stories').getAttribute('universe')
        this.storiesOrder = this.storiesTypeOrder[0][0]
    },
    delimiters: ['${', '}']
})

