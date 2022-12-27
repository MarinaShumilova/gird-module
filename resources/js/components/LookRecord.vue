<template>
    <v-dialog
        v-if="showDialog"
        v-model="dialog"
        max-width="800"
        persistent
    >
        <v-card
            min-width="600">

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
                    <v-col cols="1">
                        <v-tooltip
                            color="light-blue darken-4"
                            top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-bind="attrs"
                                    v-on="on"
                                    icon
                                    @click.stop="openAddFileDialog">
                                    <v-icon
                                        @mouseenter="iconColor.d4='light-blue darken'"
                                        @mouseleave="iconColor.d4=''"
                                        :color="iconColor.d4"
                                    >
                                        mdi-folder-information-outline
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Прикрепленные документы</span>
                        </v-tooltip>
                        <br>

                        <v-tooltip
                            color="light-blue darken-4"
                            top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click.stop="openSendFileDialog">
                                    <v-icon  @mouseenter="iconColor.d3='red darken'"
                                             @mouseleave="iconColor.d3=''"
                                             :color="iconColor.d3">
                                        mdi-folder-move-outline
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Перенаправленные документы</span>
                        </v-tooltip>
                        <br>

                        <v-tooltip
                            color="light-blue darken-4"
                            top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click.stop="openExpensesDialog">
                                    <v-icon
                                        @mouseenter="iconColor.d1='teal lighten'"
                                        @mouseleave="iconColor.d1=''"
                                        :color="iconColor.d1"
                                    >
                                        mdi-card-bulleted-outline
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Затраты</span>
                        </v-tooltip>




                    </v-col>
                    <v-divider vertical>

                    </v-divider>

                    <v-col cols="11">
                        <v-card-text>
                            <v-row v-for="(row, index) in rows" :key="index">
                                <v-col cols="4">{{ row.name }}</v-col>
                                <v-col cols="8">{{ row.value }}</v-col>
                            </v-row>
                            <br>

                            <v-divider></v-divider>
                            Мероприятия по гарантийному случаю:

                            <v-col >
                                <v-list>
                                    <v-list-item
                                        v-for="item in arrResult"
                                        :key="item.id"
                                        v-if="item.warranty != null">
                                            <v-row class="pt-2" align-self="start">
                                                <v-col cols="10" class="pt-2" align-self="start">
                                                    {{ item.warranty}}
                                                </v-col>
                                                <v-col cols="2" class="pt-2" align-self="start">
                                                    {{ item.created_at| date }}
                                                </v-col>
                                            </v-row>

                                    </v-list-item>
                                </v-list>

                            </v-col>
                            <v-divider></v-divider>
                            Мероприятия на предотвращение:

                            <v-col >
                                <v-list>
                                    <v-list-item
                                        v-for="item in arrResult"
                                        :key="item.id"
                                        v-if="item.prevention != null">
                                        <v-row class="pt-2" align-self="start">
                                            <v-col cols="10">
                                                {{ item.prevention }}
                                            </v-col>
                                            <v-col cols="2" class="pt-2" align-self="start">
                                                {{ item.created_at| date }}
                                            </v-col>
                                        </v-row>
                                    </v-list-item>
                                </v-list>

                            </v-col>


                        </v-card-text>

                    </v-col>

                </v-row>
            </v-card-text>


        </v-card>

        <add-file
            v-if="addFileCreateDialog"
            v-model="addFileCreateDialog"
            :comp-id="id">
        </add-file>
        <send-file
            v-if="sendFileCreateDialog"
            v-model="sendFileCreateDialog"
            :compId="id">
        </send-file>
        <!--   затраты-->
        <expenses-card
            v-if="expensesCreateDialog"
            v-model="expensesCreateDialog"
            :complaint_id="id"
        ></expenses-card>

        <component-redress
            v-if="redressCreateDialog"
            v-model="redressCreateDialog"
            :compId="id">
        </component-redress>


    </v-dialog>
</template>
<script>

