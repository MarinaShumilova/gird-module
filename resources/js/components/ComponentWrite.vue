<!--Компонент(Завести новую запись)-->
<template>
    <v-form>
            <v-row dense>
                <v-col
                cols="12">
                </v-col>
                <v-col
                    sm="12"
                    lg="2"
                    class="d-flex">
                    <v-text-field
                        v-model="complaint.numb_order"
                        item-value="id"
                        label="Приказ"
                        :error-messages="errors['numb_order']"
                        outlined
                        type="number"
                        dense
                        hide-spin-buttons
                    ></v-text-field>
                </v-col>
                <v-col
                    sm="12"
                    lg="2">
                    <base-date-picker
                        v-model="complaint.order_at"
                        :error-messages="errors['order_at']"
                        dense
                        outlined
                        label="Дата приказа">
                    </base-date-picker>
                </v-col>
                <v-col
                    sm="12"
                    lg="4"
                  >
                    <v-text-field
                        v-model="complaint.warranty_decree"
                        item-value="id"
                        item-text="number"
                        label="№ Гарантийного приказа"
                        outlined
                        type="number"
                        dense
                        hide-spin-buttons
                    ></v-text-field>
                </v-col>

                <v-col
                    sm="6"
                    lg="4">
                    <base-date-picker
                        v-model="complaint.start_at"
                        :error-messages="errors['start_at']"
                        dense
                        outlined
                        label="Дата гарантийного приказа">

                    </base-date-picker>
                </v-col>

                <v-col sm="4">
                    <v-select
                        v-model="complaint.warranty_type_id"
                        :error-messages="errors['warranty_type_id']"
                        item-value="id"
                        item-text="name"
                        :items="warrantyTypes"
                        label="Гарантия"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.reason_id"
                        :error-messages="errors['reason_id']"
                        item-value="id"
                        item-text="name"
                        :items="reasons"
                        label="Подразделение-виновник"
                        dense
                        outlined
                        multiple
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.type_comp_id"
                        :error-messages="errors['type_comp_id']"
                        item-value="id"
                        item-text="name"
                        :items="type_comps"
                        label="Признание случая"
                        dense
                        outlined
                    ></v-select>
                </v-col>
                <v-col
                    sm="4">
<!--                    модель-->
                    <v-text-field
                        v-model="complaint.numb_pretension"
                        :error-messages="errors['numb_pretension']"
                        item-value="id"
                        item-text="number"
                        label="№ Входящей претензии"
                        outlined
                        type="number"
                        dense
                        hide-spin-buttons
                    ></v-text-field>

                </v-col>
                <v-col
                sm="3">
<!--                    добавить вал-ию/модель-->
                    <base-date-picker
                        v-model="complaint.pretension_at"
                        :error-messages="errors['pretension_at']"
                        dense
                        outlined
                        label="Дата поступления">
                    </base-date-picker>
                </v-col>
                <v-col
                    sm="5">
                    <contractor-select
                        v-model="complaint.contractor_id"
                        :error-messages="errors['contractor_id']"
                        label="Заказчик(Потребитель)"
                        :items="contractors"
                        dense
                        outlined
                    >
                    </contractor-select>

<!--                    <v-select-->
<!--                        v-model="complaint.contractor_id"-->
<!--                        item-value="id"-->
<!--                        item-text="name"-->
<!--                        dense-->
<!--                        :items="contractors"-->
<!--                        outlined-->
<!--                        label="Заказчик"-->
<!--                        rows="1"-->
<!--                    ></v-select>-->

                </v-col>
                <v-col
                    sm="4">
                    <v-select
                        v-model="complaint.culprit_id"
                        :error-messages="errors['culprit_id']"
                        item-value="id"
                        item-text="name"
                        :items="culprits"
                        label="Виновник дефекта"
                        dense
                        outlined
                        multiple
                        @input="getCulprits"
                    ></v-select>

                </v-col>
                <v-col v-show="this.provider"

                sm="4">
                    <contractor-select
                        v-model="complaint.provider_id"
                        :error-messages="errors['provider_id']"
                        label="Поставщик"
                        :items="contractors"
                        dense
                        outlined
                    >
                    </contractor-select>
<!--                    <v-select-->
<!--                        v-model="complaint.provider_id"-->
<!--                        item-value="id"-->
<!--                        item-text="name"-->
<!--                        dense-->
<!--                        :items="providers"-->
<!--                        outlined-->
<!--                        label="Поставщик"-->
<!--                        rows="1"-->
<!--                    ></v-select>-->
                </v-col>
                <v-col
                    sm="4">
                    <v-select

                        v-model="complaint.executor_id"
                        :error-messages="errors['executor_id']"
                        item-value="id"
                        item-text="name"
                        :items="executors"
                        label="Устранение(Действие)"
                        outlined
                        multiple
                        dense
                    >

                    </v-select>

                </v-col>
                <v-col
                sm="4">
                        <base-date-picker
                            v-model="complaint.unload_at"
                            :error-messages="errors['unload_at']"
                            dense
                            outlined
                            label="Дата отгрузки шасси">
                        </base-date-picker>
                </v-col>
                <v-col
                    sm="4">

                    <v-combobox
                        v-model="complaint.chassises"
                        :error-messages="errors['chassises']"
                        label="Шасси"
                        :items="chassises"
                        small-chips
                        dense
                        solo
                        multiple
                        hide-selected
                        hide-spin-buttons
                        type="number"

                    >
                    </v-combobox>

                </v-col>

                <v-col
                sm="4">
                    <v-textarea
                        v-model="complaint.vehicle"
                        auto-grow
                        item-text="name"
                        :error-messages="errors['vehicle']"
                        dense
                        outlined
                        label="Суть претензии"
                        rows="1"
                    ></v-textarea>
                </v-col>



            </v-row>


    </v-form>

</template>
<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";
import ContractorSelect from "./ContractorSelect";

export default {
    name: "ComponentWrite",
    components: {BaseDatePicker, BaseFileInput,ContractorSelect},
    props: {
        errors: {
          type:Object,
          required:false
        },
        warrantyTypes: {  //гарантия
            type: Array,
            required: true
        },
        reasons: { //причина гарантии
            type: Array,
            required:true
        },
        type_comps:{      //тип гарантии
            type:Array,
            required:true
        },
        culprits:{      //виновник
            type:Array,
            required:true,
        },
        executors:{     //устранение
            type:Array,
            required:true,
        },

        executor_id:{     //устранение
            type:Array,
            required:true,
        },

        reason_id:{
            type:Array,
            required:true,
        },
        culprit_id:{
            type:Array,
            required:true,
        },

        chassises:{
            type:Array,
            required:true,
        },

        contractors:{
          type:Array,
          required:true,
        },

        providers:{
            type:Array,
            required:true,
        },

        providerCulprit:{
          type:Boolean,
          // required:true,
        },

        value: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            complaint: this.value,
            Calendar: null,
            contractorSelect: false,
            providerSelect:false,
            provider:this.providerCulprit,

        }

    },
    methods: {
        close() {

            this.$emit('input', false);

        },

        getContractors(){
            this.contractorSelect = true;
        },

        getProviders(){
            this.providerSelect = true;
        },

        getCulprits(){
            let arrCulprits = this.complaint.culprit_id.map(function (item) {
                return item
            }).join(', ')

            this.provider = arrCulprits.includes('1');

        },

    },
    watch:{     //следить за изменением value
        value: {
            handler(value) {
                this.complaint = value;
            },
            immediate: true,


        },


    }

}
</script>
<style scoped>

</style>
