<template>
    <v-container>
    <v-row justify="space-around">
        <v-col
            sm="3">
            <v-select
                v-model="filter.status_filter"
                item-value="id"
                item-text="name"
                :items="status"
                dense
                label="Статус рекламации"
                clearable
            ></v-select>
        </v-col>

        <v-col
            sm="3">
            <v-select
                v-model="filter.type_comps_filter"
                item-value="id"
                item-text="name"
                :items="type_comps"
                dense
                label="Статус гарантии"

            ></v-select>
        </v-col>
        <v-col sm="3">
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
                        v-model="filter.data_expenses"
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
                    v-model="filter.data_expenses"
                    multiple
                    type="month"
                    flat
                >
                </v-date-picker>
            </v-menu>
        </v-col>
    </v-row>
    </v-container>

</template>


<script>

import BaseMonthPicker from "./BaseMonthPicker";

export default {
    components: {BaseMonthPicker},
    name: "ComponentFilter",
    props: {
        status: {
            type: Array,
            required: true
        },
        type_comps: {  //гарантия
            type: Array,
            required: true
        },

    },


    data() {
        return {
            filter: {
                data_expenses: [],
                status_filter: '',
                type_comps_filter:'',
            },
            menu: false,
            date: ' ',


        }
    },
    computed:{
      filterComplaint(){
        return this.filter;
      }
    },
    // следить за событиями моделей
    watch: {
        filterComplaint: {
            handler:function(filter) {
                this.$emit('change', filter);
            },
            deep: true
        }
    },

    methods:{
        close() {
            this.$emit('input', false);
        },
    },

}

</script>
