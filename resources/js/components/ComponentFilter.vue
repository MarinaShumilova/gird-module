<template>
<span>
    <v-row justify="space-around"
           class="text-caption"
    >
        <v-col
            sm="2">
            <v-text-field
                v-model="filter.search"
                append-icon="mdi-magnify"
                label="Поиск"
                dense
                hide-details
            ></v-text-field>
        </v-col>

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
                v-model="filter.warranty_types"
                item-value="id"
                item-text="name"
                :items="warranty_types"
                dense
                label="Статус гарантии"
                clearable
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

        <v-col sm="1">
            <v-btn
                icon
                 @click.stop="openExcelDialog">
                <v-icon color="blue">
                    mdi-microsoft-excel
                </v-icon>

            </v-btn>


        </v-col>
    </v-row>

        <component-excel
            v-if="dialogExcel"
            v-model="dialogExcel">

        </component-excel>

</span>



</template>


<script>

import BaseMonthPicker from "./BaseMonthPicker";
import ComponentExcel from "./ComponentExcel"

export default {
    components: {BaseMonthPicker,ComponentExcel},
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
        warranty_types: {
            type:Array,
            required:true
        }



    },


    data() {
        return {
            filter: {
                data_expenses: [],
                status_filter: '',
                type_comps_filter:'',
                warranty_types:'',
                search: '',         /*Поиск*/
            },
            menu: false,
            date: ' ',

            dialogExcel:false,
            dialog: this.value,
            loading:false,




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
        openExcelDialog(){
          this.dialogExcel = true;
        },


    },

}

</script>
