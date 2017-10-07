<template>

    <table>

        <tr v-for="(date, index) in items" :key="date.id">

        </tr>

        <!--<paginator :dataSet="dataSet" @changed="fetch"></paginator>-->

        <!--<new-reply @created="add"></new-reply>-->
    </table>

</template>

<script>


    export default {
        name: "materiallist",

        data() {
            return {
                dataSet: false,
                url: '/api/materials',
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
