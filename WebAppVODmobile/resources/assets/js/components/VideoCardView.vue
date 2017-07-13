<template >
    <div class="container">
        <div v-for="movie in movies" class="col-md-4 text-center">
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
    }
}
</script>