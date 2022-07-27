<!--Добавить новую запись-->
<template>
    <base-dialog-action
        v-model="dialog"
        max-width="800"
        persistent
        @confirmed="submit"
        :loading="loading"

    >

        <template v-slot:title>
            Добавить запись
        </template>
            <v-container>

            <component-write
                v-model="complaint"
                :warranty-types="warrantyTypes"
                :reasons="reasons"
                :type_comps="type_comps"
                :culprits="culprits"
                :executors="executors"
                :executor_id="executors"
                :contractors="contractors"
                :errors="validationErrors"
                :chassises="chassises"

            >
            </component-write>

        <base-file-input
            v-model="complaint.files"
            :extensions="extensions"
            lable = "Прикрепить документы"
            :max-size="maxSize"
        ></base-file-input>
        </v-container>


    </base-dialog-action>


</template>

<script>
//

import ComponentWrite from "./ComponentWrite";
import BaseDialogAction from "gird-base-front/src/components/BaseDialogAction";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";


export default {
    name: "AddCard",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        loading: {
            type: Boolean,
            default: false
        },
    },
    components: {ComponentWrite, BaseDialogAction, BaseFileInput},
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


    data() {
        return {
            warrantyTypes: [],
            reasons:[],
            type_comps:[],
            culprits:[],
            executors:[],
            contractors:[],
            chassises:[],

            // файлы

            extensions:[],
            maxSize:0,


            complaint: {
                warranty_type_id: 1,
                reason_id:1,
                type_comp_id:1,
                culprit_id:1,
                executor_id: [],
                contractor_id:1,
                status_id:1,  /*статус в работе*/
                files:[],
                chassises:[],


                warranty_decree:null,
                numb_order:null,
                vehicle:null,
                start_at: new Date().toISOString().substr(0, 10),
                close_at: new Date().toISOString().substr(0, 10),
                unload_at: new Date().toISOString().substr(0, 10),
                order_at: new Date().toISOString().substr(0, 10),

            },
            dialog: this.value,
            validationErrors: { },

            showDialog:false,   /*загружает данные до отображения*/

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
            formData.append('start_at', this.complaint.start_at);
            formData.append('unload_at', this.complaint.unload_at);
            formData.append('numb_order', this.complaint.numb_order ?? ' ');
            formData.append('order_at', this.complaint.order_at);
            formData.append('contractor_id', this.complaint.contractor_id);
            formData.append('culprit_id', this.complaint.culprit_id);
            formData.append('reason_id', this.complaint.reason_id);
            formData.append('warranty_type_id', this.complaint.warranty_type_id);
            formData.append('type_comp_id', this.complaint.type_comp_id);


            for (let i = 0; i < this.complaint.chassises.length; i++) {
                formData.append('chassis' + '[' + i + ']', this.complaint.chassises[i]);
            };



            for (let i = 0; i < this.complaint.executor_id.length; i++) {
                   formData.append('executor_id' + '[' + i + ']', this.complaint.executor_id[i]);
               };


            // attachments
            for (let i = 0; i < this.complaint.files.length; i++) {
                formData.append('attachments'+'[' + i + ']', this.complaint.files[i]);

            };

            // api.call(endpoint('complaints.store'), this.complaint)
            api.call(endpoint('complaints.store'), formData)
                .then(response => {
                    this.$emit('store-complaint');
                    this.close()
                })
                .catch(error =>{
                    this.validationErrors = error.response.data.errors
                    })
                .finally(()=>{
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
