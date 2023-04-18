<!--комментарий к комплайну-->
<template>
    <v-dialog
        v-model="dialog"
        max-width="600"
        persistent
    >
        <v-card>
            <v-card-title>
                <v-icon left>mdi-comment-multiple-outline</v-icon>
                Контакты
                <v-spacer/>
                <v-btn
                    icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col
                        cols="11">
                        <v-textarea
                            v-model="commentData.comments"
                            v-show="showUser"
                            :error-messages="errors['comment']"
                            rows="1"
                            auto-grow
                            dense>
                        </v-textarea>
                    </v-col>
                    <v-col
                        sm="1" class="pa-1">
                        <v-btn icon
                               v-show="showUser"
                               :loading="loading"
                               color="cyan lighten-1"
                               @click="submit"
                        >
                            <v-icon>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                    </v-col>

                    <v-col
                        sm="12" class="pa-0 ma-0">
                        <v-list>
                            <v-list-item
                                v-for="item in comments"
                                :key="item.id"
                            >
                                <v-list-item-title>
                                    <v-textarea
                                        hide-details
                                        rows="1"
                                        dense
                                        outlined
                                        :value="item.comment">
                                    </v-textarea>

                                    <v-divider></v-divider>
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>

                    </v-col>

                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>

</template>

<script>
export default {
    name: "ComponentComment",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        complaint_id: {
            type: Number,
            required: true
        },

    },

    data() {
        return {
            showDialog: false,
            showUser:false,
            dialog: this.value,
            commentData: {
                complaint_id: this.complaint_id,
                comments: '',
            },
            comments: [],
            loading: false,
            errors: {},

        }
    },
    created() {             //вызвать при открытии диалога

        this.getComments();
        this.showUser = this.returnUser();     //роль

    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        },
    },
    methods: {
        getComments() {
            api.call(endpoint('complaints.comment.index', this.complaint_id))
                .then((response) => {
                    this.comments = response.data;

                });

        },
        submit() {
            // this.loading = true;
            api.call(endpoint('complaints.comment.store', this.complaint_id), this.commentData)
                .then(response => {
                    this.commentData.comments =null;
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.getComments();
                    // this.loading = false;
                })

        },

        returnUser(){
            return this.$store.getters.userHasRole('admin');
        },


        close() {
            this.$emit('input', false);
            this.$emit('close-comments', false);
        },


    },


}
</script>

<style scoped>

</style>
