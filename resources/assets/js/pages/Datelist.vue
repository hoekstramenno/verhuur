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

<script>
    import Dates from '../components/frontend/Dates/list/Dates';

    export default {
        props: [],
        components: {Dates},
        data() {
            return {}
        }
    }
</script>