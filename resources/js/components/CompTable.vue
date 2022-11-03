<template>
    <v-container fluid>
        <v-row>
            <v-col>
                <base-data-table
                    :fill-height="true"
                    :options.sync="options"
                    :items="complaints"
                    :loading="loading"
                    :meta="meta"
                    :headers="headers"
                    disable-sort
                    dense
                >
                    <template v-slot:top>
                        <v-row class="justify-center">
                            <v-col>
                                <component-filter
                                    :status="statuses"
                                    :type_comps="type_comps"
                                    :warranty_types="warranty_types"
                                    :search="search"
                                    @change="getFilterComplaint"
                                >
                                </component-filter>

                            </v-col>

                        </v-row>

                    </template>

                    <template v-slot:item.culprits="{ item }">
                        <span v-for="culprit in item.culprits">
                            {{ culprit.name }}
                        </span>
                    </template>

                    <template v-slot:item.reasons="{ item }">
                        <span v-for="reason in item.reasons">
                            {{ reason.name }}
                        </span>
                    </template>


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
                                    <v-list-item @click.stop="openExpensesDialog" v-show="showUser||showAccount">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-card-bulleted-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Затраты</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item v-show="showUser||showAccount" @click.stop="openSendFileDialog">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-shuffle-disabled</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Регресс</v-list-item-title>
                                    </v-list-item>
                                    <v-list-item v-show="showUser" @click.stop="openAddFileDialog">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-card-plus-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Прикрепить документы</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item v-show="showUser||showAccount" @click.stop="openEventsDialog">
                                        <v-list-item-icon>
                                            <v-icon right>mdi-inbox-full-outline</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title>Мероприятия</v-list-item-title>
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

                        <p class="text-uppercase">Сумма за период: {{ sumMonth|format }} ₽</p>

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
                            v-show="showUser||showAccount"
                            v-if="sendFileCreateDialog"
                            v-model="sendFileCreateDialog"
                            :compId="editedRow.id"
                            @close-send="closeSendFile">
                        </send-file>
                        <!--   прикрепить документ-->
                        <add-file
                            v-show="showUser"
                            v-if="addFileCreateDialog"
                            v-model="addFileCreateDialog"
                            :comp-id="editedRow.id"
                            @close-add-file="closeAddFile()">
                        </add-file>

                        <component-event
                            v-show="showUser"
                            v-if="eventsCreateDialog"
                            v-model="eventsCreateDialog"
                            :complaint_id="editedRow.id"
                            @close-comments="closeCommentCard">

                        </component-event>

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

                        <!--                        <component-redress-->
                        <!--                            v-show="showUser||showAccount"-->
                        <!--                            v-if="redressCreateDialog"-->
                        <!--                            v-model="redressCreateDialog"-->
                        <!--                            :compId="editedRow.id"-->
                        <!--                        >-->

                        <!--                        </component-redress>-->


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


                    <template v-slot:item.pretension_at="{ item }">
                        {{ item.pretension_at|date }}
                    </template>

                    <template v-slot:item.close_at="{ item }">
                        {{ item.close_at|date }}
                    </template>

                    <template v-slot:item.expense_sum="{ item }">
                        {{ item.expense_sum|format }}

                    </template>


                    <template v-slot:item.action="{ item }">
                        <v-row no-gutters class="flex-nowrap">
                            <v-tooltip bottom>
                                <template v-slot:activator="{on, attrs}">
                                    <v-icon
                                        v-bind="attrs"
                                        v-on="on"
                                        x-small
                                        :color="getColor(item.status_id)"
                                    >mdi-octagon
                                    </v-icon>
                                </template>
                                <span>{{ textStatus(item.status_id) }}</span>
                            </v-tooltip>

                            <v-btn icon
                                   v-show="showUser||showAccount"
                                   @click.stop="show(item, $event)">
                                <v-icon>mdi-menu</v-icon>
                            </v-btn>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon
                                        class="mx-1"
                                        small
                                        @click.stop="openComponentEditCard(item.id)"
                                        v-show="showUser"
                                        v-on="on"
                                    >mdi-pencil
                                    </v-icon>
                                </template>
                                <div class="caption">
                                    Редактировать
                                </div>
                            </v-tooltip>

                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon
                                        v-show="!showUser"
                                        icon
                                        @click.stop="openComponentLookRecord(item.id)"
                                        small
                                        v-on="on"
                                    >mdi-information-outline
                                    </v-icon>
                                </template>
                                <div class="caption">
                                    Информация
                                </div>

                            </v-tooltip>


                            <!--                        комментарий-->
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon small
                                            class="mx-1"
                                            @click.stop="openComponentComment(item.id)"
                                            v-on="on">
                                        mdi-card-account-details-outline

                                    </v-icon>
                                </template>
                                <div class="caption">
                                    Контакты
                                </div>

                            </v-tooltip>

                            <!--                                                если виновна другая сторона-->
                            <v-tooltip right v-if="item.transfer && item.transfer.attachments.length">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon
                                        small
                                        color="red darken-4"
                                        v-bind="attrs"
                                        v-on="on"
                                    >mdi-email-send-outline
                                    </v-icon>
                                </template>
                                <span>Регресс {{ item.transfer.transfer_at |date }}</span>
                            </v-tooltip>
                        </v-row>
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

                    <!--                    <template #footer.prepend>-->
                    <!--                        <span>-->
                    <!--                        Сумма за период:{{ sumMonth|format}}-->
                    <!--                        </span>-->

                    <!--                    </template>-->


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
import BaseDataTable from "gird-base-front/src/components/BaseDataTable"
import filtratable from "../mixins/filtratable"
import LookRecord from "./LookRecord";
import ComponentComment from "./ComponentComment";
import ComponentFilter from "./ComponentFilter";
import ComponentRedress from "./ComponentRedress";
import ComponentEvent from "./ComponentEvent";


