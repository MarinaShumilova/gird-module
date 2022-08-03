<!--Перенаправить документ виновной стороне-->
<template>
    <v-dialog
        :value="value"
        width="400"
        scrollable
        persistent>
        <v-card>
            <v-toolbar
                elevation="1"
                height="50">
                <span>
                    <v-icon>mdi-shuffle-disabled</v-icon>
                   Перенаправить доккументы
                </span>
                <v-spacer></v-spacer>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-container>
                <v-card-text>
                    <v-row>
                        <v-col sm="9">
                            <base-date-picker
                                v-model="redirectFile.transfer_at"
                                :error-messages="validationErrors['transfer_at']"
                                outlined
                                dense
                                label="Дата перенаправления">
                            </base-date-picker>
                        </v-col>

                        <v-col sm="3">
                            <comment
                                v-if="commentsCreateDialog"
                                v-model="commentsCreateDialog"
                                @comments="updateComment"
                                :comment="comment"
                                :errors="validationErrors"
                            ></comment>

                            <v-btn icon
                                   @click.stop="openComment">
                                <v-icon
                                    large
                                    color="blue">
                                    mdi-comment-processing-outline
                                </v-icon>
                            </v-btn>
                        </v-col>

                        <v-col
                            sm="12">
                            <base-file-input
                                v-model="attachments"
                                :extensions="extensions"
                                lable="Прикрепить документы"
                                :max-size="maxSize"
                                :error-messages="validationErrors['attachments']"
                            ></base-file-input>
                        </v-col>

                        <v-col sm="12">
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
            </v-container>

        </v-card>
    </v-dialog>


</template>

<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import Comment from "./Comment";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";


export default {
    components: {BaseDatePicker, Comment, BaseFileInput},
    name: "SendFile",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        compId: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            showUser:false,
            Calendar: null,
            transfer_at: new Date().toISOString().substr(0, 10),
            extensions: [],
            comment: [],

            attachments: [],
            files:[],


            redirectFile: {
                transfer_at: new Date().toISOString().substr(0, 10),
                complaint_id: this.compId,
                comment: '',
            },

            maxSize: 0,

            dialog: this.value,
            loading: false,

            validationErrors: { },
            commentsCreateDialog: false,
        }
    },

    created() {

        this.showDialog = false;
        api.call(endpoint('complaints.transfer.create', this.compId))
            .then((response) => {
                this.maxSize = response.data.attachment_rules.max_size;
                this.extensions = response.data.attachment_rules.extensions;
                this.getTransfer();
                this.showDialog = true;

            });
    },

    methods: {

        close() {
            this.$emit('input', false);
        },
        openComment() {
            this.commentsCreateDialog = true;
        },

        getTransfer() {
            api.call(endpoint('complaints.transfer.index', this.compId))
                .then((response) => {
                   this.redirectFile.transfer_at = response.data.transfer_at;
                   this.files = response.data.attachments;
                   this.idTransferFile = response.data.id;

                });
        },

        // событие с дочернего компонента
        updateComment(textComment) {
            this.comment.push(textComment);
            this.redirectFile.comment = textComment;
        },


        submit() {
            this.loading = true;
            let formData = new FormData();
            formData.append('transfer_at', this.redirectFile.transfer_at ?? ' ');
            formData.append('complaint_id', this.redirectFile.complaint_id);
            formData.append('comment', this.redirectFile.comment ?? ' ');
            // attachments
            for (let i = 0; i < this.attachments.length; i++) {
                formData.append('attachments' + '[' + i + ']', this.attachments[i]);
            }
            ;


            // api.call(endpoint('complaints.transfer.store', this.id), this.redirectFile)
            api.call(endpoint('complaints.transfer.store', this.compId), formData)
                .then(response => {
                })
                .catch(error => {

                    this.validationErrors = error.response.data.errors
                })
                .finally(() => {
                    this.getTransfer();
                    this.loading = false;
                })
        },

        destroyFile(id){
            api.call(endpoint('complaints.transfer.destroy', [this.idTransferFile, id]))
                .then(response=> {
                    this.getTransfer();
                })
        }

    }
}
</script>
