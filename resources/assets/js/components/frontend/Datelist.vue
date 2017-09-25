<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
    .done {
        color: red;
    }
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <dates></dates>
            </div>
        </div>
    </div>
</template>

<!--<script>-->
    <!--export default {-->
        <!--/*-->
         <!--* The component's data.-->
         <!--*/-->
        <!--data() {-->
            <!--return {-->
                <!--dates: []-->
            <!--};-->
        <!--},-->


        <!--/**-->
         <!--* Prepare the component (Vue 2.x).-->
         <!--*/-->
        <!--mounted() {-->
            <!--this.prepareComponent();-->
        <!--},-->

        <!--methods: {-->
            <!--/**-->
             <!--* Prepare the component (Vue 2.x).-->
             <!--*/-->
            <!--prepareComponent() {-->
                <!--this.getDates();-->
            <!--},-->

            <!--/**-->
             <!--* Get all of the authorized tokens for the user.-->
             <!--*/-->
            <!--getDates() {-->
                <!--axios.get('/api/dates')-->
                    <!--.then(response => {-->
                        <!--console.log(response);-->
                        <!--this.dates = response.data.dates;-->
                    <!--})-->
                    <!--.catch(function (error) {-->
                        <!--console.log(error.response);-->
                    <!--});-->

            <!--},-->
            <!--isBooked(date) {-->
                <!--return true;-->
            <!--}-->
        <!--}-->
    <!--}-->
<!--</script>-->

<script>
    import Dates from './Dates.vue';

    export default {
        props: [],
        components: {Dates},
        data() {
            return {}
        }
    }
</script>