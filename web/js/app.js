
    //API base URL
    var baselAPIUrl = 'http://testapi.52ys.cn/v1/service';

    //register the grid component
    Vue.component('demo-grid', {
        template: '#grid-template',
        props: {
            data: Array,
            columns: Array,
            filterKey: String,
        },
        data: function() {
            var sortOrders = {}
            this.columns.forEach(function(key) {
                sortOrders[key] = 1
            })
            return {
                sortKey: '',
                sortOrders: sortOrders
            }
        },
        computed: {
            filteredData: function() {
                var sortKey = this.sortKey
                var filterKey = this.filterKey && this.filterKey.toLowerCase()
                var order = this.sortOrders[sortKey] || 1
                var data = this.data
                if (filterKey) {
                    data = data.filter(function(row) {
                        return Object.keys(row).some(function(key) {
                            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
                        })
                    })
                }
                if (sortKey) {
                    data = data.slice().sort(function(a, b) {
                        a = a[sortKey]
                        b = b[sortKey]
                        return (a === b ? 0 : a > b ? 1 : -1) * order
                    })
                }
                return data
            }
        },

        filters: {
            capitalize: function(str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        methods: {
            //Sorting function
            sortBy: function(key) {
                /* local version 
                	this.sortKey = key
					this.sortOrders[key] = this.sortOrders[key] * -1
				*/

                //Remote version 
                const direction = (this.sortOrders[key] * -1) == 1 ? 'DESC' : 'ASC';

                demo.sortData(key, direction)
                this.sortKey = key
                this.sortOrders[key] = this.sortOrders[key] * -1

            },

            //Edit specified service with API call
            editService: function(entry) {

                if (entry['id'] > 0) {
                    axios.get(baselAPIUrl + '/' + entry['id']).then(response => {

                        if (response.data.code == 200) {

                            demo.isEdit = true
                            demo.showModal = true
                            demo.serviceName = response.data.data.serviceName
                            demo.owner = response.data.data.owner
                            demo.description = response.data.data.description
                            demo.sid = response.data.data.id
                            demo.status = response.data.data.status


                        }

                    });

                }

            }
        }
    });

    //register modal component
    Vue.component("modal", {
        template: "#modal-template",
        data: function() {

            return {
                errors: [],
                id: demo.sid,
                serviceName: demo.serviceName,
                owner: demo.owner,
                description: demo.description,
                status: demo.status,
            }
        },


        methods: {

            //Submit Form with validation
            submitForm: function(e) {

                this.errors = [];

                if (this.serviceName && this.owner && this.description) {

                    if (demo.isEdit) {
                        console.log("edit Mode")
                        axios.post(baselAPIUrl + '/update/' + this.id, {
                                serviceName: this.serviceName,
                                owner: this.serviceName,
                                description: this.description,
                                status: this.status
                            })
                            .then(function(response) {
                                demo.loadData();
                                demo.showModal = false
                            })
                            .catch(function(error) {
                                alert(error)
                            });


                    } else {
                        alert("create mode")
                            //Create Service 
                        axios.post(baselAPIUrl + '/create', {
                                serviceName: this.serviceName,
                                owner: this.serviceName,
                                description: this.description
                            })
                            .then(function(response) {
                                demo.loadData();
                                demo.showModal = false
                            })
                            .catch(function(error) {
                                alert(error)
                            });
                    }

                }



                if (!this.serviceName) {
                    this.errors.push('Service name required.');
                }
                if (!this.owner) {
                    this.errors.push('Owner required.');
                }
                if (!this.description) {
                    this.errors.push('Description required.');
                }

                e.preventDefault()
            },

        },
        mounted() {}


    });




    var demo = new Vue({
        el: '#demo',
        data() {
            return {

                showModal: false,
                searchQuery: '',

                //Define the fields name for display
                gridColumns: ['id', 'serviceName', 'owner', 'creatorName', 'createdDatetime', 'updatedDatetime', 'statusText'],
                gridData: null,
                isEdit: false,
                rowData: null,
                serviceName: '',
                owner: '',
                sid: 0,
                status: 0,
            }
        },
        mounted() {
            this.loadData();
        },
        methods: {

            //Load initial data into the grid view
            loadData: function() {
                axios.get(baselAPIUrl).then(response => {

                    if (response.data.code == 200) {
                        this.gridData = response.data.data.items;
                    }

                });
            },

            sortData: function(sortField, direction) {

                const query = "?sort=" + (direction == 'ASC' ? '+' : '-') + sortField;


                axios.get(baselAPIUrl + query).then(response => {

                    if (response.data.code == 200) {
                        this.gridData = response.data.data.items;
                    }

                });

            },
            addService: function() {
                this.serviceName = ''
                this.id = 0
                this.owner = '',
                    this.description = ''
                this.isEdit = false
                this.showModal = true
            }
        }

    });
