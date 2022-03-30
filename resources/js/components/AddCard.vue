<!--Добавить новую запись-->
<template>
    <base-dialog-action
        v-if="dialog"
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

    created() {
        api.call(endpoint('complaints.create'))
            .then((response) => {
                this.warrantyTypes = response.data.warranty_types;
                this.reasons = response.data.reason;
                this.type_comps = response.data.type_comps;
                this.culprits = response.data.culprits;
                this.executors = response.data.executors;
                this.contractors = response.data.contractors;
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

                warranty_decree:null,
                numb_order:null,
                vehicle:null,
                start_at:null,

            },
            dialog: this.value
        }
    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        }
    },
    methods: {

        submit() {
            api.call(endpoint('complaints.store'), this.complaint)
            .then(response => {
              this.vehicle = response.data.complaint;
                this.numb_order = response.data.complaint;
                this.warranty_decree = response.data.complaint;
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