import AddFile from "./AddFile";
import SendFile from "./SendFile";
import ExpensesCard from "./ExpensesCard";
import ComponentRedress from "./ComponentRedress";
import ComponentEvent from "./ComponentEvent";

export default {
    components: {AddFile, SendFile,ExpensesCard,ComponentRedress,ComponentEvent},
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
                this.type_comp_name = response.data.type_comp_name;
                this.executors = response.data.executors;
                this.reasons = response.data.reasons;
                this.culprits = response.data.culprits;
                this.contractor_name = response.data.contractor_name;
               // this.provider_name = response.data.provider_name;
               // this.sideCompanies = response.data.sideCompanies;

                this.chassises = response.data.chassises;
                this.complaint = response.data.complaint;
                this.executor_id = response.data.executor_id.join(', ');
                this.reason_id = response.data.reason_id.join(', ');
                this.culprit_id = response.data.culprit_id.join(', ');
                this.showDialog = true;
                this.complaint.chassises = this.complaint.chassises.map(function (item) {
                    return item.number
                }).join(', '),

                this.complaint.sideCompanies = this.complaint.sideCompanies.map(function (item) {
                    return item
                }).join(', ')

                this.getEvents();

            });


    },
    data() {
        return {
            iconColor: {
                d1:'',
                d2:'',
                d3:'',
                d4:'',
            },


            insert: true,
            showDialog: false,
            items: [
                {title: 'Приказ'},

            ],
            complaint: {},  //объект с данными
            dialog: this.value,

            arrResult:[],


            addFileCreateDialog: false,   //прикрепить
            sendFileCreateDialog: false,
            expensesCreateDialog: false, //затраты
            redressCreateDialog: false,
            eventsCreateDialog:false,


        }
    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        },
    },

    computed: {
        rows() {
            return [
                {name:'Приказ:', value:this.complaint.numb_order},
                {name:'Дата приказа:', value:this.complaint.order_at.replace(/^(\d+)-(\d+)-(\d+)$/, `$3.$2.$1`)},
                {name:'Дата заявки:', value:this.complaint.start_at.replace(/^(\d+)-(\d+)-(\d+)$/, `$3.$2.$1`)},
                {name:'Гарантийный приказ:', value:this.complaint.warranty_decree},
                {name:'Гарантия:', value:this.warranty_type_name},
                {name:'Признание случая:', value:this.type_comp_name},
                {name:'Контрагент:', value:this.contractor_name},
                {name:'Причина гарантии:', value:this.reason_id},
                {name:'Вид надстройки:', value:this.complaint.vehicle},
                {name:'Устранение:', value:this.executor_id},
                {name:'Командировка', value:this.complaint.tripTo},
                {name:'Сторонняя организация', value:this.complaint.sideCompanies},
                {name:'Дата отгрузки шасси:', value:this.complaint.unload_at.replace(/^(\d+)-(\d+)-(\d+)$/, `$3.$2.$1`)},
                {name:'Шасси:', value:this.complaint.chassises},
                {name:'Виновник:', value:this.culprit_id},
                {name:'Поставщик:', value:this.complaint.providers},
            ];
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

        getTransfer() {
            api.call(endpoint('complaints.transfer.index', this.id))
                .then((response) => {
                    this.redirectFile.comment = response.data.comment;
                    this.files = response.data.attachments;
                    this.idTransfer = response.data.id;


                });
        },

        getEvents() {
            api.call(endpoint('complaints.events.index', this.id))
                .then((response) => {
                    this.arrResult = response.data;

                });
        },

        openAddFileDialog() {
            this.addFileCreateDialog = true;
        },
        openSendFileDialog() {
            this.sendFileCreateDialog = true;
        },
        openExpensesDialog() {
            this.expensesCreateDialog = true;

        },

        openRedressDialog() {
            this.redressCreateDialog = true;
        },

        openEventDialog() {
          this.eventsCreateDialog = true;
        },

        close() {
            this.$emit('input', false);
        }
    }
}
</script>
<style scoped>

</style>
