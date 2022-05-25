<!--всплывающее меню-->
<template>
    <v-row
        class="d-flex"
        justify="center"
    >
        <v-menu
            v-model="showMenu"
            :position-x="x"
            :position-y="y"
            offset-x
        >

                <v-list-item
                    v-for="(item, index) in items"
                    :key="index"
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
<!--&lt;!&ndash;                                   выпадающее меню в таблице&ndash;&gt;
                <v-list-item-group>
                    <v-list-item @click.stop="openExpensesDialog">
                        <v-list-item-icon>
                            <v-icon right>mdi-card-bulleted-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Затраты</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click.stop="openSendFileDialog">
                        <v-list-item-icon>
                            <v-icon right>mdi-shuffle-disabled</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Перенаправить документы</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click.stop="openAddFileDialog">
                        <v-list-item-icon>
                            <v-icon right>mdi-card-plus-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>Прикрепить документы</v-list-item-title>
                    </v-list-item>

&lt;!&ndash;                    <v-list-item v-if = "textStatus(item.status_id)=== 'В работе'"
                                 @click ="exitComplaints(item.id)">

                        <v-list-item-icon>
                            <v-icon right>mdi-close</v-icon></v-list-item-icon>

                        <v-list-item-content  >
                            <v-list-item-title >Завершить</v-list-item-title>
                        </v-list-item-content>

                    </v-list-item>

                    <v-list-item v-else
                                 @click ="returnComplaints(item.id)">

                        <v-list-item-icon>
                            <v-icon right>mdi-share</v-icon></v-list-item-icon>
                        <v-list-item-content  >
                            <v-list-item-title >Восстанавить</v-list-item-title>

                        </v-list-item-content>

                    </v-list-item>&ndash;&gt;


                </v-list-item-group>-->
<!--            </v-list>-->

        </v-menu>

<!--        <expenses-card-->
<!--            v-if="expensesCreateDialog"
            v-model="expensesCreateDialog"
            @expenses-created="expensesCreateDialog = false"
        ></expenses-card>
        &lt;!&ndash;перенаправить &ndash;&gt;
        <send-file
            v-if="sendFileCreateDialog"
            v-model="sendFileCreateDialog"
            @expenses-created="sendFileCreateDialog = false">
        </send-file>
        &lt;!&ndash;прикрепить документ&ndash;&gt;
        <add-file
            v-if="addFileCreateDialog"
            v-model="addFileCreateDialog"
            @expenses-created="addFileCreateDialog = false">
        </add-file>-->
    </v-row>
</template>

<script>
import ExpensesCard from "./ExpensesCard";
import SendFile from "./SendFile";
import AddFile from "./AddFile";

export default {
    components: {
        ExpensesCard, SendFile,
        AddFile
    },
    data () {
        return {

            items: [
                { title: 'Click Me' },
                { title: 'Click Me' },
                { title: 'Click Me' },
                { title: 'Click Me 2' },
            ],
            showMenu: false,
            x: 0,
            y: 0,

            expensesCreateDialog: false, //затраты
            sendFileCreateDialog: false,  //перенаправить
            addFileCreateDialog: false,   //прикрепить
        }
    },


    methods: {

        show (e) {
            e.preventDefault()
            this.showMenu = false
            this.x = e.clientX
            this.y = e.clientY
            this.$nextTick(() => {
                this.showMenu = true
            })
        },

        openAddFileDialog() {
            this.addFileCreateDialog = true;
        },
        openSendFileDialog() {
            this.sendFileCreateDialog = true;
        },

        openExpensesDialog() {
            this.expensesCreateDialog = true;
        },

    /*    exitComplaints(id){
            api.call(endpoint('complaints.finish', id))
                .then((response => {

                }))


        },*/

     /*   returnComplaints(id){
            api.call(endpoint('complaints.return', id))
                .then((response => {

                }))
        } ,*/

    },
}
</script>

<style scoped>

</style>
