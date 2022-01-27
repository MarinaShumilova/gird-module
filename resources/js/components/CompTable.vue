<template>
    <v-card>
        <v-card maxHeight="70"
                elevation="0">
            <v-row justify="space-around">
                <v-col sm="2">
                    <v-checkbox
                        v-model="selectAll"
                        label="Выбрать все"
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
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="auto"
                    >
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
<!--        основная таблица-->
        <v-data-table
            :headers="headers"
            :items="complaint"
            :search="search"
            :options.sync="options"
            :server-items-length="totalComplaint"
            :loading="loading"
            @click:row="openComponentAddCard"
            dense>
            <template v-slot:top>
                <v-card-title>
                    <v-btn icon>
                        <v-icon>mdi-sync</v-icon>
                    </v-btn>

                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Поиск"
                        single-line
                        hide-details
                        dense
                    ></v-text-field>
                    <v-tooltip bottom>
                        <template v-slot:activator="{on, attrs}">
                            <v-btn icon
                                   v-bind="attrs"
                                   v-on="on"
                                   large>
                                <v-icon color="blue darken-1">mdi-microsoft-excel</v-icon>
                            </v-btn>
                        </template>
                        <span>Выгрузить таблицу</span>
                    </v-tooltip>

                    <v-btn
                        @click.stop="cardCreateDialog = true"
                        color="cyan lighten-1">
                        Новая запись
                    </v-btn>
                </v-card-title>
            </template>


            <template v-slot:item.action="{ item }">

                <v-tooltip bottom>
                    <template v-slot:activator="{on, attrs}">
                        <v-icon
                            v-bind="attrs"
                            v-on="on"
                            small
                            :color="getColor(item.status)"
                        >mdi-octagon
                        </v-icon>
                    </template>
                    <span>Status</span>
                </v-tooltip>


                <v-menu
                    absolute
                    offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            dense
                            icon
                            v-bind="attrs"
                            v-on="on">
                            <v-icon>mdi-menu</v-icon>
                        </v-btn>

                    </template>

                    <v-list
                        width="300"
                        dense
                    >
<!--                        выпадающее меню в таблице-->
                        <v-list-item-group>
                        <v-list-item @click.stop="openExpensesDialog">
                            <v-list-item-icon>
                                <v-icon right>mdi-card-bulleted-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Затраты</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click.stop="openSendFileDialog">
                            <v-list-item-icon>
                                <v-icon right>mdi-shuffle-disabled</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Перенаправить документы</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click.stop="openAddFileDialog">
                            <v-list-item-icon>
                                <v-icon right>mdi-card-plus-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>Прикрепить документы</v-list-item-title>
                        </v-list-item>

                        <v-list-item>

                            <v-list-item-icon>
                                <v-icon right>mdi-close</v-icon>
                            </v-list-item-icon >
                            <v-list-item-content>

                                <v-list-item-title>Завершить</v-list-item-title>
                            </v-list-item-content>

                        </v-list-item>

                        </v-list-item-group>
                    </v-list>

                </v-menu>
<!--если виновна другая сторона-->
                <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                        <v-icon
                            small
                            color="red darken-4"
                            v-bind="attrs"
                            v-on="on"
                        >mdi-email-send-outline
                        </v-icon>
                    </template>
                    <span>Регресс + дата</span>
                </v-tooltip>
<!--затраты-->
                <expenses-card
                    v-if="expensesCreateDialog"
                    v-model="expensesCreateDialog"
                    @expenses-created="expensesCreateDialog = false"
                ></expenses-card>
<!--перенаправить -->
                <send-file
                    v-if="sendFileCreateDialog"
                    v-model="sendFileCreateDialog"
                    @expenses-created="sendFileCreateDialog = false">
                </send-file>
<!--прикрепить документ-->
                <add-file
                    v-if="addFileCreateDialog"
                    v-model="addFileCreateDialog"
                    @expenses-created="addFileCreateDialog = false">
                </add-file>

<!--создание новой записи-->
                <add-card
                    v-if="cardCreateDialog"
                    v-model="cardCreateDialog"
                    @expenses-created="cardCreateDialog= false">
                </add-card>

            </template>


            <template v-slot:item.deleteEntry="{ item }">
                <v-btn
                    dense
                    icon>
                    <v-icon small>mdi-bucket</v-icon>
                </v-btn>
            </template>


        </v-data-table>

