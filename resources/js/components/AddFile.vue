<!--Прикрепить документы-->
<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>
    <v-card>
        <v-toolbar height="50">
                <span>
                    <v-icon>mdi-folder-multiple-plus</v-icon>
                   Прикрепить документы
                </span>
            <v-spacer></v-spacer>

                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

        </v-toolbar>

        <v-card-text>
            <v-row justify="center">
                <v-col
                    sm="10">
                    <base-file-input
                        v-model="attachment.files"
                        :extensions="extensions"
                        lable = "Прикрепить документы"
                        :max-size="maxSize"
                    ></base-file-input>
                </v-col>
                <v-col
                    sm="10">
<!--                <v-list>
                    <v-list-item
                        v-for="item in attachment.files"
                        :key="item.id"
                    >
                        <v-list-item-title>
                            <v-divider></v-divider>
                        </v-list-item-title>

                        <v-btn icon
                        >
                            <v-icon small color="red">mdi-bucket</v-icon>
                        </v-btn>
                    </v-list-item>
                </v-list>-->
                    <v-divider></v-divider>
                </v-col>

            </v-row>

            <v-card-actions>
                <v-btn
                    :disabled="loading"
                    text
                    @click="close"
                >
                    Отмена
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn
                    :loading="loading"
                    text
                    color="primary"
                    @click="submit"

                >
                    Добавить
                </v-btn>
            </v-card-actions>
        </v-card-text>


    </v-card>
    </v-dialog>

</template>
<script>

import BaseFileInput from "gird-base-front/src/components/BaseFileInput";

export default {
    components: {BaseFileInput},
    name: "AddFile",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        loading: {
            type: Boolean,
            default: false
        },
        id:{
            type:Number,
            required: true
        },
    },
    data() {
        return {
            extensions: [],
            maxSize: 0,
            attachment:{
                files: [],
            },

            dialog: this.value,
            validationErrors: {},

        }
    },
    created() {             //вызвать при открытии диалога
       api.call(endpoint('complaints.attachments.create',this.id))
            .then((response)=>{
                this.maxSize = response.data.attachment_rules.max_size;
                this.extensions = response.data.attachment_rules.extensions;
            });
    },
    methods: {

        submit() {

            let formData = new FormData();
            for (let i = 0; i < this.attachment.files.length; i++) {
                formData.append('attachments' + '[' + i + ']', this.attachment.files[i]);
            };

            api.call(endpoint('complaints.attachments.store',this.id), formData)
                .then(response => {
                    this.close()
                })
                .catch(error => {
                    this.validationErrors = error.response.data.errors
                })


         },


    close() {
        this.$emit('input', false);
    },

    }

}
</script>
