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
            <v-card-text >
                <v-row justify="center"
                  >
                    <v-col
                        sm="10">
<!--                        <BaseMonthPicker-->
<!--                            v-model="expensesData.start_at"-->
<!--                            dense-->
<!--                            outlined-->
<!--                            :error-messages="errors['start_at']"-->
<!--                            type="month"-->
<!--                            label="Период">-->
<!--                        </BaseMonthPicker>-->


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
                                    v-model="expensesData.start_at"
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

                                type="month"
                                flat
                            >
                            </v-date-picker>
                        </v-menu>


                    </v-col>
                    <v-col sm="10"
                           align="center">
                        <v-text-field
                            v-model="expensesData.sum"
                            :error-messages="errors['sum']"
                            type="number"
                            label="Сумма затрат за период"
                            value="0"
                            dense
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

        complaint_id:{
            type:Number,
            required: true
        },

    },
    data() {
        return {
            dialog: this.value,
            expensesData:{
                complaint_id: this.complaint_id,
                sum: null,
                start_at:'',
            },

            month: new Date().toISOString().substr(0, 7),

            expenses:[],
            errors: {},
            showDialog:false,
            loading:false,
            menu: false,
            date: ' ',

        }
    },
    created() {             //вызвать при открытии диалога
        this.showDialog = false;
        this.getExpenses();
        this.showDialog = true;
    },

    methods: {

        getExpenses() {
            api.call(endpoint('complaints.expenses.index', this.complaint_id))
                .then((response) => {
                    this.expenses = response.data;



                });

        },

        submit() {
            this.loading = true;

            this.expensesData.start_at = this.expensesData.start_at + '-01';

          api.call(endpoint('complaints.expenses.store', this.complaint_id), this.expensesData)
                .then(response => {
                    this.expensesData = {
                        complaint_id: this.complaint_id,
                        sum: null,
                        start_at:'',
                    };


                })
              .catch(error =>{
                  this.errors = error.response.data.errors

              })
            .finally(()=>{
                this.getExpenses();
                this.loading = false;
            })


        },
        close() {
            this.$emit('input', false);
            this.$emit('close-expenses', false);
            console.log(this.expensesData.start_at)
        },

        destroyExpense(id) {
            api.call(endpoint('complaints.expenses.destroy', id))
                .then((response => {
                    this.getExpenses();
                }))

        },


    }
}

</script>
