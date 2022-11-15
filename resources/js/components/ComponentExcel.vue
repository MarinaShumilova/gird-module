<template>
<v-dialog
    v-model="dialog"
    max-width="300"
    scrollable
    persistent>
    <v-card>
        <v-toolbar
            height="50"
            elevation="1">
                <span>
                    <v-icon>mdi-microsoft-excel</v-icon>
                  Выгрузка в Excel
                </span>
            <v-spacer></v-spacer>

            <v-btn icon color="error" @click="close">
                <v-icon>mdi-close</v-icon>
            </v-btn>

        </v-toolbar>
        <v-container>

        <v-card-text>
            <v-text-field
                v-model="yearComplaint"
                outlined
                height="5"
                type="number"
                hide-spin-buttons
                label="Введите год">
            </v-text-field>

        </v-card-text>
            <v-card-actions>
                <v-btn
                    :disabled="loading"
                    text
                    small
                    @click="close"
                >
                    Отмена
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    :loading="loading"
                    text
                    color="primary"
                    :href="url + '?year=' + yearComplaint" target="_blank"

                >
                    Сохранить в Excel
                </v-btn>

            </v-card-actions>
        </v-container>

    </v-card>


   </v-dialog>
</template>


<script>
export default {
    name:"ComponentExcel",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
    },

    data(){
        return {
            loading:false,
            errors: {},
            dialog: this.value,
            yearComplaint:'',
            url:'complaints/excel/',


        }

    },
    methods:{
        close() {
            this.$emit('input', false);
        },

        getExcel() {
            api.call(endpoint('complaints.excel', {year: this.yearComplaint}))
                .then(response=>{

                })

        },

    }



}

</script>
