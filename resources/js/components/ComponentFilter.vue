<template>
    <v-row dense>
        <v-col cols="2">
            <contractor-select
                v-model="filter.contractor_search"
                label="Контрагент"
                dense
                outlined>
            </contractor-select>
        </v-col>
        <v-col
            cols="1">
            <v-text-field
                v-model="filter.search"
                label="Приказ"
                dense
                hide-details
                outlined
            ></v-text-field>
        </v-col>
        <v-col
            cols="1">
            <v-text-field
                v-model="filter.chassis_filter"
                label="Шасси"
                dense
                hide-details
                outlined
            ></v-text-field>
        </v-col>

        <v-col
            cols="2">
            <v-text-field
                v-model="filter.warranty_decree_filter"
                append-icon="mdi-magnify"
                label="Гар-ый приказ"
                dense
                hide-details
                outlined
            ></v-text-field>
        </v-col>


        <v-col
            cols="1">
            <v-select
                v-model="filter.status_filter"
                item-value="id"
                item-text="name"
                :items="status"
                outlined
                dense
                label="Статус рекламации"
                clearable
            ></v-select>
        </v-col>

<!--        изменения колонки на 1-->
        <v-col
            cols="1">
            <v-select
                v-model="filter.warranty_types"
                item-value="id"
                item-text="name"
                :items="warranty_types"
                dense
                outlined
                label="Статус гарантии"
                clearable
            ></v-select>
        </v-col>
        <v-col
        cols = '1'>
            <v-text-field
                v-model="filter.commentstatuses_filter"
                label="Комментарий"
                dense
                outlined
            ></v-text-field>
        </v-col>
        <v-col cols="2">
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
                        readonly
                        outlined
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

        <v-col sm="1">
            <v-btn
                icon
                @click.stop="openExcelDialog">
                <v-icon color="blue">
                    mdi-microsoft-excel
                </v-icon>

            </v-btn>


        </v-col>

        <component-excel
            v-if="dialogExcel"
            v-model="dialogExcel">
        </component-excel>

    </v-row>


</template>


<script>

import BaseMonthPicker from "./BaseMonthPicker";
import ComponentExcel from "./ComponentExcel"
import ContractorSelect from "./ContractorSelect";

export default {
    components: {BaseMonthPicker, ComponentExcel, ContractorSelect},
    name: "ComponentFilter",
    props: {
        status: {
            type: Array,
            required: true
        },

        warranty_types: {
            type: Array,
            required: true
        }


    },


    data() {
        return {
            filter: {
                data_expenses: [],
                status_filter: '',
                type_comps_filter: '',
                warranty_types: '',
                search: '',         /*Поиск*/
                contractor_search: '',
                warranty_decree_filter:'',
                chassis_filter:'',
                commentstatuses_filter:'',
            },
            menu: false,
            date: ' ',

            dialogExcel: false,
            dialog: this.value,
            loading: false,


        }
    },
    computed: {
        filterComplaint() {
            return this.filter;
        }
    },
    // следить за событиями моделей
    watch: {
        filterComplaint: {
            handler: function (filter) {
                this.$emit('change', filter);
            },
            deep: true
        }
    },

    methods: {
        close() {
            this.$emit('input', false);

        },
        openExcelDialog() {
            this.dialogExcel = true;
        },


    },

}

</script>
