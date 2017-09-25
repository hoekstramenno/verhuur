<template>
    <div id="app">
        <!-- the router outlet, where all matched components would ber viewed -->
        <router-view></router-view>
        <flash></flash>
    </div>
</template>

<script>
    import Flash from './Flash.vue';
    export default {
        name: 'app',
        components: {Flash}
    }
</script>
<!-- styling for the component -->
<style>
    #app {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }
</style>