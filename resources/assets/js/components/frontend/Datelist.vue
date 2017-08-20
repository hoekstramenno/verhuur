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
    <tbody>
            <tr v-for="date in dates" v-bind:class="{'is-grey': date.status.code == 2}" >
                <td>{{ date.status.label }}</td>
                <td>{{ date.start.date }}</td>
                <td>{{ date.end.date }}</td>
                <td>10 {{ 'options taken' }}</td>
                <td><a href="dates/10/options"></a></td>
            </tr>
    </tbody>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                dates: []
            };
        },


        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getDates();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getDates() {
                axios.get('/api/dates')
                    .then(response => {
                        this.dates = response.data.dates;
                    });

            },
            isBooked(date) {
                return true;
            }
        }
    }
</script>
