<!--Компенсация-->
<template>
    <v-dialog
        v-if="showDialog"
        :value="value"
        width="400"
        scrollable
        persistent>
        <v-card>
            <v-toolbar
                elevation="1"
                height="50">
                <span>
                    <v-icon>mdi-cash-multiple</v-icon>
                   Компенсация
                </span>
                <v-spacer></v-spacer>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-container>
                <v-card-text>
                    <v-row>
                        <v-col sm="5" v-show="showUser">
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
                                        v-show="showUser||showAccount"
                                        v-model="redress.redress_at"
                                        label="Период компенсации"
                                        prepend-icon="mdi-calendar"
                                        readonly
                                        dense
                                        v-bind="attrs"
                                        v-on="on"
                                    ></v-text-field>
                                </template>
                                    <v-date-picker
                                        color="teal lighten-2"
                                        v-model="redress.redress_at"
                                        :error-messages="errors['redress_at']"
                                        type="month"
                                        flat
                                    >
                                    </v-date-picker>
                            </v-menu>
                        </v-col>
                        <v-col sm="7"
                               align="right">
                            <v-text-field
                                v-show="showUser||showAccount"
                                v-model="redress.expenses_redress"
                                :error-messages="errors['expenses_redress']"
                                type="number"
                                label="Сумма компенсации"
                                value="0"
                                dense
                                outlined
                                hide-spin-buttons
                                suffix="₽">
                            </v-text-field>
                        </v-col>
                        <v-col sm="12"
                               align="center">
                            <v-list>
                                <v-list-item
                                    v-for="item in expenses_list"
                                    :key="item.id"
                                >
                                    <v-list-item-title>{{ item.expenses_redress}}
                                        <v-divider></v-divider>
                                    </v-list-item-title>
                                    <v-btn icon
                                           @click.stop="destroyRedress(item.id)"
                                    >
                                        <v-icon small color="red">mdi-bucket</v-icon>
                                    </v-btn>
                                </v-list-item>
                            </v-list>
                        </v-col>

                        <v-col sm="12">
                            <v-textarea
                                :disabled="!showUser"
                                v-model="redress.comment"
                                :error-messages="errors['comment']"
                                dense
                                label="Комментарии"
                                outlined
                                auto-grow

                                rows="2">
                            </v-textarea>

                        </v-col>

                    </v-row>

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
                            v-show="showUser"
                            :loading="loading"
                            text
                            color="primary"
                            @click="submit"
                        >
                            Сохранить
                        </v-btn>
                    </v-card-actions>
                </v-card-text>

            </v-container>
        </v-card>

    </v-dialog>
</template>
<script>
import BaseMonthPicker from "./BaseMonthPicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    components: {BaseMonthPicker, BaseFileInput},
    name: "ComponentRedress",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        compId: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            showDialog: false,

            showUser:false,
            showAccount: false,

            menu: false,

            errors: {},

            dialog: this.value,
            loading: false,
            expenses_list: [],
            date:' ',
            formater:'',
            monthDate:'',
            month: new Date().toISOString().substr(0, 10),


            redress: {
                redress_at:'',
                complaint_id: this.compId,
                comment: '',
                expenses_redress: null,
            },


        }
    },
    created() {
        this.showDialog = false;
        this.getRedress();
        this.showUser = this.returnUser();
        this.showAccount = this.returnUserAccount();


        this.formater = (new Intl.DateTimeFormat('ru', {month:'long'}));
        this.monthDate = this.capitalize(this.formater.format(new Date()));

        this.showUser = this.returnUser();
        this.showDialog = true;

    },
    methods: {
        getRedress() {
            api.call(endpoint('complaints.redress.index', this.compId))
                .then((response) => {
                     this.expenses_list = response.data;


                });

        },

        submit() {
            this.loading = true;
            this.redress.redress_at = this.redress.redress_at + '-01';
            this.monthRedress = new Date(this.redress.redress_at);

            this.monthName = this.getMonth(this.monthRedress);

            api.call(endpoint('complaints.redress.store', this.compId), this.redress)
                .then(response => {
                    this.redress = {
                        redress_at: '',
                        complaint_id: this.compId,
                        comment: '',
                        expenses_redress: null,
                    };

                })
                .catch(error =>{
                    this.errors = error.response.data.errors
                })
                .finally(()=>{
                    this.getRedress();
                    this.loading = false;
                })


        },

        close() {
            this.$emit('input', false);
        },

        destroyRedress(id){
            api.call(endpoint('complaints.redress.destroy',id))
            .then(response=>{
                this.getRedress();
            })
        },

        capitalize(value) {
            return value[0].toUpperCase() + value.slice(1);
        },

        getMonth(monthRedress) {
            let DataFormat = new Intl.DateTimeFormat("ru", {
                month: "long",

            });

            return this.capitalize(DataFormat.format(monthRedress));

        },


        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },
        returnUserAccount() {
            return this.$store.getters.userHasRole('account');
        },

    },
}

</script>
