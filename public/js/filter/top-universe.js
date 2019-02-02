

var vm = new Vue({
    el: "#top5",
    data: {
        topUniversesFilter: null,
        topUniverses: []
    },
    watch: {
        topUniversesFilter: function (newFilter) {
            this.changeFilter(newFilter)
        }
    },
    methods: {
        goToUniverse: function(id) {
            if (id >= 0) {
                document.location = '/universe/'+id;
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
                default:
                    return;
            }
            
            axios.get('/home/top/' + date.toDateString())
                .then(function (response) {
                    vm.topUniverses = response.data.map(function (e) {
                        return { id: e.id, name: e.name }
                    })
                    for (let i = response.data.length; i < 5; i++) {
                        vm.topUniverses.push({ id: -1 * i, name: '...' })
                    }
                })
                .catch(function (error) {
                    alert(error)
                });
        }
    }, 
    created: function() {
        this.topUniversesFilter = 'day'
    },
    delimiters: ['${', '}']
})

