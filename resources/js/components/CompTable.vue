<template xmlns="http://www.w3.org/1999/html">
    <!--    <v-card>
            <v-card maxHeight="70"
                    elevation="0">
                <v-row justify="space-around">
                    <v-col sm="2">
                        <v-checkbox
                            v-model="selectAll"
                            label="Показать удаленные"
                        ></v-checkbox>
                    </v-col>
                    <v-col
                        sm="3"
                        dense>
                        <v-select
                            :items="nameStatus"
                            label="Статус"
                            multiple
                        ></v-select>
                    </v-col>
                    <v-col sm="3"
                           dense>
                        &lt;!&ndash;                    Период для фильтра&ndash;&gt;
                        <v-menu
                            ref="menu"
                            v-model="menu"
                            :close-on-content-click="false"
                            :return-value.sync="date"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="date"
                                    label="Период"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="date"
                                type="month"
                                no-title
                                scrollable
                                multiple>
                                <v-spacer></v-spacer>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="menu = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.menu.save(date)"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </v-col>
                </v-row>
            </v-card>

        </v-card>-->
    <v-container full-height>
        <v-row>
            <v-col>
                <base-data-table
                    :fill-height="true"
                    :options.sync="options"
                    :items="complaints"
                    :loading="loading"
                    :meta="meta"
                    :headers="headers"
                >

                    <template #footer.prepend>
                        <!--    всплывающее меню-->
                        <v-menu
                            v-if="showMenu"
                            v-model="showMenu"
                            :position-x="x"
                            :position-y="y"
                            absolute
                            offset-y
                        >
                            <v-list
                                width="270"
                                dense
                            >
                                <v-list-item-group>
                                    <v-list-item @click.stop="openExpensesDialog"    v-show="showUser||showAccount">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-card-bulleted-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Затраты</v-list-item-title>
                                    </v-list-item >
                                    <v-list-item  v-show="showUser" @click.stop="openSendFileDialog" >
                                        <v-list-item-icon>
                                            <v-icon right>mdi-shuffle-disabled</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Перенаправить документы</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item v-show="showUser" @click.stop="openAddFileDialog">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-card-plus-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Прикрепить документы</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item v-show="showUser" v-if="editedRow.status_id === 1"
                                                 @click="exitComplaints(editedRow.id)">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-close</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Завершить</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item v-else
                                                 @click="returnComplaints(editedRow.id)">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-share</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title left>Восстанавить</v-list-item-title>
                                    </v-list-item>

                                </v-list-item-group>
                            </v-list>
                        </v-menu>

                        <!--   затраты-->
                        <expenses-card
                            v-show="showUser||showAccount"
                            v-if="expensesCreateDialog"
                            v-model="expensesCreateDialog"
                            @close-expenses="closeExpensesCard"
                            :complaint_id="editedRow.id"
                        ></expenses-card>
                    <!--кооментарий к комплайну-->
                        <component-comment
                            v-if="commentsCreateDialog"
                            v-model="commentsCreateDialog"
                            :complaint_id="rowComplaint.id"
                            @close-comments="closeCommentCard"
                        ></component-comment>

                        <!--    перенаправить -->
                        <send-file
                            v-show="showUser"
                            v-if="sendFileCreateDialog"
                            v-model="sendFileCreateDialog"
                            @expenses-created="sendFileCreateDialog = false"
                            :id="editedRow.id">
                        </send-file>
                        <!--   прикрепить документ-->
                        <add-file
                            v-show="showUser"
                            v-if="addFileCreateDialog"
                            v-model="addFileCreateDialog"
                            :id="editedRow.id">
                        </add-file>

                        <add-card
                            v-show="showUser"
                            v-if="cardCreateDialog"
                            v-model="cardCreateDialog"
                            :id="rowComplaint.id"
                            @store-complaint="getComplaints"
                            @expenses-created="cardCreateDialog= false">
                        </add-card>

                        <!--   Просмотреть запись-->

                        <edit-card
                            v-if="dialogEdit"
                            v-model="dialogEdit"
                            :id="rowComplaint.id"
                            @store-complaint="getComplaints"
                            @expenses-created="dialogEdit = false"
                        ></edit-card>

                        <look-record
                            v-if="dialogRecord"
                            v-model="dialogRecord"
                            :id="rowComplaint.id"
                            @store-complaint="getComplaints"
                            @expenses-created="dialogRecord= false">

                        </look-record>


                    </template>
                    <template v-slot:item.deleteEntry="{item}">
                    <v-btn
                        icon
                        @click.stop="destroyMy(item.id)"
                        v-show="showUser"
                    >
                        <v-icon small
                                color="red">
                            mdi-bucket
                        </v-icon>
                    </v-btn>
                    </template>


                    <template v-slot:item.start_at="{ item }">
                        {{ item.start_at | date }}
                    </template>

                    <template v-slot:item.close_at="{ item }">
                        {{ item.close_at | date }}
                    </template>


                    <template v-slot:item.action="{ item }">
                        <v-tooltip bottom>
                            <template v-slot:activator="{on, attrs}">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    small
                                    :color="getColor(item.status_id)"
                                >mdi-octagon
                                </v-icon>
                            </template>
                            <span>{{textStatus(item.status_id)}}</span>
                        </v-tooltip>

                        <v-tooltip right >
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    @click.stop="openComponentEditCard(item.id)"
                                    v-show="showUser"
                                >
                                    <v-icon
                                        dense
                                    >mdi-pencil
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Редактировать</span>

                        </v-tooltip>

                                <v-btn
                                    v-show="!showUser"
                                    icon
                                    @click.stop="openComponentLookRecord(item.id)"
                                >
                                    <v-icon
                                        dense
                                    >mdi-information-outline
                                    </v-icon>
                                </v-btn>

                        <v-btn icon
                               v-show="showUser||showAccount"
                               @click.stop="show(item, $event)">
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>
<!--                        комментарий-->
                        <v-btn icon
                               @click.stop="openComponentComment(item.id)">
                            <v-icon>
                                mdi-comment-processing-outline
                            </v-icon>
                        </v-btn>




                        <!--                        если виновна другая сторона-->
