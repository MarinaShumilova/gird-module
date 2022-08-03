<!--Прикрепить документы-->
<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>
    <v-card>
        <v-toolbar
            height="50"
            elevation="1">
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
                        v-model="attachments"
                        :extensions="extensions"
                        lable = "Прикрепить документы"
                        :max-size="maxSize"
                        :error-messages="validationErrors['attachments']"
                    ></base-file-input>
                </v-col>
                <v-col
                    sm="10">

               <v-list>
                    <v-list-item
                        v-for="item in files"
                        :key="item.id"
                    >
                        <v-list-item-title>{{item.name}}
                            <v-divider></v-divider>
                        </v-list-item-title>
                        <v-btn
                            :href="item.url" target="_blank"
                            icon>
                            <v-icon small color="blue">mdi-file-download-outline</v-icon>
                        </v-btn>
                        <v-btn
                            icon
                            @click.stop="destroyFile(item.id)"
                            >
                            <v-icon small color="red">mdi-bucket</v-icon>
                        </v-btn>
                    </v-list-item>
                </v-list>
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
        compId:{
            type:Number,
            required: true
        },
    },
    data() {
        return {
            extensions: [],
            maxSize: 0,
            files: [],
            dialog: this.value,
            validationErrors: {},
            attachments:[],
            loading:false,
            errors: {},

        }
    },
    created() {             //вызвать при открытии диалога
        this.showDialog = false;
       api.call(endpoint('complaints.attachments.create',this.compId))
            .then((response)=>{
                this.maxSize = response.data.attachment_rules.max_size;
                this.extensions = response.data.attachment_rules.extensions;
                this.getAttachment();
                this.showDialog = true;

            });


    },
    methods: {
        getAttachment() {
            api.call(endpoint('complaints.attachments.index',this.compId))
                .then((response) => {
                    this.files = response.data;


                });

        },

        showAttachment() {
            api.call(endpoint('attachments.show', this.id))
                .then((response) => {

                });
        },

        submit() {
            this.loading = true;
            let formData = new FormData();
            for (let i = 0; i < this.attachments.length; i++) {
                formData.append('attachments' + '[' + i + ']', this.attachments[i]);
            };


            api.call(endpoint('complaints.attachments.store',this.compId), formData)
                .then(response => {
                     this.files = null;


                })
                .catch(error => {
                    this.validationErrors = error.response.data.errors
                })
                .finally(()=>{
                    this.getAttachment();
                    this.loading = false;
                })


         },


       close() {
        this.$emit('input', false);
        this.$emit('close-add-file', false);

       },

        destroyFile(id){
            api.call(endpoint('complaints.attachments.destroy', [this.compId, id]))
            .then(response=> {
                this.getAttachment();
            })
        }

    }

}
</script>
