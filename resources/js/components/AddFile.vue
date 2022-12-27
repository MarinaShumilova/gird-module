<!--Прикрепить документы-->
<template>
    <v-dialog
        :value="value"
        width="500"
        scrollable
        persistent>
        <v-card>
            <v-toolbar
                height="50"
                elevation="1">
                <span>
                    <v-icon>mdi-folder-multiple-plus</v-icon>
                  {{ this.nameForm }}
                </span>
                <v-spacer></v-spacer>

                <v-btn icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

            </v-toolbar>

            <v-card-text>
                <v-row justify="center">
                    <v-col
                        cols="12">
                        <base-file-input
                            v-model="attachments"
                            v-show="showUser"
                            :extensions="extensions"
                            lable="Прикрепить документы"
                            :max-size="maxSize"
                            :error-messages="validationErrors['attachments']"
                        ></base-file-input>
                    </v-col>

                    <v-col cols="6"  v-show="showUser">
                        <v-select
                            v-model="typePact"
                            item-value="id"
                            item-text="name"
                            :items="arrPact"
                            outlined
                            dense
                        >
                        </v-select>

                    </v-col>
                    <v-col cols="6" v-show="showUser">
                        <v-select
                            v-model="firm"
                            item-value="id"
                            item-text="name"
                            :items="arrFirm"
                            label="Компания"
                            outlined
                            dense
                        >

                        </v-select>
                    </v-col>
                    <v-col
                        cols="12"
                        class="pa-1">

                        <v-list>
                            <v-list-item
                                v-for="item in files"
                                :key="item.id"
                                class="pa-1">

                                <div class="pa-2" color="blue lighten-4">
                                    <p style="background-color:#BBDEFB; color: Black">
                                        {{ item.type_pact.name }}
                                        {{ item.firm.name }}
                                    </p>
                                </div>
                                <v-list-item-title>{{ item.name }}
                                    <v-divider></v-divider>
                                </v-list-item-title>
                                <v-btn
                                    :href="item.url" target="_blank"
                                    icon>
                                    <v-icon small color="blue">mdi-file-download-outline</v-icon>
                                </v-btn>
                                <v-btn
                                    v-show="showUser"
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

                <v-card-actions
                    v-show="showUser">
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
                        @click.stop="submit"

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
        compId: {
            type: Number,
            required: true
        },
    },
    data() {
        return {
            showUser: false,
            extensions: [],
            maxSize: 0,
            files: [],
            dialog: this.value,
            validationErrors: {},
            attachments: [],
            loading: false,
            errors: {},
            nameForm: 'Прикрепить документы',


            firm: 1,
            arrFirm: [],

            arrPact: [],
            typePact: 1,
        }
    },
    created() {             //вызвать при открытии диалога
        this.showDialog = false;
        api.call(endpoint('complaints.attachments.create', this.compId))
            .then((response) => {
                this.maxSize = response.data.attachment_rules.max_size;
                this.extensions = response.data.attachment_rules.extensions;
                this.arrFirm = response.data.firm_id;
                this.arrPact = response.data.type_pact_id;

                this.getAttachment();
                this.showDialog = true;
            });

        this.showUser = this.returnUser();
        this.getNameForm();


    },
    methods: {
        getAttachment() {
            api.call(endpoint('complaints.attachments.index', this.compId))
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
            }
            ;
            formData.append('firm_id', this.firm ?? ' ');
            formData.append('type_pact_id', this.typePact ?? ' ');


            api.call(endpoint('complaints.attachments.store', this.compId), formData)
                .then(response => {
                    this.attachments = [];
                    this.getAttachment();
                })
                .catch(error => {
                    this.validationErrors = error.response.data.errors
                })
                .finally(() => {
                    this.loading = false;
                })


        },


        close() {
            this.$emit('input', false);
            this.$emit('close-add-file', false);

        },

        destroyFile(id) {
            api.call(endpoint('complaints.attachments.destroy', [this.compId, id]))
                .then(response => {
                    this.getAttachment();
                })
        },

        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },

        getNameForm() {
            if (!this.showUser)
                return this.nameForm = 'Прикрепленные документы'

        },
    }

}
</script>
<style>

</style>
