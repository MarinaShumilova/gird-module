<template>
    <v-dialog
        v-model="dialog"
        max-width="800"
        persistent
    >

        <v-card>
            <v-toolbar height="50" elevation="0">
                <span>
                    <v-icon>mdi-information-outline</v-icon>
                  Информация
                </span>

                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon color="error" @click="close">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>

            <v-list>
                <template v-for="(item, index) in items">
                    <v-list-item
                        v-if="item.action"
                        :key="item.title"
                    >
                        <v-list-item-action>
                            <v-icon>{{ item.action }}</v-icon>
                        </v-list-item-action>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider
                        v-else-if="item.divider"
                        :key="index"
                        :inset="inset"
                    ></v-divider>
                </template>
            </v-list>
        </v-card>


    </v-dialog>
</template>
<script>




export default {
    name: "LookRecord",
    props: {
        value: {
            type: Boolean,
            //required: true,
        },
        id:{
            type:Number,
            required: true
        },
    },



    created() {
        api.call(endpoint('complaints.show', this.id))
            .then((response) => {
                this.complaints = response.data.data;
                this.$emit('store-complaint');

            });


    },
    data () {
        return{
            insert:true,
            showDialog:false,
            items:[
                {title: 'Приказ'},

            ],
            complaint:{ },  //объект с данными
            dialog: this.value,

        }
    },

    watch: {
        dialog(value) {
            this.$emit('input', value);
        },

    },
    methods: {
        showComplaint(id) {

            api.call(endpoint('complaints.show', id))
                .then((response) => {
                    this.complaints = response.data.data;
                    this.$emit('store-complaint');

                });
        },


        close() {
            this.$emit('input', false);
        }
    }
}
</script>
<style scoped>

</style>
