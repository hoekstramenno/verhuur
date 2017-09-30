<template>
    <div>

        <create-option-form :data="date"></create-option-form>


    <ul v-if="errors && errors.length">
        <li v-for="error of errors">
            {{error}}
        </li>
    </ul>
    </div>
</template>


<script>
    import CreateOptionForm from '../components/frontend/Option/Create';

    export default {
        name: "date-page",
        components: {CreateOptionForm},
        data() {
            return {
                apiurl: '/api/dates/',
                date: [],
                errors: []
            };
        },
        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(this.apiurl + this.$route.params.id).then(response => {
                    console.log(response.status);
                    if (response.status !== 200) {
                        throw 'No content found';
                    }
                    this.refresh(response);
                }).catch(e => {
                    this.date = [];
                    this.errors.push(e);
                })
            },

            refresh(data) {
                this.dataSet = data.data;
                this.date = data.data.dates;
                window.scrollTo(0, 0);
            }
        }
    }
</script>
