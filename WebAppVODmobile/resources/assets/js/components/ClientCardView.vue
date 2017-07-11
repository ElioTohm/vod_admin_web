<template >
    <div class="container">
        <div v-for="client in clientarray" class="col-md-4 text-center">
            <div class="container-fluid well">
                <br>
                <h3>{{client.email}}</h3>
                <br>
                <button v-if="client.active === 0" v-on:click="activate(client)" class="btn btn-primary" >Activate</button>
                <button v-else v-on:click="deactivate(client)" class="btn btn-warning" >Deactivate</button>
                <button v-on:click="remove(client)" class="btn btn-danger" >Delete</button>    

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'clients',
        'currentpage',
    ],
    data: function () {
        return {
            clientarray: this.clients,
        }
    },
    methods: {
        activate: function (client) {
            var data = {
                "clientID" : client.id,
                "currentpage" : this.currentpage,
                "condition": client.active
            };
            this.$http.post('/activeclients', data)
                .then(function (response) {
                    console.log('Success!:', response);
                    this.loading = false;
                    this.clientarray = response.body;
                }, function (response) {
                    console.log('Error!:', response.data);
                    this.loading = false;
                });
        },
        deactivate: function (client) {
            var data = {
                "clientID" : client.id,
                "currentpage" : this.currentpage,
                "condition": client.active
            };
            this.$http.post('/deactiveclients', data)
                .then(function (response) {
                    this.loading = false;
                    this.clientarray = response.body;
                }, function (response) {
                    this.loading = false;
                });

        },
        remove: function (client) {
            var data = {
                "clientID" : client.id,
                "currentpage" : this.currentpage,
                "condition": client.active
            };
            console.log(data)
            this.$http.delete('/clients', data)
                .then(function (response) {
                    console.log('Success!:', response);
                    this.loading = false;
                    this.clientarray = response.body;
                }, function (response) {
                    this.loading = false;
                });
        }
    }
}
</script>