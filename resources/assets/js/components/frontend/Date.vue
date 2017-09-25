<template>
    <div :id="'date-'+id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">

                <span v-text="startDate"></span>
                <span v-text="endDate"></span>
                <span v-text="difference"></span>
                <span v-text="whenStart"></span>
                <span v-text="totalOptions"></span>
                <button type="submit" :class="classes" @click="option">
                    <span class="glyphicon glyphicon-heart" v-text="optiontext"></span>

                </button>
            </div>
        </div>
    </div>
</template>

<script>
    //import Favorite from './Favorite.vue';
    import moment from 'moment';
    export default {
        props: ['data'],
        components: {},
        data() {
            return {
                id: this.data.id,
                totalOptions: this.data.total_options,
                active: false,
                optiontext: "Optie nemen"
            };
        },
        computed: {
            whenStart() {
                return moment(this.data.start).fromNow() + '...';
            },
            end() {
                return moment(this.data.end).fromNow() + '...';
            },
            startDate() {
                return moment(this.data.start).format('D MMMM YYYY');
            },
            endDate() {
                return moment(this.data.end).format('D MMMM YYYY');
            },
            difference() {
                let start = moment(this.data.start);
                let end = moment(this.data.end);
                let difference = end.diff(start, 'days');
                return difference + ' day(s)';
            },
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-default'
                ];
            },
            signedIn() {
                //return window.App.signedIn;
            },
            canUpdate() {
                //return this.authorize(user => this.data.user_id == user.id);
            }
        },
        methods: {
            option() {
                this.active ? this.destroy() : this.create();
            },
            create() {
                //axios.post(this.endpoint);
                this.active = true;
                this.optiontext = "Optie genomen";
                this.totalOptions++;
            },
            destroy() {
                //axios.delete(this.endpoint);
                this.active = false;
                this.optiontext = "Optie nemen";
                this.totalOptions--;
            }
        }
    }
</script>
