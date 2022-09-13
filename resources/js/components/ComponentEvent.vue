<template>
    <v-dialog
        v-model="dialog"
        max-width="600"
        persistent
    >
        <v-card>
            <v-card-title>
                <v-icon left>mdi-comment-multiple-outline</v-icon>
                Мероприятия
                <v-spacer/>
                <v-btn
                    icon color="error" @click="close">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col
                        cols="12">
                        <v-textarea
                            v-model="eventData.warranty"
                            :error-messages="errors['warranty']"
                            :readonly="!showUser"
                            outlined
                            label="Мероприятия по гарантийному случаю"
                            auto-grow

                            hide-details="auto">

                        </v-textarea>


                    </v-col>

                    <v-col
                        cols="12">
                        <v-textarea
                            v-model="eventData.prevention"
                            :error-messages="errors['prevention']"
                            :readonly="!showUser"
                            outlined
                            label="Мероприятия на предотвращение"
                            auto-grow
                            hide-details="auto">
                        </v-textarea>
                    </v-col>

                </v-row>

                <v-card-actions v-show="showUser">
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
                        Сохранить
                    </v-btn>
                </v-card-actions>


            </v-card-text>
        </v-card>


    </v-dialog>
</template>

<script>
export default {
    name: "ComponentEvent",
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
            showUser: false,
            dialog: this.value,
            eventData: {
                complaint_id: this.complaint_id,
                warranty: '',
                prevention: '',
            },
            // warranty: [],
            // prevention: [],

            loading: false,
            errors: {},

        }
    },
    created() {             //вызвать при открытии диалога

        this.getEvents();
        this.showUser = this.returnUser();     //роль

    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        },
    },

    methods: {

        getEvents() {

            api.call(endpoint('complaints.events.index', this.complaint_id))
                .then((response) => {
                    this.event = response.data;
                    this.eventData.warranty = this.event.map(function (item) {
                        return item.warranty;
                    });

                    this.eventData.prevention = this.event.map(function (item){
                        return item.prevention;
                    })


                });

        },

        submit() {
            // this.loading = true;
            api.call(endpoint('complaints.events.store', this.complaint_id), this.eventData)
                .then(response => {
                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.getEvents();
                    this.close()
                    // this.loading = false;
                })

        },

        close() {
            this.$emit('input', false);
            this.$emit('close-comments', false);
        },

        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },


    }


}


</script>