export default {
    components: {
        ComponentFilter,
        AddCard, ExpensesCard, SendFile,
        AddFile, BaseMonthPicker, EditCard, LookRecord,
        BaseDataTable, ComponentComment, ComponentRedress, ComponentEvent,
    },


    mixins: [
        filtratable
    ],


    data() {
        return {
            options: {
              page: 1,
              itemsPerPage: 30,
            },

            showMenu: false,
            x: 0,
            y: 0,

            sumMonth: 0,

            showUser: false,
            showAccount: false,

            editedRow: null,   //вернет строку со всеми данными при вызове

            type: 'number',
            selectAll: false,    /*Выбор значения из списка*/

            complaints: [],      /*таблица*/
            loading: false,      /*загрузка таблицы*/
            arrCulprits: [],


            headers: [          /*столбцы таблицы*/
                {
                    text: 'Действия',
                    align: 'start',
                    sortable: false,
                    value: 'action',
                },
                {text: 'Дата заявки', value: 'pretension_at'},
                {text: 'Дата закрытия', value: 'close_at'},
                {text: 'Приказ', value: 'numb_order'},
                {text: 'Гарантийный приказ', value: 'warranty_decree'},
                {text: 'Контрагент', value: 'contractor.name'},
                {text: 'Причина ГС', value: 'reasons'},
                {text: 'Виновная сторона', value: 'culprits'},
                {text: 'Затраты', value: 'expense_sum', cellClass: 'text-no-wrap'},


            ],
            /*меню действия*/
            items: [
                {title: 'Затраты', icon: "mdi-cash-fast"},
                {title: 'Перенаправить документы', icon: "mdi-shuffle-disabled"},
                {title: 'Прикрепить документы', icon: "mdi-folder-multiple-plus"},
            ],


            nameStatus: ['В работе', 'Завершен', 'Удален'],

            expensesCreateDialog: false, //затраты

            eventsCreateDialog: false,

            commentsCreateDialog: false,

            sendFileCreateDialog: false,  //перенаправить
            addFileCreateDialog: false,   //прикрепить
            cardCreateDialog: false,      /*//запись*/
            redressCreateDialog: false,


            date: new Date().toISOString().substr(0, 7),
            menu: false,        /*календарь*/

            //---
            dialogEdit: false,     /*редактировать запись*/
            dialogRecord: false,     /*редактировать запись*/


            rowComplaint: {},
            pagination: {},

            statuses: [],/* статуса из таблицы Статус*/
            type_comps: [],
            warranty_types: [],
            search:'',
            dataFilter: {},

        }
    },
    filters: {
        format: val => val ? `${val}`.replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ') : '',
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

        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },
        returnUserAccount() {
            return this.$store.getters.userHasRole('account');
        },

        //метод, закрыть форму и обновить таблицу
        closeFormMenu(){
            this.getComplaints(this.dataFilter);
        },

        closeExpensesCard() {

            this.getComplaints(this.dataFilter);
        },

        closeSendFile() {
            this.getComplaints();
        },

        closeCommentCard() {
            this.getComplaints();
        },
        closeAddFile() {
            this.getComplaints();
        },

        close() {
            this.dialog = false;
        },

        openComponentEditCard(value) {
            this.dialogEdit = true;
            this.rowComplaint.id = value;

        },

        openComponentLookRecord(id) {     //передать id в компонент
            this.dialogRecord = true;
            this.rowComplaint.id = id;

        },

        openComponentComment(id) {
            this.commentsCreateDialog = true;
            this.rowComplaint.id = id;
        },

        openAddFileDialog(id) {
            this.addFileCreateDialog = true;
            this.rowComplaint.id = id;
        },
        openSendFileDialog(id) {
            this.sendFileCreateDialog = true;
            this.rowComplaint.id = id;
        },
        openRedressDialog(id) {
            this.redressCreateDialog = true;
            this.rowComplaint.id = id;
        },

        openExpensesDialog(id) {
            this.expensesCreateDialog = true;
            this.rowComplaint.id = id;

        },

        openEventsDialog(id) {
            this.eventsCreateDialog = true;
            this.rowComplaint.id = id;
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

        getFilterComplaint(value) {

            this.dataFilter = value;
            if (value !== undefined) {
                this.getComplaints(value);
            }

        },

        textStatus(status_id) {
            // return  this.statuses.find(status => status.id === status_id).name;
            switch (status_id) {
                case 1:
                    return 'В работе';
                case 2:
                    return 'Завершена';
            }
        },

        closeComplaint() {
        },

        /**
         * In a real application this would be a call to fetch() or axios.get()
         */

        /*  Получить данные*/
        getComplaints(input) {
            api.call(endpoint('complaints.index', Object.assign({}, input, this.options)))
                .then(response => {
                    this.complaints = response.data.data;

                    this.sumMonth = this.complaints.map(item => +item.expense_sum).reduce((prev, cur) => prev + cur);
                    this.makePagination(response.data);
                    this.getStatuses();

                })
                .catch(error => {
                    //
                })

        },

        getStatuses() {
            api.call(endpoint('statuses'))
                .then(response => {
                    this.statuses = response.data;

                })

        },

        makePagination(response) {
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
        api.call(endpoint('complaints.create'))
            .then((response) => {
                this.type_comps = response.data.type_comps;
                this.warranty_types = response.data.warranty_types;

            });


        this.showUser = this.returnUser();
        this.showAccount = this.returnUserAccount();

        if (this.showUser)
            this.headers.push({text: 'Удалить', value: 'deleteEntry'});

        this.setDebounce(this.getComplaints);

    },


}
</script>
