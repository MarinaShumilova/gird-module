<!--Компенсация-->
<template>
    <v-row>
        <v-col cols="6"
               v-show="showUser||showAccount">
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
                        outlined
                        v-show="showUser||showAccount"
                        :value="computedDateFormat"
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
        <v-col cols="6"
        >
            <v-text-field
                v-show="showUser||showAccount"
                v-model="redress.expenses_redress"
                :error-messages="errors['expenses_redress']"
                type="number"
                label="Сумма"
                value="0"
                dense
                outlined
                hide-spin-buttons
                suffix="₽"
                hint="компенсации">
            </v-text-field>
        </v-col>
        <v-col cols="12">
            <v-textarea
                v-show="showUser||showAccount"
                :disabled="redress.expenses_redress == null"
                v-model="redress.comment"
                :error-messages="errors['comment']"
                dense
                label="Комментарии"
                outlined
                auto-grow
                rows="2">
            </v-textarea>
        </v-col>

        <v-col class="pa-0">
            <v-card
                v-scroll.self="onScroll"
                class="overflow-y-auto"
                max-height="150"
                elevation="0">
                <v-list class="pa-1">
                    <v-list-item

                        v-for="item in arrResult"
                        :key="item.id">
                        <v-list-item-title dense>
                            <v-row>
                                <v-col cols="3" class="pa-5" align-self="start">
                                    <span>{{ item.redress_at }}</span>
                                </v-col>

                                <v-col cols="3" class="pa-5">
                                    <span>{{ item.expenses_redress }}</span>
                                </v-col>

                                <v-col class="pa-0 ma-0">
                                    <v-textarea
                                        :disabled="!showUser"
                                        :value="item.comment"
                                        rows="1"
                                    ></v-textarea>
                                </v-col>
                            </v-row>

                            <v-divider></v-divider>

                        </v-list-item-title>

                        <v-btn
                            v-show="showUser"
                            icon
                            @click.stop="destroyRedress(item.id)">
                            <v-icon small color="red">mdi-bucket</v-icon>
                        </v-btn>
                    </v-list-item>
                </v-list>
            </v-card>

        </v-col>


    </v-row>

</template>
<script>
import BaseMonthPicker from "./BaseMonthPicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    components: {BaseMonthPicker, BaseFileInput},
    name: "ComponentRedress",
    props: {
        value: {
            type: Object,
            required: true,
        },
        errors: {
            type: Object,
            required: false
        },
        arrResult: {
            type: Array,
            required: true,
        },

    },
    data() {
        return {
            showDialog: false,
            showUser: false,
            showAccount: false,

            menu: false,
            //errors: {},
            redress: this.value,

            scrollInvoked: 0,
            // dialog: this.value,
            // loading: false,
            expenses_list: [],
            date: ' ',
            formater: '',
            monthDate: '',
            month: new Date().toISOString().substr(0, 10),
            monthStr: '',
            monthExpenses: '',
            monthName: '',

        }
    },

    watch: {
        redress(value) {
            this.$emit('input', value);


        },


    },

    computed: {
        computedDateFormat() {

            if (this.redress.redress_at != null) {
                this.redress.redress_at = this.redress.redress_at + '-01';
                this.monthExpenses = new Date(this.redress.redress_at);
                this.monthStr = this.getMonth(this.monthExpenses);

                return this.monthStr;
            }

        }


    },


    created() {
        this.showUser = this.returnUser();
        this.showAccount = this.returnUserAccount();


        this.formater = (new Intl.DateTimeFormat('ru', {month: 'long'}));
        this.monthDate = this.capitalize(this.formater.format(new Date()));

        // this.showUser = this.returnUser();
        this.showDialog = true;


    },
    methods: {
        onScroll() {
            this.scrollInvoked++
        },

        getRedress() {
            this.arrResult.map(function (item) {
                this.redress.redress_at = item.redress_at;

            })
        },

        close() {
            this.$emit('input', false);
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
        destroyRedress(id) {
            api.call(endpoint('complaints.redress.destroy', id))
                .then(response => {
                    this.$emit("delete");
                    //  this.getRedress();
                })
        },


        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },
        returnUserAccount() {
            return this.$store.getters.userHasRole('account');
        },

        deleteRedress() {
            this.$emit('delete', false);
        },
    },
}

</script>
