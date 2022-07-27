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
           :errors="validationErrors"
           :executor_id="executor_id"
           :chassises="chassises"

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
        loading: {
            type: Boolean,
            default: false
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
                //this.executor_id = response.data.complaint;
                this.chassises = response.data.chassises;
                this.complaint = response.data.complaint;
                this.complaint.executor_id = response.data.executor_id;
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
            type_comps:[],
            culprits:[],
            executors:[],
            executor_id:[],
            contractors:[],
            chassis:[],
            complaint:{ },  //объект с данными


            dialog: this.value,
            showDialog:false,
            validationErrors: { },

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



        close() {
            this.$emit('input', false);
        },

    }
}
</script>

<style scoped>

</style>
