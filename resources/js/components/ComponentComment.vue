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
                Комментарий
                <v-spacer/>
                <v-btn
                    icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col
                        cols="10">
                        <v-textarea
                            v-model="commentData.comments"
                            v-show="showUser"
                            :error-messages="errors['comment']"
                            dense
                            rows="1">
                        </v-textarea>
                    </v-col>
                    <v-col
                        sm="2">
                        <v-btn icon
                               v-show="showUser"
                               :loading="btnLoading"
                               color="cyan lighten-1"
                               @click="submit"
                        >
                            <v-icon>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                    </v-col>

                    <v-col
                        sm="10">
                        <v-list>
                            <v-list-item
                                v-for="item in comments"
                                :key="item.id"
                            >
                                <v-list-item-title>{{item.comment}}

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
        loading: {
            type: Boolean,
            default: false
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
            btnLoading: false,
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
            this.btnLoading = true;
            api.call(endpoint('complaints.comment.store', this.complaint_id), this.commentData)
                .then(response => {
                    this.commentData.comments =null;
                    console.log(this.commentData.comments);
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.btnLoading = false;
                    this.getComments();

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