<!--        Просмотреть запись-->

        <add-card
            v-if="showNewCardDialog"
            v-model="showNewCardDialog"
            @expenses-created="showNewCardDialog= false"
        ></add-card>




    </v-card>
</template>
<script>
import ExpensesCard from "../components/ExpensesCard";
import SendFile from "./SendFile";
import AddFile from "./AddFile";
import AddCard from "./AddCard";
import BaseMonthPicker from "./BaseMonthPicker";


export default {
    components: { AddCard, ExpensesCard, SendFile, AddFile, BaseMonthPicker},

    data() {
        return {
            type: 'number',
            totalComplaint: 0,
            selectAll: false,    /*Выбор значения из списка*/
            search: '',         /*Поиск*/
            complaint: [],      /*таблица*/
            loading: true,      /*загрузка таблицы*/
            options: {},
            headers: [          /*столбцы таблицы*/
                {
                    text: 'Действия',
                    align: 'start',
                    sortable: false,
                    value: 'action',
                },
                {text: 'Дата создания', value: 'createData'},
                {text: 'Дата закрытия', value: 'closeData'},
                {text: 'Приказ', value: 'order'},
                {text: 'Гарантийный приказ', value: 'orderGuarantee'},
                {text: 'Контрагент', value: 'contractor'},
                {text: 'Причина ГС', value: 'reason'},
                {text: 'Виновная сторона', value: 'faultSide'},
                {text: 'Затраты', value: 'expenses'},
                {text: 'Удалить', value: 'deleteEntry'}
            ],
                /*меню действия*/
            items: [
                {title: 'Затраты', icon: "mdi-cash-fast"},
                {title: 'Перенаправить документы', icon: "mdi-shuffle-disabled"},
                {title: 'Прикрепить документы', icon: "mdi-folder-multiple-plus"},
            ],

            nameStatus: ['В работе', 'Завершен', 'Удален'],


            expensesCreateDialog: false, //затраты
            sendFileCreateDialog: false,  //перенаправить
            addFileCreateDialog: false,   //прикрепить
            cardCreateDialog: false,      /*//запись*/


            date: new Date().toISOString().substr(0, 7),
            menu: false,        /*календарь*/

            //---
            showNewCardDialog: false,     /*просмотр записи*/

        }
    },
    watch: {
        options: {
            handler() {
                this.getDataFromApi()
            },
            deep: true,
        },


    },
    methods: {

        openComponentAddCard(row) {
            this.showNewCardDialog = true;
            //this.id = row.id;
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

        openCardDialog() {
            this.cardCreateDialog = true;
        },


        getDataFromApi() {
            this.loading = true
            this.fakeApiCall().then(data => {
                this.complaint = data.items
                this.totalComplaint = data.total
                this.loading = false
            })
        },
        /*статсус*/
        getColor(status) {

            if (status === 1) return 'blue'
            else if (status === 2) return 'green'
            else return 'red'
        },



        /**
         * In a real application this would be a call to fetch() or axios.get()
         */
        fakeApiCall() {
            return new Promise((resolve, reject) => {
                const {sortBy, sortDesc, page, itemsPerPage} = this.options

                let items = this.getComplaints();
                const total = items.length

                if (sortBy.length === 1 && sortDesc.length === 1) {
                    items = items.sort((a, b) => {
                        const sortA = a[sortBy[0]]
                        const sortB = b[sortBy[0]]

                        if (sortDesc[0]) {
                            if (sortA < sortB) return 1
                            if (sortA > sortB) return -1
                            return 0
                        } else {
                            if (sortA < sortB) return -1
                            if (sortA > sortB) return 1
                            return 0
                        }
                    })
                }

                if (itemsPerPage > 0) {
                    items = items.slice((page - 1) * itemsPerPage, page * itemsPerPage)
                }

                setTimeout(() => {
                    resolve({
                        items,
                        total,
                    })
                }, 1000)
            })
        },

      getComplaints() {
            return [
                {
                    status: 2,
                    action: '',
                    createData: '21.01.21',
                    closeData: '05.06.22',
                    order: '6251',
                    orderGuarantee: '5457',
                    contractor: 'АО "Транснефть-Приволга"',
                    reason: 'Шасси',
                    faultSide: 'Производство',
                    expenses: '26556',

                },
            ]
      },





    },

}
</script>
