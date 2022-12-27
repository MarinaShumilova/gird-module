<!--Добавить новую запись-->
<template>
    <base-dialog-action
        v-model="dialog"
        max-width="1200"
        persistent
        @confirmed="submit"
        :loading="loading"
    >
        <template v-slot:title>
            Добавить запись
        </template>

        <component-write
            class="pt-4"
            v-model="complaint"
            :warranty-types="warrantyTypes"
            :reasons="reasons"
            :type_comps="type_comps"
            :culprits="culprits"
            :executors="executors"
            :executor_id="executors"
            :reason_id="reasons"
            :culprit_id="culprits"
            :contractors="contractors"
            :errors="validationErrors"
            :chassises="chassises"
            :sideCompanies="sideCompanies"

        >
        </component-write>

    </base-dialog-action>


</template>

<script>
//

import ComponentWrite from "./ComponentWrite";
import BaseDialogAction from "gird-base-front/src/components/BaseDialogAction";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";
import ComponentEvent from "./ComponentEvent";


export default {
    name: "AddCard",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },

    },
    components: {ComponentEvent,ComponentWrite, BaseDialogAction, BaseFileInput},
    /*Загрузить данные с базы*/
    created() {
        this.showDialog = false;
        api.call(endpoint('complaints.create'))
            .then((response) => {
                this.warrantyTypes = response.data.warranty_types;
                this.reasons = response.data.reason;
                this.type_comps = response.data.type_comps;
                this.culprits = response.data.culprits;
                this.executors = response.data.executors;
                this.contractors = response.data.contractors;
                this.maxSize = response.data.attachment_rules.max_size;
                this.extensions = response.data.attachment_rules.extensions;
                this.showDialog = true;

            });


    },


    data: function () {
        return {
            warrantyTypes: [],
            reasons: [],
            type_comps: [],
            culprits: [],
            executors: [],
            contractors: [],
            chassises: '',
            sideCompanies: '',

            extensions: [],
            maxSize: 0,


            complaint: {
                warranty_type_id: 1,
                reason_id: [],
                type_comp_id: '',
                culprit_id: [],
                executor_id: [],
                contractor_id: null,
                // provider_id: null,
                providers: '',
                tripTo: '',

                status_id: 1,  /*статус в работе*/
                files: [],


                numb_pretension: '',    //№ ретензии
                pretension_at: null,  //дата претензии


                warranty_decree: '',
                numb_order: null,
                vehicle: null,
                chassises: null,
                sideCompanies: null,


                // start_at: new Date().toISOString().substr(0, 10),
                start_at: null,
                close_at: null,
                unload_at: null,
                order_at: null,

            },
            dialog: this.value,
            validationErrors: {},
            errors: {},
            showDialog: false,   /*загружает данные до отображения*/
            loading: false,

            provider: false,



        }
    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        }
    },
    methods: {
        /*Запись в базу*/
        submit() {

            this.loading = true;
            let formData = new FormData();
            formData.append('vehicle', this.complaint.vehicle ?? ' ');
            formData.append('providers', this.complaint.providers ?? ' ');
            formData.append('tripTo', this.complaint.tripTo ?? ' ');

            formData.append('start_at', this.complaint.start_at ?? ' ');
            formData.append('unload_at', this.complaint.unload_at ?? ' ');
            formData.append('numb_order', this.complaint.numb_order ?? ' ');
            formData.append('order_at', this.complaint.order_at);
            formData.append('contractor_id', this.complaint.contractor_id);
            formData.append('warranty_type_id', this.complaint.warranty_type_id);
            formData.append('type_comp_id', this.complaint.type_comp_id);

            formData.append('warranty_decree', this.complaint.warranty_decree);
            formData.append('numb_pretension', this.complaint.numb_pretension);
            formData.append('pretension_at', this.complaint.pretension_at);

            formData.append('chassises', this.complaint.chassises ?? ' ');

            formData.append('sideCompanies', this.complaint.sideCompanies ?? ' ');


            for (let i = 0; i < this.complaint.executor_id.length; i++) {
                formData.append('executor_id' + '[' + i + ']', this.complaint.executor_id[i]);
            };

            for (let i = 0; i < this.complaint.reason_id.length; i++) {
                formData.append('reason_id' + '[' + i + ']', this.complaint.reason_id[i]);
            };

            for (let i = 0; i < this.complaint.culprit_id.length; i++) {
                formData.append('culprit_id' + '[' + i + ']', this.complaint.culprit_id[i]);
            };


            // attachments
            for (let i = 0; i < this.complaint.files.length; i++) {
                formData.append('attachments' + '[' + i + ']', this.complaint.files[i]);

            };

            api.call(endpoint('complaints.store'), formData)
                .then(response => {
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

        close() {
            this.$emit('input', false);

        },


    }

}

</script>

<style scoped>

</style>
