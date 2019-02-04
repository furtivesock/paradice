
const idUniverse = document.getElementById('stories').getAttribute('universe')

var vm = new Vue({
    el: "#stories",
    data: {
        storiesOrder: null,
        storiesTypeOrder: [
            ['update', 'Dernière date de mise à jour'],
            ['create', 'Date de création'],
            ['top_day', 'Popularité (jour)'],
            ['top_week', 'Popularité (semaine)'],
            ['top_month', 'Popularité (mois)'],
            ['top_year', 'Popularité (année)'],
            ['top_all', 'Popularité (de tous les temps)'],
        ],
        stories: []
    },
    watch: {
        storiesOrder: function (newOrder) {
            this.changeOrder(newOrder)
        }
    },
    methods: {
        goToStory: function (idStory) {
            document.location = '/universe/' + idUniverse + '/story/' + idStory
        },
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

            axios.get('/universe/' + idUniverse + '/story/get/'
                + order + '/' + (date === null ? '' : date.toDateString()))
                .then(function (response) {
                    vm.stories = response.data
                })
                .catch(function (error) {
                    alert(error)
                })
        }
    },
    created: function () {
        this.storiesOrder = this.storiesTypeOrder[0][0]
    },
    delimiters: ['${', '}']
})

