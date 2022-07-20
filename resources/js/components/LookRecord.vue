<template>
    <v-dialog
        v-if="showDialog"
        v-model="dialog"
        max-width="800"
        persistent
    >
    <v-card>

            <v-card-title>
                <v-icon left>mdi-information-outline</v-icon>
                Информация
                <v-spacer/>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

                    <v-card-text>
                        <v-row>
                        <v-col
                            cols="3">
                        Приказ:<br>
                        Дата приказа:<br>
                        Дата заявки:<br>
                        Контрагент:<br>
                        Гарантийный приказ:<br>
                        Гарантия:<br>
                        Статус:<br>
                        </v-col>
                            <v-col
                            cols="3">
                                {{ this.complaint.numb_order}}<br>
                                {{this.complaint.order_at | date}}<br>
                                {{this.complaint.start_at | date}}<br>
                                {{this.contractor_name}}<br>
                                {{this.complaint.warranty_decree}}<br>
                                {{this.warranty_type_name}}<br>
                                {{this.type_comp_name}}<br>
                            </v-col>



                        <v-col
                            cols="3">
                        Причина гарантии:<br>
                        Вид надстройки: <br>
                        Виновник:<br>
                        Устранение: <br>
                        Дата отгрузки шасси:<br>
                        Шасси: <br>
                        </v-col>
                            <v-col
                            cols="3">
                                {{this.reason_name}}<br>
                                {{this.complaint.vehicle}}<br>
                                {{this.culprit_name}}<br>
                                {{this.executor_id}}<br>
                                {{this.complaint.unload_at | date}}<br>
                                {{this.complaint.chassises}} <br>
                            </v-col>

                        </v-row>
                    </v-card-text>





        </v-card>
    </v-dialog>
</template>
<script>


export default {
    name: "LookRecord",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        id: {
            type: Number,
            required: true
        },
    },


    created() {
        this.showDialog = false;
        api.call(endpoint('complaints.show', this.id))
            .then((response) => {
                this.warranty_type_name = response.data.warranty_type_name;
                this.reason_name = response.data.reason_name;
                this.type_comp_name = response.data.type_comp_name;
                this.culprit_name = response.data.culprit_name;
                this.executors = response.data.executors;
                this.contractor_name = response.data.contractor_name;
                this.chassises = response.data.chassises;
                this.complaint = response.data.complaint;
                this.executor_id = response.data.executor_id.join(', ');
                this.showDialog = true;
                this.complaint.chassises = this.complaint.chassises.map(function (item) {
                    return item.number
                }).join(', ')

            });


    },
    data() {
        return {

            insert: true,
            showDialog: false,
            items: [
                {title: 'Приказ'},

            ],
            complaint: {},  //объект с данными
            dialog: this.value,


        }
    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        },

    },
    methods: {
        showComplaint(id) {
            api.call(endpoint('complaints.show', id))
                .then((response) => {
                    this.complaints = response.data.data;
                    this.$emit('store-complaint');

                });
        },



        close() {
            this.$emit('input', false);
        }
    }
}
</script>
<style scoped>

</style>