<!--                        <v-tooltip right>-->
<!--                            <template v-slot:activator="{ on, attrs }">-->
<!--                                <v-icon-->
<!--                                    small-->
<!--                                    color="red darken-4"-->
<!--                                    v-bind="attrs"-->
<!--                                    v-on="on"-->
<!--                                >mdi-email-send-outline-->
<!--                                </v-icon>-->
<!--                            </template>-->
<!--                            <span>Регресс + дата</span>-->
<!--                        </v-tooltip>-->

                    </template>

                    <template #footer.append
                    >
                        <v-tooltip
                            top
                            color="cyan lighten-3">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    v-show="showUser"
                                    @click.stop="cardCreateDialog = true"
                                    color="cyan lighten-1"
                                    height="28"
                                    min-width="50"
                                    v-bind="attrs"
                                    v-on="on">
                                    <v-icon>
                                        mdi-plus
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span style="color: #8e3939">
                              Добавить</span>
                        </v-tooltip>

                    </template>



                </base-data-table>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>

import ExpensesCard from "../components/ExpensesCard";
import SendFile from "./SendFile";
import AddFile from "./AddFile";
import AddCard from "./AddCard";
import BaseMonthPicker from "./BaseMonthPicker";
import EditCard from "./EditCard";
import DeleteComplain from "./DeleteComplain"
import BaseDataTable from "gird-base-front/src/components/BaseDataTable"
import filtratable from "../mixins/filtratable"
import LookRecord from "./LookRecord";
import ComponentComment from "./ComponentComment";


