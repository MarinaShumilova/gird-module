<template>
    <base-dialog-action
        v-if="showDialog"
        v-model="dialog"
        max-width="1200"
        persistent
        @confirmed="submitAll"
        :loading="loading"

    >
        <template v-slot:title>
            Редактировать запись
        </template>

        <v-container>
            <component-write
                v-model="complaint"
                :warranty-types="warrantyTypes"
                :reasons="reasons"
                :type_comps="type_comps"
                :culprits="culprits"
                :executors="executors"
                :contractors="contractors"
                :chassises="chassises"
                :sideCompanies="sideCompanies"
                :errors="validationErrors"
                :executor_id="executor_id"
                :reason_id="reason_id"
                :culprit_id="culprit_id"
                :providerCulprit="providerCulprit"
                :tripExecutor="tripExecutor"
                :type-side="sideCompSelect"
                :type-reason="typeReason"
                @revers="getReason"
            >
            </component-write>

            <v-row dense v-show="vReason">
                <v-col>
                    <component-event
                        v-model="eventData"
                        :arr-result="arrResult"
                        :errors="errors"
                        @delete="this.getEvents">

                    </component-event>
                </v-col>
            </v-row>


        </v-container>

    </base-dialog-action>
</template>

<script>

import ComponentWrite from "./ComponentWrite";
import BaseDialogAction from "gird-base-front/src/components/BaseDialogAction"
import ComponentEvent from "./ComponentEvent";

export default {
    name: "EditCard",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        id: {
            type: Number,
            required: true
        },

    },
    components: {ComponentEvent, ComponentWrite, BaseDialogAction},

    //создаем массив данных комплайн
    created() {
        this.showDialog = false;
        api.call(endpoint('complaints.edit', this.id))
            .then((response) => {
                this.warrantyTypes = response.data.warranty_types;
                this.reasons = response.data.reason;
                this.type_comps = response.data.type_comps;
                this.culprits = response.data.culprits;
                this.executors = response.data.executors;
                this.contractors = response.data.contractors;
                this.chassises = response.data.chassises;
                this.sideCompanies = response.data.sideCompanies;

                this.complaint = response.data.complaint;
                this.complaint.executor_id = response.data.executor_id;
                this.complaint.reason_id = response.data.reason_id;
                this.complaint.culprit_id = response.data.culprit_id;


                this.getCulprits();
                this.getExecutors();
                this.getTypeCulprits();
                this.getTypeSide();
                this.getEvents();

                this.complaint.chassises = this.complaint.chassises.map(function (item) {
                    return item.number;
                }).join(',');

                this.showDialog = true;

            });

        this.getEvents();

    },

    data() {
        return {
            warrantyTypes: [],
            reasons: [],
            reason_id: [],
            culprit_id: [],
            type_comps: [],
            culprits: [],
            executors: [],
            executor_id: [],
            contractors: [],
            // providers:[],
            chassis: null,

            arrResult: [],

            chassises: '',
            sideCompanies: '',
            vReason: true,
            event_list:[],

            eventData: {
                complaint_id: this.id,
                warranty: '',
                prevention: '',
            },

            complaint: {},  //объект с данными


            dialog: this.value,
            showDialog: false,
            validationErrors: {},
            errors: {},
            loading: false,

            providerCulprit: false,
            tripExecutor: false,
            typeReason: false,
            sideCompSelect: false,


        }


    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        },


    },

    methods: {
        /*Обновление базы, передаем id и сам объект с данными*/
        submitAll() {
            this.submit();
            this.submitEvent();

        },
        submit() {
            this.loading = true;
            api.call(endpoint('complaints.update', this.id), this.complaint)
                .then(response => {
                    this.vehicle = response.data.complaint;
                    this.numb_order = response.data.complaint;
                    this.start_at = response.data.complaint;
                    this.$emit('store-complaint');
                    this.close()

                })
                .catch(error => {
                    this.validationErrors = error.response.data.errors

                })
                .finally(() => {
                    this.loading = false;
                })


        },

        getCulprits() {
            let arrCulprits = this.complaint.culprit_id.map(function (item) {
                return item
            }).join(', ')
            this.providerCulprit = arrCulprits.includes('1');

        },

        getReason(value) {
            this.vReason = value
        },

        getTypeCulprits() {
            let arrCulprits = this.complaint.culprit_id.map(function (item) {
                return item
            }).join(', ')
            this.typeReason = arrCulprits.includes('3');

        },

        getTypeSide() {
            let arrExecutors = this.complaint.executor_id.map(function (item) {
                return item
            }).join(', ')

            this.sideCompSelect = arrExecutors.includes('4');

        },

        getExecutors() {
            let arrExecutors = this.complaint.executor_id.map(function (item) {
                return item
            }).join(', ')

            this.tripExecutor = arrExecutors.includes('2');
        },

        submitEvent() {
            api.call(endpoint('complaints.events.store', this.id), this.eventData)
                .then(response => {
                    this.eventData.warranty = '';
                    this.eventData.prevention = '';
                    this.getEvents();
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                });
        },

        getEvents() {
            api.call(endpoint('complaints.events.index', this.id))
                .then((response) => {
                    this.arrResult = response.data;
                });
        },




        close() {
            this.$emit('input', false);
        },

    }
}
</script>

<style scoped>

</style>
