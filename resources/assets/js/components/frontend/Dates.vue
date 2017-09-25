<template>

        <div>
            <div v-for="(date, index) in items" :key="date.id">
                <date :data="date"></date>
            </div>

            <!--<paginator :dataSet="dataSet" @changed="fetch"></paginator>-->

            <!--<new-reply @created="add"></new-reply>-->
        </div>

</template>

<script>
    import Date from './Date.vue';

    export default {
        name: "dates",
        components: { Date },
//        mixins: [collection],
        data() {
            return {
                dataSet: false,
                url: '/api/dates',
                items: []
            };
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get(this.url).then(response => {
                    this.refresh(response);
                });
            },

            refresh(data) {
                this.dataSet = data.data;
                this.items = data.data.dates;
                window.scrollTo(0, 0);
            }
        }
    }
</script>
