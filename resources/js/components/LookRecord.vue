<template>
    <base-dialog-action
        v-model="dialog"
        max-width="800"
        persistent
        scrollable

    >
        <template v-slot:title>
            Просмотр записи
        </template>

    </base-dialog-action>
</template>
<script>


import BaseDialogAction from "gird-base-front/src/components/BaseDialogAction";

export default {
    name: "LookRecord",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        // id:{
        //     type:Number,
        //     required: true
        // },
    },
    components: {BaseDialogAction},

    data () {
        return{
            showDialog:false,
            complaint:{ },  //объект с данными
            dialog: this.value,
        }
    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        },

    },
    methods: {
        showComplaint() {
            this.showDialog = false;
            api.call(endpoint('complaints.show', this.id))
                .then((response) => {
                    this.complaints = response.data.data;
                    this.showDialog = true;

                });
        },


        close() {
            this.$emit('input', false);
        }
    }
}
</script>
<style scoped>

</style>
