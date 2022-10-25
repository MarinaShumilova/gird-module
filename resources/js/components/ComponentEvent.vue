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
                            :disabled="!showUser"
                            outlined
                            dense
                            label="Мероприятия по гарантийному случаю"
                            auto-grow
                            rows="1"
                            hide-details="auto">
                        </v-textarea>

                    </v-col>
                    <v-col cols="12">
                        <v-list>
                            <v-list-item
                                v-for="item in event"
                                :key="item.id"
                                v-if="item.warranty != null">

                                   <v-row>
                                       <v-col cols="8" class="pa-5" align-self="start">
                                           {{ item.warranty}}
                                       </v-col>
                                       <v-col cols="3" class="pa-5" align-self="start">
                                           {{ item.created_at| date }}
                                       </v-col>

                                       <v-btn
                                           v-show="showUser"
                                           icon
                                           @click.stop="deleteWarranty(item.id)">
                                           <v-icon small color="red">mdi-bucket</v-icon>
                                       </v-btn>
                                   </v-row>

                            </v-list-item>
                        </v-list>


                    </v-col>
                    <v-col
                        cols="12">
                        <v-textarea
                            v-model="eventData.prevention"
                            :error-messages="errors['prevention']"
                            :disabled="!showUser"
                            outlined
                            dense
                            label="Мероприятия на предотвращение"
                            auto-grow
                            rows="1"
                            hide-details="auto">
                        </v-textarea>

                        <v-list>
                            <v-list-item
                                v-for="item in event"
                                :key="item.id"
                                v-if="item.prevention != null"
                            >
                            <v-row  class="pa-5" align-self="start">
                                    <v-col cols="8" >
                                        {{ item.prevention}}
                                    </v-col>
                                    <v-col cols="3" >
                                        {{ item.created_at| date }}
                                    </v-col>

                                <v-btn
                                    v-show="showUser"
                                    icon
                                    @click.stop="deletePrevention(item.id)">
                                    <v-icon small color="red">mdi-bucket</v-icon>
                                </v-btn>
                            </v-row>
                            </v-list-item>
                        </v-list>

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
            warranty: [],
            prevention: [],
            created_at: new Date().toISOString().substr(0, 10),  //дата претензии

            loading: false,
            errors: {},
            event: [],

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
                });

        },

        updateEvent(id){


            api.call(endpoint('complaints.events.update', id), this.eventData)
                .then(response=>{

                    this.getEvents();
                    this.eventData.warranty = '';
                    this.eventData.prevention = '';
                })
        },

        deletePrevention(id){
            this.eventData.prevention = '';
            this.eventData.warranty = '-';
            this.updateEvent(id);

        },

        deleteWarranty(id){
          this.eventData.warranty = '';
          this.eventData.prevention = '-';
          this.updateEvent(id);

        },


        submit() {
            // this.loading = true;
            api.call(endpoint('complaints.events.store', this.complaint_id), this.eventData)
                .then(response => {
                    this.eventData.warranty='';
                    this.eventData.prevention='';

                })
                .catch(error => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.getEvents();
                   // this.close()
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
