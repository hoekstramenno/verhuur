<template>
    <div :id="'date-'+id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">

                <span v-text="startDate"></span>
                <span v-text="endDate"></span>
                <span v-text="difference"></span>
                <span v-text="whenStart"></span>

                <span v-if="active === true" v-text="totalOptions"></span>
                <router-link :to="link" v-text="optiontext"></router-link>
            </div>
        </div>
    </div>
</template>

<script>
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
            link() {
                return 'date/' + this.data.id;
            },
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
//                return [
//                    'btn',
//                    this.active ? 'btn-primary' : 'btn-default'
//                ];
            },
            signedIn() {
                //return window.App.signedIn;
            },
            canUpdate() {
                //return this.authorize(user => this.data.user_id == user.id);
            },
            isActive() {
                if (this.data.status == "2") {
                    this.active = false;
                    return false;
                }
                return true;
            }
        }
    }
</script>
