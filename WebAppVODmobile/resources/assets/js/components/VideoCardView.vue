<template >
    <div>
        <div>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddMovie_modal">Add movie with imdbID</button>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddMovie_custom_modal"W>Add movie with custom input</button>
        </div>
        <br>
        <div class="container">
            <div v-for="movie in moviesarray" class="col-md-4 text-center">
                <div class="container-fluid well">
                    <br>
                    <a :href="'/moviedetails/'+movie.id">
                        <img class="movie-poster" :src="movie.Poster"> 
                    </a>
                    <br>
                    <h3>{{movie.Title}}</h3>
                    <br>
                    <button v-on:click="remove(movie)" class="btn btn-danger" >Delete</button>    

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'movies',
        'currentpage',
    ],
    data: function () {
        return {
            moviesarray: this.movies,
        }
    },
    methods:{
        remove: function (movie) {
            
            var data = {
                    body:{
                        "imdbID" : movie.id,
                        "currentpage" : this.currentpage
                    }
                };

            this.$http.delete('/movies', data)
                .then(function (response) {
                    console.log('Success!:', response);
                    this.loading = false;
                    this.moviesarray = response.body;
                }, function (response) {
                    this.loading = false;
                    console.log(response.data);
                });            
        }
    }
}
</script>