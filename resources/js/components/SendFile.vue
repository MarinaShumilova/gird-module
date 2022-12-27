<!--Перенаправить документ виновной стороне-->
<template>
    <v-dialog
        :value="value"
        :width=getParamForm().widthForm
        scrollable
        persistent>
        <v-card flat>
            <v-toolbar
                elevation="1"
                height="50">
                <span>
                    <v-icon>mdi-shuffle-disabled</v-icon>
                   {{ this.paramForm.name }}
                </span>
                <v-spacer></v-spacer>
                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text class="pa-3">
                <v-row dense>
                    <v-col cols="8">
                        <v-card-title class="pa-2">
                            Регресс
                        </v-card-title>
                    </v-col>
                    <v-col cols="4">
                        <v-card-title class="justify-center">
                            Документы
                        </v-card-title>
                    </v-col>

                    <v-col cols="8" class="pa-1">
                        <v-row>
                            <v-col cols="4" v-show="showUser">

                                <base-date-picker
                                    v-model="redirectFile.transfer_at"
                                    :error-messages="validationErrors['transfer_at']"
                                    outlined
                                    dense
                                    label="Дата перенаправления">
                                </base-date-picker>
                            </v-col>

                            <v-col cols="8" class="pa-0">
                                <base-file-input
                                    v-show="showUser||showAccount"
                                    v-model="attachments"
                                    :extensions="extensions"
                                    label="Прикрепить документы"
                                    :max-size="maxSize"
                                    :error-messages="validationErrors['attachments']"
                                    :clearable="true"
                                ></base-file-input>

                            </v-col>

                        </v-row>

                        <v-col class="pa-0" cols="12">
                            <v-textarea
                                v-model="redirectFile.comment"
                                :error-messages="validationErrors['comments']"
                                dense
                                label="Общий комментарий"
                                outlined
                                auto-grow
                                :disabled="!showUser"
                                rows="1">
                            </v-textarea>
                        </v-col>
                        <v-col class="pa-0">
                            <v-card-actions v-show="showUser||showAccount">
                                <v-spacer></v-spacer>
                                <v-btn
                                    :loading="loading"
                                    text
                                    color="primary"
                                    @click="submit"
                                >
                                    Сохранить
                                </v-btn>
                            </v-card-actions>
                        </v-col>

                        <v-row>
                            <v-col cols="12" class="pa-5">
                                <hr/>
                            </v-col>
                        </v-row>

                        <v-col cols="12">
                            <v-card-title class="pa-2">
                                Компенсация
                            </v-card-title>
                        </v-col>

                        <v-row>
                            <v-col cols="12">

                                <component-redress
                                    v-model="redress"
                                    :arr-result="arrResult"
                                    :errors="errors"
                                    @delete="this.getRedress">

                                </component-redress>

                            </v-col>
                        </v-row>
                    </v-col>


                    <v-col cols="4">
                        <v-row>
                            <v-col cols="12">
                                <v-card
                                    v-scroll.self="onScroll"
                                    class="overflow-y-auto"
                                    max-height="500"
                                    elevation="0">
                                    <v-list>
                                        <v-list-item
                                            v-for="item in files"
                                            :key="item.id"
                                        >
                                            <v-list-item-title>{{ item.name }}
                                                <v-divider></v-divider>
                                            </v-list-item-title>
                                            <v-btn
                                                :href="item.url" target="_blank"
                                                icon>
                                                <v-icon small color="blue">mdi-file-download-outline</v-icon>
                                            </v-btn>
                                            <v-btn
                                                v-show="showUser||showAccount"
                                                icon
                                                @click.stop="destroyFile(item.id)"
                                            >
                                                <v-icon small color="red">mdi-bucket</v-icon>
                                            </v-btn>
                                        </v-list-item>
                                    </v-list>
                                </v-card>
                            </v-col>


                        </v-row>

                    </v-col>

                    <v-col class="pa-0" cols="8">
                        <v-card-actions v-show="showUser||showAccount">
                            <v-btn
                                :disabled="loading"
                                text
                                @click="close">
                                Отмена
                            </v-btn>
                            <v-spacer></v-spacer>
                            <v-btn
                                :disabled="this.getDisable"
                                :loading="loadingRedress"
                                text
                                color="primary"
                                @click="submitRedress"
                            >
                                Сохранить
                            </v-btn>
                        </v-card-actions>
                    </v-col>


                </v-row>


            </v-card-text>


        </v-card>
    </v-dialog>


