

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
        goToStory: function(idStory) {
            const universe = document.getElementById('stories').getAttribute('universe')
            document.location = '/universe/'+universe+'/story/'+idStory;
        },
        changeOrder: function (newOrder) {

            const universe = document.getElementById('stories').getAttribute('universe')
            axios.get('/universe/' + universe + '/story/get/' + newOrder)
                .then(function (response) {
                    vm.stories = response.data;
                })
                .catch(function (error) {
                    alert(error)
                });
        }
    },
    created: function () {
        this.storiesOrder = this.storiesTypeOrder[0][0]
    },
    delimiters: ['${', '}']
})

