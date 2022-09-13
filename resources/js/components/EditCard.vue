<template>
    <base-dialog-action
        v-if="showDialog"
        v-model="dialog"
        max-width="800"
        persistent
        @confirmed="submit"
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
           :providers="providers"
           :errors="validationErrors"
           :executor_id="executor_id"
           :chassises="chassises"
           :reason_id="reason_id"
           :culprit_id="culprit_id"
           :providerCulprit="providerCulprit"

           >

       </component-write>
        </v-container>

    </base-dialog-action>
</template>

<script>

import ComponentWrite from "./ComponentWrite";
import BaseDialogAction from "gird-base-front/src/components/BaseDialogAction"

export default {
    name: "EditCard",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        id:{
            type:Number,
            required: true
        },

    },
    components: {ComponentWrite, BaseDialogAction},

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
                this.providers = response.data.providers;
                //this.executor_id = response.data.complaint;
                this.chassises = response.data.chassises;
                this.complaint = response.data.complaint;
                this.complaint.executor_id = response.data.executor_id;
                this.complaint.reason_id = response.data.reason_id;
                this.complaint.culprit_id = response.data.culprit_id;
                this.getCulprits();
                this.complaint.chassises=this.complaint.chassises.map(function(item)
                {
                    return item.number;
                })

                this.showDialog = true;

            });


    },
    data() {
        return {
            warrantyTypes: [],
            reasons:[],
            reason_id:[],
            culprit_id:[],
            type_comps:[],
            culprits:[],
            executors:[],
            executor_id:[],
            contractors:[],
            providers:[],
            chassis:[],

            complaint:{ },  //объект с данными


            dialog: this.value,
            showDialog:false,
            validationErrors: { },
            loading: false,

            providerCulprit:false,

        }



    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        },
        //

    },

    methods: {
        /*Обновление базы, передаем id и сам объект с данными*/
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
                .catch(error =>{
                    this.validationErrors = error.response.data.errors
                    console.log(error)})
                .finally(()=>{
                    this.loading = false;
                })

        },

        getCulprits(){
            let arrCulprits = this.complaint.culprit_id.map(function (item) {
                return item
            }).join(', ')

            this.providerCulprit = arrCulprits.includes('1');

        },



        close() {
            this.$emit('input', false);
        },

    }
}
</script>

<style scoped>

</style>