export default {
    components: {

        AddCard, ExpensesCard, SendFile,
        AddFile, BaseMonthPicker, EditCard,
        DeleteComplain, LookRecord,
        BaseDataTable,ComponentComment,
    },

    mixins:[
        filtratable
    ],

    data() {
        return {
            showMenu: false,
            x: 0,
            y: 0,

            showUser:false,
            showAccount:false,

            editedRow: null,   //вернет строку со всеми данными при вызове

            type: 'number',
            selectAll: false,    /*Выбор значения из списка*/
            search: '',         /*Поиск*/
            complaints: [],      /*таблица*/
            loading: false,      /*загрузка таблицы*/
            headers: [          /*столбцы таблицы*/
                {
                    text: 'Действия',
                    align: 'start',
                    sortable: false,
                    value: 'action',
                },
                {text: 'Дата создания', value: 'start_at' },
                {text: 'Дата закрытия', value: 'close_at'},
                {text: 'Приказ', value: 'numb_order'},
                {text: 'Гарантийный приказ', value: 'warranty_decree'},
                {text: 'Контрагент', value: 'contractor.name'},
                {text: 'Причина ГС', value: 'reason.name'},
                {text: 'Виновная сторона', value: 'culprit.name'},
                {text: 'Затраты', value: 'expense_sum'},


            ],
            /*меню действия*/
            items: [
                {title: 'Затраты', icon: "mdi-cash-fast"},
                {title: 'Перенаправить документы', icon: "mdi-shuffle-disabled"},
                {title: 'Прикрепить документы', icon: "mdi-folder-multiple-plus"},
            ],

            nameStatus: ['В работе', 'Завершен', 'Удален'],

            expensesCreateDialog: false, //затраты

            commentsCreateDialog:false,

            sendFileCreateDialog: false,  //перенаправить
            addFileCreateDialog: false,   //прикрепить
            cardCreateDialog: false,      /*//запись*/


            date: new Date().toISOString().substr(0, 7),
            menu: false,        /*календарь*/

            //---
            dialogEdit: false,     /*редактировать запись*/
            dialogRecord: false,     /*редактировать запись*/


            rowComplaint: {},
            pagination:{},

            statuses: [],/* статуса из таблицы Статус*/

        }
    },

    watch: {},
    methods: {
   /*      открыть форму редактирования и загрузить данные с таблицы */

        show(item, e) {

            this.editedRow = item;

            e.preventDefault()
            this.showMenu = false
            this.x = e.clientX
            this.y = e.clientY
            this.$nextTick(() => {
                this.showMenu = true
            })
        },


        returnUser(){
            return this.$store.getters.userHasRole('admin');
        },
        returnUserAccount(){
            return this.$store.getters.userHasRole('account');
        },


        closeExpensesCard(){
            this.getComplaints();
        },
        closeCommentCard(){
            this.getComplaints();
        },
        close() {
            this.dialog = false;
        },

        openComponentEditCard(value) {
            this.dialogEdit = true;
            this.rowComplaint.id = value;

        },

        openComponentLookRecord(id){     //передать id в компонент
          this.dialogRecord = true;
          this.rowComplaint.id = id;

        },

        openComponentComment(id){
          this.commentsCreateDialog = true;
          this.rowComplaint.id = id;
        },

        openAddFileDialog(id) {
            this.addFileCreateDialog = true;
            this.rowComplaint.id = id;
        },
        openSendFileDialog() {
            this.sendFileCreateDialog = true;
        },

        openExpensesDialog() {
            this.expensesCreateDialog = true;

        },

        openCardDialog() {
            this.cardCreateDialog = true;
        },/*
        /*статсус*/
        getColor(status_id) {
            switch (status_id) {
                case 1:
                    return 'blue lighten-1';
                case 2:
                    return 'teal lighten-1';

            }

        },

        textStatus(status_id) {
           // return  this.statuses.find(status => status.id === status_id).name;
            switch (status_id) {
                case 1:
                    return 'В работе';
                case 2:
                    return 'Завершен';
            }
        },

        closeComplaint() {

        },

        /**
         * In a real application this would be a call to fetch() or axios.get()
         */
        /*  Получить данные*/
        getComplaints() {
            api.call(endpoint('complaints.index', this.params))
                .then(response => {
                    this.complaints = response.data.data;
                    this.makePagination(response.data);
                    this.getStatuses();
                })
                .catch(error => {
                    //
                })

        },

        getStatuses(){
          api.call(endpoint('statuses'))
                .then(response =>{
                    this.statuses = response.data;

                })
        },


        makePagination(response){
            this.meta = {
                current_page: response.current_page,
                last_page: response.last_page,
                prev_page_url: response.prev_page_url,
                next_page_url: response.next_page_url,
                from: response.from,
                to: response.to,
                total: response.total
            }
        },


        /*
        удалить комплайн*/
        destroyMy(id) {
            api.call(endpoint('complaints.destroy', id))
                .then((response => {
                    // перезагрузить id
                    this.getComplaints();

                }))

        },
        /* завершить */
        exitComplaints(id) {
            api.call(endpoint('complaints.finish', id))
                .then((response => {
                    this.getComplaints();
                }))


        },
        /* восстановить*/
        returnComplaints(id) {
            api.call(endpoint('complaints.return', id))
                .then((response => {
                    this.getComplaints();
                }))
        },


    },

    created() {

        this.showUser = this.returnUser();
        this.showAccount = this.returnUserAccount();

        if(this.showUser)
            this.headers.push( {text: 'Удалить', value: 'deleteEntry'});

        this.setDebounce(this.getComplaints);

    },


}
</script>
