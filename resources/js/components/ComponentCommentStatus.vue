<template>
    <v-dialog
        :value="value"
        width="500"
        scrollable
        persistent
    >
        <v-card>
            <v-toolbar  height="50" elevation="1">
                <span>
                    <v-icon>mdi-comment-multiple-outline</v-icon>
                   Комментарий
                </span>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon color="error" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-container>
                <v-card-text>
                    <v-row justify="center">
                        <v-col sm = 12>
                            <v-textarea
                                v-model="commentstatusData.comment"
                                v-show="showUser"
                                :error-messages="errors['comment']"
                                outlined
                            ></v-textarea>
                        </v-col>

                        <v-col
                            sm="12" class="pa-0 ma-0">
                            <v-list>
                                <v-list-item
                                    v-for="item in commentstatus"
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

                                    <v-btn icon v-show="showUser||showAccount"
                                           @click.stop="destroyComment(item.id)"
                                    >
                                        <v-icon small color="red">mdi-bucket</v-icon>
                                    </v-btn>
                                </v-list-item>
                            </v-list>

                        </v-col>
                    </v-row>


                </v-card-text>
            </v-container>

            <v-card-actions >
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
<!--                    -->
                    Добавить
                </v-btn>
            </v-card-actions>


        </v-card>


    </v-dialog>

</template>

<script>

export default {
    name: "ComponentCommentStatus",
    props: {
        value: {
            type: Boolean,
            required: true,
        },

        complaint_id: {
            type: Number,
            required: true
        },
    },

    data(){
        return{
            dialog: this.value,
            showDialog: false,
            loading: false,
            showUser:false,
            errors: {},

            commentstatusData: {
                complaint_id: this.complaint_id,
                comment:'',
            },
            commentstatus:[],


            showAccount: false,
        }
    },
    created() {             //вызвать при открытии диалога

     this.getCommentStatus();
        this.showUser = this.returnUser();
    },

    methods:{
        getCommentStatus() {

            api.call(endpoint('complaints.commentstatus.index', this.complaint_id))
                .then((response) => {
                     this.commentstatus = response.data;

                });
        },

        submit(){
            api.call(endpoint('complaints.commentstatus.store', this.complaint_id), { 'comment': this.commentstatusData.comment })
                .then(response => {
                    // this.commentstatusData.commentstatus =null;
                    // this.commentstatusData.comment
                    this.close();
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.getCommentStatus();

                })
        },

        returnUser(){
            return this.$store.getters.userHasRole('admin');
        },


            close() {
                this.$emit('input', false);
                this.$emit('close-commentstatus', false);
            },

        destroyComment(id){
            api.call(endpoint('complaints.commentstatus.destroy', id))
                .then((response => {
                    this.getCommentStatus();
                }))
        },



        },






}
</script>

<style scoped>

</style>
