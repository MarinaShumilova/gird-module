<!--Добавить новую запись-->
<template>
    <base-dialog-action
        v-if="showDialog"
        v-model="dialog"
        max-width="800"
        persistent
        @confirmed="submit"
    >
        <template v-slot:title>
            Добавить запись
        </template>

            <component-write
                v-model="complaint"
                :warranty-types="warrantyTypes"
                :reasons="reasons"
                :type_comps="type_comps"
                :culprits="culprits"
                :executors="executors"
                :contractors="contractors"
                :errors="validationErrors"

            >
            </component-write>

    </base-dialog-action>

</template>

<script>
//

import ComponentWrite from "./ComponentWrite";
import BaseDialogAction from "gird-base-front/src/components/BaseDialogAction"

export default {
    name: "AddCard",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
    },
    components: {ComponentWrite, BaseDialogAction},
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


            complaint: {
                warranty_type_id: 1,
                reason_id:1,
                type_comp_id:1,
                culprit_id:1,
                executor_id:2,
                contractor_id:1,
                status_id:1,  /*статус в работе*/


                warranty_decree:null,
                numb_order:null,
                vehicle:null,
                start_at: new Date().toISOString().substr(0, 10),


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
            api.call(endpoint('complaints.store'), this.complaint)
                .then(response => {
                    this.$emit('store-complaint');
                    this.close()
                })
                .catch(error =>{
                    this.validationErrors = error.response.data.errors
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
