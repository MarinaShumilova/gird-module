<!--Добавить новую запись-->
<template>
    <base-dialog-action
        v-model="dialog"
        max-width="900"
        persistent
        @confirmed="submit"
        :loading="loading"
    >
        <template v-slot:title>
            Добавить запись
        </template>
            <v-container class="pa-2">
            <component-write
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

            >
            </component-write>

<!--        <base-file-input-->
<!--            v-model="complaint.files"-->
<!--            :extensions="extensions"-->
<!--            lable = "Прикрепить документы"-->
<!--            :max-size="maxSize"-->
<!--            :error-messages="validationErrors['attachments']"-->

<!--        ></base-file-input>-->
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
                // this.providers = response.data.providers;
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
            // providers:[],

            // файлы

            extensions:[],
            maxSize:0,


            complaint: {
                warranty_type_id: 1,
                reason_id: [],
                type_comp_id:'',
                culprit_id:[],
                executor_id: [],
                contractor_id: null,
                // provider_id: null,
                providers:'',
                tripTo:'',

                status_id:1,  /*статус в работе*/
                files:[],
                chassises:[],

                numb_pretension:'',    //№ ретензии
                pretension_at:new Date().toISOString().substr(0, 10),  //дата претензии


                warranty_decree:'',
                numb_order:null,
                vehicle:null,
                start_at: new Date().toISOString().substr(0, 10),
                close_at: new Date().toISOString().substr(0, 10),
                unload_at: new Date().toISOString().substr(0, 10),
                order_at: new Date().toISOString().substr(0, 10),

            },
            dialog: this.value,
            validationErrors: { },
            errors: {},
            showDialog:false,   /*загружает данные до отображения*/
            loading: false,

             provider:false,


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

            formData.append('start_at', this.complaint.start_at);
            formData.append('unload_at', this.complaint.unload_at);
            formData.append('numb_order', this.complaint.numb_order ?? ' ');
            formData.append('order_at', this.complaint.order_at);
            formData.append('contractor_id', this.complaint.contractor_id);

            // if (this.complaint.provider_id)
            //     formData.append('provider_id', this.complaint.provider_id);

            formData.append('warranty_type_id', this.complaint.warranty_type_id);
            formData.append('type_comp_id', this.complaint.type_comp_id);

            formData.append('warranty_decree', this.complaint.warranty_decree);
            formData.append('numb_pretension', this.complaint.numb_pretension);
            formData.append('pretension_at', this.complaint.pretension_at);




            for (let i = 0; i < this.complaint.chassises.length; i++) {
                formData.append('chassis' + '[' + i + ']', this.complaint.chassises[i]);
            };



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

        // getCulprits(){
        //     let arrCulprits = this.complaint.culprit_id.map(function (item) {
        //         return item
        //     }).join(', ')
        //
        //     provider = arrCulprits.includes('1');
        //
        // },



        close() {
            this.$emit('input', false);


        },



    }

}

</script>

<style scoped>

</style>
