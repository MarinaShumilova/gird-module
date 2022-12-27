<!--Компонент(Завести новую запись)-->
<template>
    <v-form>
        <v-row>
            <v-col cols="9">
                <v-row dense>
                    <v-col
                        cols="3"
                        class="d-flex">
                        <v-textarea
                            v-model="complaint.numb_order"
                            item-value="id"
                            label="Приказ"
                            :error-messages="errors['numb_order']"
                            rows="1"
                            outlined
                            auto-grow
                            dense
                            hide-spin-buttons
                        ></v-textarea>
                    </v-col>
                    <v-col
                        cols="3">
                        <base-date-input-picker
                            v-model="complaint.order_at"
                            :error-messages="errors['order_at']"
                            dense
                            outlined
                            label="Дата приказа">
                        </base-date-input-picker>
                    </v-col>
                    <v-col
                        cols="3">
                        <v-text-field
                            v-model="complaint.warranty_decree"
                            item-value="id"
                            item-text="number"
                            label="№ Гарантийного приказа"
                            outlined
                            dense
                            hide-spin-buttons
                        ></v-text-field>
                    </v-col>

                    <v-col
                        cols="3">
                        <base-date-input-picker
                            v-model="complaint.start_at"
                            :error-messages="errors['start_at']"
                            dense
                            outlined
                            label="Дата гар-го приказа">
                        </base-date-input-picker>
                    </v-col>
                </v-row>

                <v-row dense>
                    <v-col
                        cols="3">
                        <v-text-field
                            v-model="complaint.numb_pretension"
                            :error-messages="errors['numb_pretension']"
                            item-value="id"
                            label="№ Входящей претензии"
                            outlined
                            dense
                            hide-spin-buttons
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="3">
                        <base-date-input-picker
                            v-model="complaint.pretension_at"
                            :error-messages="errors['pretension_at']"
                            dense
                            outlined
                            label="Дата поступления">
                        </base-date-input-picker>
                    </v-col>
                    <v-col
                        cols="6">
                        <contractor-select
                            v-model="complaint.contractor_id"
                            :error-messages="errors['contractor_id']"
                            label="Заказчик(Потребитель)"
                            :items="contractors"
                            dense
                            outlined
                        >
                        </contractor-select>
                    </v-col>

                </v-row>


                <v-row dense>
                    <v-col
                        cols="3">
                        <base-date-input-picker
                            v-model="complaint.unload_at"
                            :error-messages="errors['unload_at']"
                            dense
                            outlined
                            label="Дата отгрузки шасси">
                        </base-date-input-picker>
                    </v-col>
                    <v-col
                        cols="9">
                        <v-textarea
                            v-model="complaint.chassises"
                            label="Шасси"
                            rows="1"
                            outlined
                            auto-grow
                            dense
                            hide-spin-buttons>
                        </v-textarea>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4" class="pt-0">
                        <v-row dense>
                            <v-col class="pt-1" cols="12">
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
                            <v-col cols="12"
                                   v-if="complaint.warranty_type_id == 2">
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
                        </v-row>

                    </v-col>
                    <v-col cols="4" class="pt-0">
                        <v-row dense>
                            <v-col cols="12" class="pt-1">
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

                            <v-col v-show="this.setReason" cols="12">
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

                            <v-col v-show="this.setProvider" cols="12">
                                <v-textarea
                                    v-model="complaint.providers"
                                    auto-grow
                                    item-text="name"
                                    :error-messages="errors['providers']"
                                    dense
                                    outlined
                                    label="Поставщик"
                                    rows="1">
                                </v-textarea>
                            </v-col>

                        </v-row>
                    </v-col>

                    <v-col cols="4" class="pt-0">
                        <v-row dense>
                            <v-col cols="12" class="pt-1">
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
                                    @input="getExecutors">
                                </v-select>
                            </v-col>
                            <v-col v-show="this.setTripTo" cols="12">
                                <v-textarea
                                    v-model="complaint.tripTo"
                                    auto-grow
                                    item-text="name"
                                    :error-messages="errors['tripTo']"
                                    dense
                                    outlined
                                    label="Командировка"
                                    rows="1">
                                </v-textarea>
                            </v-col>
                            <v-col v-show="this.setSideCompanies" cols="12">
                                <v-text-field
                                    v-model="complaint.sideCompanies"
                                    item-text="name"
                                    :error-messages="errors['sideCompanies']"
                                    label="Сторонняя организация"
                                    persistent-hint
                                    dense
                                    outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-col>

                </v-row>
            </v-col>

            <v-col cols="3">
                <v-textarea
                    v-model="complaint.vehicle"

                    item-text="name"
                    :error-messages="errors['vehicle']"
                    dense
                    outlined
                    label="Суть претензии"
                    height="320"
                ></v-textarea>

            </v-col>
        </v-row>
    </v-form>