</template>

<script>

import BaseDatePicker from "gird-base-front/src/components/BaseDatePicker";
import Comment from "./Comment";
import BaseFileInput from "gird-base-front/src/components/BaseFileInput";
import ComponentRedress from "./ComponentRedress";


export default {
    components: {BaseDatePicker, Comment, BaseFileInput, ComponentRedress},
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
            arrResult: [],
            showUser: false,
            showAccount: false,

            Calendar: null,
            transfer_at: new Date().toISOString().substr(0, 10),
            extensions: [],
            comments: [],
            attachments: [],
            files: [],
            idTransfer: 0,
            idComponent: 0,

            redress: {
                redress_at: null,
                complaint_id: this.compId,
                comment: null,
                expenses_redress: null,
            },

            redirectFile: {
                transfer_at: new Date().toISOString().substr(0, 10),
                complaint_id: this.compId,
                comment: '',
            },

            maxSize: 0,

            dialog: this.value,
            loadingRedress: false,
            loading: false,

            paramForm: {
                name: 'Регресс',
                widthForm: '800',
                // smCol: '9',
            },
            errors: {},

            scrollInvoked: 0,
            validationErrors: {},
            commentsCreateDialog: false,

            expenses_list: [],

            disExpenses: '',
            // emptyFile: '',

        }
    },
    computed: {
        getDisable(){
            if (this.redress.expenses_redress == '' || this.redress.expenses_redress == null)
                return true
        },

        emptyFile() {
            return this.files.length === 0;
        },

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
        this.showUser = this.returnUser();
        this.showAccount = this.returnUserAccount();

        this.getRedress();

    },


    methods: {

        close() {
            this.$emit('input', false);
            this.$emit('close-send', false);

        },
        openComment() {
            this.commentsCreateDialog = true;
        },

        onScroll() {
            this.scrollInvoked++
        },

        getTransfer() {
            api.call(endpoint('complaints.transfer.index', this.compId))
                .then((response) => {
                    this.redirectFile.comment = response.data.comment;
                    this.files = response.data.attachments;
                    this.idTransfer = response.data.id;

                });
        },
        getRedress() {
            api.call(endpoint('complaints.redress.index', this.compId))
                .then((response) => {
                    this.expenses_list = response.data;

                    this.arrResult = this.expenses_list.map(function (item) {
                        let str = item.redress_at;
                        let mnt = '';
                        mnt = new Date(str);

                        let DataFormat = new Intl.DateTimeFormat("ru", {
                            month: "long",

                        });
                        let res = '';
                        res = DataFormat.format(mnt);
                        let result = res[0].toUpperCase() + res.slice(1); //имя месяца

                        item.redress_at = result;
                        return item;

                    })

                });

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

            api.call(endpoint('complaints.transfer.store', this.compId), formData)
                .then(response => {
                    this.attachments = [];
                    this.redress.redress_at = null;
                })
                .catch(error => {
                    this.validationErrors = error.response.data.errors
                })
                .finally(() => {
                    this.getTransfer();
                    this.loading = false;

                })
        },

        submitRedress() {
            this.loadingRedress = true;
            api.call(endpoint('complaints.redress.store', this.compId), this.redress)
                .then(response => {
                    this.redress.expenses_redress = '';
                    this.redress.comment = '';
                    this.redress.redress_at = null;
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.getRedress();
                    this.loadingRedress = false;
                })


        },


        destroyFile(id) {
            api.call(endpoint('transfers.attachments.delete', [this.idTransfer, id]))
                .then(response => {
                    this.idComponent = id;

                    this.getTransfer();

                })
        },


        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },
        returnUserAccount() {
            return this.$store.getters.userHasRole('account');
        },

        getParamForm() {
            if (!this.showUser) {
                this.paramForm.widthForm = '1000';
            }


            return this.paramForm;
        },

    }
}
</script>
<style>
.vl {
    border-left: 1px solid DimGrey;
    /*//height: 500px;*/
    width: 10px;

}
</style>
