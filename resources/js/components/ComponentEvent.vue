<template>

    <v-row>
        <v-col class="pt-0" cols="6">
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

        <v-col class="pt-0"
               cols="6">
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

        </v-col>



        <v-col cols="6">
            <v-list>
                <v-list-item
                    v-for="item in arrResult"
                    :key="item.id"
                    v-if="item.warranty != null">
                        <v-row class="pt-2" align-self="start">
                            <v-col cols="8" >
                                {{ item.warranty}}
                            </v-col>
                            <v-col cols="3" class="pt-2" align-self="start">
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

          <v-col cols="6">
            <v-list>
                <v-list-item
                    v-for="item in arrResult"
                    :key="item.id"
                    v-if="item.prevention != null">
                    <v-row class="pt-2" align-self="start">
                        <v-col cols="8">
                            {{ item.prevention }}
                        </v-col>
                        <v-col cols="3" class="pt-2" align-self="start">
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

</template>

<script>
export default {
    name: "ComponentEvent",
    props: {
        value: {
            type: Object,
            required: true,
        },

        arrResult: {
            type: Array,
            required: true,
        },

        errors: {
            type: Object,
            required: false
        },

    },


    data() {
        return {
            showDialog: false,
            showUser: false,
            dialog: this.value,

            eventData: this.value,

            warranty: [],
            prevention: [],
            created_at: new Date().toISOString().substr(0, 10),  //дата претензии

            loading: false,
            event: [],

        }
    },
    created() {             //вызвать при открытии диалога

        //this.getEvents();
        this.showUser = this.returnUser();     //роль

    },
    watch: {
        dialog(value) {
            this.$emit('input', value);
        },


    },

    methods: {
        updateEvent(id) {
            api.call(endpoint('complaints.events.update', id), this.eventData)
                .then(response => {
                    this.$emit("delete");
                    this.eventData.warranty = '';
                    this.eventData.prevention = '';
                })
        },

        deletePrevention(id) {
            this.eventData.prevention = '';
            this.eventData.warranty = '-';
            this.updateEvent(id);

        },

        deleteWarranty(id) {
            this.eventData.warranty = '';
            this.eventData.prevention = '-';
            this.updateEvent(id);

        },

        // close() {
        //     this.$emit('input', false);
        //     this.$emit('close-comments', false);
        // },

        saveEvent() {
            this.$emit('submit');
        },

        returnUser() {
            return this.$store.getters.userHasRole('admin');
        },

        deleteEvent(){
          this.$emit('delete',false);
        },

    }


}


</script>