</template>
<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import BaseDateInputPicker from "gird-base-front/src/components/BaseDateInputPicker";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";
import ContractorSelect from "./ContractorSelect";
import ComponentEvent from "./ComponentEvent";

export default {
    name: "ComponentWrite",
    components: {ComponentEvent, BaseDatePicker, BaseDateInputPicker, BaseFileInput,
        ContractorSelect},
    props: {
        errors: {
            type: Object,
            required: false
        },
        warrantyTypes: {  //гарантия
            type: Array,
            required: true
        },
        reasons: { //причина гарантии
            type: Array,
            required: true
        },
        type_comps: {      //тип гарантии
            type: Array,
            required: true
        },
        culprits: {      //виновник
            type: Array,
            required: true,
        },
        executors: {     //устранение
            type: Array,
            required: true,
        },

        executor_id: {     //устранение
            type: Array,
            required: true,
        },

        reason_id: {
            type: Array,
            required: true,
        },
        culprit_id: {
            type: Array,
            required: true,
        },

        chassises: {
            type: String,
            required: true,
        },

        sideCompanies: {
            type: String,
            required: true,
        },

        contractors: {
            type: Array,
            required: true,
        },

        // providers:{
        //     type:Array,
        //     required:true,
        // },

        providerCulprit: {
            type: Boolean,
        },

        tripExecutor: {
            type: Boolean,
        },

        typeReason: {
            type: Boolean,
        },

        typeSide:{
            type:Boolean,
        },

        value: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            complaint: this.value,          //переприсвоить value(работа с моделью)

            Calendar: null,
            heightVehical:320,
            contractorSelect: false,
            providerSelect: false,
            sideCompSelect: false,

            setProvider: this.providerCulprit,
            setTripTo: this.tripExecutor,
            setReason: this.typeReason,
            setSideCompanies: this.typeSide,

        }

    },
    computed:{
        // heightForm(){
        //     if(this.setReason){
        //         return this.heightVehical = 400}
        // },


    },
    watch: {     //следить за изменением value
        value: {
            handler(value) {
                this.complaint = value;
            },
            immediate: true,
        },
        setReason: {
            handler: function (value) {
                this.$emit('revers', value);
            },
            immediate: true,
        }

    },

    methods: {
        close() {
            this.$emit('input', false);
        },

        getContractors() {
            this.contractorSelect = true;
        },

        getProviders() {
            this.providerSelect = true;

        },
        getSideCompanies() {
            this.sideCompSelect = true;
        },

        heightForm() {
            if(this.setReason){
                return this.heightVehical = 400}
        },

        getCulprits() {
            let arrCulprits = this.complaint.culprit_id.map(function (item) {
                return item
            }).join(', ')

            this.setProvider = arrCulprits.includes('1');
            this.getReasons();
        },

        getExecutors() {
            let arrExecutors = this.complaint.executor_id.map(function (item) {
                return item
            }).join(', ')

            this.setTripTo = arrExecutors.includes('2');
            this.getSide();

        },

        getReasons() {
            let arrCulprits = this.complaint.culprit_id.map(function (item) {
                return item
            }).join(', ')

            this.setReason = arrCulprits.includes('3');

        },

        getSide() {
            let arrCulprits = this.complaint.executor_id.map(function (item) {
                return item
            }).join(', ')

            this.setSideCompanies = arrCulprits.includes('4');
        }


    },


}
</script>
<style scoped>

</style>
