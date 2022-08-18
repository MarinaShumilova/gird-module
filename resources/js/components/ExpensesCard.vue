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
                        <v-col  v-show="showUser"
                            sm="10">
                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                :return-value.sync="date"
                                transition="fade-transition"
                                offset-y
                                max-width="290px"
                                min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="monthDate"
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
                               v-show="showUser"
                               align="center">
                            <v-text-field
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
                            <v-list-item-title>{{ item.sum }}
                                <v-divider></v-divider>
                            </v-list-item-title>

                            <v-btn icon  v-show="showUser"
                                   @click.stop="destroyExpense(item.id)"
                            >
                                <v-icon small color="red">mdi-bucket</v-icon>
                            </v-btn>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>
                </v-card-text>
            </v-container>

            <v-card-actions>
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
                    v-show="showUser"
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
            expensesData: {
                complaint_id: this.complaint_id,
                sum: null,
                start_at: '',
            },

            month: new Date().toISOString().substr(0, 10),
            monthDate:'',
            expenses: [],
            errors: {},
            showDialog: false,
            loading: false,
            menu: false,
            date: ' ',

            monthExpenses: '',
            monthName: '',
            formater:'',

            showUser:false,
            showAccount: false,




        }
    },
    created() {             //вызвать при открытии диалога
        this.showDialog = false;
        this.getExpenses();
        this.showDialog = true;

        this.formater = (new Intl.DateTimeFormat('ru', {month:'long'}));
        this.monthDate = this.capitalize(this.formater.format(new Date()));

        this.showUser = this.returnUser();
    },

    methods: {

        getExpenses() {
            api.call(endpoint('complaints.expenses.index', this.complaint_id))
                .then((response) => {
                    this.expenses = response.data;
                   // this.month = this.getMonth(this.month);

                });

        },

        submit() {
            this.loading = true;
            this.expensesData.start_at = this.expensesData.start_at + '-01';
            this.monthExpenses = new Date(this.expensesData.start_at);

            this.monthName = this.getMonth(this.monthExpenses);


            api.call(endpoint('complaints.expenses.store', this.complaint_id), this.expensesData)
                .then(response => {
                    this.expensesData = {
                        complaint_id: this.complaint_id,
                        sum: null,
                        start_at: '',
                    };


                })
                .catch(error => {
                    this.errors = error.response.data.errors

                })
                .finally(() => {
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

            return this.capitalize(DataFormat.format(monthExpenses));

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
