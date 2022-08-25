<!--Затраты-->
<template>
    <v-dialog
        v-if="showDialog"
        :value="value"
        width="300"
        scrollable
        persistent
    >
        <v-card>
            <v-toolbar height="50" elevation="1">
                <span>
                    <v-icon>mdi-card-bulleted-outline</v-icon>
                    Затраты
                </span>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon color="error" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-container>
                <v-card-text>
                    <v-row justify="center"
                    >
                        <v-col
                            v-show="showUser||showAccount"
                            sm="10">
                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :return-value.sync="date"
                                :close-on-content-click="false"
                                transition="fade-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        :value="computedDateFormat"
                                        label="Период затрат"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        dense
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>

                                </template>
                                <v-date-picker
                                    color="teal lighten-2"
                                    v-model="expensesData.start_at"
                                    :error-messages="errors['start_at']"
                                    type="month"
                                    flat
                                >
                                </v-date-picker>
                            </v-menu>


                        </v-col>
                        <v-col sm="10"
                               align="center">
                            <v-text-field
                                v-show="showUser||showAccount"
                                v-model="expensesData.sum"
                                :error-messages="errors['sum']"
                                type="number"
                                label="Сумма затрат за период"
                                value="0"
                                dense
                                hide-spin-buttons
                                outlined
                                suffix="₽">
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <v-subheader>Затраты</v-subheader>
                    <v-divider></v-divider>
                    <v-list>
                        <v-list-item
                            v-for="item in expenses"
                            :key="item.id"
                        >
                            <v-list-item-title>
                                <span class="text-caption">{{ item.start_at }}</span>
                                <v-divider></v-divider>
                                {{ item.sum }}
                            </v-list-item-title>

                            <v-btn icon
                                   @click.stop="destroyExpense(item.id)"
                            >
                                <v-icon small color="red">mdi-bucket</v-icon>
                            </v-btn>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>
                </v-card-text>
            </v-container>

            <v-card-actions  v-show="showUser||showAccount">
                <v-btn
                    :disabled="loading"
                    text
                    @click="close"
                >
                    Отмена
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    :loading="loading"
                    text
                    color="primary"
                    @click="submit"
                >
                    Добавить
                </v-btn>
            </v-card-actions>

        </v-card>

    </v-dialog>


</template>
<script>
import BaseMonthPicker from "./BaseMonthPicker";


export default {
    components: {BaseMonthPicker},
    name: "ExpensesCard",
    props: {
        value: {
            type: Boolean,
            required: true,
        },

        complaint_id: {
            type: Number,
            required: true
        },

    },
    data() {
        return {
            dialog: this.value,

            startExpenses: [],   //массив месяце

            expensesData: {
                complaint_id: this.complaint_id,
                sum: null,
                start_at: null,
            },

            month: new Date().toISOString().substr(0, 7),

            expenses: [],
            errors: {},
            showDialog: false,
            loading: false,
            menu: false,
            date: '',

            monthExpenses: '',
            monthName: '',


            monthStr: '',

            nameMonth: [],


            showUser: false,
            showAccount: false,


        }
    },

    computed: {
        computedDateFormat() {

            if (this.expensesData.start_at != null) {
                this.expensesData.start_at = this.expensesData.start_at + '-01';
                this.monthExpenses = new Date(this.expensesData.start_at);
                this.monthStr = this.getMonth(this.monthExpenses);

                return  this.monthStr;
            }

        }


    },
    created() {             //вызвать при открытии диалога
        this.showDialog = false;
        this.getExpenses();
        this.showUser = this.returnUser();
        this.showAccount = this.returnUserAccount();
        this.showDialog = true;


    },

    methods: {

        getExpenses() {
            api.call(endpoint('complaints.expenses.index', this.complaint_id))
                .then((response) => {
                    this.expenses = response.data;

                    this.expenses = this.expenses.map(function (item) {
                        let str = item.start_at;
                        let mnt = '';
                        mnt = new Date(str);

                        let DataFormat = new Intl.DateTimeFormat("ru", {
                            month: "long",

                        });
                        let res = '';
                        res = DataFormat.format(mnt);
                        let result = res[0].toUpperCase() + res.slice(1);

                        item.start_at = result;
                        return item;

                    });

                });

        },

        submit() {
            this.loading = true;
            api.call(endpoint('complaints.expenses.store', this.complaint_id), this.expensesData)
                .then(response => {
                    this.expensesData = {

                        complaint_id: this.complaint_id,
                        sum: null,

                    };


                })
                .catch(error => {
                    this.errors = error.response.data.errors

                })
                .finally(() => {
                    /// this.expensesData.start_at = this.expensesData.start_at.slice(0,-3);

                    this.getExpenses();
                    this.loading = false;
                })


        },
        close() {
            this.$emit('input', false);
            this.$emit('close-expenses', false);



        },

        destroyExpense(id) {
            api.call(endpoint('complaints.expenses.destroy', id))
                .then((response => {
                    this.getExpenses();
                }))

        },


        getMonth(monthExpenses) {
            let DataFormat = new Intl.DateTimeFormat("ru", {
                month: "long",

            });

            this.monthName = DataFormat.format(monthExpenses)

            return this.capitalize(this.monthName);

        },

        capitalize(value) {
            return value[0].toUpperCase() + value.slice(1);
        },

        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },
        returnUserAccount() {
            return this.$store.getters.userHasRole('account');
        },

    }
}

</script>
