<template>
    <v-form>
                <v-row>
                    <v-col
                        cols="10">
                        <v-textarea
                            v-model="textComment"
                            v-show="showUser"
                            :error-messages="errors['comments']"
                            dense
                            auto-grow
                            rows="2">
                        </v-textarea>
                    </v-col>
                    <v-col
                        sm="2">
                        <v-btn icon
                               v-show="showUser"
                               :loading="btnLoading"
                               color="cyan lighten-1"
                               @click="submitComment"

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
                                v-for="item in comment"
                                :key="item.id"
                            >
                                <v-list-item-title>{{ item }}

                                    <v-divider></v-divider>
                                </v-list-item-title>
                            </v-list-item>
                        </v-list>

                    </v-col>

                </v-row>


    </v-form>
</template>

<script>
export default {
    name: "Comment",
    props: {
        errors: {
            type: Object,
            required: false
        },
        value: {
            type: Boolean,
            //required: true,
        },
        loading: {
            type: Boolean,
            default: false
        },
        comment: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            showDialog: false,
            showUser: false,
            dialog: this.value,
            commentData: {
                comments: '',
            },

            // comments: [],
            textComment: '',

            btnLoading: false,
            errors: {},
            redirectFile: this.value,
        }
    },
    created() {             //вызвать при открытии диалога

        // this.getComments();
        this.showUser = this.returnUser();     //роль

    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        },

    },
    methods: {
        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },

        close() {
            this.$emit('input', false);
        },

        submitComment() {
            this.$emit('comments', this.textComment);

        },


    },
}
</script>

<style scoped>
</style>
