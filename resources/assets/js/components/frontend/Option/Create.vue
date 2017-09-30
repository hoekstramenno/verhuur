<template>
    <div>
        <vue-form-generator :schema="schema" :model="model" :options="formOptions" @validated="onValidated"></vue-form-generator>
    </div>
</template>


<script>
    import VueFormGenerator from "vue-form-generator";

    export default {
        name: "createOptionForm",
        components: {"vue-form-generator": VueFormGenerator.component},

        data() {
            return {
                apiurl: '/api/dates/' + this.$route.params.id + '/options',
                model: {
                    date_id: this.$route.params.id,
                    email: "john.doe@gmail.com",
                    pax: 6
                },

                schema: {
                    fields: [{
                        type: "input",
                        inputType: "hidden",
                        model: "date_id",
                        readonly: true
                    }, {
                        type: "input",
                        inputType: "email",
                        label: "E-mail",
                        model: "email",
                        styleClasses: 'field',
                        placeholder: "E-mail",
                        required: true,
                        validator: ["email"]
                    }, {
                        type: "input",
                        inputType: "number",
                        label: "Total persons",
                        model: "pax",
                        placeholder: "Total Persons",
                        styleClasses: 'field',
                        required: true,
                        min: 6,
                        validator: ["number"]
                    }, {
                        type: "submit",
                        buttonText: "Optie nemen",
                        validateBeforeSubmit: true,
                        onSubmit: this.submitForm,
                        styleClasses: 'field',
                        disabled() {
                            return this.errors.length > 0;
                        }
                    }]
                },

                formOptions: {
                    validateAfterLoad: false,
                    validateAfterChanged: true
                }
            }
        },
        methods: {
            onValidated(isValid, errors) {},
            submitForm() {
                axios.post(this.apiurl, this.model).then(response => {
                    this.model = {
                        date_id: this.$route.params.id
                    };
                    flash('Optie genomen. Wij nemen contact op');
                }).catch(e => {
//                    this.date = [];
//                    this.errors.push(e);
                })
            }
        }
    }
</script>
