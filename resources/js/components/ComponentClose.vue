<template>
    <v-dialog
        v-model="dialog"
        width="400"
        scrollable
        persistent>
        <v-card>
            <v-card-title>
                <v-icon left>mdi-comment-multiple-outline</v-icon>
                Завершить рекламацию
                <v-spacer/>
                <v-btn
                    icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
            <v-row justify="center">
                <v-col cols="8" >
                        <base-date-picker
                            v-model="data_close"
                            dense
                            outlined>
                        </base-date-picker>
                </v-col>
            </v-row>

                <v-card-actions>
                    <v-btn
                        text
                        @click="close"
                    > Отмена
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click.stop="submit"
                    >Сохранить
                    </v-btn>
                </v-card-actions>
            </v-card-text>

        </v-card>
    </v-dialog>

</template>
<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";

export default {
    name: "ComponentClose",
    components:{BaseDatePicker},
    props:{
        value: {
            type: Boolean,
           required: true
        }
    },
    data(){
        return{
            data_close:new Date().toISOString().split('T')[0],
            dialog: this.value,
        }

    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        },
    },
    methods:{
        close() {
            this.$emit('input', false);
            this.$emit('closeDialog', false);
        },

        submit(){
            this.$emit('data-close', this.data_close)
            this.close();
        },

    }



}

</script>
